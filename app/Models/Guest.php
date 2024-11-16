<?php

namespace App\Models;

use App\Services\PhoneService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'country',
    ];

    protected static function booted()
    {
        static::creating(function ($guest) {
            if (empty($guest->country)) {
                $guest->country = app(PhoneService::class)->getCountryFromPhone($guest->phone);
            }
        });
    }
}
