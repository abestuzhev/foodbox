<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
};

use \Bitrix\Main\Loader;

if (!Loader::IncludeModule('redsign.devfunc')) {
    return;
}
if (!Loader::IncludeModule('catalog')) {
    return;
}
if (!Loader::IncludeModule('sale')) {
    return;
}

$arResult = RSDevFuncResultModifier::SaleBasketBasketSmall($arResult);
$arResult["RIGHT_WORD"] = RSDevFunc::BasketEndWord($arResult["NUM_PRODUCTS"]);
$arResult['NO_PHOTO'] = RSDevFunc::GetNoPhoto(array('MAX_WIDTH' => 80, 'MAX_HEIGHT' => 75));

if (count($arResult['CATEGORIES']['READY']) > 0) {
    $arResult['CATEGORIES']['READY'] = getRatio($arResult['CATEGORIES']['READY']);
}

foreach ($arResult['CATEGORIES']['READY'] as $k => $item) {
    $res = CIBlockElement::GetByID($item['PRODUCT_ID'])->Fetch();
    $section = CIBlockSection::GetByID($res['IBLOCK_SECTION_ID'])->Fetch();

    $ratioRes = CNewRation::getNewRationInBasket($section['IBLOCK_ID'], $section['ID'], $section['DEPTH_LEVEL'], $item['QUANTITY']);

    $arResult['CATEGORIES']['READY'][$k]['RATIO_DATA'] = $ratioRes;
}