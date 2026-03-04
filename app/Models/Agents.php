<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
  protected $fillable = [
    'company_id',
    'office_id',        // baru
    'association_id',
    'people_id',
    'ppiu_license_number',
    'pihk_license_number',
  ];


  protected $casts = [
    'status' => 'boolean',
  ];

  /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

  // Agent belongs to Company
  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  // Agent belongs to People (biodata)
  public function people()
  {
    return $this->belongsTo(People::class);
  }

  // Agent belongs to Association
  public function association()
  {
    return $this->belongsTo(Association::class);
  }

  // Agent has one User (polymorphic)
  public function user()
  {
    return $this->morphOne(User::class, 'userable');
  }
  
}
