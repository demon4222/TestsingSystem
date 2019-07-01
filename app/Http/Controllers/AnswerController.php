<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;

class AnswerController extends Controller
{
    public function getAnswersByQuestionAjax(Request $request)
    {
        $question_id = $request->question_id;
        $question = Question::find($question_id);
        $answers = $question->answers()->get();

        return response()->json(['answers'=>$answers]);
    }
}
