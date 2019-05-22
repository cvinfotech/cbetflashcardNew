<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    public function getQuestionDetails(){
        return $this->hasOne('App\OnlineTest', 'id', 'question_id');
    }
}
