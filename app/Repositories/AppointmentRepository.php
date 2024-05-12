<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\User;
use App\Repositories\Interfaces\IAppointmentRepository;
use Illuminate\Database\Eloquent\Collection;

// Bu sınıf, IAppointmentRepository interface'ini implement eder.
// Appointment ile ilgili veritabanı işlemleri bu sınıfta gerçekleştirilir.
class AppointmentRepository implements IAppointmentRepository
{
    // Tüm randevuları getirir
    public function getAll($salonId): Collection
    {
        return Appointment::where('salon_id', $salonId)->get();
    }

    // Randevu oluşturur
    public function create($request, $googleEventId)
    {
        return Appointment::create([
            'start_time' => $request->startDateTime,
            'end_time' => $request->endDateTime,
            'salon_id' => $request->salonId,
            'user_id' => auth()->id(),
            'google_event_id' => $googleEventId
        ]);
    }

    // verilen id'ye göre randevuyu getirir
    public function findAppointmentById(int $id)
    {
        return Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    }

    // Randevuyu günceller
    public function update($appointment, $request)
    {
        return $appointment->update([
            'start_time' => $request->startDateTime,
            'end_time' => $request->endDateTime,
        ]);
    }

}