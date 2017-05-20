var needOffset = 0;
var needOffset = 0;
var elementsWidth = 0;

if (BX) {
    BX.showWait = function (el) {
        RSMONOPOLY_Area2Darken($(el));
    };

    BX.closeWait = function (el) {
        RSMONOPOLY_Area2Darken($(el));
    };
}

var rsMshop = window.rsMshop || {};
rsMshop = {
    options: {
        breakpoints: {
            xs: 480,
            sm: 768,
            md: 992,
            lg: 1200
        }
    }
}

function SendAnalyticsGoal(event) {
    //ga('send', 'event', event, document.URL);
    yaCounter38959340.reachGoal(event);
    console.log(event);
}

function RSMONOPOLY_hideLis(resize) {
    // main menu
    /*if( $('.main-menu-nav').length>0 ) {
     var $menu = $('.main-menu-nav');
     $menu.find('.other').removeAttr('style');
     if($(document).width()>=970) {
     element = $menu.find('.lvl1')[0];
     needOffset = $(element).offset();
     needOffset = needOffset.top;
     $menu.find('.lvl1').each(function(index) {
     offset = $(this).offset();
     offset = offset.top;
     if(offset!=needOffset) {
     $(this).addClass('invisible');
     $menu.find('.other').removeClass('invisible');
     if($menu.find('.other #element'+$(this).attr('id')).length>=1) {
     $menu.find('.other #element'+$(this).attr('id')).show();
     } else {
     if(resize) {
     $menu.find('.other ul.dropdown-menu').prepend('<li class="other_li" id="element'+$(this).attr('id')+'">'+$(this).html()+'</li>');
     } else {
     $menu.find('.other ul.dropdown-menu').append('<li class="other_li" id="element'+$(this).attr('id')+'">'+$(this).html()+'</li>');
     }
     }
     } else {
     $(this).removeClass('invisible');
     if($menu.find('.other #element'+$(this).attr('id')).length>=1) {
     $menu.find('.other #element'+$(this).attr('id')).hide();
     }
     }
     });
     } else {
     $menu.find('.lvl1').each(function(index) {
     $(this).removeClass('invisible');
     $menu.find('.other').addClass('invisible');
     });
     }
     elementsWidth = 0;
     $menu.find('li.lvl1').each(function(index){
     if (!$(this).hasClass('invisible')) {
     elementsWidth = elementsWidth + $(this).outerWidth(true);
     }
     });
     width = $menu.width() - elementsWidth;
     $menu.find('.other').css('width', width);
     $menu.removeAttr('style');
     if ($menu.find('.lvl1.invisible').length==0) {
     $menu.find('.other').hide();
     } else {
     $menu.find('.other').show();
     }
     }
     // top line dropdown's and stores
     var $dd1 = $('.top_line_menu_responsive').find('.dropdown-menu'),
     $dd2 = $('.authinhead').find('.dropdown-menu');
     //$dd3 = $('.js-stores').find('.dropdown-menu');
     if ($dd1.length > 0 || $dd2.length > 0 || $dd3.length > 0) {
     $('body').trigger('click');
     if ($(document).width() <= 751) {
     //var $dd3Link = $dd3.parent().find(".dropdown-toggle")
     //var dd3offset = -$(document).width() + $dd3Link.offset().left + $dd3Link.width() + "px";
     var w = ($(document).width() - 2) + 'px';
     $dd1.css({'left': '-14px', 'width': w});
     $dd2.css({'right': '-14px', 'width': w});
     //$dd3.css({'right': dd3offset, 'width': w});
     } else {
     $dd1.removeAttr('style');
     $dd2.removeAttr('style');
     //$dd3.removeAttr('style');
     }
     }*/
}

// Area2Darken
function RSMONOPOLY_Area2Darken(areaObj) {
    areaObj.toggleClass('area2darken');
}

// drop fancybox on mobile
function RSMONOPOLY_DropFancy() {
    if ($(document).width() < 600) {
        $('.fancyajax').removeClass('fancyajax fancybox.ajax').addClass('fancyajaxwait');
        $("#ddbasketinhead").attr('data-toggle', '');
    } else {
        $('.fancyajaxwait').removeClass('fancyajaxwait').addClass('fancyajax fancybox.ajax');
        $("#ddbasketinhead").attr('data-toggle', 'dropdown');
    }
}


