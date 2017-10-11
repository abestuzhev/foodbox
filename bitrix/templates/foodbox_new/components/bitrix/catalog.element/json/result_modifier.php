<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule('redsign.devfunc'))
	return;

$arResult['JSON_EXT'] = RSDevFuncOffersExtension::GetJSONElement(
	$arResult,
	$arParams['RSMONOPOLY_PROPS_ATTRIBUTES'],
	$arParams['PRICE_CODE'],
	array('SKU_MORE_PHOTO_CODE'=>$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO'],'SIZES'=>array('WIDTH'=>120,'HEIGHT'=>120),'SKU_ARTICLE_CODE' => $arParams['RSMONOPOLY_PROP_ARTICLE'])
);