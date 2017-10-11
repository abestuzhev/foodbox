$(document).ready(function () {
    //показываем popup "Регистрация пользователя"

    //Открыть вход
    $(".js-entry").on('click',function () {
        
        console.log('клик по классу "Войти в личный кабинет"');
        $('.c-popup_entry').addClass('c-popup_show');
        $('.c-popup_bg').addClass('is-visible');
        $('.c_auth.c-popup_entry').parents('.c-popup_container').addClass('c-popup_show');
        $('body').addClass('body-popup');
    });
    //Открыть регистрацию
    $(".js-reg").click(function () {
        
        $(".c-popup_reg-user").toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $('body').toggleClass('body-popup');
    });
    //Открыть регистрация из окна вход
    $("#linkReg").click(function (event) {
        event.preventDefault();
        $(".c-popup_close").click();
        $(".c-popup_reg-user").toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $('body').toggleClass('body-popup');
    });
    //Открыть вход вызов из окна Регистрация
    $("#linkIn").click(function (event) {
        event.preventDefault();
        $(".c-popup_reg-user.c-popup_entity").removeClass('c-popup_show');
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').removeClass('c-popup_show');
        $(".cor_user.c-popup_entity").parents('.c-popup_container').removeClass('c-popup_show');
        $('.c_auth.c-popup_entry').parents('.c-popup_container').toggleClass('c-popup_show');
        $('.c-popup_entry').toggleClass('c-popup_show');
    });
    //Открыть регитстрация юр лиц
    $("#linkCor").click(function (event) {
        event.preventDefault();
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $(".cor_user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $('.c-popup_entity').toggleClass('c-popup_show');
    });
    //Открыть регистрацию вызов из окна Вход
    $("#btn_reg_in").click(function (event) {
        event.preventDefault();
        $(".c-popup_reg-user").addClass('c-popup_show');
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $('.c_auth.c-popup_entry').parents('.c-popup_container').toggleClass('c-popup_show');
        $(".c-popup_reg-user.c-popup_entity").removeClass('c-popup_show');
        $('.c-popup_entry').toggleClass('c-popup_show');
    });
    //Открыть Вход вызов из окна Регистрации Юр Лиц
    $("#btn_entity_in").click(function (event) {
        event.preventDefault();
        $(".cor_user.c-popup_entity").removeClass('c-popup_show');
        $(".cor_user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $(".c_auth.c-popup_entry").parents('.c-popup_container').addClass('c-popup_show');
        $('.c-popup_entry').toggleClass('c-popup_show');
    });
    //Открыть Регистрация вызов из окна Регистрации Юр Лиц
    $("#btn_entity_reg").click(function (event) {
        event.preventDefault();
        $(".c-popup_reg-user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $(".cor_user.c-popup_entity").parents('.c-popup_container').toggleClass('c-popup_show');
        $(".c-popup_entity").toggleClass('c-popup_show');
        $('.c-popup_reg-user').toggleClass('c-popup_show');
    });
    //Открыть окно опроса при успешной регистрации
    /*function getQueryVariable(variable)
     {
     var query = window.location.search.substring(1);
     var vars = query.split("&");
     for (var i = 0; i < vars.length; i++) {
     var pair = vars[i].split("=");
     if (pair[0] == variable) {
     return pair[1];
     }
     }
     return(false);
     }

     function delPrm(Url, Prm) {
     var a = Url.split('?');
     var re = new RegExp('(\\?|&)' + Prm + '=[^&]+', 'g');
     Url = ('?' + a[1]).replace(re, '');
     Url = Url.replace(/^&|\?/, '');
     var dlm = (Url == '') ? '' : '?';
     return a[0] + dlm + Url;
     }
     ;

     if (getQueryVariable("reg") == "yes")
     {
     if ($("div").is(".c-popup_question"))
     {
     $('.c-popup_question').toggleClass('c-popup_show');
     $('.c-popup_bg').toggleClass('is-visible');
     $(".c-popup_question").parents('.c-popup_container').toggleClass('c-popup_show');
     $('body').toggleClass('body-popup');
     } else
     {
     history.pushState('', '', delPrm(window.location.href, "reg"));
     }
     }*/
    //конец

    /*закрыть popup*/
    $(".c-popup_close").click(function (event) {
        event.preventDefault();
        $(this).parent('.c-popup').removeClass('c-popup_show');
        $(this).parents('.c-popup_container').removeClass('c-popup_show');
        $('.c-popup_bg').removeClass('is-visible');
        $('body').removeClass('body-popup');
        $('.c-popup').removeClass('body-popup');
        history.pushState('', '', "");
    });

    $('#entity_file').on('change', function () {
        $(this).siblings('input[type="file"]').removeClass('is-hidden');
    });

    $('#entity_callback, #entity_yourself').on('change', function () {
        $('#entity_file').siblings('input[type="file"]').addClass('is-hidden');
    });

    $(".phone-mask").mask("+7(999)999-99-99");
    $(".js-profile_date").mask("99.99.9999");

    $(".c-popup_entity form input[type='checkbox']").on('change', function () {
        if ($('#entity_confirmation-stock').prop('checked') && $('#entity_confirmation-data').prop('checked') && $('#entity_confirmation-pact').prop('checked')) {
            console.log('hello');
            $(".c-popup_entity .c-form_button").removeAttr('disabled');
        } else {
            $(".c-popup_entity .c-form_button").attr('disabled', 'disabled');
        }
    });


    //Отправка формы вопроса
    $("#sendquest").click(function () {


        $.ajax({
            type: 'POST',
            url: "/bitrix/templates/foodbox_new/include/question.php",
            data: {quest: ques,
            }
        });

        $(this).parents('.c-popup_container').removeClass('c-popup_show');
        $('.c-popup_question').toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');

    });

    //Получить пароль форма Вход
    $("#getpassauth").click(function () {
        function ValidMail() {
            var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i;
            var myMail = document.getElementById('entry_login').value;
            var valid = re.test(myMail);
            if (valid)
                vmail = 1;
            else
                vmail = 0;
            return vmail;
        }

        function ValidPhone() {
            var re = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
            var myPhone = document.getElementById('entry_login').value;
            var valid = re.test(myPhone);
            if (valid)
                vphone = 1;
            else
                vphone = 0;
            return vphone;
        }

        $.ajax({
            type: 'POST',
            url: "/bitrix/templates/foodbox_new/include/getpassauth.php",
            data: {
                login: $('#entry_login').val(),
                mail: ValidMail(),
                phone: ValidPhone()
            },
            dataType: "html",
            success: function (data)
            {
                $("#mesAuth").html(data);
                console.log(">"+data);
            }
        });

    });
    //Купить без регистрации
    $("#btnnoreg").click(function () {
        $.ajax({
            type: 'POST',
            url: "/bitrix/templates/foodbox_new/include/getpassauth.php",
            data: {
                login: "fastreg",

            }
        });
        location.reload();
    });

    //изменить пароль
    $('#butpass').click(function () {
        $("#butpasssend").click();
    });
    //Изменить личные данные
    $('#butpersonal').click(function () {
        $("#butpersonalsend").click();
    });

    //Получить код
    $("#butGetCode,#linkGetCode").click(function () {
        $.ajax({
            type: 'POST',
            url: '/personal/newprofile/getCode.php',
            data: {
                tel: $("#profile_phone").val(),
            },
        });
    });
//Подтвердить код
    $("#setCode").click(function () {
        $.ajax({
            type: 'POST',
            url: '/personal/newprofile/getCode.php',
            data: {
                code: $("#profile_code").val(),
            }

        });
    });


    $("#setEmail").click(function () {
        $.ajax({
            type: 'POST',
            url: "/bitrix/templates/foodbox_new/include/emailset.php",
            data: {
                email: $('#profile_email').val(),

            }
        });
    });
    //регистрация
    $(document).ready(function () {

        $('#but_reg').click(function () {
            $.ajax({
                type: 'POST',
                url: "/bitrix/templates/foodbox_new/include/getphone.php",
                data: {
                    mail: $("#reg-user_email").val(),
                    phone: $("#reg-user_phone").val(),

                },
                success: function (data)
                {
                    if (data)
                    {
                        $("#mesReg").html(data);
                    } else
                    {
                        $("#butreg").click();
                    }
                }
            });

        });

    });
});
