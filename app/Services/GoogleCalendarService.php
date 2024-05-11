<?php

namespace App\Services;

use App\Models\Salon;
use App\Services\Interfaces\IGoogleCalendarService;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
class GoogleCalendarService implements IGoogleCalendarService
{
    public function store($request)
    {

        $salonId = $request->query('salonId');
        $startTime = $request->query('startDateTime');
        $endTime = $request->query('endDateTime');

        $this->changeCalendar($salonId);

        //create a new event
        $event = new Event;
        $event->name = 'Salon Randevu';
        $event->description = 'Salona yapılmış olan randevu';

        // Convert request datetime to Carbon instances
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startTime, 'Europe/Istanbul');
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime, 'Europe/Istanbul');

        // Convert to UTC
        $startDateTime->setTimezone('UTC');
        $endDateTime->setTimezone('UTC');

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $newEvent = $event->save();
        return $newEvent->id;
    }
    public function update($appointment, $request){
        
        $startTime = $request->query('startDateTime');
        $endTime = $request->query('endDateTime');

        // Convert request datetime to Carbon instances
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startTime, 'Europe/Istanbul');
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endTime, 'Europe/Istanbul');

        // Convert to UTC
        $startDateTime->setTimezone('UTC');
        $endDateTime->setTimezone('UTC');
        
        $this->changeCalendar($appointment->salon_id);

        $event = Event::find($appointment->google_event_id);

        $event->startDateTime = $startDateTime;
        $event->endDateTime = $endDateTime;

        $event->save();
    }
    
    public function destroy($appointment){

        $this->changeCalendar($appointment->salon_id);
        
        $event = Event::find($appointment->google_event_id);

        $event->delete();
    }
    public function changeCalendar($salonId){
        // Fetch the salon from the database
        $salon = Salon::find($salonId);

        if ($salon && $salon->google_calendar_id) {
            // Update the configuration value
            config(['google-calendar.calendar_id' => $salon->google_calendar_id]);
        }
    }


}