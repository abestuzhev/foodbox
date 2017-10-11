/* global BX */

/**
 * @param basketItemId
 * @param {{BASKET_ID : string, BASKET_DATA : { GRID : { ROWS : {} }}, COLUMNS: {}, PARAMS: {}, DELETE_ORIGINAL : string }} res
 */
function updateBasketTable(basketItemId, res)
{
    var table = BX("basket_items"),
            rows,
            newBasketItemId,
            arItem,
            lastRow,
            newRow,
            arColumns,
            bShowDeleteColumn = false,
            bShowDelayColumn = false,
            bShowPropsColumn = false,
            bShowPriceType = false,
            bUseFloatQuantity,
            origBasketItem,
            oCellMargin,
            i,
            oCellName,
            imageURL,
            cellNameHTML,
            oCellItem,
            cellItemHTML,
            bSkip,
            j,
            val,
            propId,
            arProp,
            bIsImageProperty,
            full,
            arVal,
            valId,
            arSkuValue,
            selected,
            valueId,
            k,
            arItemProp,
            oCellQuantity,
            oCellQuantityHTML,
            ratio,
            max,
            isUpdateQuantity,
            oldQuantity,
            oCellPrice,
            fullPrice,
            id,
            oCellDiscount,
            oCellWeight,
            oCellCustom,
            customColumnVal;

    if (!table || typeof res !== 'object')
    {
        return;
    }

    rows = table.rows;
    lastRow = rows[rows.length - 1];
    bUseFloatQuantity = (res.PARAMS.QUANTITY_FLOAT === 'Y');

    // insert new row instead of original basket item row
    if (basketItemId !== null && !!res.BASKET_DATA)
    {
        //console.log(arItem);
        newBasketItemId = res.BASKET_ID;
        arItem = res.BASKET_DATA.GRID.ROWS[newBasketItemId];
        arColumns = res.COLUMNS.split(',');
        newRow = document.createElement('tr');

        origBasketItem = BX(basketItemId);

        newRow.setAttribute('id', res.BASKET_ID);
        lastRow.parentNode.insertBefore(newRow, origBasketItem.nextSibling);

        if (res.DELETE_ORIGINAL === 'Y')
        {
            origBasketItem.parentNode.removeChild(origBasketItem);
        }

        // fill row with fields' values
        oCellMargin = newRow.insertCell(-1);
        oCellMargin.setAttribute('class', 'margin');

        for (i = 0; i < arColumns.length; i++)
        {
            if (arColumns[i] === 'DELETE')
            {
                bShowDeleteColumn = true;
            } else if (arColumns[i] === 'DELAY')
            {
                bShowDelayColumn = true;
            } else if (arColumns[i] === 'PROPS')
            {
                bShowPropsColumn = true;
            } else if (arColumns[i] === 'TYPE')
            {
                bShowPriceType = true;
            }
        }

        for (i = 0; i < arColumns.length; i++)
        {
            switch (arColumns[i])
            {
                case 'PROPS':
                case 'DELAY':
                case 'DELETE':
                case 'TYPE':
                    break;
                case 'NAME':
                    // first <td> - image and brand
                    oCellName = newRow.insertCell(-1);
                    imageURL = '';
                    cellNameHTML = '';

                    oCellName.setAttribute('class', 'itemphoto');

                    if (arItem.PREVIEW_PICTURE_SRC.length > 0)
                    {
                        imageURL = arItem.PREVIEW_PICTURE_SRC;
                    } else if (arItem.DETAIL_PICTURE_SRC.length > 0)
                    {
                        imageURL = arItem.DETAIL_PICTURE_SRC;
                    } else
                    {
                        imageURL = basketJSParams.TEMPLATE_FOLDER + '/images/no_photo.png';
                    }

                    if (arItem.DETAIL_PAGE_URL.length > 0)
                    {
                        cellNameHTML = '<div class="bx_ordercart_photo_container">\
							<a href="' + arItem.DETAIL_PAGE_URL + '">\
								<img alt="' + imageURL + '" src="" />\
							</a>\
						</div>';
                    } else
                    {
                        cellNameHTML = '<div class="bx_ordercart_photo_container">\
							<img alt="' + imageURL + '" src="" />\
						</div>';
                    }

                    if (arItem.BRAND && arItem.BRAND.length > 0)
                    {
                        cellNameHTML += '<div class="bx_ordercart_brand">\
							<img alt="" src="' + arItem.BRAND + '"/>\
						</div>';
                    }

                    oCellName.innerHTML = cellNameHTML;

                    // second <td> - name, basket props, sku props
                    oCellItem = newRow.insertCell(-1);
                    cellItemHTML = '';
                    oCellItem.setAttribute('class', 'item');

                    if (arItem['DETAIL_PAGE_URL'].length > 0)
                        cellItemHTML += '<a class="aprimary" href="' + arItem['DETAIL_PAGE_URL'] + '">' + arItem['NAME'] + '</a>';
                    else
                        cellItemHTML += '<span>' + arItem['NAME'] + '</span>';

                    oCellItem.innerHTML = cellItemHTML;
                    break;
                case 'QUANTITY':
                    oCellQuantity = newRow.insertCell(-1);
                    oCellQuantityHTML = '';
                    ratio = (parseFloat(arItem['MEASURE_RATIO']) > 0) ? arItem['MEASURE_RATIO'] : 1;
                    max = (parseFloat(arItem['AVAILABLE_QUANTITY']) > 0) ? 'max="' + arItem['AVAILABLE_QUANTITY'] + '"' : '';

                    isUpdateQuantity = false;

                    if (ratio != 0 && ratio != '')
                    {
                        oldQuantity = arItem['QUANTITY'];
                        arItem['QUANTITY'] = getCorrectRatioQuantity(arItem['QUANTITY'], ratio, bUseFloatQuantity);

                        if (oldQuantity != arItem['QUANTITY'])
                        {
                            isUpdateQuantity = true;
                        }
                    }

                    oCellQuantity.setAttribute('class', 'custom');
                    oCellQuantityHTML += '<span>' + getColumnName(res, arColumns[i]) + ':</span>';

                    oCellQuantityHTML += '<div class="centered">';
                    oCellQuantityHTML += '<table cellspacing="0" cellpadding="0" class="counter">';
                    oCellQuantityHTML += '<tr>';
                    oCellQuantityHTML += '<td>';

                    oCellQuantityHTML += '<input class="form-control" type="text" size="3" id="QUANTITY_INPUT_' + arItem['ID'] + '"\
											name="QUANTITY_INPUT_' + arItem['ID'] + '"\
											size="2" maxlength="18" min="0" ' + max + 'step=' + ratio + '\
											style="max-width: 50px"\
											value="' + arItem['QUANTITY'] + '"\
											onchange="updateQuantity(\'QUANTITY_INPUT_' + arItem['ID'] + '\',\'' + arItem['ID'] + '\', ' + ratio + ',' + bUseFloatQuantity + ')"\
						>';

                    oCellQuantityHTML += '</td>';

                    if (ratio != 0
                            && ratio != ''
                            ) // if not Set parent, show quantity control
                    {
                        oCellQuantityHTML += '<td id="basket_quantity_control">\
							<div class="basket_quantity_control">\
								<a href="javascript:void(0);" class="plus" onclick="setQuantity(' + arItem['ID'] + ', ' + ratio + ', \'up\', ' + bUseFloatQuantity + ');"></a>\
								<a href="javascript:void(0);" class="minus" onclick="setQuantity(' + arItem['ID'] + ', ' + ratio + ', \'down\', ' + bUseFloatQuantity + ');"></a>\
							</div>\
						</td>';
                    }

                    if (arItem.hasOwnProperty('MEASURE_TEXT') && arItem['MEASURE_TEXT'].length > 0)
                        oCellQuantityHTML += '<td style="text-align: left">' + arItem['MEASURE_TEXT'] + '</td>';

                    oCellQuantityHTML += '</tr>';
                    oCellQuantityHTML += '</table>';
                    oCellQuantityHTML += '</div>';

                    oCellQuantityHTML += '<input type="hidden" id="QUANTITY_' + arItem['ID'] + '" name="QUANTITY_' + arItem['ID'] + '" value="' + arItem['QUANTITY'] + '" />';

                    oCellQuantity.innerHTML = oCellQuantityHTML;

                    if (isUpdateQuantity)
                    {
                        updateQuantity('QUANTITY_INPUT_' + arItem['ID'], arItem['ID'], ratio, bUseFloatQuantity);
                    }
                    break;
                case 'PRICE':
                    oCellPrice = newRow.insertCell(-1);
                    fullPrice = (arItem['FULL_PRICE_FORMATED'] != arItem['PRICE_FORMATED']) ? arItem['FULL_PRICE_FORMATED'] : '';

                    oCellPrice.setAttribute('class', 'price');
                    oCellPrice.innerHTML += '<div class="price current_price text-nowrap" id="current_price_' + arItem['ID'] + '">' + arItem['PRICE_FORMATED'] + '</div>';
                    oCellPrice.innerHTML += '<div class="price old old_price text-nowrap" id="old_price_' + arItem['ID'] + '">' + fullPrice + '</div>';

                    break;
                case 'DISCOUNT':
                    oCellDiscount = newRow.insertCell(-1);
                    oCellDiscount.setAttribute('class', 'custom');
                    oCellDiscount.innerHTML = '<span>' + getColumnName(res, arColumns[i]) + ':</span>';
                    oCellDiscount.innerHTML += '<div id="discount_value_' + arItem['ID'] + '" class="price discount">' + arItem['DISCOUNT_PRICE_PERCENT_FORMATED'] + '</div>';
                    break;
                case 'WEIGHT':
                    oCellWeight = newRow.insertCell(-1);
                    oCellWeight.setAttribute('class', 'custom');
                    oCellWeight.innerHTML = '<span>' + getColumnName(res, arColumns[i]) + ':</span>';
                    oCellWeight.innerHTML += arItem['WEIGHT_FORMATED'];
                    break;
                default:
                    oCellCustom = newRow.insertCell(-1);
                    customColumnVal = '';

                    oCellCustom.setAttribute('class', 'custom');
                    oCellCustom.innerHTML = '<span>' + getColumnName(res, arColumns[i]) + ':</span>';

                    if (arColumns[i] == 'SUM')
                        customColumnVal += '<div class="price" id="sum_' + arItem['ID'] + '">';

                    if (typeof (arItem[arColumns[i]]) != 'undefined')
                    {
                        customColumnVal += arItem[arColumns[i]];
                    }

                    if (arColumns[i] == 'SUM')
                        customColumnVal += '</div>';

                    oCellCustom.innerHTML += customColumnVal;
                    break;
            }
        }

        if (bShowDeleteColumn || bShowDelayColumn)
        {
            var oCellControl = newRow.insertCell(-1);
            oCellControl.setAttribute('class', 'control');

            if (bShowDeleteColumn)
                oCellControl.innerHTML = '<a href="' + basketJSParams['DELETE_URL'].replace('#ID#', arItem['ID']) + '">' + basketJSParams['SALE_DELETE'] + '</a><br />';

            if (bShowDelayColumn)
                oCellControl.innerHTML += '<a href="' + basketJSParams['DELAY_URL'].replace('#ID#', arItem['ID']) + '">' + basketJSParams['SALE_DELAY'] + '</a>';
        }

        var oCellMargin2 = newRow.insertCell(-1);
        oCellMargin2.setAttribute('class', 'margin');

        // set sku props click handler
        var sku_props = BX.findChildren(BX(newBasketItemId), {tagName: 'li', className: 'sku_prop'}, true);
        if (!!sku_props && sku_props.length > 0)
        {
            for (i = 0; sku_props.length > i; i++)
            {
                BX.bind(sku_props[i], 'click', BX.delegate(function (e) {
                    skuPropClickHandler(e);
                }, this));
            }
        }
    }

    // update product params after recalculation
    if (!!res.BASKET_DATA)
    {
        for (id in res.BASKET_DATA.GRID.ROWS)
        {
            if (res.BASKET_DATA.GRID.ROWS.hasOwnProperty(id))
            {
                var item = res.BASKET_DATA.GRID.ROWS[id];

                if (BX('discount_value_' + id))
                    BX('discount_value_' + id).innerHTML = item.DISCOUNT_PRICE_PERCENT_FORMATED;

                if (BX('current_price_' + id))
                    BX('current_price_' + id).innerHTML = item.PRICE_FORMATED;

                if (BX('old_price_' + id))
                    BX('old_price_' + id).innerHTML = (item.FULL_PRICE_FORMATED != item.PRICE_FORMATED) ? item.FULL_PRICE_FORMATED : '';

                if (BX('sum_' + id))
                    BX('sum_' + id).innerHTML = item.SUM;

                // if the quantity was set by user to 0 or was too much, we need to show corrected quantity value from ajax response
                if (BX('QUANTITY_' + id))
                {
                    BX('QUANTITY_INPUT_' + id).value = item.QUANTITY;
                    BX('QUANTITY_INPUT_' + id).defaultValue = item.QUANTITY;

                    BX('QUANTITY_' + id).value = item.QUANTITY;
                }
            }
        }
    }

    // update coupon info
    if (!!res.BASKET_DATA)
        couponListUpdate(res.BASKET_DATA);

    // update warnings if any
    if (res.hasOwnProperty('WARNING_MESSAGE'))
    {
        var warningText = '';

        for (i = res['WARNING_MESSAGE'].length - 1; i >= 0; i--)
            warningText += res['WARNING_MESSAGE'][i] + '<br/>';

        BX('warning_message').innerHTML = warningText;
    }

    // update total basket values


    if (!!res.BASKET_DATA)
    {
        if (BX('allWeight_FORMATED'))
            BX('allWeight_FORMATED').innerHTML = res['BASKET_DATA']['allWeight_FORMATED'].replace(/\s/g, '&nbsp;');

        if (BX('allSum_wVAT_FORMATED'))
            BX('allSum_wVAT_FORMATED').innerHTML = res['BASKET_DATA']['allSum_wVAT_FORMATED'].replace(/\s/g, '&nbsp;');

        if (BX('allVATSum_FORMATED'))
            BX('allVATSum_FORMATED').innerHTML = res['BASKET_DATA']['allVATSum_FORMATED'].replace(/\s/g, '&nbsp;');

        if (BX('allSum_FORMATED'))
            BX('allSum_FORMATED').innerHTML = res['BASKET_DATA']['allSum_FORMATED'].replace(/\s/g, '&nbsp;');

        if (BX('PRICE_WITHOUT_DISCOUNT'))
            BX('PRICE_WITHOUT_DISCOUNT').innerHTML = (res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'] != res['BASKET_DATA']['allSum_FORMATED']) ? res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'].replace(/\s/g, '&nbsp;') : '';

        if (res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'] != res['BASKET_DATA']['allSum_FORMATED']) {
            BX.show(BX('PRICE_WITHOUT_DISCOUNT').parentNode);
            BX.show(BX('DISCOUNT_PRICE_ALL_FORMATED').parentNode);
            BX('DISCOUNT_PRICE_ALL_FORMATED').innerHTML = res['BASKET_DATA']['DISCOUNT_PRICE_ALL_FORMATED'].replace(/\s/g, '&nbsp;');
        }
        else {
            BX.hide(BX('PRICE_WITHOUT_DISCOUNT').parentNode);
            BX.hide(BX('DISCOUNT_PRICE_ALL_FORMATED').parentNode);
            BX('DISCOUNT_PRICE_ALL_FORMATED').innerHTML = '';
        }

        BX.onCustomEvent('OnBasketChange');
    }

    //if(parseInt(res['BASKET_DATA']['allSum'])<1500) showBuyMoreForFreeDelivery(res['BASKET_DATA']['allSum'], 1500);
}
/**
 * @param couponBlock
 * @param {COUPON: string, JS_STATUS: string} oneCoupon - new coupon.
 */
