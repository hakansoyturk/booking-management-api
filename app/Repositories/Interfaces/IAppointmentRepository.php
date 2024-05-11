<?php

namespace App\Repositories\Interfaces;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface IAppointmentRepository
{
    public function getAll(int $salonId): Collection;
    public function create(Request $request, string $googleEventId);
    public function findAppointmentById(int $id);
    public function update(Appointment $appointment, Request $request);
}