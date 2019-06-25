@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/admin/chooseTest.css')}}">
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <ul>
                    @foreach($tests as $test)
                        <li><a href="/test/{{$test->id}}">{{$test->test_name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
