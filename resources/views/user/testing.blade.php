@extends('layouts.app')

@push('styles')

@endpush

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{asset('js/user/testing.js')}}"></script>
@endpush

@section('content')
    <div class="container test-block">

    </div>
@endsection
