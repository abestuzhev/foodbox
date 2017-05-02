$(document).ready(function(){
    //показываем popup "Регистрация пользователя"
    $("#ddEntry").click(function(event) {
        event.preventDefault();
        $('.c-popup_reg-user').toggleClass('c-popup_show');
        $('.popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');
    });

    /*Ваша заявка отправлена*/
    $(".popup-sent_close").click(function(event) {
        event.preventDefault();
        $('.popup-sent').toggleClass('popup-show');
        $('.popup_bg').toggleClass('is-visible');
        $('body').toggleClass('body-popup');
    });
});


$(".c-popup_entity form").on('change', function(){
   if($('#entity_confirmation-stock').is('checked') || $('#entity_confirmation-data').is('checked') || $('#entity_confirmation-pact').is('checked')){
     $(".c-popup_entity .c-popup_button").removeAttr('checked');
   }
});