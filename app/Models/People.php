<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';

    protected $fillable = [
        'fullname',
        'gender',
        'birth_date',
        'birth_place',
        'phone',
        'address',
    ];

    public $timestamps = true;
}
