<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $casts = [
        "result"=>'array'
        ];

    function test(){
        return $this->hasOne('App\Test', "id", "test_id");
    }
}
