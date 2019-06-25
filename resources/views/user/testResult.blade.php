@extends('layouts.app');

@push('scripts')

@endpush

@section('content')

    <div class="container test-block">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header head">
                        <div class="text-center">{{$test_name}}</div>
                    </div>

                    <div class="card-body">
                        Ваш результат: {{$result}}
{{--                        <ul class="list-group">--}}
{{--                            <li class="list-group-item list-group-item-success">A simple success list group item</li>--}}
{{--                            <li class="list-group-item list-group-item-danger">A simple danger list group item</li>--}}
{{--                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
