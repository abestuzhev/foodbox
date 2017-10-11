<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

if(!Loader::includeModule('redsign.mshop'))
    return;
if(!Loader::includeModule('redsign.devfunc'))
    return;


$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCurrentValues['IBLOCK_ID']);

Loc::loadMessages(__FILE__);

$arTemplateParameters = array(
    "RS_SUPERBANNER_HEIGHT" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_HEIGHT'),
        "TYPE" => "STRING"
    ),
    "RS_SUPERBANNER_WIDTH" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_WIDTH'),
        "TYPE" => "STRING"
    ),
    "RS_SUPERBANNER_IMAGES_PROPERTY" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_IMAGES_PROPERTY'),
        "TYPE" => 'LIST',
        "VALUES" => $listProp['F'],
    ),
    "RS_SUPERBANNER_TITLE_PROPERTY" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_TITLE_PROPERTY'),
        "TYPE" => 'LIST',
        "VALUES" => $listProp['SNL'],
    ),
    "RS_SUPERBANNER_LINK_PROPERTY" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_LINK_PROPERTY'),
        "TYPE" => 'LIST',
        "VALUES" => $listProp['SNL'],
    ),
    "RS_SUPERBANNER_DESC_PROPERTY" => array(
        "NAME" => Loc::getMessage('RS.SUPERBANNER_DESC_PROPERTY'),
        "TYPE" => 'LIST',
        "VALUES" => $listProp['F'],
    ),
);