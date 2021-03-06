//preloader    
var preloader = document.getElementById("preloader_preload");
function fadeOutnojquery(el) {
    el.style.opacity = 1;
    var interpreloader = setInterval(function () {
        el.style.opacity = el.style.opacity - 0.05;
        if (el.style.opacity <= 0.05) {
            clearInterval(interpreloader);
            preloader.style.display = "none";
        }
    }, 16);
}

window.onload = function () {
    setTimeout(function () {
        fadeOutnojquery(preloader);
    }, 300); //время показа после загрузки 
};

$(document).ready(function () {
//button up

    $(window).scroll(function () {

        if ($(this).width() >= 768) { //если ширина окна >= 768 пикселов
            if ($(this).scrollTop() >= 200) {//показываем
                $('#button-up').css({'display': 'initial'});
            } else if ($(this).scrollTop() <= 200) {  //убираем
                $('#button-up').css({'display': 'none'});
            }
        }
    });
    $('#button-up').click(function (e) {
        $('html, body').animate({scrollTop: 0}, 800);
        $(this).css({
            'display': 'none'
        });
        e.preventDefault();
    });
    
    
//скролл при клике на якорь //TODO переделать на data

    $(".anchor__link").on("click", function (e) {
        //отменяем стандартную обработку нажатия по ссылке
        e.preventDefault();
        //для ссылокзабираем идентификатор блока с атрибута href
        var destination = $(this).attr('href'),
                //узнаем высоту от начала страницы до блока на который ссылается якорь
                top = $(destination).offset().top;
        //анимируем переход на расстояние - top за 1000 мс
        $('body,html').animate({scrollTop: top}, 1000);
    });

// Fancy-box. Images and gallery
    $("[data-fancybox]").fancybox({
        protect: true,
        toolbar: true
    });
    
    
//inputmask
    $('.tel_mask').inputmask({
        mask: '9-(999)-999-99-99',
        jitMasking: true
    });
//    $('.name_mask').inputmask({
//        mask: 'a{55}',
//        jitMasking: true
//    });
//    $('.email_mask').inputmask({
//        mask: "*{1,20}[.*{1,20}][.-{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
//        greedy: false,
//        onBeforePaste: function (pastedValue, opts) {
//            pastedValue = pastedValue.toLowerCase();
//            return pastedValue.replace("mailto:", "");
//        }
//    });
        
    //формы 
    
    //input range
    var range_qnt = $('#reg_input_gamers_qnt');
    var range_qnt_text = $('#reg_input_gamers_qnt_text');
    range_qnt_text.text('Количество игроков : ' + range_qnt.val());
    range_qnt.on('input', function(){
        range_qnt_text.text('Количество игроков : ' + range_qnt.val());
    });
    
    //тогглер для чекбокса
    
        (function ($) {
        $.fn.toggleDisabled = function () {
            return this.each(function () {
                this.disabled = !this.disabled;
            });
        };
    })(jQuery);
    
    var timestamp = new Date().getUTCMilliseconds();

    $('#reg_input_check_gamers').on('change', function () {
        //убираем/показываем ползунок        
        $('#reg_input_gamers_qnt').toggleClass('d-none');
        //убираем/показываем инпут с названием команды
        $('.input-group-team').toggleClass('d-none');
        //если чекбокс отмечен
        if (($(this)).is(':checked')) {
            $('#reg_input_gamers_qnt[type=range]').attr('min' , '1');
            $('#reg_input_gamers_qnt[type=range]').val('1');
            $('.check[name=reg_input_team]').val('Легионер_' + timestamp);
            $('#reg_input_gamers_qnt_text').text('Количество игроков : 1');
        } else {
            $('.check[name=reg_input_team]').val('');
            $('#reg_input_gamers_qnt[type=range]').attr('min' , '2');
            $('#reg_input_gamers_qnt[type=range]').val('2');
            $('#reg_input_gamers_qnt_text').text('Количество игроков : 2');
            
        }

    });
   
    //вспомогательные функции для валидация полей.    
    function validateName(selector) {
        if (selector.val().length < 3) {
            selector.addClass('is-invalid');
            selector.focus();
            
        } else
            selector.removeClass('is-invalid');
            selector.addClass('is-valid');
    }
    
    function validateTel(selector) {
        if (selector.val().length !== 17) {
            selector.addClass('is-invalid');
        } else
            selector.removeClass('is-invalid');
            selector.addClass('is-valid');
    }
    
    function validateCheckBox(selector) {
        if(!selector.prop("checked")) {
            selector.addClass('is-invalid');
        } else
            selector.removeClass('is-invalid');
            selector.addClass('is-valid');

    }
    function validateEmail(selector) {
        var pattern = /.+@.+\..+/i;
        if(!pattern.test(selector.val())) {
            selector.addClass('is-invalid');
        } else
            selector.removeClass('is-invalid');
            selector.addClass('is-valid');
    }
                
    //обработка фомы            
    //Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
 
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                if (form.checkValidity() === false) {
                   
                    //форма регистрации
                        $('.check[name=reg_input_team]').keyup(function () {
                            validateName($('.check[name=reg_input_team]'));
                        });
                        $('.check[name=reg_input_name]').keyup(function () {
                            validateName($('.check[name=reg_input_name]'));
                        });
                        $('.check[name=reg_input_tel]').keyup(function () {
                            validateTel($('.check[name=reg_input_tel]'));
                        });
                        $('.check[name=reg_input_email]').keyup(function () {
                            validateEmail($('.check[name=reg_input_email]'));
                        });
                        $('#reg_input_check').change(function () {
                            validateCheckBox($('#reg_input_check'));
                        });
                    
                    //форма звонка
                        $('.check[name=call_input_name]').keyup(function () {
                            validateName($('.check[name=call_input_name]'));
                        });
                        $('.check[name=call_input_tel]').keyup(function () {
                            validateTel($('.check[name=call_input_tel]'));
                        });
                        $('.check[name=call_input_check], #call_input_check').change(function () {
                            validateCheckBox($('.check[name=call_input_check], #call_input_check'));
                        });
                    }   

                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false || $(this).find('.check').hasClass('is-invalid')) {
                        event.preventDefault();
                        event.stopPropagation();

                        //форма регистрации
                            validateName($('.check[name=reg_input_team]'));
                            $('.check[name=reg_input_team]').keyup(function () {
                                validateName($('.check[name=reg_input_team]'));
                            });
                            validateName($('.check[name=reg_input_name]'));
                            $('.check[name=reg_input_name]').keyup(function () {
                                validateName($('.check[name=reg_input_name]'));
                            });
                            validateTel($('.check[name=reg_input_tel]'));
                            $('.check[name=reg_input_tel]').keyup(function () {
                                validateTel($('.check[name=reg_input_tel]'));
                            });
                            validateEmail($('.check[name=reg_input_email]'));
                            $('.check[name=reg_input_email]').keyup(function () {
                                validateEmail($('.check[name=reg_input_email]'));
                            });
                            validateCheckBox($('#reg_input_check'));
                            $('#reg_input_check').change(function () {
                                validateCheckBox($('#reg_input_check'));
                            });
                        //форма звонка
                            validateName($('.check[name=call_input_name]'));
                            $('.check[name=call_input_name]').keyup(function () {
                                validateName($('.check[name=call_input_name]'));
                            });
                            validateTel($('.check[name=call_input_tel]'));
                            $('.check[name=call_input_tel]').keyup(function () {
                                validateTel($('.check[name=call_input_tel]'));
                            });
                            validateCheckBox($('.check[name=call_input_check], #call_input_check'));
                            $('.check[name=call_input_check], #call_input_check').change(function () {
                                validateCheckBox($('.check[name=call_input_check], #call_input_check'));
                            });

                    } else {
                        event.preventDefault();
                        $('#form-register button[type=submit]').attr('disabled', 'disabled').text('Ожидание...');
                        var result_ = $('.result_');
                        sendAjaxForm(result_, $(form));
                        
                    }
                    //form.classList.add('was-validated');

                }, false);
            });
        }, false);
    })();

    //функция отправки формы аяксом
    function sendAjaxForm(result_, form) {
        $.ajax({
            url: 'libs/mail.php', //url страницы 
            cache: false, // выключили кэш
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: form.serialize(), // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                var result = $.parseJSON(response);
                form.css({'display': 'none'});
                result_.removeClass('d-none');
                result_.text(result);
                $('#form-register button[type=submit]').removeAttr('disabled').text('Отправить');
            },
            error: function (response) { // Данные не отправлены
                form.css({'display': 'none'});
                result_.removeClass('d-none');
                result_.text('Ошибка. Данные не отправленны.');
            }
        });
        
        $('#modal_call , #modal_reg').on('hidden.bs.modal', function () {
            $('form').css({'display': 'initial'});
            $('.result_').addClass('d-none');
            $('input').removeClass('is-valid is-invalid');
            $('form').trigger('reset');
            $('#reg_input_gamers_qnt_text').text('Количество игроков : 2');
            //показываем ползунок        
            $('#reg_input_gamers_qnt').removeClass('d-none');
            //оказываем инпут с названием команды
            $('.input-group-team').removeClass('d-none');
            //возвращаем значеиня по - умолчанию
            $('#reg_input_gamers_qnt[type=range]').attr('min', '2');
            $('#reg_input_gamers_qnt[type=range]').val('2');
            $('#reg_input_gamers_qnt_text').text('Количество игроков : 2');
        });

    }


    //тултип у звонилки
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    if ($(window).width() >= 768) {
        $('.pulse').mouseover(function () {
            $(this).tooltip('show');
        });
    }
    
    
    //формирование данных формы
    let seasonId;
    let gameId;
    $('.timetable-item__btn , .gamestable-content__btn').click(function () {
        seasonId = $(this).data('season_id');
        gameId = $(this).data('game_id');
    });


    $('#modal_reg').on('show.bs.modal', function () {
        $.ajax({
            url: 'libs/getDataFormRegAjax.php', //url страницы 
            cache: false, // выключили кэш
            type: "POST", //метод отправки
            //dataType: "html", //формат данных
            data: {
                seasonId: seasonId,
                gameId: gameId
            },
            success: function (response) { //Данные отправлены успешно
                var result = $.parseJSON(response);
                
                $('#form_reg_game_logo').attr('src' , '../' + result.season_logo);
                
                $('#form_reg_select option').remove();
                
                for(let i = 0; i<result.gamesDate.length; i++) {
           
                    $('#form_reg_select')
                            .append('<option value="'+result.gamesDate[i].gameId+'">'
                            + result.gamesDate[i].gameDate
                            + '</option>'
                            );
                       
                }
                $('#form_reg_select').find("[value='" + result.seleceted_game_id + "']").attr('selected', 'true');
            },
            error: function (response) { // Данные не отправлены
                $('#form-game-title').text('произошла ошибка');
            },
            complete: function () {

            }
        });

    });
   
    $('#modal_call , #modal_reg').on('hidden.bs.modal', function () {
        $('input').removeClass('is-valid is-invalid');
        $('form').trigger('reset');
        $('#reg_input_gamers_qnt_text').text('Количество игроков : 2');
        //показываем ползунок        
        $('#reg_input_gamers_qnt').removeClass('d-none');
        //оказываем инпут с названием команды
        $('.input-group-team').removeClass('d-none');
        //возвращаем значеиня по - умолчанию
        $('#reg_input_gamers_qnt[type=range]').attr('min', '2');
        $('#reg_input_gamers_qnt[type=range]').val('2');
        $('#reg_input_gamers_qnt_text').text('Количество игроков : 2');
    });