function couponCreate(couponBlock, oneCoupon)
{
    console.log('couponCreate');
    var couponClass = 'disabled';

    if (!BX.type.isElementNode(couponBlock))
        return;
    if (oneCoupon.JS_STATUS === 'BAD')
        couponClass = 'bad has-error';
    else if (oneCoupon.JS_STATUS === 'APPLYED')
        couponClass = 'good has-success';

    var rand = Math.floor(Math.random());

    couponBlock.appendChild(BX.create(
            'div',
            {
                props: {
                    className: 'has-feedback ' + couponClass
                },
                children: [
                    BX.create(
                            'label',
                            {
                                props: {
                                    className: 'control-label'
                                },
                                attrs: {
                                    for : 'coupon_' + rand
                                },
                                html: BX.message('COUPON')
                            }
                    ),
                    BX.create(
                            'input',
                            {
                                props: {
                                    className: 'form-control',
                                    type: 'text',
                                    value: oneCoupon.COUPON,
                                    name: 'OLD_COUPON[]'
                                },
                                attrs: {
                                    disabled: true,
                                    readonly: true,
                                    id: 'coupon_' + rand
                                }
                            }
                    ),
                    BX.create(
                            'span',
                            {
                                props: {
                                    className: 'fa glyphicon-remove form-control-feedback',
                                }
                            }
                    ),
                    BX.create(
                            'p',
                            {
                                props: {
                                    className: 'help-block'
                                },
                                children: [
                                    BX.create(
                                            'span',
                                            {
                                                props: {
                                                    className: 'note'
                                                },
                                                html: oneCoupon.JS_CHECK_CODE + '&nbsp;',
                                            }
                                    ),
                                    BX.create(
                                            'span',
                                            {
                                                props: {
                                                    className: 'aprimary ' + couponClass
                                                },
                                                attrs: {
                                                    'data-coupon': oneCoupon.COUPON,
                                                    'style': 'cursor:pointer;'
                                                },
                                                html: BX.message('SALE_DELETE')
                                            }
                                    )
                                ]
                            }
                    )
                ]
            }
    ));
}

