<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/functions.php';

$isNormal = count($arResult["ITEMS"]["AnDelCanBuy"]) > 0 ? true : false;
$isDelay = count($arResult["ITEMS"]["DelDelCanBuy"]) > 0 ? true : false;
$isSubscribe = count($arResult["ITEMS"]["ProdSubscribe"]) > 0 ? true : false;
$isUnavail = count($arResult["ITEMS"]["nAnCanBuy"]) > 0 ? true : false;
$isItems = count($arResult['GRID']['ROWS']) > 0 ? true : false;

$curPage = $APPLICATION->GetCurPage() . '?' . $arParams["ACTION_VARIABLE"] . '=';
$arUrls = array(
    "delete" => $curPage . "delete&id=#ID#",
    "delay" => $curPage . "delay&id=#ID#",
    "add" => $curPage . "add&id=#ID#",
);
?>

<div id="warning_message">
    <?
    if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"])) {
        foreach ($arResult["WARNING_MESSAGE"] as $v)
            ShowError($v);
    }
    ?>
</div>

<div class = "row">


</div>
<form
    method="post" 
    action="<?= POST_FORM_ACTION_URI ?>"
    class = "form-horizontal"
    name="basket_form" 
    id="basket_form"
    >
    <div class = "row p_basket">
        <div class = "col col-md-12">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="normal">
                    <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/basket_items.php'; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="delay">
                    <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/basket_items_delay.php'; ?>

                </div>
                <div role="tabpanel" class="tab-pane" id="subscribe">
                    <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/basket_items_subscribe.php'; ?>

                </div>
                <div role="tabpanel" class="tab-pane" id="unavail">
                    <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/basket_items_notavail.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <input class="hidden" type="submit" name="BasketRefresh">
    <?
    $arHeaders = array_map('identIdHeaderFromArray', $arResult["GRID"]["HEADERS"]);
    ?>
    <input type="hidden" id="column_headers" value="<?= CUtil::JSEscape(implode($arHeaders, ",")) ?>" />
    <input type="hidden" id="offers_props" value="<?= CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ",")) ?>" />
    <input type="hidden" id="action_var" value="<?= CUtil::JSEscape($arParams["ACTION_VARIABLE"]) ?>" />
    <input type="hidden" id="quantity_float" value="<?= $arParams["QUANTITY_FLOAT"] ?>" />
    <input type="hidden" id="count_discount_4_all_quantity" value="<?= ($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N" ?>" />
    <input type="hidden" id="price_vat_show_value" value="<?= ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N" ?>" />
    <input type="hidden" id="hide_coupon" value="<?= ($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N" ?>" />
    <input type="hidden" id="use_prepayment" value="<?= ($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N" ?>" />
</form>
<?
$MESS = array(
    'COUPON' => Loc::getMessage('COUPON'),
    'SALE_DELETE' => Loc::getMessage('SALE_DELETE')
);
$APPLICATION->AddHeadString('<script>BX.message(' . CUtil::PhpToJSObject($MESS, false) . ')</script>', true);
