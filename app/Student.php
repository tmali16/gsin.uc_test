<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $casts = [
        "result"=>'array',
        'passed'=>'boolean'
        ];

    function test(){
        return $this->hasOne('App\Test', "id", "test_id");
    }
    public function Answer()
    {
        return $this->hasMany("App\Answer", 'student_id', 'id');
    }
}