/**
 * @param {COUPON_LIST : []} res
 */
function couponListUpdate(res)
{
    var couponBlock,
            couponClass,
            fieldCoupon,
            couponsCollection,
            couponFound,
            i,
            j,
            key;

    if (!!res && typeof res !== 'object')
    {
        return;
    }

    couponBlock = BX('coupons_block');
    if (!!couponBlock)
    {
        if (!!res.COUPON_LIST && BX.type.isArray(res.COUPON_LIST))
        {
            fieldCoupon = BX('coupon');
            if (!!fieldCoupon)
            {
                fieldCoupon.value = '';
            }
            couponsCollection = BX.findChildren(couponBlock, {tagName: 'input', property: {name: 'OLD_COUPON[]'}}, true);

            if (!!couponsCollection)
            {
                if (BX.type.isElementNode(couponsCollection))
                {
                    couponsCollection = [couponsCollection];
                }

                for (i = 0; i < res.COUPON_LIST.length; i++)
                {
                    couponFound = false;
                    key = -1;
                    for (j = 0; j < couponsCollection.length; j++)
                    {
                        if (couponsCollection[j].value === res.COUPON_LIST[i].COUPON)
                        {
                            couponFound = true;
                            key = j;
                            couponsCollection[j].couponUpdate = true;
                            break;
                        }
                    }
                    if (couponFound)
                    {
                        couponClass = 'disabled';
                        if (res.COUPON_LIST[i].JS_STATUS === 'BAD')
                            couponClass = 'bad has-error';
                        else if (res.COUPON_LIST[i].JS_STATUS === 'APPLYED')
                            couponClass = 'good has-success';

                        console.log(couponsCollection[key]);
                        BX.adjust(couponsCollection[key].parentNode, {props: {className: ' has-feedback ' + couponClass}});
                        //BX.adjust(couponsCollection[key].nextSibling, {props: {className: couponClass}});
                        BX.adjust(couponsCollection[key].nextElementSibling.nextElementSibling.firstChild, {html: res.COUPON_LIST[i].JS_CHECK_CODE + '&nbsp;'});
                    } else
                    {
                        couponCreate(couponBlock, res.COUPON_LIST[i]);
                    }
                }
                for (j = 0; j < couponsCollection.length; j++)
                {
                    if (typeof (couponsCollection[j].couponUpdate) === 'undefined' || !couponsCollection[j].couponUpdate)
                    {
                        BX.remove(couponsCollection[j].parentNode);
                        couponsCollection[j] = null;
                    } else
                    {
                        couponsCollection[j].couponUpdate = null;
                    }
                }
            } else
            {
                for (i = 0; i < res.COUPON_LIST.length; i++)
                {
                    couponCreate(couponBlock, res.COUPON_LIST[i]);
                }
            }
        }
    }
    couponBlock = null;
}

