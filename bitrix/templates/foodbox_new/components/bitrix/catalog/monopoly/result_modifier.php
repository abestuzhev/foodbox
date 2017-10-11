<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!\Bitrix\Main\Loader::includeModule('redsign.mshop'))
	return;

$arParams['HEAD_TYPE'] = RSMshop::getSettings('headType', 'type1');
$arParams['FILTER_TYPE'] = RSMshop::getSettings('filterType', 'ftype1');

$arParams['USE_FILTER'] = ( $arParams['FILTER_TYPE']!='ftype0' ? 'Y' : 'N' );

// have sidebar?
$arResult['SIDEBAR'] = 'N';
if( $arParams["HEAD_TYPE"]=='type3' || $arParams['FILTER_TYPE']=='ftype1' ){
	$arResult['SIDEBAR'] = 'Y';
}
// /have sidebar?

$arResult['FAVORITE_URL'];

$res = CIBlockSection::GetList(array(), array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'], 
		'CODE' => $arResult["VARIABLES"]["SECTION_CODE"]
	)
);
$section = $res->Fetch();
$nav = CIBlockSection::GetNavChain(false, $section["ID"]);
$nav = $nav->GetNext();
$arResult['ROOT_SECTION_ID'] = $nav['ID'];

$arParams['TEMPLATE_AJAX_ID'] = 'js-ajaxcatalog';