<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use SoftDeletes;
    //
    protected $casts = [
        'state' => 'boolean',
        'question_rand' => 'boolean',
    ];
    public function question()
    {
        return $this->hasMany('App\Question');
    }
}
