<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
  protected $table = 'jamaahs';

  protected $fillable = [
    'people_id',
    'agent_id',
    'registration_number',
    'departure_date',
    'package_id',
    'status',
    'group_id',
  ];

  public function people()
  {
    return $this->belongsTo(People::class, 'people_id');
  }

  public function group()
  {
    return $this->belongsTo(JamaahGroup::class, 'group_id');
  }

  public function documents()
  {
    return $this->hasMany(JamaahDocument::class, 'jamaah_id');
  }

  public function health()
  {
    return $this->hasMany(JamaahHealth::class, 'jamaah_id');
  }

  public function payments()
  {
    return $this->hasMany(JamaahPayment::class, 'jamaah_id');
  }

  public function agent()
  {
    return $this->belongsTo(Agents::class, 'agent_id');
  }

  public function agentName()
  {
    return $this->agent ? $this->agent->name : 'Admin';
  }
  
}