// popup gallery
function RSMONOPOLY_PopupGallerySetHeight() {
    if ($('.popupgallery').length > 0) {
        if ($(document).width() > 767) {
            var innerHeight = parseInt($('.popupgallery').parents('.fancybox-inner').height()),
                h1 = innerHeight - 55,
                h2 = h1 - 30,
                h3 = innerHeight - 55 - parseInt($('.popupgallery').find('.preview').height());
            $('.popupgallery').find('.thumbs.style1').css('maxHeight', h3);
        } else {
            var fullrightHeight = parseInt($('.popupgallery').find('.fullright').height());
            var innerHeight = parseInt($('.popupgallery').parents('.fancybox-inner').height()),
                h1 = innerHeight - 55 - fullrightHeight - 25,
                h2 = h1 - 30 - fullrightHeight - 25,
                h3 = innerHeight - 55 - parseInt($('.popupgallery').find('.preview').height());
            $('.popupgallery').find('.thumbs.style1').css('maxHeight', 100);
        }
        $('.popupgallery').find('.changeit').css('height', h1);
        $('.popupgallery').find('.changeit').find('img').css('maxHeight', h2);
    }
}
function RSMONOPOLY_PopupGallerySetPicture() {
    // TODO: РІС‹Р±СЂР°С‚СЊ РёР·РѕР±СЂР°Р¶РµРЅРёРµ РІ РіР°Р»РµСЂРµРµ
}

// set set
function RSMONOPOLY_SetSet() {
    RSMONOPOLY_SetCompared();
    RSMONOPOLY_SetInBasket();
    RSMONOPOLY_SetInFavorite();
}
// set compare
function RSMONOPOLY_SetCompared() {
    $('.js-compare').removeClass('checked');
    for (element_id in RSMONOPOLY_COMPARE) {
        if (RSMONOPOLY_COMPARE[element_id] == 'Y' && $('.js-elementid' + element_id).find('.js-compare').length > 0) {
            $('.js-elementid' + element_id).find('.js-compare').addClass('checked').find('.count').html(' (' + RS_MONOPOLY_COUNT_COMPARE + ')');
        }
    }
    $('.js-compare:not(.checked)').find('.count').html('');
}
// set in basket
function RSMONOPOLY_SetInBasket() {
    $('.add2basketform').removeClass('checked');
    for (element_id in RSMONOPOLY_INBASKET) {
        if (
            (
                RSMONOPOLY_INBASKET[element_id] == 'Y' ||
                $.isNumeric(RSMONOPOLY_INBASKET[element_id])
            ) &&
            $(".js-add2basketpid[value='" + element_id + "']").length > 0
        ) {
            $('.js-add2basketpid[value="' + element_id + '"]').parents('.add2basketform').addClass('checked');
        }
    }
}
// set favorite
function RSMONOPOLY_SetInFavorite() {
    $('.favorite').removeClass('checked');
    if ($(".favorite > span").length) {
        $(".favorite > span").text(BX.message('RSMONOPOLY_JS_BTN_BOX'));
    }
    for (var id in RSMONOPOLY_FAVORITE) {
        if (RSMONOPOLY_FAVORITE[id] == 'Y') {
            $(".favorite[data-elementid=" + id + "]").addClass("checked");
            if ($(".favorite[data-elementid=" + id + "] > span").length) {
                $(".favorite[data-elementid=" + id + "] > span").text(BX.message('RSMONOPOLY_JS_BTN_GOBOX'));
            }
        }
    }
}

