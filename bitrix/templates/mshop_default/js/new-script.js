$(document).ready(function(){
    //показываем popup "Регистрация пользователя"

    $(".js-entry").click(function(event) {
        event.preventDefault();
        $('.c-popup_entry').toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');
    });

    $(".js-reg").click(function(event) {
        console.log("ghbdtn");
        event.preventDefault();
        $(".c-popup_entity").toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');
    });

    /*закрыть popup*/
    $(".c-popup_close").click(function(event) {
        event.preventDefault();
        $(this).parent('.c-popup').toggleClass('c-popup_show');
        $('.c-popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');
    });

    $('#entity_file').on('change', function(){
        $(this).siblings('input[type="file"]').removeClass('is-hidden');
    });

    $('#entity_callback, #entity_yourself').on('change', function(){
        $('#entity_file').siblings('input[type="file"]').addClass('is-hidden');
    });

    $(".phone-mask").mask("+7(999)999-99-99");
    $(".js-profile_date").mask("99.99.9999");

    $(".c-popup_entity form input[type='checkbox']").on('change', function(){
        if($('#entity_confirmation-stock').prop('checked') && $('#entity_confirmation-data').prop('checked') && $('#entity_confirmation-pact').prop('checked')){
            console.log('hello');
            $(".c-popup_entity .c-form_button").removeAttr('disabled');
        }else {
            $(".c-popup_entity .c-form_button").attr('disabled', 'disabled');
        }
    });

    $(".products").owlCarousel();
});


