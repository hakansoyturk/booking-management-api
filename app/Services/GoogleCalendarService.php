<?php

namespace App\Services;

use App\Models\Salon;
use App\Services\Interfaces\IGoogleCalendarService;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

// Bu sınıf, IGoogleCalendarService interface'ini implement eder.
// Google Calendar ile ilgili işlemler bu serviste gerçekleştirilir.
class GoogleCalendarService implements IGoogleCalendarService
{
    // Google Calendar'da yeni bir etkinlik oluşturur
    public function store($request)
    {

        $salonId = $request->query('salonId');
        $startTime = $request->query('startDateTime');
        $endTime = $request->query('endDateTime');

        // Kullanılacak takvimi değiştir
        $this->changeCalendar($salonId);

        // Yeni bir event oluşturuldu.
        $event = new Event;
        $event->name = 'Salon Randevu';
        $event->description = 'Salona yapılmış olan randevu';

        // Request'ten gelen tarihler Carbon instance'larına dönüştürülüyor
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startTime, 'Europe/Istanbul');
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime, 'Europe/Istanbul');

        // Timezone'u UTC'ye dönüştürme
        $startDateTime->setTimezone('UTC');
        $endDateTime->setTimezone('UTC');

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $newEvent = $event->save();
        return $newEvent->id;
    }

    // Google Calendar'da etkinliği günceller
    public function update($appointment, $request){
        
        $startTime = $request->query('startDateTime');
        $endTime = $request->query('endDateTime');

        // Request'ten gelen tarihler Carbon instance'larına dönüştürülüyor
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startTime, 'Europe/Istanbul');
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime, 'Europe/Istanbul');

        // Timezone'u UTC'ye dönüştürme
        $startDateTime->setTimezone('UTC');
        $endDateTime->setTimezone('UTC');
        
        // Kullanılacak takvimi değiştir
        $this->changeCalendar($appointment->salon_id);

        // Etkinliği bulmak için Google Calendar'da etkinlik ID'sini kullan
        $event = Event::find($appointment->google_event_id);

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $event->save();
    }
    
    // Google Calendar'da etkinliği siler
    public function destroy($appointment){

        $this->changeCalendar($appointment->salon_id);
        
        $event = Event::find($appointment->google_event_id);

        $event->delete();
    }

    // Kullanılacak takvimi değiştirir
    public function changeCalendar($salonId){
        // Fetch the salon from the database
        $salon = Salon::find($salonId);

        if ($salon && $salon->google_calendar_id) {
            // Update the configuration value
            config(['google-calendar.calendar_id' => $salon->google_calendar_id]);
        }
    }


}