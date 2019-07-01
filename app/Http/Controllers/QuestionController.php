<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Helpers\QuestionCreatorHelper;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    private $qeustionHelper;

    public function __construct(QuestionCreatorHelper $helper)
    {
        $this->qeustionHelper = $helper;
    }

    public function newQuestionView(Request $request)
    {
        return view('admin.create_question');
    }

    public function addNewQuestionToSession(Request $request)
    {
        $this->qeustionHelper->addNewQuestion($request);
    }

    public function updateQuestionAjax(Request $request)
    {
        $old_question = Question::find($request->question_id);
        $old_question->delete();

        $this->saveNewQuestion($request);
    }

    /*while test updating*/
    public function saveNewQuestion(Request $request)
    {

        $test_id = Session::get('editing_test_id');
        $question = new Question();
        $question->test_id = $test_id;
        $question->answer_type_id = $request->answer_type;
        $question->question_text = $request->question_text;
        $question->save();


        foreach ($request->wrong_answer_text as $answer_text)
        {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->answer = $answer_text;
            $answer->isCorrect = 0;
            $answer->save();
        }

        foreach ($request->correct_answer_text as $answer_text)
        {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->answer = $answer_text;
            $answer->isCorrect = 1;
            $answer->save();
        }
    }

    public function getQuestionAjax(Request $request)
    {
        $question_id = $request->question_id;
        $question = Question::find($question_id);

        return response()->json(['question'=>$question]);
    }

    public function deleteQuestionAjax(Request $request)
    {
        $id = $request->question_id;
        $question = Question::find($id);
        $answers = $question->answers()->get();
        foreach ($answers as $answer)
        {
            $answer->delete();
        }

        $question->delete();
    }
}
