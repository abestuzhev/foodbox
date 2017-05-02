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
});


$(".c-popup_entity form").on('change', function(){
   if($('#entity_confirmation-stock').is('checked') || $('#entity_confirmation-data').is('checked') || $('#entity_confirmation-pact').is('checked')){
     $(".c-popup_entity .c-popup_button").removeAttr('checked');
   }
});