<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header head">
                <div>{{Session::get('test_name')}}</div>
                <div>Вопросов: {{Session::get('questions_cnt')-1}}</div>
            </div>

            <div class="card-body">
                <form id="question_form">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Тип вопроса</label>
                        <select name="answer_type" class="form-control" id="questionTypeSelect"
                                onchange="type_change()">
                            <option value="1">Один вариант ответа</option>
                            <option value="2">Много вариантов ответов</option>
                            <option value="3">Текстовый ответ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Введите вопрос</label>
                        <input name="question_text" id="question_text_field" required type="text" class="form-control">
                    </div>

                    <div class="answers"></div>

                    <div id="butt-block" class="mb-3">
                        <input onclick="add_wrong_answer()" type="button" class="btn btn-primary " id="add-false-btn"
                               value="Ложный вариант">
                        <input onclick="add_right_answer()" type="button" class="btn btn-primary " id="add-right-btn"
                               value="Правильный вариант">
                    </div>

                    <input onclick="endCreation()" type="button" class="btn btn-danger next-btn" value="Завершить">
                    <input onclick="next_question()" type="button" class="btn btn-success next-btn mr-3"
                           value="Добавить вопрос">
                </form>
            </div>
        </div>
    </div>
</div>
