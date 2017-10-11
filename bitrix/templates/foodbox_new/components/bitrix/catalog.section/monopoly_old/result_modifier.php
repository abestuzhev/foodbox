<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('redsign.devfunc'))
	return;
if(!CModule::IncludeModule('redsign.mshop'))
	return;
if(!CModule::IncludeModule('redsign.favorite'))
	return;

$arResult['RS_IS_2_COL'] = 'N';

$arResult['TEMPLATE_DEFAULT'] = array(
	'TEMPLATE' => 'showcase',
	'CSS' => 'showcase',
);
if( $arParams['RSMONOPOLY_TEMPLATE']=='list' ) {
	$arResult['TEMPLATE_DEFAULT'] = array(
		'TEMPLATE' => 'list',
		'CSS' => 'list',
	);
} elseif( $arParams['RSMONOPOLY_TEMPLATE']=='list_little' ) {
	$arResult['TEMPLATE_DEFAULT'] = array(
		'TEMPLATE' => 'list',
		'CSS' => 'list little',
	);
}

if(!is_array($arResult['ITEMS']) || count($arResult['ITEMS'])<1)
	return;

$max_width_size = 300;
$max_height_size = 300;
$params = array(
	'PROP_MORE_PHOTO' => $arParams['RSMONOPOLY_PROP_MORE_PHOTO'],
	'PROP_SKU_MORE_PHOTO' => $arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO'],
	'MAX_WIDTH' => $max_width_size,
	'MAX_HEIGHT' => $max_height_size,
);



// get other data
RSDevFunc::GetDataForProductItem($arResult['ITEMS'], $params);
// /get other data
// QB and DA2
if( is_array($arResult['ITEMS']) && count($arResult['ITEMS'])>0 ) {
	foreach($arResult['ITEMS'] as $key1 => $arItem) {
		
		// quantity for bitrix:catalog.store.amount
		$arQuantity[$arItem['ID']] = $arItem['CATALOG_QUANTITY'];
		if(is_array($arItem['OFFERS']) && count($arItem['OFFERS'])>0) {
			foreach ($arItem['OFFERS'] as $key => $arOffer) {
				$arQuantity[$arOffer['ID']] = $arOffer['CATALOG_QUANTITY'];
			}
		}
		$arResult['ITEMS'][$key1]['DATA_QUANTITY'] = $arQuantity;
		// QB and DA2
		$arResult['ITEMS'][$key1]['HAVE_DA2'] = 'N';
		$arResult['ITEMS'][$key1]['HAVE_QB'] = 'N';
		$arResult['ITEMS'][$key1]['FULL_CATALOG_QUANTITY'] = ( IntVal($arItem['CATALOG_QUANTITY'])>0 ? $arItem['CATALOG_QUANTITY'] : 0 );
		if(is_array($arItem['OFFERS']) && count($arItem['OFFERS'])>0) {
			foreach($arItem['OFFERS'] as $arOffer) {
				if( isset($arOffer['DAYSARTICLE2']) ) {
					$arResult['ITEMS'][$key1]['HAVE_DA2'] = 'Y';
				}
				if( isset($arOffer['QUICKBUY']) ) {
					$arResult['ITEMS'][$key1]['HAVE_QB'] = 'Y';
				}
				$arResult['ITEMS'][$key1]['FULL_CATALOG_QUANTITY'] = $arResult['ITEMS'][$key1]['FULL_CATALOG_QUANTITY'] + $arOffer['CATALOG_QUANTITY'];
			}
		}
		if( isset($arItem['DAYSARTICLE2']) ) {
			$arResult['ITEMS'][$key1]['HAVE_DA2'] = 'Y';
		}
		if( isset($arItem['QUICKBUY']) ) {
			$arResult['ITEMS'][$key1]['HAVE_QB'] = 'Y';
		}
		// /QB and DA2

	}
}
// /QB and DA2

// get no photo
$arResult['NO_PHOTO'] = RSDevFunc::GetNoPhoto(array('MAX_WIDTH'=>$max_width_size,'MAX_HEIGHT'=>$max_height_size));
// /get no photo