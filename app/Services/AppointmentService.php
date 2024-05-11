<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\Interfaces\IAppointmentRepository;
use App\Services\Interfaces\IAppointmentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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

    public function getAllAppointments($salonId)
    {
        return $this->appointmentRepository->getAll($salonId);
    }

    public function createAppointment(Request $request, string $googleEventId)
    {
        return $this->appointmentRepository->create($request, $googleEventId);
    }

    public function findAppointmentById(int $id){
        return $this->appointmentRepository->findAppointmentById($id);
    }

    public function updateAppointment($appointment, $request){
        return $this->appointmentRepository->update($appointment, $request);
    }

}
