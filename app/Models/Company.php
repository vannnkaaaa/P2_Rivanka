<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
  ];

  public function offices()
  {
    return $this->hasMany(Office::class);
  }

  public function agents()
  {
    return $this->hasMany(Agents::class);
  }
}
