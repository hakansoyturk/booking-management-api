<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IAppointmentService;
use App\Services\Interfaces\IGoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{

    /**
     * Create a new interface instance.
     *
     * @param IGoogleCalendarService $subService
     * @param IAppointmentService $appointmentService
     */
    public function __construct(
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
    public function store(Request $request)
    {
        $request->validate([
            'startDateTime' => 'required|date_format:Y-m-d H:i',
            'endDateTime' => 'required|date_format:Y-m-d H:i|after:startDateTime',
            'salonId' => 'required|exists:salons,id',
        ]);

        $eventId = $this->googleCalendarService->store($request);

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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'startDateTime' => 'required|date_format:Y-m-d H:i',
            'endDateTime' => 'required|date_format:Y-m-d H:i|after:startDateTime',
        ]);

        $appointment = $this->appointmentService->findAppointmentById($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found or not owned by the user'], Response::HTTP_NOT_FOUND);
        }

        $this->googleCalendarService->update($appointment, $request);
         
        $this->appointmentService->updateAppointment($appointment, $request);

        return response()->json($appointment, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = $this->appointmentService->findAppointmentById($id);

        if ($appointment) {
            $this->googleCalendarService->destroy($appointment);
            $appointment->delete();
            return response()->json(['message' => 'Appointment has been deleted successfully'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Appointment not found or not owned by the user'], Response::HTTP_NOT_FOUND);
    }
}
