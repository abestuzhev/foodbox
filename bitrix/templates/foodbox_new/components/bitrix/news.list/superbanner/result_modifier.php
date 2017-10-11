<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

$imagesProperty = !empty($arParams['RS_SUPERBANNER_IMAGES_PROPERTY']) ?
                    $arParams['RS_SUPERBANNER_IMAGES_PROPERTY'] :
                    "IMAGES";    
$titleProperty = !empty($arParams['RS_SUPERBANNER_TITLE_PROPERTY']) ?
                    $arParams['RS_SUPERBANNER_TITLE_PROPERTY'] :
                    "TITLE";
$descProperty = !empty($arParams['RS_SUPERBANNER_DESC_PROPERTY']) ?
                    $arParams['RS_SUPERBANNER_DESC_PROPERTY'] :
                    "DESC";
$linkProperty = !empty($arParams['RS_SUPERBANNER_LINK_PROPERTY']) ?
                    $arParams['RS_SUPERBANNER_LINK_PROPERTY'] :
                    "LINK";

if(empty($arResult['ITEMS']) && !is_array($arResult['ITEMS'])) {
   return; 
}

$arItem = $arResult['ITEMS'][0];

$arResult['IMAGES'] = array();
foreach($arItem["PROPERTIES"][$imagesProperty]['VALUE'] as $imageId) {
    $arResult['IMAGES'][] = CFile::GetPath($imageId);
}

$arResult['TITLE'] = $arItem["DISPLAY_PROPERTIES"][$titleProperty]['DISPLAY_VALUE'];
$arResult['DESC'] = $arItem["DISPLAY_PROPERTIES"][$descProperty]['DISPLAY_VALUE'];
$arResult['LINK'] = $arItem["DISPLAY_PROPERTIES"][$linkProperty]['DISPLAY_VALUE'];
$arResult['BANNER_WIDTH'] = !empty($arParams['RS_SUPERBANNER_WIDTH']) ?
                                $arParams['RS_SUPERBANNER_WIDTH'] : 1140;
$arResult['BANNER_HEIGHT'] = !empty($arParams['RS_SUPERBANNER_WIDTH']) ?
                                $arParams['RS_SUPERBANNER_WIDTH'] : 440;