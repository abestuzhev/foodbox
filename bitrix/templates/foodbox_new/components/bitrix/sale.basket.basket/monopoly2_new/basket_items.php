<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Sale\DiscountCouponsManager;
use \Bitrix\Main\Localization\Loc;
?>

<?
if ($USER->isAdmin()) {
    //print_var($arResult, true);
}
$isDiscountActive = Marketing::getCoupon();
//Еще в файле script.js(шаблоне) есть вызов этой же функии для события изменения состава корзины.
//if(intVal($arResult['allSum'])<1500) echo "<script>showBuyMoreForFreeDelivery(".$arResult['allSum'].",1500);</script>";
?>
<? if (!$isNormal): ?>
    <div class="alert alert-info"><?= Loc::getMessage("SALE_NO_ITEMS"); ?></div>
<? else: ?>
    <?
    showTableWithItems(array(
        'ITEMS' => $arResult["ITEMS"]["AnDelCanBuy"],
        'HEADERS' => $arResult["GRID"]["HEADERS"],
        'SKIP_PROP' => array('WEIGHT', 'PROPS', 'PROPERTY_CML2_ARTICLE_VALUE', 'TYPE'),
        'URLS' => $arUrls,
        'NO_PHOTO' => $arResult['NO_PHOTO']
    ));
    ?>
    <div class="row">
        <div class="col col-xs-6 visible-xs">
            <a href="#" class="clearbasket aprimary"><?= Loc::getMessage("CLEAR_BASKET") ?></a>
        </div>
        <div class = "col col-xs-6 col-md-12 text-right ws_formated">
            <span class = "count-items "> <?= Loc::getMessage("SALE_COUNT_ITEMS"); ?> <span id = ""><?= count($arResult["ITEMS"]["AnDelCanBuy"]); ?></span> </span>
            <? if ($arResult['allWeight']): ?>
                <span class = "total-weight left-indent"><?= Loc::getMessage("SALE_TOTAL_WEIGHT"); ?>  <span id = "allWeight_FORMATED"><?= $arResult['allWeight_FORMATED'] ?></span> </span>
            <? endif; ?>
        </div>
    </div>
    <div class="row">
        <div class = "col col-md-12">
            <div class="panel panel-basket">
                <div class="panel-body">
                    <div class = "row">
                        <div class="col col-md-8">
                            <? if ($isDiscountActive): ?>
                                <span class="marketing-text">
                                    Уважаемый посетитель! Специально для Вас действует персональная <b>скидка <?= Marketing::persent ?>%</b> на весь ассортимент!<br>
                                    Вы можете изменить содержимое корзины, скидка будет действовать на любую продукцию!
                                </span>
                            <? endif; ?>
                        </div>
                        <div class="col col-md-4">
                            <div class="text-right <?= $isDiscountActive ? 'marketing' : '' ?>">
                                <b style="font-size:14px;font-weight: normal;display: <?= floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0 ? 'block' : 'none' ?>;">
                                    <span style="font-size:14px;">Сумма заказа без скидки:</span>
                                    <span class="price cool discount_price" id="PRICE_WITHOUT_DISCOUNT"> <?= $arResult['PRICE_WITHOUT_DISCOUNT'] ?>  </span>
                                </b>
                                <b style="font-size:14px;font-weight: normal;display: <?= floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0 ? 'block' : 'none' ?>;">
                                    <span style="font-size:14px;">Скидка:</span>
                                    <span class="price cool discount_price" id="DISCOUNT_PRICE_ALL_FORMATED"> <?= $arResult['DISCOUNT_PRICE_ALL_FORMATED'] ?>  </span>
                                </b>
                                <? if ($isDiscountActive): ?>
                                    <b class="order_price">
                                        <span style="font-size:14px;"><?= Loc::getMessage("SALE_TOTAL") ?></span>
                                        <span class="price cool" id="allSum_FORMATED" style="text-decoration: line-through">
                                            <?= CCurrencyLang::CurrencyFormat($arResult['allSum'] + $arResult['DISCOUNT_PRICE_ALL'], 'RUB') ?> 
                                        </span>
                                    </b> 
                                    <b style="font-size:14px;font-weight: normal">
                                        <span style="font-size:14px;">Сумма заказа со скидкой <?= Marketing::persent ?>%:</span>
                                        <span class="price cool discount_price" id="allSum_FORMATED"> <?= $arResult['allSum_FORMATED'] ?>  </span>
                                    </b>
                                <? elseif ($arResult['COUPON_LIST']): ?> 
                                    <b style="font-size:22px;">
                                        <?= Loc::getMessage("SALE_TOTAL") ?>
                                        <span class="price cool" id="allSum_FORMATED"> <?= $arResult['allSum_FORMATED'] ?>  </span>
                                    </b>
                                <? else: ?>
                                    <b style="font-size:22px;">
                                        <?= Loc::getMessage("SALE_TOTAL") ?>
                                        <span class="price cool" id="allSum_FORMATED"> <?= $arResult['allSum_FORMATED'] ?>  </span>
                                    </b>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <br>
                        <div class="col col-xs-12 col-md-6" id="coupons_block" style="padding-bottom: 10px">
                            <? //if (/*$arResult['COUPON_LIST']*/ false): ?>
                            <p class="visible-xs visible-sm"></p>
                            <div class="input-group">
                                <input class="form-control" type="text" id="coupon" name="COUPON" value="" placeholder="<?= Loc::getMessage('STB_COUPON_PROMT') ?>">
                                <span class="input-group-btn">
                                    <input type = "button" onclick="enterCoupon();" class = "btn btn-primary" value = "<?= Loc::getMessage('CHECK_COUPON') ?>">
                                </span>
                            </div>
                            <p class="visible-xs visible-sm"></p>
                            <? //endif; ?>
                            <?
                            //print_r($arResult);
                            if ($arResult['COUPON_LIST']):
                                ?>
                                <? foreach ($arResult['COUPON_LIST'] as $i => $oneCoupon): ?>
                                    <? $couponClass = 'disabled'; ?>
                                    <?
                                    switch ($oneCoupon['STATUS']) {
                                        case DiscountCouponsManager::STATUS_NOT_FOUND:
                                        case DiscountCouponsManager::STATUS_FREEZE:
                                            $couponClass = 'bad has-error';
                                            break;
                                        case DiscountCouponsManager::STATUS_APPLYED:
                                            $couponClass = 'good has-success';
                                            break;
                                    }
                                    ?>
                                    <div class="<?= $couponClass ?> has-feedback" name="coup">
                                        <label class="control-label" for="coupon_<?= $i ?>"><?= Loc::getMessage('COUPON') ?></label>
                                        <input class="form-control" disabled readonly type="text" name="OLD_COUPON[]" id="coupon_<?= $i ?>"  value="<?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>">
                                        <span class="fa glyphicon-remove form-control-feedback"></span>
                                        <div class="help-block">
                                            <? if (isset($oneCoupon['CHECK_CODE_TEXT'])): ?>
                                                <span class="note"><? echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']); ?>&nbsp;</span>
                                            <? endif; ?>
                                            <span class="aprimary <?= $couponClass ?>" data-coupon="<?= htmlspecialcharsbx($oneCoupon['COUPON']) ?>" style="cursor:pointer;"><?= Loc::getMessage('SALE_DELETE') ?></span>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                                <? unset($couponClass, $oneCoupon); ?>
                            <? endif ?>
                        </div>
                        <div class = "col col-xs-12 col-md-12">
                            <div class = "text-right">
                                <div class = "buttons">
                                    <div class="col-xs-12 col-sm-2 col-md-2">
                                        <a onClick="SendAnalyticsGoal('to-return');" href="/catalog/" class="btn btn-default">Вернуться к покупкам</a>
                                        <!--
    <a href = "<? //=SITE_DIR                               ?>forms/buy1click/"
       class = "btn btn-default buy1click_basket fancyajax fancybox.ajax"
       title = "<? //=Loc::getMessage('BUY1CLICK')                               ?>"
                                           onClick="SendAnalyticsGoal('buy-1');"
    >
                                        <?= Loc::getMessage('BUY1CLICK') ?>
    </a> -->
                                    </div>
                                    <div class="col-xs-12 col-sm-10 col-md-10">

                                        <input class="btn-order btn btn-primary" type="button" value="<?= Loc::getMessage('SALE_ORDER') ?>" onclick="showPopupOformlenie();">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col col-md-12">
            <div class="basket-information" style="word-wrap: break-word;">
                <?
                $APPLICATION->IncludeComponent(
                        "bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => "standard.php",
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH" => "/include/cart_text.php"
                        ), false
                );
                ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">





        function SetContact(profileId)
        {
            BX("profile_change").value = "Y";
            submitForm();
        }

        function changePaySystem(param)
        {
            if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
            {
                if (param == 'account')
                {
                    if (BX("PAY_CURRENT_ACCOUNT"))
                    {
                        BX("PAY_CURRENT_ACCOUNT").checked = true;
                        BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                        BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

                        // deselect all other
                        var el = document.getElementsByName("PAY_SYSTEM_ID");
                        for (var i = 0; i < el.length; i++)
                            el[i].checked = false;
                    }
                } else
                {
                    BX("PAY_CURRENT_ACCOUNT").checked = false;
                    BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                    BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                }
            } else if (BX("account_only") && BX("account_only").value == 'N')
            {
                if (param == 'account')
                {
                    if (BX("PAY_CURRENT_ACCOUNT"))
                    {
                        BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

                        if (BX("PAY_CURRENT_ACCOUNT").checked)
                        {
                            BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                        } else
                        {
                            BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                        }
                    }
                }
            }

            submitForm();
        }
    </script>

<? endif; ?>
<style>
    .panel-basket .buttons a, .panel-basket .buttons input{width:175px; margin-bottom:3px;}
</style>