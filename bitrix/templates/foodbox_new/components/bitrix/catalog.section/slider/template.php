<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;


include $_SERVER["DOCUMENT_ROOT"].$templateFolder.'/functions.php';


if(!is_array($arResult['ITEMS']) && count($arResult['ITEMS']) < 1) {
    return;
}

?>
  
    
<?php include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/templates_ext/catalog.section/mshop/showcase_slider.php'); ?>
      


