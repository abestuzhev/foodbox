<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Loader;

if(!Loader::includeModule('iblock')) {
    return;
}

if(!Loader::includeModule('redsign.devfunc')) {
    return;
}

if(!Loader::includeModule('redsign.mshop')) {
    return;
}

$linkProperty = (!empty($arParams['RS_LINK_PROPERTY'])) ? $arParams['RS_LINK_PROPERTY'] : 'LINK';

$arResult['SLIDER_ADAPTER'] = 'owl';
$arResult['BANNER_HEIGHT'] = (!empty($arParams['RS_BANNER_HEIGHT'])) ? $arParams['RS_BANNER_HEIGHT'] : '400px';
$arResult['BANNER_TYPE'] = (!empty($arParams['RS_BANNER_TYPE'])) ? $arParams['RS_BANNER_TYPE'] : 'wide';
$arResult['IS_JS_HEIGHT_ADJUST'] = 'N';
$arResult['MARGIN_TOP'] = ($headType == 'type3') ? '7px' : null;

$arResult['BANNER_CLASS'] = $arResult['BANNER_TYPE']=='wide' ? '__wide' : '__center';
if(!empty($arParams['RS_SIDEBAR']) && $arParams['RS_SIDEBAR'] == 'Y') {
    $arResult['BANNER_CLASS'] = '';
}


$arResult['BANNER_OPTIONS'] = array(
    "autoplay" =>  ($arParams['RS_BANNER_IS_AUTOPLAY'] == 'N') ? false : true,
    "autoplay-speed" => (!empty($arParams['RS_BANNER_AUTOPLAY_SPEED'])) ? $arParams['RS_BANNER_AUTOPLAY_SPEED'] : 2000,
    "autoplay-timeout" => (!empty($arParams['RS_BANNER_AUTOPLAY_TIMEOUT'])) ? $arParams['RS_BANNER_AUTOPLAY_TIMEOUT'] : 7000,
    "height" => $arResult['BANNER_HEIGHT'],
    "is-auto-adjust-height" => $arResult['IS_JS_HEIGHT_ADJUST'] == 'Y' ? true : false
);

foreach($arResult['ITEMS'] as &$arItem) {

    $arItem['PRODUCT_LINK'] = $arItem['PROPERTIES'][$linkProperty]['VALUE'];
             
}
unset($arItem);