$(document).ready(function () {

    var AddToBasketPopup = BX.PopupWindowManager.create('CatalogSectionBasket_', null, {
        autoHide: false,
        offsetLeft: 0,
        offsetTop: 0,
        overlay: true,
        closeByEsc: true,
        titleBar: true,
        closeIcon: true,
        contentColor: 'white'
    });

    $('.fancypopup').fancybox({
        autoResize: true,
        autoHeight: true,
        autoWidth: true
    });

    var $smallBasket = $(".js-basketline").smallBasket();
    $smallBasket.on("smallBasket.recalculated", function (e, data) {
        data.BASKET_DATA.ITEMS.AnDelCanBuy.forEach(function (item) {
            $smallBasket.find(".js-product[data-product-id=" + item.ID + "] .price").text(item.SUM)
        });
        $('.smallbasketAllSum b').text(data.BASKET_DATA.allSum_FORMATED);
    });
    $smallBasket.on("smallBasket.quantityChange", function (e, data) {
        $smallBasket.trigger("smallBasket.recalculate");
    });

    $(document).on("click", ".dropdown-smallbasket", function (e) {
        e.stopPropagation();
    });

    // Success send message from fancybox
    $(document).on("closeFancy", function () {
        if ($.fancybox && $.fancybox.isOpen) {
            setTimeout($.fancybox.close, 1500);
        }
    });

    // Dropdown hack
    $(document).on("show.bs.dropdown", ".products .js-stores.dropdown", function () {
        'use strict';
        var documentWidth = $(document).width() - 3,
            $this = $(this),
            $dropdown = $this.find("div[aria-labelledby]");
        if (documentWidth <= 751) {
            var dropdownLeftOffset = -$this.offset().left;

            $dropdown.css({
                width: documentWidth + "px",
                left: dropdownLeftOffset + "px",
                right: "auto"
            });

        } else {
            $dropdown.removeAttr("style");
        }
    });


    $(document).on("click", ".fancyajaxwait.buy1click", function (e) {
        e.preventDefault();
        var $this = $(this),
            insertData = $this.data('insertdata'),
            urlParam = $.param($.extend(insertData, {"get_form": "1"})),
            url = $this.attr("href").indexOf("?") != -1 ?
                $this.attr("href") + "&" + urlParam :
                $this.attr("href") + "?" + urlParam;

        window.location = url;
        return true;
    });

    $(document).on('click', '.area2darken', function (e) {
        console.info('Area2Darken - block click');
        e.preventDefault();
        e.stopImmediatePropagation();
    });



    $(window).resize(function () {
        setTimeout(function () {
            //RSMONOPOLY_hideLis(true);
            RSMONOPOLY_DropFancy();
        }, 100);
    });
    $(window).load(function () {
        setTimeout(function () {
            //RSMONOPOLY_hideLis(false);
            RSMONOPOLY_DropFancy();
        }, 100);
    });

    // main menu
    $(document).on('click', '.main-menu-nav .dropdown a > span', function () {
        $(this).parent().parent().toggleClass('open');
        return false;
    });

    //captcha
    $(document).on('click', '.reloadCaptcha', function () {
        var $object = $(this).parents('.captcha_wrap');
        BX.ajax.loadJSON("/bitrix/tools/ajax_captcha.php", function (data) {
            $object.find('.captchaImg').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + data.captcha_sid);
            $object.find('.captchaSid').val(data.captcha_sid);
        });
        return false;
    });

    // header search box
    $(document).on('click', '.nav .search-btn', function () {
        var $searchBtn = $(this);
        if ($searchBtn.hasClass('lupa')) {
            $('.search-open').fadeIn(500, function () {
                $searchBtn.removeClass('lupa');
                $searchBtn.addClass('remove');
            });
        } else {
            $('.search-open').fadeOut(500, function () {
                $searchBtn.addClass('lupa');
                $searchBtn.removeClass('remove');
            });
        }
    });

    // click at first main menu
    $(document).on('show.bs.dropdown', 'header .main-menu-nav li.dropdown, header .main-menu-nav li.dropdown > a', function (e) {
        console.warn('script.js -> preventDefault');
        e.preventDefault();
    });

    // click at sidebar menu
    $(document).on('shown.bs.collapse', '.nav-sidebar', function (e) {
        $(e.target).parent().addClass('showed');
    }).on('hidden.bs.collapse', '.nav-sidebar', function (e) {
        $(e.target).parent().removeClass('showed');
    });

    $(".owl").each(function () {
        var $owl = $(this);

        owlInit($owl);
    });


    // fancybox -> popup links
    var RSGoPro_FancyOptions1 = {},
        RSGoPro_FancyOptions2 = {};
    RSGoPro_FancyOptions1 = {
        maxWidth: 400
        , maxHeight: 750
        , minWidth: 200
        , minHeight: 100
        , openEffect: 'none'
        , closeEffect: 'none'
        , padding: [20, 24, 15, 24]
        , helpers: {
            title: {
                type: 'inside'
                , position: 'top'
            }
        }
        , beforeShow: function () {
            var $element = $(this.element);
            var params = {};

            if ($element.data('insertdata') != '' && (typeof ($element.data('insertdata')) == 'object')) {
                setTimeout(function () {
                    var obj = $element.data('insertdata');
                    for (fieldName in obj) {
                        $('.fancybox-inner').find('[name="' + fieldName + '"]').val(obj[fieldName]);
                    }
                }, 50);
            }

            if (this.href = "/forms/buy1click/") {
                params.isSetBuy1Click = true;
            }
            $(document).trigger('RSMONOPOLY_fancyBeforeShow', params);
        }
        , afterShow: function () {
            setTimeout(function () {
                $.fancybox.toggle();
                RSMONOPOLY_PopupGallerySetHeight();
                RSMONOPOLY_PopupGallerySetPicture();
                $(document).trigger('RSMONOPOLY_fancyAfterShow');
            }, 50);
        }
        , onUpdate: function () {
            setTimeout(function () {
                RSMONOPOLY_PopupGallerySetHeight();
                $(document).trigger('RSMONOPOLY_fancyOnUpdate');
            }, 50);
        }
    };
    $('.fancyajax:not(.big)').fancybox(RSGoPro_FancyOptions1);
    $('.fancywithoutajax:not(.big)').fancybox(RSGoPro_FancyOptions1);

    RSGoPro_FancyOptions2 = $.extend({}, RSGoPro_FancyOptions1);
    delete RSGoPro_FancyOptions2.minHeight;
    delete RSGoPro_FancyOptions2.maxHeight;
    RSGoPro_FancyOptions2.ajax = {
        type: "POST",
        cache: false,
        data: {'AJAX_CALL': 'Y', 'POPUP_GALLERY': 'Y'}
    };
    RSGoPro_FancyOptions2.maxWidth = 1091;
    RSGoPro_FancyOptions2.minWidth = 600;
    RSGoPro_FancyOptions2.width = '90%';
    RSGoPro_FancyOptions2.height = '90%';
    RSGoPro_FancyOptions2.autoSize = false;

    $('.changeFromSlider:not(.cantopen)').fancybox(RSGoPro_FancyOptions2);

    RSGoPro_FancyOptions3 = $.extend({}, RSGoPro_FancyOptions1);
    delete RSGoPro_FancyOptions3.minHeight;
    delete RSGoPro_FancyOptions3.maxHeight;
    RSGoPro_FancyOptions3.maxWidth = 1091;
    RSGoPro_FancyOptions3.minWidth = 200;
    RSGoPro_FancyOptions3.width = '90%';
    RSGoPro_FancyOptions3.autoSize = false;
    RSGoPro_FancyOptions3.autoHeight = true;
    $('.fancyajax.big').fancybox(RSGoPro_FancyOptions3);
    $(document).on('click', '.cantopen', function () {
        return false;
    });

    // pictures slider
    $(document).on('click', '.thumbs .thumb a', function () {
        var $link = $(this);
        var $thumbs = $link.parents('.thumbs');
        $thumbs.find('.thumb').removeClass('checked');
        $thumbs.find('.thumb.pic' + $link.data('index')).addClass('checked');
        $($thumbs.data('changeto')).attr('src', $(this).attr('href'));

        $(document).trigger('RSMONOPOLY_changePicture', {
            id: $(this).data("index")
        });
        return false;
    });
    $(document).on('click', '.js-nav', function () {
        var $btn = $(this),
            $gallery = $(this).parents('.js-gallery'),
            $curPic = $gallery.find('.thumb.checked'),
            $prev = ($curPic.prev().hasClass('thumb') ? $curPic.prev() : $gallery.find('.thumb:last')),
            $next = ($curPic.next().hasClass('thumb') ? $curPic.next() : $gallery.find('.thumb:first'));
        if ($btn.hasClass('prev')) {
            $prev.find('a').trigger('click');
        } else {
            $next.find('a').trigger('click');
        }
        return false;
    }).on('mouseenter mouseleave', '.js-nav', function () {
        $('html').toggleClass('disableSelection');
    });
    $(document).on('click', '.popupgallery .changeit img', function () {
        $('.popupgallery').find('.js-nav.next').trigger('click');
    });

    /* forms error show */
    $(document).on('focusin', '.form-control', function () {
        $(this).next().addClass('focused');
    });
    $(document).on('focusout', '.form-control', function () {
        $(this).next().removeClass('focused');
    });
    $(document).on('focusout', '.req-input', function () {
        if ($(this).val() == '') {
            $(this).addClass('must-be-filled almost-filled');
            $(this).attr("placeholder", BX.message('RSMONOPOLY_JS_REQUIRED_FIELD'));
        }
    }).on('focusin', '.req-input', function () {
        if ($(this).hasClass('must-be-filled')) {
            $(this).removeClass('must-be-filled almost-filled');
        }
    });
    // check custom bitrix.forms
    $(document).on('click', '.dropdown-menu .variable', function () {
        $(this).parents('.dropdown').find('.dropdown-button').html($(this).html() + '<span class="right-arrow-caret"></span>');
        $(this).parents('.dropdown').find('input[type="hidden"]').val($(this).data('value'));
    });
    $(document).on('click', '.btn.btn-primary', function () {
        submittedFlag = false;
        $(this).parents('form').find('.field-wrap.req').each(function () {
            if (($(this).find('input.req-input').val() == "" && $(this).hasClass('text-wrap')) ||
                ($(this).find('select option:selected').length == 0 && $(this).hasClass('select-wrap')) ||
                ($(this).find('input.req-input').val() == "" && $(this).hasClass('calendar-wrap')) ||
                ($(this).find('textarea').val() == "" && $(this).hasClass('textarea-wrap')) ||
                ($(this).find('input.req-input').val() == "" && $(this).hasClass('file-wrap')) ||
                ($(this).find('input:checked').length == 0 && $(this).hasClass('choice-wrap'))
            ) {
                $(this).addClass('has-error');
                submittedFlag = true;
            } else {
                $(this).removeClass('has-error');
            }
        });
        if (submittedFlag) {
            return false;
        }
    });
    $(document).on('click', '.checkbox label', function () {
        $(this).parent().find('input').checked = !$(this).parent().find('input').checked;
    });
    $(document).on('change', '.almost-filled', function () {
        $(this).removeClass('almost-filled').attr('placeholder', '');
    });

    // AJAX -> add2compare
    $(document).on('click', '.js-compare', function () {
        console.info('AJAX -> add2compare ');
        var $linkObj = $(this),
            url = $linkObj.parents('.js-element').data('detailpageurl'),
            id = parseInt($linkObj.parents('.js-element').data('elementid')),
            action = '';
        if (id > 0) {
            if (url.indexOf('?') == -1) {
                url = url + '?';
            }
            if (RSMONOPOLY_COMPARE[id] == 'Y' || parseInt(RSMONOPOLY_COMPARE[id]) > 0) {
                action = 'DELETE_FROM_COMPARE_LIST';
            } else {
                action = 'ADD_TO_COMPARE_LIST';
            }
            url = url + 'AJAX_CALL=Y&action=' + action + '&id=' + id;
            RSMONOPOLY_Area2Darken($('.js-compare'));
            $.getJSON(url, {}, function (json) {
                if (json.TYPE == "OK") {
                    if (action == 'DELETE_FROM_COMPARE_LIST') { // delete from compare{
                        delete RSMONOPOLY_COMPARE[id];
                    } else { // add to compare
                        RSMONOPOLY_COMPARE[id] = 'Y';
                    }
                    RS_MONOPOLY_COUNT_COMPARE = json.COUNT;
                    if (RS_MONOPOLY_COUNT_COMPARE > 0) {
                        $('.comparelist').removeClass('hidden').find('.count').html(json.COUNT_WITH_WORD);
                    } else {
                        $('.comparelist').addClass('hidden');
                    }
                } else {
                    console.warn('compare - error responsed');
                }
            }).fail(function (data) {
                console.warn('compare - fail request');
            }).always(function () {
                RSMONOPOLY_Area2Darken($('.js-compare'));
                RSMONOPOLY_SetCompared();
            });
        }
        return false;
    });

    // AJAX -> add2basket
    $(document).on('submit', '.add2basketform', function () {
        //console.info( 'AJAX -> add2basket ' );
        var $formObj = $(this),
            url = $formObj.parents('.js-element').data('detailpageurl'),
            id = parseInt($formObj.find('.js-add2basketpid').val()),
            seriData = $formObj.serialize() + '&AJAX_CALL=Y';

        recalcElement($formObj);

        if (id > 0) {
            RSMONOPOLY_Area2Darken($formObj);
            $.getJSON(url, seriData, function (json) {
                if (json.TYPE == 'OK') {
                    RSMONOPOLY_INBASKET[id] = "Y";
                    $(".dropdown-basketinhead").html(json.HTMLBYID.ddbasketinhead);
                    //console.log($($formObj).parents('.in'));
                    var strContent = '<div style="width: 100%; margin: 0; text-align: center;"><p><img src="' + $($formObj).parents('.in').find('.pic img').attr('src') + '"><br><br>' + $($formObj).parents('.in').find('.name a').text() + '</p></div>';
                    var buttons = [
                        new BX.PopupWindowButton({
                            ownerClass: "btn",
                            className: 'bx_medium bx_bt_button',
                            text: 'РџРµСЂРµР№С‚Рё РІ РєРѕСЂР·РёРЅСѓ',
                            events: {
                                click: function () {
                                    location.href = '/personal/cart/'
                                }
                            }
                        }),
                        new BX.PopupWindowButton({
                            ownerClass: "btn",
                            className: 'bx_medium bx_bt_button',
                            text: "РџСЂРѕРґРѕР»Р¶РёС‚СЊ РїРѕРєСѓРїРєРё",
                            events: {
                                click: function () {
                                    AddToBasketPopup.close()
                                }
                            }
                        })
                    ];

                    SendAnalyticsGoal('produkt-ok');

                    if ($("#imgItem" + id).length) {
                        $("#imgItem" + id)
                            .clone()
                            .css({'position': 'absolute', 'z-index': '11100', 'top': $("#imgItem" + id).offset().top, 'left': $("#imgItem" + id).offset().left})
                            .appendTo("body")
                            .animate({opacity: 0.05,
                                    left: $("#ddbasketinhead").offset()['left'],
                                    top: $("#ddbasketinhead").offset()['top'],
                                    width: 20},
                                1000,
                                function () {
                                    $(this).remove();

                                    AddToBasketPopup.setTitleBar("РўРѕРІР°СЂ РґРѕР±Р°РІР»РµРЅ РІ РєРѕСЂР·РёРЅСѓ");
                                    AddToBasketPopup.setContent(strContent);
                                    //AddToBasketPopup.setButtons(buttons);
                                    AddToBasketPopup.show();
                                    updateBasketLine();
                                    setTimeout(function () {
                                        AddToBasketPopup.close()
                                    }, 1000);
                                });
                    } else {
                        AddToBasketPopup.setTitleBar("РўРѕРІР°СЂ РґРѕР±Р°РІР»РµРЅ РІ РєРѕСЂР·РёРЅСѓ");
                        AddToBasketPopup.setContent(strContent);
                        //AddToBasketPopup.setButtons(buttons);
                        AddToBasketPopup.show();
                        updateBasketLine();
                        setTimeout(function () {
                            AddToBasketPopup.close()
                        }, 1000);
                    }







                } else {
                    console.warn('add2basket - error responsed');
                }
            }).fail(function (data) {
                console.warn('add2basket - can\'t load json');
            }).always(function () {
                RSMONOPOLY_Area2Darken($formObj);
                RSMONOPOLY_SetInBasket();
            });
        } else {
            console.warn('add product to basket failed');
        }
        return false;
    });

    // AJAX -> add2favorite
    $(document).on("click", ".favorite", function (e) {
        console.info('AJAX -> add2favorite ');
        e.preventDefault();
        var $this = $(this),
            url = $this.data('detailpageurl'),
            id = parseInt($this.data("elementid")),
            $elSelectors = $(".favorite[data-elementid=" + id + "]");
        if (!id) {
            return;
        }
        data = {
            "action": "UPDATE_FAVORITE",
            "element_id": id,
            "AJAX_CALL": "Y"
        };
        RSMONOPOLY_Area2Darken($elSelectors);
        $.getJSON(url, data, function (json) {
            if (json.TYPE == 'OK') {
                if (json.ACTION == 'ADD') {
                    RSMONOPOLY_FAVORITE[id] = "Y";
                } else {
                    delete RSMONOPOLY_FAVORITE[id];
                }
                $("#favorinfo").html(json.HTMLBYID.favorinfo);
            } else {
                console.warn('add2favorite - error responsed');
            }
        }).fail(function () {
            console.warn('add2favorite - can\'t load json');
        }).always(function () {
            RSMONOPOLY_Area2Darken($elSelectors);
            RSMONOPOLY_SetInFavorite();
        });
    });

    // disableSelection
    $(document).on('mouseenter mouseleave', '.js-minus, .js-plus', function () {
        $('html').toggleClass('disableSelection');
    });

    // quantity
    $(document).on('click', '.js-minus', function () {
        var $btn = $(this);
        var ratio = parseFloat($btn.parent().find('.js-quantity').data('ratio'));
        var ration2 = ratio.toString().split('.', 2)[1];
        var length = 0;
        if (ration2 !== undefined) {
            length = ration2.length;
        }
        var val = parseFloat($btn.parent().find('.js-quantity').val());
        if (val > ratio) {
            $btn.parent().find('.js-quantity').val((val - ratio).toFixed(length)).change();
        }
        recalcElement($btn.parents('.add2basketform'));
        return false;
    });
    $(document).on('click', '.js-plus', function () {
        var $btn = $(this);
        var ratio = parseFloat($btn.parent().find('.js-quantity').data('ratio'));
        var ration2 = ratio.toString().split('.', 2)[1];
        var length = 0;
        if (ration2 !== undefined) {
            length = ration2.length;
        }
        var val = parseFloat($btn.parent().find('.js-quantity').val());
        $btn.parent().find('.js-quantity').val((val + ratio).toFixed(length)).change();
        recalcElement($btn.parents('.add2basketform'));
        return false;
    });
    $(document).on('blur', '.js-quantity', function () {
        var $input = $(this);
        var quantity = parseFloat($input.val());

        if (!quantity) {
            $input.val('1');
        }
        /*
         var ration2 = ratio.toString().split('.', 2)[1];
         var length = 0;
         if( ration2!==undefined ) { length = ration2.length; }
         var val = parseFloat( $input.val() );
         if( val>0 ) {
         $input.val( (ratio*(Math.floor(val/ratio))).toFixed(length) );
         } else {
         $input.val( ratio );
         }*/
        recalcElement($input.parents('.add2basketform'));
    });

    function recalcElement(obj) {
        var ratio = 1;
        price = parseFloat(obj.find('.js-price').val()),
            quantity = (obj.find('.js-quantity').val()) ? parseFloat(obj.find('.js-quantity').val()) : 1,
            value = price * quantity;


        var ration2 = value.toString().split('.', 2)[1];
        var length = 0;
        if (ration2 !== undefined) {
            length = 2;
        }

        var value2 = value.toFixed(length);

        obj.parents('.buyblock').find('.jsPrice').html(value2 + ' СЂ.');
        if (quantity < 2) {
            obj.parents('.buyblock').find('.jsUNIT').html('');
        } else {
            obj.parents('.buyblock').find('.jsUNIT').html(quantity);
        }

    }

    // location :focus
    $(document).on('focus blur', '.bx-sls .bx-ui-sls-fake', function () {
        $(this).parents('.bx-sls').toggleClass('active');
    }).on('focus blur', '.bx-slst .bx-ui-combobox-fake', function () {
        $(this).parents('.dropdown-block').toggleClass('active');
    });




});

