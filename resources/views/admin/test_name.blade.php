@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/admin/create_test.css')}}">
@endpush

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{asset('js/admin/create_test.js')}}"></script>
@endpush

@section('content')
    <div class="container test-block">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header head">
                        <div>Новый тест</div>
                        <div>Вопросов:</div>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Название теста</label>
                                <input name="test_name" id="testName" type="text" class="form-control">
                            </div>
                            <input required onclick="next_step()" type="button" class="btn btn-success next-btn" value="Далее">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
