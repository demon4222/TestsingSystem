@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body row text-center">
                <div class="col-3">
                    <h4>Имя пользователя</h4>
                    @foreach($results as $result)
                        <div class="column my-2">
                            {{$result->user()->first()->name}}
                        </div>
                    @endforeach
                </div>
                <div class="col-3">
                    <h4>Тест</h4>
                    @foreach($results as $result)
                        <div class="column my-2">
                            {{$result->test()->first()->test_name}}
                        </div>
                    @endforeach
                </div>
                <div class="col-3">
                    <h4>Результат</h4>
                    @foreach($results as $result)
                        <div class="column my-2">
                            {{$result->result}}
                        </div>
                    @endforeach
                </div>
                <div class="col-3">
                    <h4>Дата</h4>
                    @foreach($results as $result)
                        <div class="column my-2">
                            {{$result->created_at}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
