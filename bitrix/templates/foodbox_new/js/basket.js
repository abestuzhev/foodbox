;(function($) {
    "use strict";

    var pluginName = "smallBasket",
        BasketApi = BasketApiBitrix,
        defaults = {
            
        };

    function SmallBasket(element, options, Api) {
        this.$element = $(element);
        this.options = $.extend({}, defaults, options);
        this.options.api = this.options.api || {};
        this.$products = [];
        this.quantities = [];
        this.deleted = [];
        
        this.api = this.options.basketApi ? new this.options.basketApi(this) : new BasketApi(this);
        
        this.init();
        this.startEvents();
    }

    $.extend(SmallBasket.prototype, {
        
        init: function() {
            this.$products = findProducts(this.$element);
            this.updateQuantity();
            this.updateDeleted();
        },
        
        update: function() {
            this.init();
        },
        
        getQuantities: function() {
            
            if(this.quantities.length === 0) {
                this.updateQuantity();
            }
            
            return this.quantities;
        },
        getQuantity: function(id) {
            return this.quantities[id];
        },
        setQuantity: function(id, value) {
            if(id && value) {
                this.quantities[id] = value;
            }
        },
        
        getDeleted: function() {
            return this.deleted;
        },
        
        updateDeleted: function() {
            
            this.$products.each(function(key, product) {
                var $product = $(product);
                if($product.find(".js-deleted-check").is(":checked")) {
                    pushDeleted(getProductId($product));
                }
            });
        },
        pushDeleted: function(id) {
            if(id) {
                this.deleted.push(id);
            }
        },
        
        updateQuantity: function() {
            var base = this;
            this.$products.each(function(key, product) {
                var $product = $(product),
                    productId = getProductId($product),
                    quantity = $product.find('.js-quantity').val() || 
                                parseFloat($product.find('.js-quantity').text());
                base.setQuantity(productId, quantity);
                
            });
        },
        
        startEvents: function() {
            var base = this;
            
            base.$element.on(pluginName + ".recalculate", function() {
                base.recalc()
                    .then(function(data) {
                       base.$element.trigger(pluginName + ".recalculated", data); 
                    }, function (error, status) {
                        base.$element.trigger(pluginName + ".recalculated", error); 
                    });
            });
            
            base.$element.on(pluginName + ".update", function() {
                console.log(11);
                base.update();
            });
            
            base.$element.on("change", ".js-quantity", function() {
                base.update();
                base.$element.trigger(pluginName + ".quantityChange"); 
            });
            
            
        },
        
        recalc: function() {
            return this.api.recalc();
        }
        
    });
    
    function findProducts($context) {
        return $(".js-product");
    }
    function getProductId($context) {
        return $context.data('product-id');
    }

    
    /**
    * ��������� API �������
    **/
    function BasketApiInterface(basketContext) {}
    
    /**
    * ���������� �������
    * @return jQuery Deffered Object
    **/
    BasketApiInterface.prototype.recalc = function(params) {};
    /**
    * �������� ������� �� �������
    * @return jQuery Deffered Object
    **/
    BasketApiInterface.prototype.del = function(params) {};
    
    
    /** 
    *  API � ������� ��������
    **/
    function BasketApiBitrix(basketContext) {
        this.basket = basketContext;
        this.url = "/bitrix/components/bitrix/sale.basket.basket/ajax.php";
    }
    BasketApiBitrix.prototype = Object.create(BasketApiInterface.prototype);
    
    BasketApiBitrix.prototype.recalc = function() {
        
        var selectProps = this.basket.options.api.selectProps ||
                          'NAME,DISCOUNT,PRICE,WEIGHT,QUANTITY,PRICE,SUM,QUANTITY_FLOAT';
        var offersProps = this.basket.options.api.offersProps || '';
        
        
        var data = {
            'action': 'recalculate',
            'sessid': BX.bitrix_sessid(),
            'site_id': BX.message('SITE_ID'),
            'props': this.basket.options.api.props || {},
            'action_var': this.basket.options.api.action || 'action',
            'select_props': selectProps,
            'offers_props': offersProps,
            'quantity_float': this.basket.options.api.quantityFloat || 'Y',
            'count_discount_4_all_quantity': this.basket.options.api.countDiscount4allQuantity || 'Y',
            'price_vat_show_value': this.basket.options.api.priceVatShowValue || 'Y',
            'hideCoupon': 'Y',
            'use_prepayment': this.basket.options.api.usePayment || 'N'
        };
        
        for(var productId in this.basket.quantities) {
            data['QUANTITY_' + productId] = this.basket.quantities[productId];
        }
        console.log(data);
        return $.post(this.url, data, null, 'text')
                .then(function(data) {
                    return BX ? BX.parseJSON(data) : JSON.parse(data);
                });
    };
    
    

    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if(!$.data(this, "plugin_" + pluginName)) {
                $.data(
                    this, 
                    "plugin_" + pluginName,
                    new SmallBasket(this, options)
                );
            }
        });
    };
    
})(jQuery);