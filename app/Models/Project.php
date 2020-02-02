<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    protected $table='project';

    protected $appends = ['progress','estimated_total_revenue'];

    public function getGroupLeadersAttribute($value)
{
    return explode(',', $value);
}

    public function setGroupLeadersAttribute($value)
    {
        $this->attributes['group_leaders'] = implode(',', $value);
    }

    public function getCheckersAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCheckersAttribute($value)
    {
        $this->attributes['checkers'] = implode(',', $value);
    }

    public function getManagerAttribute($value)
    {
        return explode(',', $value);
    }

    public function setManagerAttribute($value)
    {
        $this->attributes['manager'] = implode(',', $value);
    }
    public function getProgressAttribute()
    {
        //日项目完成量
        $daily_label=UserProjectDay::select('daily_label')->where(['project_id'=>$this->id])->get()->toArray();
        $daily_label_sum=array_sum(Arr::flatten($daily_label));
        // 预计总量
        $estimated_count=$this->estimated_count;
        //占比
        if($estimated_count==0){
            $rate=0;
        }elseif ($daily_label_sum>$estimated_count){
            $rate=100;
        }else{
            $rate=($daily_label_sum/$estimated_count)*100;
        }

        return $rate;
    }

    public function getEstimatedTotalRevenueAttribute(){
        return $this->estimated_count*$this->unit_price;

    }

    public function userProjectDay()
    {
        return $this->hasMany(UserProjectDay::class);
    }
}
