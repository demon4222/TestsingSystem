@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header text-center"><h4>Список доступных тестов</h4></div>
            <div class="card-body">
                <ul>
                    @foreach($tests as $test)
                        <form action="/test/delete/{{$test->id}}" method="post">
                            <div class="px-4" style="border-bottom: 1px solid grey;">
                                <a class="btn btn-info" href="/test/edit/{{$test->id}}">Редактировать</a>
                                <input style="position: relative; float: right;" class="btn btn-default" type="submit" value="Удалить" />
                                @method('delete')
                                @csrf
                                <li><a class="" href="/test/{{$test->id}}">{{$test->test_name}}</a></li>
                                <p style="position: relative">вопросов: {{$test->countOfQuestions()}}</p>
                            </div>
                        </form>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection
