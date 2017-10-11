/* global BX */

function RSMONOPOLY_OnOfferChangeDetail($elementObj) {
    'use strict';

    var offerId = $elementObj.find('.js-add2basketpid').val(),
            $owlImages = $(".js-images"),
            elementId = $elementObj.data('elementid') || -1,
            images = RSMONOPOLY_PRODUCTS[elementId].IMAGES || [],
            $owlGeneralImages = $(".js-general_images"),
            detailUrl = $elementObj.data('detailpageurl');

    $owlImages.find(".owl-item:not(.cloned) .imgoffer").each(function (key, item) {
        var removedPostions = $(item).parent().index(".js-images .owl-item:not(.cloned)");
        if (removedPostions !== -1) {
            $owlImages.trigger('remove.owl.carousel', removedPostions);
            $owlGeneralImages.trigger('remove.owl.carousel', removedPostions);
        }
    });

    for (var imageId in images) {
        if (images[imageId].DATA.OFFER_ID == offerId) {
            // General images		
            $owlGeneralImages.trigger('add.owl.carousel', [

                $("<div></div>")
                        .addClass("changeFromSlider fancybox.ajax fancyajax")
                        .html(
                                $("<img>")
                                .attr("data-index", images[imageId].PIC.ID)
                                .attr("title", images[imageId].PIC.TITLE || '')
                                .attr("src", images[imageId].PIC.SRC)
                                ),
                1
            ]
                    );

            // Slider images
            $owlImages.trigger('add.owl.carousel',
                    [$("<div></div>")
                                .addClass(
                                        "changeimage scrollitem pic offerImg thumb pic" +
                                        images[imageId].PIC.ID + " imgoffer imgofferid" +
                                        images[imageId].DATA.OFFER_ID
                                        )
                                .html(
                                        $("<a></a>")
                                        .attr("href", images[imageId].PIC.SRC)
                                        .attr("data-index", images[imageId].PIC.ID)
                                        .css('background-image', "url(" + images[imageId].PIC.RESIZE.src + ")")
                                        .append(
                                                $("<div></div>")
                                                .addClass("overlay")
                                                )
                                        .append(
                                                $("<i></i>")
                                                .addClass("fa")
                                                )
                                        ),

                        1]

                    );
        }
    }

    $owlGeneralImages.find(".owl-item .changeFromSlider").attr("href", detailUrl + '?OFFER_ID=' + offerId);
    $owlImages.trigger('refresh.owl.carousel');
    $owlGeneralImages.trigger('refresh.owl.carousel');
    $owlImages.find(".owl-item:not(.cloned):eq(0) a").trigger("click");
}

$(document).ready(function () {

    // Change item in image slider 
    $(document).on("RSMONOPOLY_changePicture", function (e, img) {
        'use strict';

        var index = $(".js-general_images .owl-item:not(.cloned) img[data-index=" + img.id + "]")
                .parents(".owl-item")
                .index(".js-general_images .owl-item:not(.cloned)");

        $(".js-general_images").trigger("to.owl.carousel", index);
    });

    $('.part2').find('.tabs .nav > li:first').addClass('active');
    $('.part2').find('.tabs .tab-content > .tab-pane:first').addClass('in active');

    // images
    $(".fancybox").fancybox();
    $(document).on('click', '.thumb a', function () {
        $('.js-detail .slider').find('.checked').removeClass('checked');
        $('.js-detail .slider').find('.pic' + $(this).data('index')).addClass('checked');
        $('.js-detail .thumbs').find('.thumb').removeClass('checked');
        $('.js-detail .thumbs').find('.pic' + $(this).data('index')).addClass('checked');
        return false;
    });

    $(document).on("RSMONOPOLY_fancyBeforeShow", function (e) {
        var $jsGallery = $(".js-gallery");

        if ($jsGallery.length > 0) {
            var selectedId = $(".js-general_images .owl-item.active:not(.cloned) img").data("index");
            var index = $(".js-gallery a[data-index=" + selectedId + "]").parent().index();

            if (index) {
                $jsGallery.find(".thumbs a").eq(index).click();
            } else {
                $jsGallery.find(".thumbs a:eq(0)").click();
            }
        }
    });

    var $owlProducts = $(".owlslider.products-owl-slider");
    owlInit($owlProducts, {
        margin: 35,
        items: 4,
        responsive: {"0": {"items": "1"}, "768": {"items": "2"}, "956": {"items": "4"}}
    });

    var $owlGeneralImages = $(".js-general_images");
    owlInit($owlGeneralImages, {
        margin: 0,
        nav: false,
        loop: false,
        items: 1,
        onChanged: function (event) {

            if (event.item && event.item.index) {
                var $owlImagesSlider = $(".thumbs .owlslider.images"),
                        activeId = this.$element.find("img:eq(" + event.item.index + ")").data('index'),
                        $owlImagesSliderActive = $owlImagesSlider.find("a[data-index=" + activeId + "]");

                $owlImagesSlider.find(".checked").removeClass("checked");
                $owlImagesSliderActive.parent().addClass("checked");
            }

        },
        onInitialize: function () {
            $owlGeneralImages.addClass('owl-carousel owl-theme withdots owlslider');
        }
    });


    $(document).on('click', '.js-detail .moretext', function () {
        $('.part2 .tabs a.detailtext').trigger('click');
    });
    $(document).on('click', '.js-detail .moreprops', function () {
        console.log("text");
        $('.part2 .tabs a.properties').trigger('click');
    });

    // change offer
    $(document).on('RSMONOPOLYOnOfferChange', function (e, elementObj) {
        RSMONOPOLY_OnOfferChangeDetail(elementObj);
    });

    //tabs to collapse
    $("#detail-tabs").tabCollapse();
});

