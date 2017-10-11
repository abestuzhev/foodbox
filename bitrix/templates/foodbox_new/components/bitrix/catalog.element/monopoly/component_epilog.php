<?php
use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
use \Bitrix\Main\Page\Asset;

CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());


if($arParams['RSMONOPOLY_USE_CUSTOM_COLLECTION']) {    
    $isCollectionProperty = "IS_COLLECTION";
    $collectionElementsProperty = "ELEMENTS_OF_COLLECTION";
    if($arResult['PROPERTIES'][$isCollectionProperty]['VALUE_XML_ID'] == "Y") {
        global $collectionFilter;
        $collectionFilter["ID"] = $arResult['PROPERTIES'][$collectionElementsProperty]['VALUE'];
    }
}
$asset = Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH.'/js/bootstrap/bootstrap-tabcollapse.js');