//    if (!$('.timetable-more__btn').hasClass('more-btn-active')) {
//        $('.timetable-more__btn').text('больше игр').append(' <i class="fas fa-caret-down"></i>');
//    } else {
//        $('.timetable-more__btn').text('меньше игр').append(' <i class="fas fa-caret-up"></i>');
//    }
//      
    //кнопки скрытия/показа расписания игр   
    var btn_games = $('#btn_timetable');
    var btn_results = $('#btn_resulttable');
    var table_games = $('#gamestable');
    var table_results = $('#resulttable');
      
      
    $('#btn_timetable, #btn_resulttable').on('click', function () {
       $('#gamestable, #resulttable').collapse('hide');
    });
      
    $('#btn_timetable').on('click', function () {
        $('#btn_timetable').toggleClass('animated flipInX');
    });
    $('#gamestable').on('hidden.bs.collapse', function () {
        $('#btn_timetable').removeClass('animated flipInX').text('больше игр').append(' <i class="fas fa-chevron-down"></i>');
    });
    $('#gamestable').on('shown.bs.collapse', function () {
        $('#btn_timetable').removeClass('animated flipInX').text('меньше игр').append(' <i class="fas fa-chevron-up"></i>');
    });
////    
////    
    $('#btn_resulttable').on('click', function () {
        $('#btn_resulttable').toggleClass('animated flipInX');
    });
    $('#resulttable').on('hidden.bs.collapse', function () {
        $('#btn_resulttable').removeClass('animated flipInX').text('итоги игр').append(' <i class="fas fa-chevron-down"></i>');
    });
    $('#resulttable').on('shown.bs.collapse', function () {
        $('#btn_resulttable').removeClass('animated flipInX').text('итоги игр').append(' <i class="fas fa-chevron-up"></i>');
    });



   
   
//    опции карусельки
//    $('.carousel').carousel({
//        interval: 20000000
//    });
    
    
    
//end file
});


