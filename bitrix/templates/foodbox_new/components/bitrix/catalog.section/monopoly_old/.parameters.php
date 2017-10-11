<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('iblock'))
    return;
if(!CModule::IncludeModule('catalog'))
    return;
if(!CModule::IncludeModule('redsign.mshop'))
    return;
if(!CModule::IncludeModule('redsign.devfunc'))
    return;

$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCurrentValues['IBLOCK_ID']);
$arCatalog = CCatalog::GetByID($arCurrentValues['IBLOCK_ID']);

$arTemplateParameters = array(
    'RSMONOPOLY_PROP_MORE_PHOTO' => array(
        'NAME' => GetMessage('RS.MONOPOLY.PROP_MORE_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp['F'],
    ),
    'RSMONOPOLY_PROP_ARTICLE' => array(
        'NAME' => GetMessage('RS.MONOPOLY.PROP_ARTICLE'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp['SNL'],
    ),
    'RSMONOPOLY_USE_FAVORITE' => array(
        'NAME' => GetMessage('RS.MONOPOLY.USE_FAVORITE'),
        'TYPE' => 'CHECKBOX',
        'VALUE' => 'Y',
        'DEFAULT' => 'Y',
    ),
);

if(IntVal($arCatalog["OFFERS_IBLOCK_ID"])) {
    $listProp2 = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCatalog['OFFERS_IBLOCK_ID']);
    $arTemplateParameters['RSMONOPOLY_PROP_SKU_MORE_PHOTO'] = array(
        'NAME' => GetMessage('RS.MONOPOLY.PROP_SKU_MORE_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp2['F'],
    );
    $arTemplateParameters['RSMONOPOLY_PROP_SKU_ARTICLE'] = array(
        'NAME' => GetMessage('RS.MONOPOLY.PROP_SKU_ARTICLE'),
        'TYPE' => 'LIST',
        'VALUES' => $listProp2['SNL'],
    );
}