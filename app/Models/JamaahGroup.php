<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamaahGroup extends Model
{
    protected $table = 'jamaah_groups';

    protected $fillable = [
        'name',
        'agent_id',
        'departure_date',
        'notes',
    ];

    public function jamaahs()
    {
        return $this->hasMany(Jamaah::class, 'group_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agents::class, 'agent_id');
    }
}