//custom load files
$(function () {
    var wrapper = $(".file_upload"),
        inp = wrapper.find("input"),
        btn = wrapper.find(".file-link"),
        lbl = wrapper.find(".file-link");

    // Yep, it works!
    btn.add(lbl).click(function () {
        inp.click();
    });

    var file_api = (window.File && window.FileReader && window.FileList && window.Blob) ? true : false;

    inp.change(function () {

        var file_name;
        if (file_api && inp[ 0 ].files[ 0 ])
            file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace("C:\\fakepath\\", '');
        if (!file_name.length)
            return;

        if (lbl.is(":visible")) {
            lbl.text(file_name);
            btn.text(file_name);
        } else
            btn.text(file_name);
    }).change();

});

// Update basket.line Items
function updateBasketLine() {

    var defer = $.Deferred();

    $.post(window.location, {AJAX: 'Y', REFRESH_BASKET_LINE: 'Y'}, function (html) {
        defer.resolve();
        $(".dropdown-basketinhead").html(html);
    }, "html");

    return defer.promise();
}
// owl init
function owlInit($owl, params) {

    var defaultParams = {
        items: $owl.data('items') || 4,
        margin: $owl.data('margin') || 30,
        loop: $owl.data('loop') == undefined ? true : $owl.data('loop'),
        autoplay: $owl.data('autoplay'),
        merge: $owl.data('merge'),
        nav: $owl.data('nav') == undefined ? true : $owl.data('nav'),
        autoplaySpeed: $owl.data('changespeed') || 2000,
        autoplayTimeout: $owl.data('changedelay') || 8000,
        smartSpeed: $owl.data('changespeed') || 2000,
        navText: ['<span></span>', '<span></span>'],
        navClass: ['prev', 'next'],
        responsive: $owl.data('responsive') || {},

        onInitialize: function (e) {
            $owl.addClass('owl-carousel owl-theme');
            if ($owl.data('loop') != "false" || $owl.data('loop')) {
                if (this.$element.children().length <= this.settings.items) {
                    this.settings.loop = false;
                }
            }
        },
        onResize: function (e) {
            if ($owl.data('loop') != "false" || $owl.data('loop')) {
                var responsiveItems = this.settings.items,
                    windowWidth = $(window).width();

                if (this.options.responsive) {
                    var currentBreakpoint = -1,
                        breakpoint;

                    for (breakpoint in this.options.responsive) {
                        if (breakpoint <= windowWidth && breakpoint >= currentBreakpoint) {
                            if (this.options.responsive[breakpoint].items) {
                                responsiveItems = this.options.responsive[breakpoint].items;
                            }
                        }
                    }
                }

                if (this.items().length <= responsiveItems) {
                    this.options.loop = false;
                } else {
                    this.options.loop = true;
                }
            }
        },
        onRefreshed: function (e) {
            if ($owl.data('noscroll') == "true") {
                $owl.removeClass('noscroll');
                if ($owl.find('.cloned').length < 1) {
                    $owl.addClass('noscroll');
                }
            }
        }
    };

    if ($owl.data('changespeed')) {
        defaultParams.autoplay = true;
    }

    params = $.extend({}, defaultParams, params);
    return $owl.owlCarousel(params);
}
// select city
function RSMSHOPSelectCity(input, city_id) {
    var $input = $(input),
        $form = $input.closest('form');
    $form.find('input[name="' + city_id + '"]').val($input.val());
    $form.find('input[type="submit"]').trigger('click');
}

