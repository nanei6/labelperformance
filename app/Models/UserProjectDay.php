<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProjectDay extends Model
{
    protected $table='user_project_day';

    public function user()
    {
        return $this->belongsTo(User::class,'employee_number','employee_number');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
