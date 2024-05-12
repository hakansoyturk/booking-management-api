<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // startDateTime alanı gereklidir ve Y-m-d H:i formatında olmalıdır.
        return [
            'startDateTime' => [
                'required',
                'date_format:Y-m-d H:i',
                function ($attribute, $value, $fail) {
                    $endDateTime = $this->input('endDateTime');
                    $salonId = $this->input('salonId');
                    // İlgili salon için aynı saat aralığında başka bir randevu var mı kontrol edildi
                    $appointmentExists = Appointment::where('salon_id', $salonId)
                                                    ->where(function ($query) use ($value, $endDateTime) {
                                                        $query->whereBetween('start_time', [$value, $endDateTime])
                                                              ->orWhereBetween('end_time', [$value, $endDateTime]);
                                                    })
                                                    ->exists();
    
                    if ($appointmentExists) {
                        $fail('An appointment already exists in this time range.');
                    }
                },
            ],
            // endDateTime alanı gereklidir, Y-m-d H:i formatında olmalıdır ve startDateTime'den sonra olmalıdır.
            'endDateTime' => 'required|date_format:Y-m-d H:i|after:startDateTime',
            // salonId alanı gereklidir ve salons tablosunda bulunmalıdır.
            'salonId' => 'required|exists:salons,id',
        ];
    }
}
