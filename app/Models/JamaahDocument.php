<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamaahDocument extends Model
{
    protected $table = 'jamaahs_documents';

    protected $fillable = [
        'jamaah_id',
        'document_type',
        'file_path',
        'issued_date',
        'expiry_date',
        'notes',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class, 'jamaah_id');
    }
}