function skuPropClickHandler(e)
{
    if (!e)
    {
        e = window.event;
    }
    var target = BX.proxy_context,
            basketItemId,
            property,
            property_values = {},
            postData = {},
            action_var,
            all_sku_props,
            i,
            sku_prop_value,
            m;

    if (!!target && target.hasAttribute('data-value-id'))
    {
        BX.showWait();

        basketItemId = target.getAttribute('data-element');
        property = target.getAttribute('data-property');
        action_var = BX('action_var').value;

        property_values[property] = target.getAttribute('data-value-id');

        // if already selected element is clicked
        if (BX.hasClass(target, 'bx_active'))
        {
            BX.closeWait();
            return;
        }

        // get other basket item props to get full unique set of props of the new product
        all_sku_props = BX.findChildren(BX(basketItemId), {tagName: 'ul', className: 'sku_prop_list'}, true);
        if (!!all_sku_props && all_sku_props.length > 0)
        {
            for (i = 0; all_sku_props.length > i; i++)
            {
                if (all_sku_props[i].id !== 'prop_' + property + '_' + basketItemId)
                {
                    sku_prop_value = BX.findChildren(BX(all_sku_props[i].id), {tagName: 'li', className: 'bx_active'}, true);
                    if (!!sku_prop_value && sku_prop_value.length > 0)
                    {
                        for (m = 0; sku_prop_value.length > m; m++)
                        {
                            if (sku_prop_value[m].hasAttribute('data-value-id'))
                            {
                                property_values[sku_prop_value[m].getAttribute('data-property')] = sku_prop_value[m].getAttribute('data-value-id');
                            }
                        }
                    }
                }
            }
        }

        postData = {
            'basketItemId': basketItemId,
            'sessid': BX.bitrix_sessid(),
            'site_id': BX.message('SITE_ID'),
            'props': property_values,
            'action_var': action_var,
            'select_props': BX('column_headers').value,
            'offers_props': BX('offers_props').value,
            'quantity_float': BX('quantity_float').value,
            'count_discount_4_all_quantity': BX('count_discount_4_all_quantity').value,
            'price_vat_show_value': BX('price_vat_show_value').value,
            'hide_coupon': BX('hide_coupon').value,
            'use_prepayment': BX('use_prepayment').value
        };

        postData[action_var] = 'select_item';

        BX.ajax({
            url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
            method: 'POST',
            data: postData,
            dataType: 'json',
            onsuccess: function (result)
            {
                BX.closeWait();
                updateBasketTable(basketItemId, result);
            }
        });
    }
}

