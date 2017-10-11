<?php

use \Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
if(!is_array($arResult['ITEMS']) || count($arResult['ITEMS'])<1) {
	return;
}

$title = Loc::getMessage("RS.MONOPOLY.SPL_TITLE");
require_once $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/templates_ext/catalog.section/mini/template.php';