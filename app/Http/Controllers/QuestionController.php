<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\QuestionCreatorHelper;

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
}
