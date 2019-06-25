<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = ['question_id', 'answer'];

    public $timestamps = false;

    public function test(){
        return $this->belongsTo('App\Test');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

}
