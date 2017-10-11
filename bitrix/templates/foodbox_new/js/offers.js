var RSMONOPOLY_OffersExt_timeout_id = 0;

function RSMONOPOLY_OffersExt_ChangeHTML($elementObj) {
	var element_id = $elementObj.data('elementid');
	if( RSMONOPOLY_OFFERS[element_id] ) {
		// get all selected values
		var arrFullChosed = new Object();
		$elementObj.find('.div_option.selected').each(function(index1){
			var $optionObj = $(this);
			var code = $optionObj.parents('.offer_prop').data('code');
			var value = $optionObj.data('value');
			arrFullChosed[code] = value;
		});

		// get offerID (key=ID)
		var finedOfferID = 0,
		    all_prop_true2 = true;
		for(offerID in RSMONOPOLY_OFFERS[element_id].OFFERS) {
			all_prop_true2 = true;
			for(pCode in arrFullChosed) {
				if( arrFullChosed[pCode] != RSMONOPOLY_OFFERS[element_id].OFFERS[offerID].PROPERTIES[pCode] ) {
					all_prop_true2 = false;
					break;
				}
			}
			if(all_prop_true2) {
				finedOfferID = offerID;
				break;
			}
		}

        if(parseInt(finedOfferID)<1) {
            console.error('offers.js -> Can not find offer ID');
            return;
        }

		// set current offer id
		$elementObj.data('curerntofferid',finedOfferID);
		
		// article
		if( $elementObj.find('.js-article').length>0 ) {
			if( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].ARTICLE ) {
				$elementObj.find('.js-article').html( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].ARTICLE ).parent().css('visibility','visible');
			} else if( $elementObj.find('.js-article').data('prodarticle') ) {
				$elementObj.find('.js-article').html( $elementObj.find('.js-article').data('prodarticle') ).parent().css('display','inline-block');
			} else {
				$elementObj.find('.js-article').parent().css('display','none');
			}
		}
		
		// set solo price
        if( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].MIN_PRICE ) {
            var MIN_PRICE = RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].MIN_PRICE,
				PRICE_CODE = 'pricemin';
			$elementObj.find('.js-discound').hide();
			if( $elementObj.find('.price_pdv_'+PRICE_CODE) ) {
				$elementObj.find('.price_pdv_'+PRICE_CODE).removeClass('new').html( MIN_PRICE.PRINT_DISCOUNT_VALUE );
				if( parseInt(MIN_PRICE.DISCOUNT_DIFF)>0 ) {
					$elementObj.find('.js-discound').show();
					$elementObj.find('.price_pdv_'+PRICE_CODE).addClass('new');
				}
			}
			if( $elementObj.find('.price_pdd_'+PRICE_CODE) ) {
				if( parseInt(MIN_PRICE.DISCOUNT_DIFF)>0 ) {
					$elementObj.find('.price_pdd_'+PRICE_CODE).html( MIN_PRICE.PRINT_DISCOUNT_DIFF );
				} else {
					$elementObj.find('.price_pdd_'+PRICE_CODE).html( '' );
				}
			}
			if( $elementObj.find('.price_pv_'+PRICE_CODE) ) {
				if( parseInt(MIN_PRICE.DISCOUNT_DIFF)>0 ) {
					$elementObj.find('.price_pv_'+PRICE_CODE).html( MIN_PRICE.PRINT_VALUE );
				} else {
					$elementObj.find('.price_pv_'+PRICE_CODE).html( '' );
				}
			}
        }
        // set multi price
		if( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].PRICES ) {
			var PRICES = RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].PRICES;
			for(var PRICE_CODE in PRICES) {
				if( $elementObj.find('.price_pdv_'+PRICE_CODE) ) {
					$elementObj.find('.price_pdv_'+PRICE_CODE).removeClass('new').html( PRICES[PRICE_CODE].PRINT_DISCOUNT_VALUE );
					if( parseInt(PRICES[PRICE_CODE].DISCOUNT_DIFF)>0 ) {
						$elementObj.find('.price_pdv_'+PRICE_CODE).addClass('new');
					}
				}
				if( $elementObj.find('.price_pdd_'+PRICE_CODE) ) {
					if( parseInt(PRICES[PRICE_CODE].DISCOUNT_DIFF)>0 ) {
						$elementObj.find('.price_pdd_'+PRICE_CODE).html( PRICES[PRICE_CODE].PRINT_DISCOUNT_DIFF );
					} else {
						$elementObj.find('.price_pdd_'+PRICE_CODE).html( '' );
					}
				}
				if( $elementObj.find('.price_pv_'+PRICE_CODE) ) {
					if( parseInt(PRICES[PRICE_CODE].DISCOUNT_DIFF)>0 ) {
						$elementObj.find('.price_pv_'+PRICE_CODE).html( PRICES[PRICE_CODE].PRINT_VALUE );
					} else {
						$elementObj.find('.price_pv_'+PRICE_CODE).html( '' );
					}
				}
			}
		}
		
		// set ratio
		if( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].CATALOG_MEASURE_RATIO && $elementObj.find('.js-quantity') ) {
			$elementObj.find('.js-quantity').data('ratio',RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].CATALOG_MEASURE_RATIO);
			$elementObj.find('.js-quantity').val( $elementObj.find('.js-quantity').data('ratio') );
		}
		if( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].CATALOG_MEASURE_NAME && $elementObj.find('.js-measurename') ) {
			$elementObj.find('.js-measurename').html( RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].CATALOG_MEASURE_NAME );
		}
		
		// daysarticle & quickbuy
		$elementObj.removeClass('qb da2');
		$elementObj.find('.timers .timer').hide();
		if( RSMONOPOLY_OFFERS[element_id].ELEMENT.QUICKBUY || RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].QUICKBUY ) {
			$elementObj.addClass('qb');
			if( $elementObj.find('.timers .qb.js-timer_id'+element_id).length>0 ) {
				$elementObj.find('.timers .qb.js-timer_id'+element_id).css('display','inline-block');
			} else if ( $elementObj.find('.timers .qb.js-timer_id'+finedOfferID).length>0 ) {
				$elementObj.find('.timers .qb.js-timer_id'+finedOfferID).css('display','inline-block');
			}
		}
		if( RSMONOPOLY_OFFERS[element_id].ELEMENT.DAYSARTICLE2 || RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].DAYSARTICLE2 ) {
			$elementObj.removeClass('qb').addClass('da2');
			if( $elementObj.find('.timers .da2.js-timer_id'+element_id).length>0 ) {
				$elementObj.find('.timers .timer').hide();
				$elementObj.find('.timers .da2.js-timer_id'+element_id).css('display','inline-block');
			} else if ( $elementObj.find('.timers .da2.js-timer_id'+finedOfferID).length>0 ) {
				$elementObj.find('.timers .timer').hide();
				$elementObj.find('.timers .da2.js-timer_id'+finedOfferID).css('display','inline-block');
			}
		}

		// change product id
		$elementObj.find('.js-add2basketpid').val( finedOfferID );
		if(RSMONOPOLY_OFFERS[element_id].OFFERS[finedOfferID].CAN_BUY) {
			$elementObj.find('.add2basketform').removeClass('cantbuy');
		} else {
			$elementObj.find('.add2basketform').addClass('cantbuy');
		}
		
		// stores
		if( $elementObj.find('.js-stores').length>0 && finedOfferID>0 ) {
			if( RSMONOPOLY_STOCK[element_id] ) {
				if( $elementObj.find('.js-stores').length>0 ) {
					// change stores
					for(storeID in RSMONOPOLY_STOCK[element_id].JS.SKU[finedOfferID]) {
						var stores = RSMONOPOLY_STOCK[element_id].JS.SKU[finedOfferID];
						var quantity = stores[storeID];
						if( RSMONOPOLY_STOCK[element_id].USE_MIN_AMOUNT==true ) {
							if( quantity < 1 ) {
								$elementObj.find('.js-stores').find('.store_'+storeID).find('.amount').removeClass('isset empty').addClass('empty').html( RSMONOPOLY_STOCK[element_id].MESSAGE_EMPTY );
							} else if( quantity < RSMONOPOLY_STOCK[element_id].MIN_AMOUNT ) {
								$elementObj.find('.js-stores').find('.store_'+storeID).find('.amount').removeClass('isset empty').html( RSMONOPOLY_STOCK[element_id].MESSAGE_LOW );
							} else {
								$elementObj.find('.js-stores').find('.store_'+storeID).find('.amount').removeClass('isset empty').addClass('isset').html( RSMONOPOLY_STOCK[element_id].MESSAGE_ISSET );
							}
						} else {
							$elementObj.find('.js-stores').find('.store_'+storeID).find('.amount').html( quantity );
						}
						if( RSMONOPOLY_STOCK[element_id].SHOW_EMPTY_STORE==false && quantity<1 ) {
							$elementObj.find('.js-stores').find('.store_'+storeID).hide();
						} else {
							$elementObj.find('.js-stores').find('.store_'+storeID).show();
						}
					}
				}
				// change general
				if( RSMONOPOLY_STOCK[element_id].QUANTITY[element_id] ) {
					var quantity = parseInt( RSMONOPOLY_STOCK[element_id].QUANTITY[finedOfferID] );
					if( RSMONOPOLY_STOCK[element_id].USE_MIN_AMOUNT==true ) {
						if( quantity < 1 ) {
							$elementObj.find('.js-stores').find('.genamount').removeClass('isset empty').addClass('empty').html( RSMONOPOLY_STOCK[element_id].MESSAGE_EMPTY );
						} else if( quantity < RSMONOPOLY_STOCK[element_id].MIN_AMOUNT ) {
							$elementObj.find('.js-stores').find('.genamount').removeClass('isset empty').html( RSMONOPOLY_STOCK[element_id].MESSAGE_LOW );
						} else {
							$elementObj.find('.js-stores').find('.genamount').removeClass('isset empty').addClass('isset').html( RSMONOPOLY_STOCK[element_id].MESSAGE_ISSET );
						}
					} else {
						$elementObj.find('.js-stores').find('.genamount').html( quantity );
					}
				}
			} else {
				console.warn( 'OffersExt_ChangeHTML -> store not found' );
			}
		}
		
		// set buttons "in basket" and "not in basket"
		RSMONOPOLY_SetInBasket();

		// event
		$(document).trigger('RSMONOPOLYOnOfferChange',[$elementObj]);
	}
}

