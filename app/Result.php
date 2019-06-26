<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'test_results';

    protected $fillable = ['user_id','test_id','result'];

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
