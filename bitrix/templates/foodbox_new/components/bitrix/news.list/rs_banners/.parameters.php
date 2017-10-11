<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Loader;
    
if(
    !Loader::includeModule('iblock') ||
    !Loader::includeModule('redsign.devfunc')
) {
    return;
}

Loc::loadMessages(__FILE__);


$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCurrentValues['IBLOCK_ID']);

$arIBlockTypes = array(); 
$dbIBlockType = CIBlockType::GetList(
   array("sort" => "asc"),
   array("ACTIVE" => "Y")
);
while ($arIBlockType = $dbIBlockType->Fetch()) {
    $arIBlockLangName = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID);
    if($arIBlockLangName) {
        $arIBlockTypes[$arIBlockType["ID"]] = "[".$arIBlockType["ID"]."] ".$arIBlockTypeLang["NAME"];
    }
}



$bannerTypes = array(
    "wide" => Loc::getMessage("RS_BANNER_TYPE__WIDE"),
    "center" => Loc::getMessage("RS_BANNER_TYPE__CENTER")
);

$arSidebannerTypes = array(
    "none" => Loc::getMessage("RS_SIDEBANNERS__NONE"),
    "left" => Loc::getMessage("RS_SIDEBANNERS__LEFT"),
    "right" => Loc::getMessage("RS_SIDEBANNERS__RIGHT"),
    "both" => Loc::getMessage("RS_SIDEBANNERS__BOTH")
);

$arTemplateParameters = array(

    "RS_BANNER_HEIGHT" => array(
        "NAME" => Loc::getMessage("RS_BANNER_HEIGHT"),
        "TYPE" => "STRING",
        "DEFUALT" => "400px"
    ),
    
    "RS_BANNER_TYPE" => array(
        "NAME" => Loc::getMessage("RS_BANNER_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $bannerTypes,
        "DEFUALT" => "wide"
    ),
    
    "RS_BANNER_IS_AUTOPLAY" => array(
        "NAME" => Loc::getMessage("RS_BANNER_IS_AUTOPLAY"),
        "TYPE" => "CHECKBOX",
        "DEFUALT" => "Y",
        "REFRESH" => "Y"
    ),
    
    "RS_LINK_PROPERTY" => array(
        "NAME" => Loc::getMessage("RS_LINK_PROPERTY"),
        "TYPE" => "LIST",
        "VALUES" => $listProp['SNL'],
        "DEFUALT" => "LINK"
    ),
    
);

if(
    !empty($arCurrentValues['RS_BANNER_IS_AUTOPLAY']) &&
    $arCurrentValues['RS_BANNER_IS_AUTOPLAY'] == "Y"
) {
    
    $arTemplateParameters['RS_BANNER_AUTOPLAY_SPEED'] = array(
        "NAME" => Loc::getMessage("RS_BANNER_AUTOPLAY_SPEED"),
        "TYPE" => "STRING",
        "DEFUALT" => "2000"
    );
    
    $arTemplateParameters['RS_BANNER_AUTOPLAY_TIMEOUT'] = array(
        "NAME" => Loc::getMessage("RS_BANNER_AUTOPLAY_TIMEOUT"),
        "TYPE" => "STRING",
        "DEFUALT" => "7000"
    );
}
