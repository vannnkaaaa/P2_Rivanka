<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamaahHealth extends Model
{
    protected $table = 'jamaahs_health';

    protected $fillable = [
        'jamaah_id',
        'health_type',
        'description',
        'recorded_at',
        'notes',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'jamaah_id');
    }
}