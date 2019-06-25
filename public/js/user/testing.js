$(document).ready(function () {
    $('.test-block').load('/get_question');
});

function next_question() {
    var answer_type = document.getElementById('answer_type');
    if (answer_type.value == 1) {
        var checked = false;
        var rad = document.getElementsByName('answer');
        for (var i = 0; i < rad.length; i++) {
            if (rad[i].checked) {
                checked = true;
            }
        }
        if (!checked) {
            alert('Выберете вариант ответа!');
            return;
        }
    } else if (answer_type.value == 2) {
        var checked = false;
        var ch = document.querySelectorAll('input[type=checkbox]:checked');
        for (var i = 0; i < ch.length; i++) {
            if (ch[i].checked) {
                checked = true;
            }
        }
        if (!checked) {
            alert('Выберете вариант ответа!');
            return;
        }
    } else if (answer_type.value == 3) {
        var answer_field = document.getElementById('answer_text');
        if (answer_field.value == '') {
            alert('Введите ответ!');
            return;
        }
    }
    if (($('input[name=answer]:checked')) && answer_type.value != 3) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#answer_form')

        $.ajax({
            type: "POST",
            url: '/test/saveAnswerToSession',
            dataType: 'html',
            data: form.serialize(),
            success: function (data) {
                // alert(data);
                // if (!data)
                //     $('.test-block').load('/get_question');
                // else
                //     location.href = '/result';
                if (!data)
                    $('.test-block').load('/get_question');
                else
                    location.href = '/result';
            },
            error: function (data) {
                console.log('Error:', data);
            }
        })

    }
}

function finish_test() {
    location.href = '/result';
}