function getColumnName(result, columnCode)
{
    if (BX('col_' + columnCode))
    {
        return BX.util.trim(BX('col_' + columnCode).innerHTML);
    } else
    {
        return '';
    }
}

function leftScroll(prop, id, count)
{
    count = parseInt(count, 10);
    var el = BX('prop_' + prop + '_' + id);

    if (el)
    {
        var curVal = parseInt(el.style.marginLeft, 10);
        if (curVal <= (6 - count) * 20)
            el.style.marginLeft = curVal + 20 + '%';
    }
}

function rightScroll(prop, id, count)
{
    count = parseInt(count, 10);
    var el = BX('prop_' + prop + '_' + id);

    if (el)
    {
        var curVal = parseInt(el.style.marginLeft, 10);
        if (curVal > (5 - count) * 20)
            el.style.marginLeft = curVal - 20 + '%';
    }
}

function checkOut()
{
    if (!!BX('coupon'))
        BX('coupon').disabled = true;
    BX("basket_form").submit();
    return true;
}

function enterCoupon()
{
    SendAnalyticsGoal('promo');

    var newCoupon = BX('coupon');
    if (!!newCoupon && !!newCoupon.value)
        recalcBasketAjax({'coupon': newCoupon.value});
}

// check if quantity is valid
// and update values of both controls (text input field for PC and mobile quantity select) simultaneously
function updateQuantity(controlId, basketId, ratio, bUseFloatQuantity)
{
    var oldVal = BX(controlId).defaultValue,
            newVal = parseFloat(BX(controlId).value) || 0,
            bIsCorrectQuantityForRatio = false;

    if (ratio === 0 || ratio == 1)
    {
        bIsCorrectQuantityForRatio = true;
    } else
    {

        var newValInt = newVal * 10000,
                ratioInt = ratio * 10000,
                reminder = newValInt % ratioInt,
                newValRound = parseInt(newVal);

        if (reminder === 0)
        {
            bIsCorrectQuantityForRatio = true;
        }
    }

    var bIsQuantityFloat = false;

    if (parseInt(newVal) != parseFloat(newVal))
    {
        bIsQuantityFloat = true;
    }

    newVal = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(newVal) : parseFloat(newVal).toFixed(2);

    if (bIsCorrectQuantityForRatio)
    {
        BX(controlId).defaultValue = newVal;

        BX("QUANTITY_INPUT_" + basketId).value = newVal;

        // set hidden real quantity value (will be used in actual calculation)
        BX("QUANTITY_" + basketId).value = newVal;

        recalcBasketAjax({});
    } else
    {
        newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

        if (newVal != oldVal)
        {
            BX("QUANTITY_INPUT_" + basketId).value = newVal;
            BX("QUANTITY_" + basketId).value = newVal;
            recalcBasketAjax({});
        } else
        {
            BX(controlId).value = oldVal;
        }
    }
}

