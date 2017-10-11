/* global BX */

(function (window) {

    if (!!window.JCCatalogBasket)
    {
        return;
    }

    window.JCCatalogBasket = function (arParams)
    {
        this.ratioInput = arParams.RATIO_INPUT;
        this.useFloat = arParams.USE_FLOAT;
        this.basketId = arParams.ID;
        this.ratio = parseFloat(arParams.RATIO);
        this.startRatio = parseFloat(arParams.START_RATIO);
        this.middleRatio = arParams.MIDDLE_RATIO;
        this.obQuantity = BX('QUANTITY_INPUT_' + arParams.ID);
        this.obQuantityDown = BX('bx_down_' + arParams.ID);
        this.obQuantityUp = BX('bx_up_' + arParams.ID);
        this.curValue = this.startRatio;
        this.middleLenght = arParams.MIDDLE_RATIO.length;
        this.step = arParams.CURRENT_STEP;

        if (this.obQuantityUp)
            BX.bind(this.obQuantityUp, 'click', BX.delegate(this.QuantityUp, this));
        if (this.obQuantityDown)
            BX.bind(this.obQuantityDown, 'click', BX.delegate(this.QuantityDown, this));

        BX.bind(this.obQuantity, 'bxchange', BX.delegate(this.QuantityStop, this));

        //this.obQuantity.disabled = 'disabled';
    };
    window.JCCatalogBasket.prototype.QuantityStop = function () {
        this.obQuantity.value = this.curValue;
        return false;
    }
    window.JCCatalogBasket.prototype.QuantityUp = function ()
    {
        var curStep = this.step, nextStep = 0;
        nextStep = parseInt(curStep) + 1;
        if (typeof this.middleRatio[nextStep - 1] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) + this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep - 1];

        this.curValue = this.obQuantity.value;
        this.step = nextStep;

        $(this.obQuantityUp).parent().find('.js-quantity').change();
        this.recalc();
    };
    window.JCCatalogBasket.prototype.QuantityDown = function ()
    {
        var curStep = this.step, nextStep = 0;

        nextStep = parseInt(curStep) - 1;

        if (nextStep <= 0) {
            this.obQuantity.value = this.startRatio;
            this.curValue = this.startRatio;
            this.step = 0;
            $(this.obQuantityDown).parent().find('.js-quantity').change();
            return false;
        }
        if (typeof this.middleRatio[nextStep - 1] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) - this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep - 1];

        this.curValue = this.obQuantity.value;
        this.step = nextStep;

        $(this.obQuantityDown).parent().find('.js-quantity').change();
        this.recalc();

    };
    window.JCCatalogBasket.prototype.recalc = function ()
    {

        var $smallBasket = $(".js-basketline").smallBasket();

        $smallBasket.on("smallBasket.recalculated", function (e, data) {
            data.BASKET_DATA.ITEMS.AnDelCanBuy.forEach(function (item) {
                $smallBasket.find(".js-product[data-product-id=" + item.ID + "] .price").text(item.SUM)
            });
            $('.smallbasketAllSum b').text(data.BASKET_DATA.allSum_FORMATED);
            $('.cart__price').text(data.BASKET_DATA.allSum_FORMATED);
        });
        $smallBasket.trigger("smallBasket.recalculate");
    }
})(window);


$(document).ready(function(){
    $('.js-basketline').click(function(){
        if (!$(this).hasClass('open'))
            $('.menu__item--cart').addClass('open');
        else
            $('.menu__item--cart').removeClass('open');
    })
})