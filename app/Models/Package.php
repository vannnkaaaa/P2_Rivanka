<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'type',
        'code',
        'name',
        'slug',
        'price',
        'price_triple',
        'price_double',
        'dp',
        'quota',
        'quota_used',
        'departure_date',
        'departure_time',
        'return_date',
        'return_time',
        'duration_days',
        'departure_city',
        'destination_city',
        'airline',
        'hotel_makkah',
        'hotel_madinah',
        'hotel_rating',
        'room_type',
        'status',
    ];

    // Relasi ke detail paket
    public function detail()
    {
        return $this->hasOne(PackageDetail::class, 'package_id');
    }

    // Relasi ke itinerary
    public function itineraries()
    {
        return $this->hasMany(PackageItinerary::class, 'package_id')->orderBy('day_number');
    }
}
