<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamaahPayment extends Model
{
    protected $table = 'jamaahs_payments';

    protected $fillable = [
        'jamaah_id',
        'payment_method_id',
        'payment_type',
        'amount',
        'payment_date',
        'status',
        'notes',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'jamaah_id');
    }
}