// used when quantity is changed by clicking on arrows
function setQuantity(basketId, ratio, sign, bUseFloatQuantity)
{
    var curVal = parseFloat(BX("QUANTITY_INPUT_" + basketId).value),
            newVal;

    newVal = (sign == 'up') ? curVal + ratio : curVal - ratio;

    if (newVal < 0)
        newVal = 0;

    if (bUseFloatQuantity)
    {
        newVal = newVal.toFixed(2);
    }

    if (ratio > 0 && newVal < ratio)
    {
        newVal = ratio;
    }

    if (!bUseFloatQuantity && newVal != newVal.toFixed(2))
    {
        newVal = newVal.toFixed(2);
    }

    newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

    BX("QUANTITY_INPUT_" + basketId).value = newVal;
    BX("QUANTITY_INPUT_" + basketId).defaultValue = newVal;

    updateQuantity('QUANTITY_INPUT_' + basketId, basketId, ratio, bUseFloatQuantity);
}

function getCorrectRatioQuantity(quantity, ratio, bUseFloatQuantity)
{
    var newValInt = quantity * 10000,
            ratioInt = ratio * 10000,
            reminder = newValInt % ratioInt,
            result = quantity,
            bIsQuantityFloat = false,
            i;
    ratio = parseFloat(ratio);

    if (reminder === 0)
    {
        return result;
    }

    if (ratio !== 0 && ratio != 1)
    {
        for (i = ratio, max = parseFloat(quantity) + parseFloat(ratio); i <= max; i = parseFloat(parseFloat(i) + parseFloat(ratio)).toFixed(2))
        {
            result = i;
        }

    } else if (ratio === 1)
    {
        result = quantity | 0;
    }

    if (parseInt(result, 10) != parseFloat(result))
    {
        bIsQuantityFloat = true;
    }

    result = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(result, 10) : parseFloat(result).toFixed(2);

    return result;
}
/**
 *
 * @param {} params
 */
function recalcBasketAjax(params)
{
    BX.showWait();

    var property_values = {},
            action_var = BX('action_var').value,
            items = BX('basket_items'),
            delayedItems = BX('delayed_items'),
            postData,
            i;

    postData = {
        'sessid': BX.bitrix_sessid(),
        'site_id': BX.message('SITE_ID'),
        'props': property_values,
        'action_var': action_var,
        'select_props': BX('column_headers').value,
        'offers_props': BX('offers_props').value,
        'quantity_float': BX('quantity_float').value,
        'count_discount_4_all_quantity': BX('count_discount_4_all_quantity').value,
        'price_vat_show_value': BX('price_vat_show_value').value,
        'hide_coupon': BX('hide_coupon').value,
        'use_prepayment': BX('use_prepayment').value
    };
    postData[action_var] = 'recalculate';
    if (!!params && typeof params === 'object')
    {
        for (i in params)
        {
            if (params.hasOwnProperty(i))
                postData[i] = params[i];
        }
    }

    if (!!items && items.rows.length > 0)
    {
        for (i = 1; items.rows.length > i; i++)
            postData['QUANTITY_' + items.rows[i].id] = BX('QUANTITY_' + items.rows[i].id).value;
    }

    if (!!delayedItems && delayedItems.rows.length > 0)
    {
        for (i = 1; delayedItems.rows.length > i; i++)
            postData['DELAY_' + delayedItems.rows[i].id] = 'Y';
    }

    RSMONOPOLY_Area2Darken($(".p_basket"));
    BX.ajax({
        url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
        method: 'POST',
        data: postData,
        dataType: 'json',
        onsuccess: function (result)
        {
            BX.closeWait();
            updateBasketTable(null, result);
            RSMONOPOLY_Area2Darken($(".p_basket"));
            updateBasketLine();
            $(".js-basketline").smallBasket();
        }
    });
}

