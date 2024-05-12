<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Services\Interfaces\IAppointmentService;
use App\Services\Interfaces\IGoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{

    /**
     * Create a new interface instance.
     *
     * @param IGoogleCalendarService $googleCalendarService
     * @param IAppointmentService $appointmentService
     */
    public function __construct( // Kullanılacak servislerin bağımlılıkları enjekte edildi
        private IGoogleCalendarService $googleCalendarService,
        private IAppointmentService $appointmentService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // salonId alanı gereklidir. Ayrıca salonId salons tablosunda bulunması gerekir.
        $request->validate([
            'salonId' => 'required|exists:salons,id',
        ]);

        // İlgili salon için tüm randevular getirildi
        $appointments = $this->appointmentService->getAllAppointments($request->salonId);

        return response()->json($appointments, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request) // validasyon için form request kullanıldı
    {
        // İlgili salon için Google Calendar'a kayıt oluşturuldu
        $eventId = $this->googleCalendarService->store($request);

        // Appointment tablosuna kayıt oluşturuldu
        $appointment = $this->appointmentService->createAppointment($request, $eventId);

        return response()->json($appointment, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, string $id)
    {
        // Güncellenecek randevu bulundu
        $appointment = $this->appointmentService->findAppointmentById($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found or not owned by the user'], Response::HTTP_NOT_FOUND);
        }

        // Google Calendar'da güncelleme yapıldı
        $this->googleCalendarService->update($appointment, $request);
        
        // Appointment tablosunda güncelleme yapıldı
        $this->appointmentService->updateAppointment($appointment, $request);

        return response()->json($appointment, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Silinecek randevu bulundu
        $appointment = $this->appointmentService->findAppointmentById($id);

        if ($appointment) {
            // Google Calendar'dan randevu silindi
            $this->googleCalendarService->destroy($appointment);
            
            // Appointment tablosundan randevu silindi
            $appointment->delete();
            return response()->json(['message' => 'Appointment has been deleted successfully'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Appointment not found or not owned by the user'], Response::HTTP_NOT_FOUND);
    }
}
