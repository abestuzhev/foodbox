
$(document).ready(function () {

    $('.no-thanks').click(function () {
        $('.change_phone .c-popup_close').trigger('click');
    });

    $('.another-phone').click(function () {
        $('#enter-phone').show();
        $('#send-phone-code').hide();
        $('#entry_phone').val('');
    });

    $('#entry_phone').keyup(function () {
        if ($(this).val().length < 16) {
            $('#send-code').prop('disabled', true);
        } else {
            $('#send-code').prop('disabled', false);
        }
    })
    window.sended = 0;
    $("#sendCode").click(function (e) {
        e.preventDefault();
        $('#profile_phone').trigger('click');
//        if (window.sended < 3) {
//            e.preventDefault();
//            $.ajax({
//                type: 'POST',
//                url: url + "/sms.php",
//                data: {
//                    tel: $("#profile_phone").val(),
//                },
//                onsuccess: function (res) {
//                    window.sended++;
//                }
//            });
//        }
    });
    $("#check").click(function (e) {

        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: url + "/sms.php",
            data: {
                check_code: 'Y',
                code: $("#profile_code").val(),
            },
            success: function (res) {
                if (parseInt(res.error) == 0)
                    window.location.reload();
            }
        });

    });
    $('.js-add-additional_phone').on("click", function (e) {
        e.preventDefault();
        $(this).hide();
        $('#additional_phone').show();
    });
    $("#profile_phone, .checked").click(function (event) {
        event.preventDefault();
        $('.change_phone.c-popup_entry').addClass('c-popup_show');
        $('.c-popup_bg').addClass('is-visible');
        $('.change_phone.c-popup_entry').parents('.c-popup_container').addClass('c-popup_show');
        $('body').addClass('body-popup');
    });
})

function checkCode() {
    $.ajax({
        type: 'POST',
        url: url + "/sms.php",
        data: {
            check_code: 'Y',
            code: $("#entry_code").val(),
            phone: $('#entry_phone').val()
        },
        success: function (res) {
            if (parseInt(res.error) == 0) {
                $('.messages_alert').text(res.code);
                $('.messages_alert').fadeIn();
                $('#profile_phone').val(res.phone);
                setTimeout(function () {
                    $('.messages_alert').fadeOut();
                    $('.change_phone .c-popup_close').trigger('click');
                    window.location.reload();
                }, 1000)
            } else {
                $('.messages_alert').removeClass('hidden');
                $('.messages_alert').text(res.code);
            }
        }
    });
}
function sendSms() {
    $('.messages_alert').addClass('hidden');

    if (window.sended < 3) {
        $.ajax({
            type: 'POST',
            url: url + "/sms.php",
            data: {
                tel: $("#entry_phone").val(),
            },
            success: function (res) {
                if (parseInt(res.error) > 0) {
                    $('.messages_alert').removeClass('hidden');
                    $('.messages_alert').text(res.code);
                } else {
                    window.sended++;
                    $('#enter-phone').hide();
                    $('#send-phone-code').show();
                    $('.confirm_phone_container').html($('#entry_phone').val());
                }
            }
        });
    }
}