function deleteCoupon(e)
{
    var target = BX.proxy_context,
            value;

    if (!!target && target.hasAttribute('data-coupon'))
    {
        value = target.getAttribute('data-coupon');
        if (!!value && value.length > 0)
        {
            recalcBasketAjax({'delete_coupon': value});
        }
    }
}

BX.ready(function () {
    var sku_props = BX.findChildren(BX('basket_items'), {tagName: 'li', className: 'sku_prop'}, true),
            i,
            couponBlock;
    if (!!sku_props && sku_props.length > 0)
    {
        for (i = 0; sku_props.length > i; i++)
        {
            BX.bind(sku_props[i], 'click', BX.delegate(function (e) {
                skuPropClickHandler(e);
            }, this));
        }
    }
    couponBlock = BX('coupons_block');
    if (!!couponBlock)
        BX.bindDelegate(couponBlock, 'click', {'attribute': 'data-coupon'}, BX.delegate(function (e) {
            deleteCoupon(e);
        }, this));
});

function responsiveBasket($status) {
    //$('.responsiveHiddenDISCOUNT, .responsiveHiddenQUANTITY, .responsiveHiddenPRICE, .responsiveHiddenPRICE, .responsiveHiddenSUM').hide();
    $(".basket_table tr.trBody").each(function (index, obj) {
        var itemId = $(obj).attr('id');

        if ($(document).width() > 1024 && $status == "N") {
            $status = "Y";
        }


        if ($(document).width() <= 1024) {
            if ($status == "Y") {
                $(".ajaxColResponsive" + itemId + " .discountRes" + itemId + ' .value').empty();
                //$(".ajaxColResponsive"+itemId+" .countRes"+itemId+' .value').empty();
                //$(".ajaxColResponsive"+itemId+" .priceRes"+itemId+' .value').empty();
                $(".ajaxColResponsive" + itemId + " .sumRes" + itemId + ' .value').empty();
            }

            $(".ajaxColResponsive" + itemId + " .discountRes" + itemId + ' .value').append($("#discount_value_" + itemId).html());
            $(".ajaxColResponsive" + itemId + " .countRes" + itemId + ' .value').append($("#count_value_" + itemId).html());
            $(".ajaxColResponsive" + itemId + " .priceRes" + itemId + ' .value').append($("#price_value_" + itemId).html());
            $(".ajaxColResponsive" + itemId + " .sumRes" + itemId + ' .value').append($("#sum_" + itemId).html());


            $("#discount_value_" + itemId).empty();
            $("#count_value_" + itemId).empty();
            $("#price_value_" + itemId).empty();
            $("#sum_" + itemId).empty();
        } else {

            $("#discount_value_" + itemId).append($(".ajaxColResponsive" + itemId + " .discountRes" + itemId + ' .value').html());
            $("#count_value_" + itemId).append($(".ajaxColResponsive" + itemId + " .countRes" + itemId + ' .value').html());
            $("#price_value_" + itemId).append($(".ajaxColResponsive" + itemId + " .priceRes" + itemId + ' .value').html());
            $("#sum_" + itemId).append($(".ajaxColResponsive" + itemId + " .sumRes" + itemId + ' .value').html());

            $(".ajaxColResponsive" + itemId + " .discountRes" + itemId + ' .value').empty();
            $(".ajaxColResponsive" + itemId + " .countRes" + itemId + ' .value').empty();
            $(".ajaxColResponsive" + itemId + " .priceRes" + itemId + ' .value').empty();
            $(".ajaxColResponsive" + itemId + " .sumRes" + itemId + ' .value').empty();
        }
    });
}
$(window).resize(function () {
    responsiveBasket("N");
});

