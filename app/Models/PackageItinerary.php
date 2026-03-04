<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItinerary extends Model
{
    use HasFactory;

    protected $table = 'package_itineraries';

    protected $fillable = [
        'package_id',
        'day_number',
        'title',
        'description',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
