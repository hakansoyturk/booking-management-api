<?php

namespace App\Services\Interfaces;
use App\Models\Appointment;
use Illuminate\Http\Request;
interface IGoogleCalendarService
{
    public function store(Request $request);
    public function update(Appointment $appointment, Request $request);
    public function destroy(Appointment $appointment);
}