<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header head">
                <div>{{Session::get('test_name')}}</div>
                <div>Осталось вопросов: {{Session::get('questions_cnt')}}</div>
            </div>

            <div class="card-body">
                <form id="answer_form">
                    <input type="hidden" value="{{$question->answer_type_id}}" name="answer_type"id="answer_type">
                    <h3 class="mb-4">{{$question->question_text}}</h3>
                    @foreach($answers as $answer)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" name="answers[]" id="answer_radio" value="{{$answer->id}}">
                            <label class="form-check-label">
                                {{$answer->answer}}
                            </label>
                        </div>
                    @endforeach

                    @if(Session::get('questions_cnt')==1)
                        <input onclick="next_question()" type="button" class="btn btn-danger next-btn mr-3"
                               value="Завершить">
                    @else
                        <input onclick="next_question()" type="button" class="btn btn-success next-btn mr-3"
                               value="Следуйщий вопрос">
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
