$(document).ready(function () {

});

function add_right_answer() {
    var field = document.getElementById('correct_answer_field');
    var question_type = document.getElementById('questionTypeSelect');
    if (field != null && question_type.value == 1) {
        alert('В данном типе вопроса возможен добавить только один правильный ответ');
        return;
    }
    $(".answers").append('<div class="form-group mt-2">\n' +
        '                                    <label class="text-success">Ответ</label>\n' +
        '<a href="#" id="delete-btn" onclick="remove_div(this)">удалить</a>\n' +
        '                                    <input name="correct_answer_text[]" required id="correct_answer_field" type="text" class="form-control">\n' +
        '                                </div>')
}

function add_wrong_answer() {

    $(".answers").append('<div class="form-group mt-2">\n' +
        '                                    <label class="text-danger">Ответ</label>\n' +
        '<a href="#" id="delete-btn" onclick="remove_div(this)">удалить</a>\n' +
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

function next_question()
{
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
        url : '/test/create/add_question_ajax',
        dataType: 'html',
        data: form.serialize(),
        success: function(data){
            $('.test-block').load('/test/create/newQuestionView');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}

function endCreation()
{
    location.href = "/test/endCreation";
}

function next_step() {

    var test_name = document.getElementById('testName').value;
    if(test_name=='') {
        alert('Введите название теста!');
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "GET",
        url : '/test/addTestName',
        data: {test_name : test_name},
        success: function(data){
            $('.test-block').load('/test/create/newQuestionView');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    })
}
