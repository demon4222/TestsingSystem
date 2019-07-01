@extends('layouts.app')

@push('scripts')
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script src="{{asset('js/admin/edit_test.js')}}"></script>
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center"><h4>Редактирование теста</h4></div>
                    <div class="card-body">
                        <form method="post" id="edit_name_form">
                            @csrf
                            <div class="form-group">
                                <label>Название теста</label>
                                <input type="hidden" name="test_id" value="{{$test->id}}">
                                <input type="text" class="form-control" name="new_name" value="{{$test->test_name}}">
                                <input type="button" onclick="edit_test_name()" class="btn btn-success mt-3"
                                       value="Изменить">
                            </div>
                        </form>

                        <div class="form-group">
                            <label>Список вопросов:</label>
                            <label style="float: right;">Всего вопросов: {{count($questions)}}</label>
                            <select class="form-control" id="all_questions_list" onchange="change_question()">
                                @foreach($questions as $question)
                                    <option value="{{$question->id}}">{{$question->question_text}}</option>
                                @endforeach
                            </select>

                            <input type="button" onclick="add_new_question()" class="btn btn-success mt-4"
                                   value="Новый вопрос">
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" id="question_block">
                                <form id="question_form">
                                    @csrf
                                    @if(!$questions->isEmpty())
                                        <div class="form-group">
                                            <label>Тип вопроса</label>
                                            <select name="answer_type" class="form-control" id="questionTypeSelect"
                                                    onchange="type_change()">
                                                @if($questions[0]->answer_type_id==1)
                                                    <option selected value="1">Один вариант ответа</option>
                                                @else
                                                    <option value="1">Один вариант ответа</option>
                                                @endif
                                                @if($questions[0]->answer_type_id==2)
                                                    <option selected value="2">Много вариантов ответов</option>
                                                @else
                                                    <option value="2">Много вариантов ответов</option>
                                                @endif
                                                @if($questions[0]->answer_type_id==3)
                                                    <option selected value="3">Текстовый ответ</option>
                                                @else
                                                    <option value="3">Текстовый ответ</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Вопрос:</label>
                                            <input name="question_text" id="question_text_field" required type="text"
                                                   class="form-control" value="{{$questions[0]->question_text}}">
                                        </div>

                                        <div class="answers">
                                            @foreach($questions[0]->answers()->get() as $answer)
                                                @if($answer->isCorrect == 1)
                                                    <div class="form-group mt-2">
                                                        <label class="text-success">Ответ</label>
                                                        <a href="#" id="delete-btn"
                                                           onclick="remove_div(this)">удалить</a>
                                                        <input name="correct_answer_text[]" required
                                                               id="correct_answer_field" value="{{$answer->answer}}"
                                                               type="text" class="form-control">
                                                    </div>
                                                @else
                                                    <div class="form-group mt-2">
                                                        <label class="text-danger">Ответ</label>
                                                        <a href="#" id="delete-btn"
                                                           onclick="remove_div(this)">удалить</a>
                                                        <input name="wrong_answer_text[]" id="wrong_answer_field"
                                                               value="{{$answer->answer}}" required type="text"
                                                               class="form-control">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div id="butt-block" class="mb-3">
                                            @if($questions[0]->answer_type_id!=3)
                                                <input onclick="add_wrong_answer()" type="button"
                                                       class="btn btn-primary "
                                                       id="add-false-btn"
                                                       value="Ложный вариант">
                                                <input onclick="add_right_answer()" type="button"
                                                       class="btn btn-primary "
                                                       id="add-right-btn"
                                                       value="Правильный вариант">
                                            @else
                                                <div class="form-group mt-2">
                                                    <label class="text-success">Ответ</label>
                                                    <input name="correct_answer_text[]" id="correct_answer_field"
                                                           required
                                                           type="text" class="form-control"
                                                           value="{{$questions[0]->answers()->first()->answer}}">
                                                </div>
                                            @endif
                                        </div>

                                        <input onclick="update_question()" type="button"
                                               class="btn btn-success next-btn mr-3"
                                               value="Сохранить">
                                        <input onclick="delete_question()" style="float: right;" type="button"
                                               class="btn btn-danger next-btn mr-3"
                                               value="Удалить вопрос">
                                        <input type="hidden" name="question_id" value="{{$questions[0]->id}}" id="question_id">
                                        <input type="hidden" name="answer_type" value="{{$questions[0]->answer_type_id}}" id="answer_type">
                                    @endif
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
