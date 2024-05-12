<?php

namespace App\Services;

use App\Repositories\Interfaces\IAppointmentRepository;
use App\Services\Interfaces\IAppointmentService;
use Illuminate\Http\Request;

// Bu sınıf, IAppointmentService interface'ini implement eder. 
// IAppointmentRepository interface'ini kullanarak veritabanı işlemlerini gerçekleştirir.
// Appointment ile ilgili işlemler bu serviste gerçekleştirilir.
class AppointmentService implements IAppointmentService
{
    /**
     * Create a new interface instance.
     *
     * @param IAppointmentRepository $appointmentRepository
     */
    public function __construct(private IAppointmentRepository $appointmentRepository)
    {
    }

    // Tüm randevuları getirir
    public function getAllAppointments($salonId)
    {
        return $this->appointmentRepository->getAll($salonId);
    }

    // Randevu oluşturur
    public function createAppointment(Request $request, string $googleEventId)
    {
        return $this->appointmentRepository->create($request, $googleEventId);
    }

    // verilen id'ye göre randevuyu getirir
    public function findAppointmentById(int $id){
        return $this->appointmentRepository->findAppointmentById($id);
    }

    // Randevuyu günceller
    public function updateAppointment($appointment, $request){
        return $this->appointmentRepository->update($appointment, $request);
    }

}
