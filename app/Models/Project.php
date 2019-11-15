<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table='project';

    public function getGroupLeadersAttribute($value)
    {
        return explode(',', $value);
    }

    public function setGroupLeadersAttribute($value)
    {
        $this->attributes['group_leaders'] = implode(',', $value);
    }

    public function userProjectDay()
    {
        return $this->hasMany(UserProjectDay::class);
    }
}
