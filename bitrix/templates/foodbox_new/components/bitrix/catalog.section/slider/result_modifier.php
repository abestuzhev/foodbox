<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Loader;

if(!Loader::IncludeModule('redsign.devfunc'))
	return;
if(!Loader::IncludeModule('redsign.mshop'))
	return;
if(!Loader::IncludeModule('iblock'))
	return;

include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/templates_ext/catalog.section/mshop/result_modifier.php');

$arResult['SECTIONS'] = array();
$arSectionIds = array();

foreach($arResult['ITEMS'] as &$arItem) {
    if(!is_array($arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']])) {
        $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']] = array();
        $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]['ITEMS'] = array();
    }
    
    $arResult['SECTIONS'][$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = &$arItem;
    $arSectionIds[] = $arItem['IBLOCK_SECTION_ID'];
    
}
unset($arItem);

$dbSections = CIBLockSection::GetTreeList(array(
    'ID' => $arSectionIds
));
while($arSection = $dbSections->GetNext()) {
    $arResult['SECTIONS'][$arSection['ID']]["NAME"] = $arSection['NAME'];
}