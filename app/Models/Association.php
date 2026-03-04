<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relasi ke Agent
    public function agents()
    {
        return $this->hasMany(Agents::class);
    }
}
