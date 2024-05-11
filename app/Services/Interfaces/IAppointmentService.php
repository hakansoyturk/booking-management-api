<?php

namespace App\Services\Interfaces;

use App\Models\Appointment;
use Illuminate\Http\Request;

interface IAppointmentService
{
    public function getAllAppointments(int $salonId);
    public function createAppointment(Request $request, string $googleEventId);
    public function findAppointmentById(int $id);
    public function updateAppointment(Appointment $appointment, Request $request);
}