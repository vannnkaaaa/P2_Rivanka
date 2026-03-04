<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
  protected $fillable = [
    'association_id',
    'name',
    'email',
    'phone',
    'address',
  ];

  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  public function association()
  {
    return $this->belongsTo(Association::class);
  }
}
