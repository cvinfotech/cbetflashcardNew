<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestHistory extends Model
{
    public function getTestResult(){
        return $this->hasMany('App\TestReport', 'test_id', 'test_id');
    }

    public function getCorrectQues(){
        return $this->hasMany('App\TestReport', 'test_id', 'test_id')->whereRaw('chosen = correct');
    }
}
