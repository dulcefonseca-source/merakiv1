<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $fillable = [
        'client_id',
        'appointment_date',
        'start_time',
        'end_time',
        'location',
        'address',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }
    public function payments()
{
    return $this->hasMany(AppointmentPayment::class);
}
}
