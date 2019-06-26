<?php

namespace App\Http\Controllers;

use App\Helpers\SessionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Test;
use App\Helpers\TestHelper;

class TestController extends Controller
{
    private $testHelper;

    public function __construct(TestHelper $helper)
    {
        $this->testHelper = $helper;
    }

    public function createIndex()
    {
        SessionHelper::clearSession();

        return view('admin.test_name');
    }

    /**
     * find test by id and put questions to session
     */
    public function startTest($id)
    {
        $this->testHelper->prepareQuestionsForTest($id);

        return view('user.testing');
    }

    public function showCurrentTestResult()
    {

        if(!Session::exists('test_id')) {
            return redirect('/home');
        }
        $result = $this->testHelper->calculateResult();

        $test = Test::find(Session::get('test_id'));
        $test_name = $test->test_name;
        return view('user.testResult', compact('test_name', 'result'));
    }

    /**
     * gets from session new question
     */
    public function getNewQuestion()
    {
        $question = $this->testHelper->putNextQuestionToSession();

        if ($question->answer_type_id == 1) {
            $answers = $question->answers()->get();

            return view('user.question_a1', compact('question', 'answers'));
        } elseif ($question->answer_type_id == 2) {
            $answers = $question->answers()->get();

            return view('user.question_a2', compact('question', 'answers'));
        } elseif ($question->answer_type_id == 3) {
            return view('user.question_a3', compact('question'));
        }
    }

    public function saveAnswerToSession(Request $request)
    {
        $this->testHelper->saveAnswerToSession($request);

        if ($this->testHelper->checkIfLastQuestion()) {
            return 0;
        }
    }

    public function getTestsList()
    {
        $tests = Test::all();
        return view('user.chooseTest', compact('tests'));
    }

    public function getAdminTestList()
    {
        $tests = Test::all();
        return view('admin.testlist', compact('tests'));
    }

    public function delete($id)
    {
        $test = Test::find($id);
        $test->delete();

        return redirect()->back();
    }

    public function addTestName(Request $request)
    {
        Session::put('test_name', $request->test_name);
        Session::put('questions_cnt', 1);
    }

    public function endTestCreation()
    {
        try {
            $this->testHelper->endTestCreation();
        } catch (Exception $e) {
            return redirect('/home');
        }

        return redirect('/home');
    }
}
