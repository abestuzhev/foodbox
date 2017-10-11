<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
} 

use \Bitrix\Main\Loader;

if(!Loader::IncludeModule('iblock')) {
    return;
}
if(!Loader::IncludeModule('catalog')) {
    return;
}
if(!Loader::IncludeModule('redsign.mshop')) {
    return;
}
if(!Loader::IncludeModule('redsign.devfunc')) {
    return;
}

$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList(
    $arCurrentValues['IBLOCK_ID']
);
$arCatalog = CCatalog::GetByID($arCurrentValues['IBLOCK_ID']);

$arTemplateParameters = array(
    'RSMONOPOLY_PROP_MORE_PHOTO' => array(
        'NAME' => Loc::getMessage('RS.MONOPOLY.PROP_MORE_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp['F'],
    ),
    'RSMONOPOLY_PROP_ARTICLE' => array(
        'NAME' => Loc::getMessage('RS.MONOPOLY.PROP_ARTICLE'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp['SNL'],
    ),
    'RSMONOPOLY_USE_FAVORITE' => array(
        'NAME' => Loc::getMessage('RS.MONOPOLY.USE_FAVORITE'),
        'TYPE' => 'CHECKBOX',
        'VALUE' => 'Y',
        'DEFAULT' => 'Y',
    ),
);

if((int) $arCatalog["OFFERS_IBLOCK_ID"]) {
    $listProp2 = RSDevFuncParameters::GetTemplateParamsPropertiesList(
        $arCatalog['OFFERS_IBLOCK_ID']
    );
    $arTemplateParameters['RSMONOPOLY_PROP_SKU_MORE_PHOTO'] = array(
        'NAME' => Loc::getMessage('RS.MONOPOLY.PROP_SKU_MORE_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp2['F'],
    );
    $arTemplateParameters['RSMONOPOLY_PROP_SKU_ARTICLE'] = array(
        'NAME' => Loc::getMessage('RS.MONOPOLY.PROP_SKU_ARTICLE'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp2['SNL'],
    );
}