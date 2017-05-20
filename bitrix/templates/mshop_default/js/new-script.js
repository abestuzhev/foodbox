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

    $('.js-readmore').readMore({
        readMoreLinkClass: "read-more__link",
        readMoreText: "Подробнее",
        readLessText: "Скрыть",
        readMoreHeight: 96
    });

    //в фауле profile.html добавление дополнительнгго поля для телефона
    $('.js-add-additional_phone').on("click", function(e){
        e.preventDefault();
        $(this).hide();
        $('#additional_phone').show();
    })

    /***************************************/
    /***************************************/
    /***************************************/
    /*search button*/


    function buttonUp(){
        var valux = $('.sb-search-input').val();
        valux = $.trim(valux).length;
        if(valux !== 0){
            $('.sb-search-submit').css('z-index','99999');
        } else{
            $('.sb-search-input').val('');
            $('.sb-search-submit').css('z-index','-999');
        }
    }


    var submitIcon = $('.sb-icon-search');
    var submitInput = $('.sb-search-input');
    var searchBox = $('.sb-search');
    var isOpen = false;

    $(document).mouseup(function(){
        if(isOpen == true){
            submitInput.val('');
            $('.sb-search-submit').css('z-index','-999');
            submitIcon.click();
        }
    });

    submitIcon.mouseup(function(){
        return false;
    });

    searchBox.mouseup(function(){
        return false;
    });

    submitIcon.click(function(){
        if(isOpen == false){
            searchBox.addClass('sb-search-open');
            isOpen = true;
        } else {
            searchBox.removeClass('sb-search-open');
            isOpen = false;
        }
    });


//кнопка вверх
    var offset = 300,
        offset_opacity = 1200,
        scroll_top_duration = 700,
        $back_to_top = $('.cd-top');
    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $back_to_top.addClass('cd-fade-out');
        }
    });
    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
                scrollTop: 0
            }, scroll_top_duration
        );
    });

});