/********Р¤РЈРќРљР¦РР СЂР°Р±РѕС‚С‹ СЃ COOKIE*****/
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}

/*******COOKIE END ***********/

$(document).ready(function () {
    $('.bx_catalog_top_home').bxSlider({
        slideWidth: 235,
        minSlides: 2,
        maxSlides: 6,
        // slideMargin: 1,
        pager: false,
        slideMargin: 1
    });
});

$(document).ready(function () {
    console.log((new Date()).getDate());
    if (getCookie("grafikRaboty") !== "wasShown" && $.inArray((new Date()).getDate(), [/* 27,28, 09, 30,31,1,2,3,4,5,6,7 */]) >= 0)
    {
        var grafikRaboty = new BX.PopupWindow(
            "grafikRaboty",
            null,
            {
                content: "<div id='grafikRaboty'><b><center>Р“СЂР°С„РёРє СЂР°Р±РѕС‚С‹ РЅР° РїСЂР°Р·РґРЅРёС‡РЅС‹Рµ РґРЅРё:</center></b><br><b>31.12.16</b> РЅР°С€ РѕРЅР»Р°Р№РЅ-РјР°РіР°Р·РёРЅ СЂР°Р±РѕС‚Р°РµС‚ РґРѕ 14:00 <br><b>01.01.17</b> - РІС‹С…РѕРґРЅРѕР№<br>Р’ РѕСЃС‚Р°Р»СЊРЅС‹Рµ РґРЅРё РїСЂРёРЅРёРјР°РµРј Р·Р°РєР°Р·С‹ РІ РѕР±С‹С‡РЅРѕРј СЂРµР¶РёРјРµ</div>",
                autoHide: false,
                offsetLeft: 0,
                offsetTop: 0,
                overlay: true,
                closeByEsc: true,
                titleBar: false,
                closeIcon: true,
                //titleBar: {content: BX.create("span", {html: '<b>Р­С‚Рѕ Р·Р°РіРѕР»РѕРІРѕРє РѕРєРЅР°</b>', 'props': {'className': 'access-title-bar'}})},
                contentColor: 'white'

            });
        grafikRaboty.show();
        setCookie("grafikRaboty", "wasShown", {
            expires: 60 * 60 * 12
        });
        setTimeout(function () {
            grafikRaboty.close()
        }, 5000);
    }
});