function RSMONOPOLY_OffersExt_PropChanged($optionObj) {
	var element_id = $optionObj.parents('.js-element').data('elementid'),
	    CURRENT_PROP_CODE = $optionObj.parents('.offer_prop').data('code'),
	    value = $optionObj.data('value');
	if( RSMONOPOLY_OFFERS[element_id] && !$optionObj.hasClass('disabled') ) {
		// change styles
		$optionObj.parents('.offer_prop').removeClass('opened').addClass('closed');
		$optionObj.parents('.offer_prop').find('.div_option').removeClass('selected');
		$optionObj.addClass('selected');
		
		// set current value
		if( $optionObj.parents('.offer_prop').hasClass('color') ) { // color 
			$optionObj.parents('.offer_prop').find('.div_selected span').css({'backgroundImage':$optionObj.find('span').css('backgroundImage')});
		} else {
			$optionObj.parents('.offer_prop').find('.div_selected span').html(value);
		}
		
		var next_index = 0,
		    NEXT_PROP_CODE = '',
            PROP_CODE = '',
            arCurrentValues = new Object();
		
		// get current values
		for(index in RSMONOPOLY_OFFERS[element_id].SORT_PROPS) {
			PROP_CODE = RSMONOPOLY_OFFERS[element_id].SORT_PROPS[index];
			arCurrentValues[PROP_CODE] = $optionObj.parents('.js-element').find('.prop_'+PROP_CODE).find('.div_option.selected').data('value');
			// save next prop_code
			if(PROP_CODE==CURRENT_PROP_CODE) {
				next_index = parseInt(index)+1;
				if( RSMONOPOLY_OFFERS[element_id].SORT_PROPS[next_index] )
					NEXT_PROP_CODE = RSMONOPOLY_OFFERS[element_id].SORT_PROPS[next_index];
				else
					NEXT_PROP_CODE = false;
				break;
			}
		}

		// get enabled values for next property
		if(NEXT_PROP_CODE) {
			var allPropTrue1 = true,
			    arNextEnabledProps = new Array();
			for(offerID in RSMONOPOLY_OFFERS[element_id].OFFERS) {
				allPropTrue1 = true;
				for(pCode1 in arCurrentValues) {
					if( arCurrentValues[pCode1] != RSMONOPOLY_OFFERS[element_id].OFFERS[offerID].PROPERTIES[pCode1] ) {
						allPropTrue1 = false;
					}
				}
				if(allPropTrue1) {
					arNextEnabledProps.push( RSMONOPOLY_OFFERS[element_id].OFFERS[offerID].PROPERTIES[NEXT_PROP_CODE] );
				}
			}

			// disable and enable values for NEXT_PROP_CODE
			$optionObj.parents('.js-element').find('.prop_'+NEXT_PROP_CODE).find('.div_option').each(function(i){
				var $option = $(this),
				    emptyInEnabled = true;
				for(inden in arNextEnabledProps) {
					if( $option.data('value') == arNextEnabledProps[inden] ) {
						emptyInEnabled = false;
						break;
					}
				}
				$option.addClass('disabled');
				if(!emptyInEnabled)
					$option.removeClass('disabled');
			});

			// call itself
			var nextOptionObj;
			if(!$optionObj.parents('.js-element').find('.prop_'+NEXT_PROP_CODE).find('.div_option.selected').hasClass('disabled')) {
				nextOptionObj = $optionObj.parents('.js-element').find('.prop_'+NEXT_PROP_CODE).find('.div_option.selected');
			} else {
				nextOptionObj = $optionObj.parents('.js-element').find('.prop_'+NEXT_PROP_CODE).find('.div_option:not(.disabled):first');
			}
            RSMONOPOLY_OffersExt_PropChanged(nextOptionObj);
		} else {
            RSMONOPOLY_OffersExt_ChangeHTML( $optionObj.parents('.js-element') );
		}
	}
}