$(function () {
    responsiveBasket("Y");

    // basket lineHeight
    $(document).on("smallBasket.recalculated", function (e, data) {
        updateBasketTable(null, data);
    });

    // Clear basket
    $(document).on("click", ".clearbasket", function (e) {
        e.preventDefault();

        SendAnalyticsGoal('delite');

        $("[id^=DELETE_]").attr("checked", "checked");
        basketRefresh();
    });

    // BUY1CLICK 
    $(document).on("click", ".fancyajaxwait.buy1click_basket", function (e) {
        e.preventDefault();

        var $this = $(this),
                strItems = getStrNormalItems(),
                urlData = {
                    RS_EXT_FIELD_0: strItems,
                    "get_form": "1"
                },
                url = url = $this.attr("href").indexOf("?") != -1 ?
                $this.attr("href") + "&" + $.param(urlData) :
                $this.attr("href") + "?" + $.param(urlData);

        window.location = url;
    });

    // BU1CLICK form
    $(document).on("RSMONOPOLY_fancyBeforeShow", function (e, params) {
        var text = '';

        if (params.isSetBuy1Click) {
            text = getStrNormalItems();
            $(".fancybox-wrap [name=RS_EXT_FIELD_0]").val(text);
        }
    });

    // Refresh basket event
    $(document).on("click", "[name=BasketRefresh]", function () {
        RSMONOPOLY_Area2Darken($(".p_basket"));
    });

    // Enabled link to tab
    showTabByHash(window.location.hash);

    function showTabByHash(hash) {
        var hash = document.location.hash;
        if (hash) {
            $('.nav-tabs a[href=' + hash + ']').tab('show');
        }
    }

    function basketRefresh() {
        $("[name=BasketRefresh]").trigger("click");
    }


    function getStrNormalItems() {
        var strItems = '',
                $items = $("#normal tbody > tr");

        $items.each(function (i, item) {
            var $item = $(item),
                    quantity = $item.find("#QUANTITY_INPUT_" + $item.data("elementid")).val(),
                    measure = $item.find(".quantity_measure").text();

            strItems = strItems + "[" + $item.data("elementid") + "] " + $item.data("elementname") +
                    '(' + quantity + measure + ')';
            if ($items.length !== i + 1) {
                strItems += ", ";
            }
        });

        return strItems;
    }
    BX.addCustomEvent('onAjaxSuccess', function () {
        owlInit($(".owlslider.productsmini-owl-slider"));
        updateBasketLine();
        responsiveBasket("Y");
    });
});

function showBuyMoreForFreeDelivery(curSum, freeDeliverySum)
{
    if (getCookie("buyMore") !== "wasShown" && curSum > 0)
    {
        var strContent = "<div id='buyMore'>Бесплатная доставка от 1500 руб.<br>(в пределах МКАД)<br>Для бесплатной доставки Вам не хватает:<br>" + (freeDeliverySum - curSum) + "  руб.</div>"
        var AddToBasketPopup = BX.PopupWindowManager.create('buyMore', null, {
            autoHide: false,
            offsetLeft: 0,
            offsetTop: 0,
            overlay: true,
            closeByEsc: true,
            titleBar: false,
            closeIcon: true,
            contentColor: 'white'
        });
        var buttons = [
            new BX.PopupWindowButton({
                ownerClass: "btn",
                className: 'bx_medium bx_bt_button',
                text: 'Вернуться к покупкам',
                events: {
                    click: function () {
                        location.href = '/catalog/'
                    }
                }
            }),
            new BX.PopupWindowButton({
                ownerClass: "btn",
                className: 'bx_medium bx_bt_button',
                text: "Продолжить оформление заказа",
                events: {
                    click: function () {
                        AddToBasketPopup.close()
                    }
                }
            })
        ];
        //AddToBasketPopup.setTitleBar("Товар добавлен в корзину");
        AddToBasketPopup.setContent(strContent);
        AddToBasketPopup.setButtons(buttons);
        AddToBasketPopup.show();
        setCookie("buyMore", "wasShown", {
            expires: 60 * 60
        });
    }

}

/* function showPopupOformlenie()
 {
 $.ajax({
 url: '/bitrix/templates/mshop_default/components/bitrix/sale.order.ajax/monopoly_new/script.js',
 type: "GET",
 dataType: "script"
 });
 
 $.ajax({
 url: '/personal/order/make/',
 type: "POST",
 success: function(data){
 var strContent = $(data).find("#formOrderDiv").html();
 var AddToBasketPopup = BX.PopupWindowManager.create('PopupOformlenie', null, {
 autoHide: false,
 offsetLeft: 0,
 offsetTop: 0,
 overlay : true,
 closeByEsc: true,
 titleBar: false,
 closeIcon: true,
 contentColor: 'white'
 });
 //AddToBasketPopup.setTitleBar("Товар добавлен в корзину");
 AddToBasketPopup.setContent(strContent);
 AddToBasketPopup.show();
 
 }
 });
 } */

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

        this.obQuantity.disabled = 'disabled';
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
        updateQuantity('QUANTITY_INPUT_' + this.basketId, this.basketId, this.ratioInput, true);

    };
    window.JCCatalogBasket.prototype.QuantityDown = function ()
    {
        var curStep = this.step, nextStep = 0;

        nextStep = parseInt(curStep) - 1;

        if (nextStep <= 0) {
            this.obQuantity.value = this.startRatio;
            this.curValue = this.startRatio;
            this.step = 0;
            updateQuantity('QUANTITY_INPUT_' + this.basketId, this.basketId, this.ratioInput, true);
            return false;
        }
        if (typeof this.middleRatio[nextStep - 1] === 'undefined')
            this.obQuantity.value = parseFloat(this.obQuantity.value) - this.ratio;
        else
            this.obQuantity.value = this.middleRatio[nextStep - 1];

        this.curValue = this.obQuantity.value;
        this.step = nextStep;
        updateQuantity('QUANTITY_INPUT_' + this.basketId, this.basketId, this.ratioInput, true);

    };
})(window);