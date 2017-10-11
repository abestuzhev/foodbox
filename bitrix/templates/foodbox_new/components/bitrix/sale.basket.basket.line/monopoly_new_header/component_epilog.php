<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if( $arParams['JSON']=='Y') {
    global $JSON;
    $JSON = array(
        'TYPE' => 'OK',
        'HTMLBYID' => $templateData,
    );
}

if(is_array($arResult['CATEGORIES']['READY']) && count($arResult['CATEGORIES']['READY'])>0) {
    $arrIDs = array();
    foreach($arResult['CATEGORIES']['READY'] as $arItem) {
        $arrIDs[$arItem["PRODUCT_ID"]] = ( $arItem['CATALOG']['PARENT_ID'] > 0 ? $arItem['CATALOG']['PARENT_ID'] : 'Y' );
    }
    ?><script>RSMONOPOLY_INBASKET = <?=json_encode($arrIDs)?>;</script><?
}