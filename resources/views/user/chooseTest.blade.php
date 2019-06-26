@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/admin/chooseTest.css')}}">
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-center"><h4>Список доступных тестов</h4></div>
            <div class="card-body">
                <ul>
                    @foreach($tests as $test)
                        <li><a href="/test/{{$test->id}}">{{$test->test_name}}</a></li>
                        <p style="position: relative">вопросов: {{$test->countOfQuestions()}}</p>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
