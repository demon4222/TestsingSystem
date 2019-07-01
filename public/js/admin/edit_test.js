jQuery(document).ready(function($) {
    document.getElementById('questionTypeSelect').disabled =true;
});

function edit_test_name() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = $('#edit_name_form');

    $.ajax({
        type: "POST",
        url: '/test/edit_name',
        dataType: 'html',
        data: form.serialize(),
        success: function (data) {
            alert('Изменения сохраненны');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}


function add_right_answer() {
    var field = document.getElementById('correct_answer_field');
    var question_type = document.getElementById('questionTypeSelect');
    if (field != null && question_type.value == 1) {
        alert('В данном типе вопроса возможен добавить только один правильный ответ');
        return;
    }
    $(".answers").append('<div class="form-group mt-2">\n' +
        '                                    <label class="text-success">Ответ</label>\n' +
        '<a href="#" id="delete-btn" style="float: right" onclick="remove_div(this)">удалить</a>\n' +
        '                                    <input name="correct_answer_text[]" required id="correct_answer_field" type="text" class="form-control">\n' +
        '                                </div>')
}

function add_wrong_answer() {

    $(".answers").append('<div class="form-group mt-2">\n' +
        '                                    <label class="text-danger">Ответ</label>\n' +
        '<a href="#" id="delete-btn" style="float: right" onclick="remove_div(this)">удалить</a>\n' +
        '                                    <input name="wrong_answer_text[]" id="wrong_answer_field" required type="text" class="form-control">\n' +
        '                                </div>')
}

function type_change() {
    var question_type = document.getElementById('questionTypeSelect');
    $('.answers').empty();
    var buttons = document.getElementById('butt-block');
    if (question_type.value == 3) {
        if (buttons != null)
            buttons.innerHTML = "";
        $(".answers").append('<div class="form-group mt-2">\n' +
            '                                    <label class="text-success">Ответ</label>\n' +
            '                                    <input name="correct_answer_text[]" id="correct_answer_field" required type="text" class="form-control">\n' +
            '                                </div>');
    }
    if (question_type.value == 2 || question_type.value == 1) {
        if (buttons.innerHTML == "") {
            $('#butt-block').append('<input onclick="add_wrong_answer()" type="button" class="btn btn-primary " id="add-false-btn" value="Ложный вариант">\n' +
                '                                <input onclick="add_right_answer()" type="button" class="btn btn-primary " id="add-right-btn"\n' +
                '                                       value="Правильный вариант">');
        }
    }
}

function remove_div(btn) {
    ((btn.parentNode).parentNode).removeChild(btn.parentNode);
}

function add_new_question() {
    $('#question_form').empty();
    $('#question_form').append('<div class="form-group">\n' +
        '                                            <label>Тип вопроса</label>\n' +
        '                                            <select name="answer_type" class="form-control" id="questionTypeSelect"\n' +
        '                                                    onchange="type_change()">\n' +
        '                                                    <option value="1">Один вариант ответа</option>\n' +
        '                                                    <option value="2">Много вариантов ответов</option>\n' +
        '                                                    <option value="3">Текстовый ответ</option>\n' +
        '                                            </select>\n' +
        '                                        </div>\n' +
        '\n' +
        '                                        <div class="form-group">\n' +
        '                                            <label>Вопрос:</label>\n' +
        '                                            <input name="question_text" id="question_text_field" required type="text"\n' +
        '                                                   class="form-control" value="">\n' +
        '                                        </div>\n' +
        '\n' +
        '                                        <div class="answers">\n' +
        '                                        </div>\n' +
        '\n' +
        '                                        <div id="butt-block" class="mb-3">\n' +
        '                                                <input onclick="add_wrong_answer()" type="button"\n' +
        '                                                       class="btn btn-primary "\n' +
        '                                                       id="add-false-btn"\n' +
        '                                                       value="Ложный вариант">\n' +
        '                                                <input onclick="add_right_answer()" type="button"\n' +
        '                                                       class="btn btn-primary "\n' +
        '                                                       id="add-right-btn"\n' +
        '                                                       value="Правильный вариант">\n' +
        '                                        </div>\n' +
        '\n' +
        '                                        <input onclick="save_new_question()" type="button"\n' +
        '                                               class="btn btn-success next-btn mr-3"\n' +
        '                                               value="Сохранить">');
}

function save_new_question() {
    var answer_type = document.getElementById('questionTypeSelect');
    var question_text_field = document.getElementById('question_text_field');
    if(question_text_field.value == "")
        return alert('Введите текст вопроса!');
    var correct_answer_field = document.getElementById('correct_answer_field');
    var wrong_answer_field = document.getElementById('wrong_answer_field');
    if(correct_answer_field==null||correct_answer_field.value=='')
        return alert('Добавьте минимум один правильный ответ');
    if(answer_type.value!=3) {
        if ((wrong_answer_field == null) || wrong_answer_field.value == '')
            return alert('Добавьте минимум один ложный ответ');
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = $('#question_form');

    $.ajax({
        type: "POST",
        url: '/saveNewQuestion',
        dataType: 'html',
        data: form.serialize(),
        success: function (data) {
            alert('Вопрос сохранён!');
            location.reload();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function delete_question() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var e = document.getElementById("all_questions_list");
    var question_id = e.options[e.selectedIndex].value;
    //$('.answers').empty();

    $.ajax({
        type: "DELETE",
        url: '/deleteQuestionAjax',
        dataType: 'html',
        data: {question_id: question_id},
        success: function (data) {
            location.reload();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function change_question() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    document.getElementById('questionTypeSelect').disabled =true;
    var e = document.getElementById("all_questions_list");
    var question_id = e.options[e.selectedIndex].value;
    $('.answers').empty();

    $.ajax({
        type: "POST",
        url: '/getQuestionAjax',
        dataType: 'html',
        data: {question_id: question_id},
        success: function (data) {
            var response = JSON.parse(data);
            //console.log(response.question.id);
            if (response.question.answer_type_id == 1)
                document.getElementById('questionTypeSelect').value = 1;
            else if(response.question.answer_type_id == 2)
                document.getElementById('questionTypeSelect').value = 2;
            else if(response.question.answer_type_id == 3)
                document.getElementById('questionTypeSelect').value = 3;
            document.getElementById('question_text_field').value = response.question.question_text;
            document.getElementById('question_id').value = response.question.id;
            getAnswersAjax(response.question);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function getAnswersAjax(question) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: '/getAnswersByQuestionAjax',
        dataType: 'html',
        data: {question_id: question.id},
        success: function (data) {
            var response = JSON.parse(data);
            render_answers(response.answers);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function update_question()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = $('#question_form');

    $.ajax({
        type: "POST",
        url: '/updateQuestion',
        dataType: 'html',
        data: form.serialize(),
        success: function (data) {
            console.log(data);
            alert('Данные обновлены!');
            location.reload();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function render_answers(answers) {
    answers.forEach(function (answer) {
        if (answer.isCorrect) {
            $(".answers").append('<div class="form-group mt-2">\n' +
                '                                    <label class="text-success">Ответ</label>\n' +
                '<a href="#" id="delete-btn" onclick="remove_div(this)">удалить</a>\n' +
                '                                    <input name="correct_answer_text[]" required id="correct_answer_field" value="' + answer.answer + '" type="text" class="form-control">\n' +
                '                                </div>')
        } else {
            $(".answers").append('<div class="form-group mt-2">\n' +
                '                                    <label class="text-danger">Ответ</label>\n' +
                '<a href="#" id="delete-btn" onclick="remove_div(this)">удалить</a>\n' +
                '                                    <input name="wrong_answer_text[]" id="wrong_answer_field" value="' + answer.answer + '" required type="text" class="form-control">\n' +
                '                                </div>')
        }
    });
}
