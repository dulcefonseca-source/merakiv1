<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    protected $table = 'business_settings';

    protected $fillable = [
        'business_name',
        'tagline',
        'logo_path',
        'cover_path',
        'phone',
        'whatsapp',
        'email',
        'address',
        'instagram',
        'facebook',
        'primary_color',
        'secondary_color',
    ];
}
