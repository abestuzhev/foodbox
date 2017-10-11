/* global BX */

(function (window) {

    if (!!window.JCCatalogSection)
    {
        return;
    }

    window.JCCatalogSection = function (arParams)
    {
        this.productId = arParams.ID;
        this.ratio = parseFloat(arParams.RATIO);
        this.startRatio = parseFloat(arParams.START_RATIO);
        this.middleRatio = arParams.MIDDLE_RATIO;
        this.obQuantity = BX('bx_quantity_' + arParams.ID);
        this.obQuantityDown = BX('bx_down_' + arParams.ID);
        this.obQuantityUp = BX('bx_up_' + arParams.ID);
        this.curValue = this.startRatio;
        this.middleLenght = arParams.MIDDLE_RATIO.length;
        this.step = 0;

        for (var i = 0; i <= arParams.MIDDLE_RATIO.length; i++) {
            if (arParams.MIDDLE_RATIO[i] == arParams.START_RATIO) {
                this.step = parseInt(i);
            }
        }

        if (this.obQuantityUp)
            BX.bind(this.obQuantityUp, 'click', BX.delegate(this.QuantityUp, this));
        if (this.obQuantityDown)
            BX.bind(this.obQuantityDown, 'click', BX.delegate(this.QuantityDown, this));

        BX.bind(this.obQuantity, 'bxchange', BX.delegate(this.QuantityStop, this));

        //this.obQuantity.disabled = 'disabled';
    };
    window.JCCatalogSection.prototype.QuantityStop = function () {
        this.obQuantity.value = this.curValue;
        return false;
    }
    window.JCCatalogSection.prototype.QuantityUp = function ()
    {
        var curStep = this.step, nextStep = 0;
        nextStep = parseInt(curStep) + 1;
        if (typeof this.middleRatio[nextStep] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) + this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep];

        this.curValue = this.obQuantity.value;
        this.step = nextStep;

    };
    window.JCCatalogSection.prototype.QuantityDown = function ()
    {
        var curStep = this.step, nextStep = 0;

        nextStep = parseInt(curStep) - 1;

        if (nextStep <= 0) {
            this.obQuantity.value = this.middleRatio[0];
            this.curValue = this.startRatio;
            this.step = 0;
            return false;
        }
        if (typeof this.middleRatio[nextStep] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) - this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep];

        this.curValue = this.obQuantity.value;
        this.step = nextStep;

    };
})(window);

function showMore(e) {
    var $curpage = $(e).data('start');
    var $allpages = $(e).data('pages');
    var _this = $(e);
    if ($allpages < $curpage) {
        $(this).parent().remove();
        return false;
    }
    $.ajax({
        url: '?show_more=Y&PAGEN_1=' + $curpage,
        success: function (e) {
            var data = $(e).find('.row.products').html();
            var nav = $(e).find('nav').html();
            $('.row.products').append(data);
            $('#js-ajaxcatalog nav').html(nav);
            $curpage++;
            _this.data('start', $curpage);
            if ($allpages < $curpage) {
                _this.parent().remove();
            }
        }
    })
}