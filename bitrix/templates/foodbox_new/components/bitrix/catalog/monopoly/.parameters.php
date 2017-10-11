<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

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
    'RSMONOPOLY_SHOW_DESC_IN_SECTION' => array(
		'NAME' => GetMessage('RS.MONOPOLY.SHOW_DESC_IN_SECTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	),
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
    'RSMONOPOLY_SHOW_CREDIT_BTN' => array(
        'NAME' => GetMessage('RS.MONOPOLY.SHOW_CREDIT_BTN'),
        'TYPE' => 'CHECKBOX',
        'VALUE' => 'Y',
        'DEFAULT' => 'Y',
        'REFRESH' => 'Y',
        'PARENT' => 'DETAIL_SETTINGS',
    ),
	'RSMONOPOLY_USE_FAVORITE' => array(
		'NAME' => GetMessage('RS.MONOPOLY.USE_FAVORITE'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y',
	),
	'PROPS_TABS' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('PROPS_TABS'),
		'TYPE' => 'LIST',
		'VALUES' => $listProp['ALL'],
		'MULTIPLE' => 'Y',
	),
	'RSMONOPOLY_SHOW_RECOMMENDED_PRODUCTS' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('SHOW_RECOMMENDED_PRODUCTS'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y'
	),
	'RSMONOPOLY_SHOW_VIEWED_PRODUCTS' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('SHOW_VIEWED_PRODUCTS'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y'
	),
	'RSMONOPOLY_SHOW_SETS' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('SHOW_SETS'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y'
	),
    'RSMONOPOLY_USE_CUSTOM_COLLECTION' => array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('RS.MONOPOLY.USE_CUSTOM_COLLECTION'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y'
	),
    'SORTER_USE_AJAX' => array(
		'NAME' => GetMessage('RS.MONOPOLY.SORTER_USE_AJAX'),
		'TYPE' => 'LIST',
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
	),
    
    // Filter
    'FILTER_USE_AJAX' => array(
		'PARENT' => 'FILTER_SETTINGS',
		'NAME' => GetMessage('RS.MONOPOLY.FILTER_USE_AJAX'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
	),
);
if( $arCurrentValues['RSMONOPOLY_SHOW_CREDIT_BTN']=='Y' ) {
    $arTemplateParameters['RSMONOPOLY_CREDIT_BTN_LINK'] = array(
        'NAME' => GetMessage('RS.MONOPOLY.CREDIT_BTN_LINK'),
        'TYPE' => 'STRING',
        'VALUE' => '',
        'PARENT' => 'DETAIL_SETTINGS',
    );
}

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
	$arTemplateParameters['RSMONOPOLY_PROPS_ATTRIBUTES'] = array(
		'NAME' => GetMessage('RS.MONOPOLY.PROPS_ATTRIBUTES'),
		'TYPE' => 'LIST',
		'VALUES' => $listProp2['SNL'],
		'MULTIPLE' => 'Y',
	);
	$arTemplateParameters['RSMONOPOLY_PROPS_ATTRIBUTES_COLOR'] = array(
		'NAME' => GetMessage('RS.MONOPOLY.PROPS_ATTRIBUTES_COLOR'),
		'TYPE' => 'LIST',
		'VALUES' => $listProp2['HL'],
		'MULTIPLE' => 'Y',
	);
}

if( \Bitrix\Main\Loader::includeModule("redsign.devcom") ) {
	$arTemplateParameters['RSMONOPOLY_SHOW_SORTER'] = array(
		'NAME' => GetMessage('RS.MONOPOLY.SHOW_SORTER'),
		'TYPE' => 'CHECKBOX',
		'VALUE' => 'Y',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y',
		'PARENT' => 'LIST_SETTINGS',
	);
	if( $arCurrentValues['RSMONOPOLY_SHOW_SORTER']=='Y' ) {
		$arTemplateParameters['RSMONOPOLY_SORTER_SHOW_TEMPLATE'] = array(
			'NAME' => GetMessage('RS.MONOPOLY.SORTER_SHOW_TEMPLATE'),
			'TYPE' => 'CHECKBOX',
			'VALUE' => 'Y',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y',
			'PARENT' => 'LIST_SETTINGS',
		);
		$arTemplateParameters['RSMONOPOLY_SORTER_SHOW_SORTING'] = array(
			'NAME' => GetMessage('RS.MONOPOLY.SORTER_SHOW_SORTING'),
			'TYPE' => 'CHECKBOX',
			'VALUE' => 'Y',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y',
			'PARENT' => 'LIST_SETTINGS',
		);
		$arTemplateParameters['RSMONOPOLY_SORTER_SHOW_PAGE_COUNT'] = array(
			'NAME' => GetMessage('RS.MONOPOLY.SORTER_SHOW_PAGE_COUNT'),
			'TYPE' => 'CHECKBOX',
			'VALUE' => 'Y',
			'DEFAULT' => 'Y',
			'REFRESH' => 'Y',
			'PARENT' => 'LIST_SETTINGS',
		);
		if( $arCurrentValues['RSMONOPOLY_SORTER_SHOW_TEMPLATE']=='Y' ) {
			$arTemplateParameters['RSMONOPOLY_SORTER_TEMPLATE_DEFAULT'] = array(
				'NAME' => GetMessage('RS.MONOPOLY.SORTER_TEMPLATE_DEFAULT'),
				'TYPE' => 'STRING',
				'VALUE' => '',
				'DEFAULT' => 'showcase',
				'PARENT' => 'LIST_SETTINGS',
			);
		}
	}
}

if(ModuleManager::isModuleInstalled("sale")) {
	$arTemplateParameters['USE_SALE_BESTSELLERS'] = array(
		'NAME' => GetMessage('RS.MONOPOLY.USE_SALE_BESTSELLERS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	);
	$arTemplateParameters['USE_BIG_DATA'] = array(
		'PARENT' => 'BIG_DATA_SETTINGS',
		'NAME' => GetMessage('RS.MONOPOLY.USE_BIG_DATA'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['USE_BIG_DATA']) || $arCurrentValues['USE_BIG_DATA'] == 'Y')
	{
		$rcmTypeList = array(
			'bestsell' => GetMessage('RS.MONOPOLY.RCM_BESTSELLERS'),
			'personal' => GetMessage('RS.MONOPOLY.RCM_PERSONAL'),
			'similar_sell' => GetMessage('RS.MONOPOLY.RCM_SOLD_WITH'),
			'similar_view' => GetMessage('RS.MONOPOLY.RCM_VIEWED_WITH'),
			'similar' => GetMessage('RS.MONOPOLY.RCM_SIMILAR'),
			'any_similar' => GetMessage('RS.MONOPOLY.RCM_SIMILAR_ANY'),
			'any_personal' => GetMessage('RS.MONOPOLY.RCM_PERSONAL_WBEST'),
			'any' => GetMessage('RS.MONOPOLY.RCM_RAND')
		);
		$arTemplateParameters['BIG_DATA_RCM_TYPE'] = array(
			'PARENT' => 'BIG_DATA_SETTINGS',
			'NAME' => GetMessage('RS.MONOPOLY.BIG_DATA_RCM_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $rcmTypeList
		);
		unset($rcmTypeList);
	}
}