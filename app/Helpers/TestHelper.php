<?php


namespace App\Helpers;

use App\Answer;
use App\Question;
use App\Result;
use App\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\SessionHelper;

class TestHelper
{
    private function putQuestionsToSession($test)
    {
        $questions = $test->questions()->get()->toArray();
        shuffle($questions);

        Session::put('questions_cnt', count($questions));
        foreach ($questions as $question) {
            Session::push('question_id', $question['id']);
        }
    }

    public function prepareQuestionsForTest($test_id)
    {
        SessionHelper::clearSession();
        Session::put('test_id', $test_id);
        $test = Test::find($test_id);

        $this->putQuestionsToSession($test);
    }

    public function checkIfLastQuestion()
    {
        $questions_left = Session::get('questions_cnt');
        $isLast = ($questions_left == 1) ? true : false;
        if (!$isLast)
            $this->updateQuestionsCount($questions_left);
        return $isLast;
    }

    private function updateQuestionsCount($questions_left)
    {
        $questions_left--;
        Session::put('questions_cnt', $questions_left);
    }

    public function putNextQuestionToSession()
    {
        $question = $this->getUpdatedQuestionList();

        return $question;
    }

    private function getUpdatedQuestionList()
    {
        $questions_arr = Session::get('question_id');
        $question_id = reset($questions_arr);
        Session::put('current_question_id', $question_id);
        $question = Question::find($question_id);
        $updated_questions = Session::get('question_id');
        array_shift($updated_questions);
        Session::put('question_id', $updated_questions);

        return $question;
    }

    public function saveAnswerToSession($request)
    {
        $current_question_id = Session::get('current_question_id');
        if ($request->answer_type == 1 || $request->answer_type == 3) {
            Session::push('answers', ['question' => $current_question_id, 'answer' => $request->answer]);
        } elseif ($request->answer_type == 2) {
            Session::push('answers', ['question' => $current_question_id, 'answer' => $request->answers]);
        }
    }

    private function createNewTest()
    {
        $test = new Test();
        $test->test_name = Session::get('test_name');
        $test->save();
        Session::put('test_id', $test->id);

        return $test;
    }

    public function createNewQuestion($data, $test_id)
    {
        $q = new Question();
        $question_data = $data;
        $q->test_id = $test_id;
        $q->answer_type_id = $question_data['answer_type'];
        $q->question_text = $question_data['text'];
        $q->save();

        return $q;
    }

    private function createNewAnswer($question, $answer_data, $is_correct)
    {
        $a = new Answer();
        $a->question_id = $question->id;
        $a->answer = $answer_data;
        $a->isCorrect = $is_correct;
        $a->save();
    }

    public function endTestCreation()
    {
        $test = $this->createNewTest();

        foreach (Session::get('question') as $session_data) {
            $question = $this->createNewQuestion($session_data, $test->id);
            if($session_data['answer_type']!=3) {
                foreach ($session_data['wrong_answers'] as $answer) {
                    $this->createNewAnswer($question, $answer, 0);
                }
            }

            foreach ($session_data['correct_answers'] as $answer) {
                $this->createNewAnswer($question, $answer, 1);
            }
        }
    }

    private function getTestQuestionsCount()
    {
        $test_id = Session::get('test_id');
        $test = Test::find($test_id);

        return count($test->questions()->get());
    }

    private function checkIfCorrectAnswer($answer_data)
    {
        $correct = false;

        if(is_array($answer_data['answer'])) {
            $answer = Answer::find($answer_data['answer'][0]);
            $question = $answer->question()->first();
            $correct_answers_for_question = $question->answers()->where('isCorrect',1)->get();
            $count_of_correct_answers = count($correct_answers_for_question);
            $count_of_user_correct_answers = 0;
            foreach ($answer_data['answer'] as $answer_id) {
                $user_answer = Answer::find($answer_id);
                if($user_answer->isCorrect)
                    $count_of_user_correct_answers++;
            }
            if($count_of_user_correct_answers==$count_of_correct_answers)
                $correct=true;
        }
        else{
            $question = Question::find($answer_data['question']);
            if($question->answer_type_id==1) {
                $answer = Answer::find($answer_data['answer']);
                if ($answer->isCorrect)
                    $correct = true;
            }
            elseif($question->answer_type_id==3)
            {
                $correct_answer = $question->answers()->first();
                if($correct_answer->answer==$answer_data['answer'])
                    $correct=true;
            }
        }
        return $correct;
    }

    private function saveResult($result)
    {
        $newResult = new Result();
        $newResult->user_id = Auth::user()->id;
        $test_id = Session::get('test_id');
        $newResult->test_id = $test_id;
        $newResult->result = $result;
        $newResult->save();
    }

    public function calculateResult()
    {
        $countOfAllQuestions = $this->getTestQuestionsCount();

        $correctAnswersCount = 0;

        $answers = Session::get('answers');

        foreach ($answers as $answer_data) {
            // dd($answer_id);
            if ($this->checkIfCorrectAnswer($answer_data)) {

                $correctAnswersCount++;
            }
        }

        $result = intval($correctAnswersCount/$countOfAllQuestions * 100);
        $this->saveResult($result);

        return $result;
    }
}
