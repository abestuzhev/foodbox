<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if(!CModule::IncludeModule('redsign.devfunc'))
	return;

// get no photo
$arResult['NO_PHOTO'] = RSDevFunc::GetNoPhoto(array('MAX_WIDTH' => 110, 'MAX_HEIGHT' => 110));
// /get no photo

CModule::IncludeModule('iblock');

if(empty($arResult['ERRORS']['FATAL']))
{

	$hasDiscount = false;
	$hasProps = false;
	$productSum = 0;
	$basketRefs = array();

	$noPict = array(
		'SRC' => $arResult['NO_PHOTO']['src']
	);

	if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'].$noPict['SRC']))
	{
		$noPictSize = getimagesize($nPictFile);
		$noPict['WIDTH'] = $noPictSize[0];
		$noPict['HEIGHT'] = $noPictSize[1];
	}

	foreach($arResult["BASKET"] as $k => &$prod)
	{
		if(floatval($prod['DISCOUNT_PRICE']))
			$hasDiscount = true;

		// move iblock props (if any) to basket props to have some kind of consistency
		if(isset($prod['IBLOCK_ID']))
		{
			$iblock = $prod['IBLOCK_ID'];
			if(isset($prod['PARENT']))
				$parentIblock = $prod['PARENT']['IBLOCK_ID'];

			foreach($arParams['CUSTOM_SELECT_PROPS'] as $prop)
			{
				$key = $prop.'_VALUE';
				if(isset($prod[$key]))
				{
					// in the different iblocks we can have different properties under the same code
					if(isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
						$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
					elseif(isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
						$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
					
					if(!empty($realProp))
						$prod['PROPS'][] = array(
							'NAME' => $realProp['NAME'], 
							'VALUE' => htmlspecialcharsEx($prod[$key])
						);
				}
			}
		}

		// if we have props, show "properties" column
		if(!empty($prod['PROPS']))
			$hasProps = true;

		$productSum += $prod['PRICE'] * $prod['QUANTITY'];

		$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];

		if(!isset($prod['PICTURE']))
			$prod['PICTURE'] = $noPict;
	}

	$arResult['HAS_DISCOUNT'] = $hasDiscount;
	$arResult['HAS_PROPS'] = $hasProps;

	$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

	if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
	{

		$pict = CFile::ResizeImageGet($img, array(
			'width' => 110,
			'height' => 110
		), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

		if(strlen($pict['src']))
			$pict = array_change_key_case($pict, CASE_UPPER);

		$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
	}

}


// Copy Link
$arResult['PATH_TO_COPY'] = str_replace('#ID#', $arResult['ID'], $arParams['PATH_TO_COPY']);

//Determine status color
// we dont trust input params, so validation is required
$legalColors = array(
	'green' => true,
	'yellow' => true,
	'red' => true,
	'gray' => true
);
// default colors in case parameters unset
$defaultColors = array(
	'N' => 'green',
	'P' => 'yellow',
	'F' => 'gray',
	'PSEUDO_CANCELLED' => 'red'
);

$orderStatusId = $arResult["STATUS"]["ID"];

$arResult["STATUS"]["COLOR"] = 
	$arParams['STATUS_COLOR_'.$orderStatusId] ? $arParams['STATUS_COLOR_'.$orderStatusId] :
		(isset($defaultColors[$orderStatusId]) ? $defaultColors[$orderStatusId] : 'gray');