$(document).ready(function(){
	
	// prop select -> click
	$(document).on('click','.div_option',function(e){
		e.stopPropagation();
		clearTimeout( RSMONOPOLY_OffersExt_timeout_id );
		var $optionObj = $(this);
		if(!$optionObj.hasClass('disabled')) {
			var element_id = $optionObj.parents('.js-element').data('elementid');
			if( element_id > 0 ) {
				var propCode = $optionObj.parents('.offer_prop').data('code'),
				    value = $optionObj.data('value');
				if( RSMONOPOLY_OFFERS[element_id] ) {
                    RSMONOPOLY_OffersExt_PropChanged($optionObj);
				} else {
                    RSMONOPOLY_Area2Darken( $optionObj.parents('.js-element'), 'animashka' );
					var url = $optionObj.parents('.js-element').data('detailpageurl') + '?AJAX_CALL=Y&action=get_element_json&element_id=' + element_id;
					$.getJSON(url, {}, function(json){
                        RSMONOPOLY_OFFERS[element_id] = json;
                        RSMONOPOLY_OffersExt_PropChanged($optionObj);
                        RSMONOPOLY_Area2Darken( $optionObj.parents('.js-element') );
					}).fail(function(data){
						console.warn( 'Get element JSON -> fail request' );
                        RSMONOPOLY_Area2Darken( $optionObj.parents('.js-element') );
					});
				}
			} else {
				console.warn( 'offers.js -> element_id is empty' );
			}
		}
		return false;
	});
	$(document).on('click','.div_selected',function(e){
		$('.offer_prop.opened:not(.prop_'+ $(this).parents('.offer_prop').data('code')+')').removeClass('opened').addClass('closed');
		if( $(this).parents('.offer_prop').hasClass('closed') ) { // was closed 
			$(this).parents('.offer_prop').removeClass('closed').addClass('opened');
		} else { // was opened
			$(this).parents('.offer_prop').removeClass('opened').addClass('closed');
		}
		return false;
	});
	// close prop select by click outside
	$(document).on('click',function(e){
		if( $(e.target).parents('.offer_prop').length>0 && !$(e.target).parents('.offer_prop').hasClass('color') ) {

		} else {
			$('.offer_prop').removeClass('opened').addClass('closed');
		}
	});

});