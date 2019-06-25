<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['test_id', 'answer_type_id', 'question'];

    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
