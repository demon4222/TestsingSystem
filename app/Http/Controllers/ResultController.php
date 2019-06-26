<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Result;

class ResultController extends Controller
{
    public function indexUser()
    {
        $results = Result::where('user_id', Auth::user()->id)->get();

        return view('results.userResults', compact('results'));
    }

    public function indexRating()
    {
        $results = Result::all();

        return view('admin.rating', compact('results'));
    }
}