var BXFormPosting = false;
function submitForm(val)
{
    /* if (BXFormPosting === true)
     return true; */
    var submit = true;
    var scrolled = false;
    var ORDER_PROP_1 = $('#ORDER_PROP_1').val();
    var ORDER_PROP_2 = $('#ORDER_PROP_2').val();
    var ORDER_PROP_3 = $('#ORDER_PROP_3').val();
    var ORDER_PROP_7 = $('#ORDER_PROP_7').val();

    var body = $("body");
    if (ORDER_PROP_1 == '') {
        $('#ORDER_PROP_1').addClass('error_order');
        submit = false;
    } else
        $('#ORDER_PROP_1').removeClass('error_order');

    if (ORDER_PROP_2 == '') {
        submit = false;
        $('#ORDER_PROP_2').addClass('error_order');
    } else
        $('#ORDER_PROP_2').removeClass('error_order');
    if (ORDER_PROP_3 == '') {
        submit = false;
        $('#ORDER_PROP_3').addClass('error_order');
    } else
        $('#ORDER_PROP_3').removeClass('error_order');
    if (ORDER_PROP_7 == '') {
        submit = false;
        $('#ORDER_PROP_7').addClass('error_order');
    } else
        $('#ORDER_PROP_7').removeClass('error_order');

    if (!submit) {
        body.animate({scrollTop: $('.error_order').eq(0).offset().top - 20}, '500');
        return false;
    }
    BXFormPosting = true;
    if (val != 'Y')
        BX('confirmorder').value = 'N';

    var orderForm = BX('ORDER_FORM');
    BX.showWait();



    BX.ajax.submit(orderForm, ajaxResult);

    return true;
}