(function (window) {

    if (!!window.JCCatalogElement)
    {
        return;
    }

    window.JCCatalogElement = function (arParams)
    {
        this.productId = arParams.ID;
        this.ratio = parseFloat(arParams.RATIO);
        this.startRatio = parseFloat(arParams.START_RATIO);
        this.middleRatio = arParams.MIDDLE_RATIO;
        this.obQuantity = BX('bx_quantity_' + arParams.ID);
        this.obQuantityDown = BX('bx_down_' + arParams.ID);
        this.obQuantityUp = BX('bx_up_' + arParams.ID);
        this.priceBlock = BX('bx_price_' + arParams.ID);
        this.priceJsBlock = BX('bx_js_price_block_' + arParams.ID);
        
        
        this.middleLenght = arParams.MIDDLE_RATIO.length;
        this.step = 0;

        if (this.obQuantityUp)
            BX.bind(this.obQuantityUp, 'click', BX.delegate(this.QuantityUp, this));
        if (this.obQuantityDown)
            BX.bind(this.obQuantityDown, 'click', BX.delegate(this.QuantityDown, this));

        BX.bind(this.obQuantity, 'bxchange', BX.delegate(this.QuantityStop, this));

        //this.obQuantity.disabled = 'disabled';
    };
    window.JCCatalogElement.prototype.QuantityStop = function () {
        this.obQuantity.value = this.curValue;
        return false;
    }
    window.JCCatalogElement.prototype.QuantityUp = function ()
    {
        var curStep = this.step, nextStep = 0;
        nextStep = parseInt(curStep) + 1;
        if (typeof this.middleRatio[nextStep - 1] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) + this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep - 1];

        this.step = nextStep;
        //this.recalcPrice();

    };
    window.JCCatalogElement.prototype.QuantityDown = function ()
    {
        var curStep = this.step, nextStep = 0;

        nextStep = parseInt(curStep) - 1;

        if (nextStep <= 0) {
            this.obQuantity.value = this.startRatio;
            this.step = 0;
            //this.recalcPrice();
            return false;
        }
        if (typeof this.middleRatio[nextStep - 1] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) - this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep - 1];

        this.step = nextStep;
        //this.recalcPrice();

    };
    window.JCCatalogElement.prototype.recalcPrice = function ()
    {
        price = parseFloat(this.priceJsBlock.value),
                quantity = parseFloat(this.obQuantity.value),
                value = price * quantity;


        var ration2 = value.toString().split('.', 2)[1];
        var length = 0;
        if (ration2 !== undefined) {
            length = 2;
        }

        var value2 = value.toFixed(length);

        this.priceBlock.innerHTML = value2 + ' р.';
    }
})(window);