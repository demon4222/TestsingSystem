<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Session;

class SessionHelper
{
    public static function clearSession()
    {
        Session::forget('question');
        Session::forget('question_id');
        Session::forget('test_name');
        Session::forget('test_id');
        Session::forget('questions_cnt');
        Session::forget('answers');
        Session::forget('current_question_id');
    }
}
