<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    protected $fillable = ['test_name'];

    public $timestamps = false;

    public function results(){
        return $this->hasMany('App\Results');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