function ajaxResult(res)
{
    var orderForm = BX('ORDER_FORM');
    try
    {
        // if json came, it obviously a successfull order submit

        var json = JSON.parse(res);
        BX.closeWait();

        if (json.error)
        {
            BXFormPosting = false;
            return;
        } else if (json.redirect)
        {
            SendAnalyticsGoal('produkt-zakaz');

            window.top.location.href = json.redirect;
        }
    } catch (e)
    {
        // json parse failed, so it is a simple chunk of html

        BXFormPosting = false;
        BX('order_form_content').innerHTML = res;

    }

    BX.closeWait();
    BX.onCustomEvent(orderForm, 'onAjaxSuccess');
}

function showPopupOformlenie()
{
    $.ajax({
        url: '/bitrix/templates/mshop_default/components/bitrix/sale.order.ajax/monopoly_new/script.js',
        type: "GET",
        dataType: "script"
    });

    $.ajax({
        url: '/personal/order/make/',
        type: "POST",
        success: function (data) {
            var strContent = $(data).find("#formOrderDiv").html();
            var AddToBasketPopup = BX.PopupWindowManager.create('PopupOformlenie', window.body, {
                autoHide: false,
                offsetLeft: 0,
                offsetTop: parseInt(screen.width) < 400 ? 200 : 0,
                overlay: true,
                closeByEsc: true,
                titleBar: false,
                closeIcon: true,
                contentColor: 'white'
            });
            //AddToBasketPopup.setTitleBar("РўРѕРІР°СЂ РґРѕР±Р°РІР»РµРЅ РІ РєРѕСЂР·РёРЅСѓ");
            AddToBasketPopup.setContent(strContent);
            AddToBasketPopup.show();
            $("#ORDER_PROP_3").mask("+7 (999) 999-99-99");

        }
    });
}

function deleteFromSmallBasket(id)
{
    $.ajax({
        url: '/personal/cart/?action=delete&id=' + id,
        type: "POST",
        success: function (data) {
            BX.ajax.insertToNode('/include/header/ajax_cart.php?open=Y', BX('basket-refresh'));
            //location.reload(true);
        }
    });
}
