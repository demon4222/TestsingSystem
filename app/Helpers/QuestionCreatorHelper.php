<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Session;

class QuestionCreatorHelper
{
    public function addNewQuestion($request)
    {
        $this->updateQuestionsCount();

        if($request->answer_type==1||$request->answer_type==2)
        {
            $wrong = $request->wrong_answer_text;
            $correct = $request->correct_answer_text;
            Session::push('question', ['text' => $request->question_text, 'answer_type' => $request->answer_type, 'wrong_answers' => $wrong, 'correct_answers' => $correct]);
        }
        else if($request->answer_type==3)
        {

        }
    }

    private function updateQuestionsCount()
    {
        $questions_cnt = intval(Session::get('questions_cnt'));
        $questions_cnt++;
        Session::put('questions_cnt', $questions_cnt);
    }
}
