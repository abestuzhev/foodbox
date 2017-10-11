<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>

<style>
   <?php if($arResult['IS_JS_HEIGHT_ADJUST'] != "Y"): ?>
       .rs-banners .rs-banners_banner,
       .rs-banners-sidebanner,
       .rs_banner-preloader {
           height: 40vw
       }
       @media(min-width: 768px) {           
           .rs-banners .rs-banners_banner,
           .rs-banners-sidebanner,
           .rs_banner-preloader {
               height: <?=$arResult['BANNER_HEIGHT']?>
           }
       }

   <?php endif; ?>
</style>

<div class="rs-banners-container js-mainbanners-container <?=$arResult['BANNER_CLASS']?>" 
    style="opacity: 0; transition: 1s; <?php if(!empty($arResult['MARGIN_TOP'])) echo 'margin-top: 7px;'?>">

    <div class="rs-banners js-banners owl-theme owl-carousel" style=" display: none;">
    
    <?php foreach($arResult['ITEMS'] as $arItem): ?>
    
        <?php
         $this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
        );
        $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), 
            array("CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
        );
        ?>
    
        <div class="rs-banners_banner">
			<div class="rs-banners_wrap">
				
				<div class="textPl">
					<div class="rs-banners_name"><?=$arItem['NAME']?></div>
					
					<?if ($arItem['PREVIEW_TEXT']) :?>
						<div class="rs-banners_text"><?=$arItem['PREVIEW_TEXT']?></div>
					<?endif;?>
					
					<div class="rs-banners_link">
						<?if(!empty($arItem['PRODUCT_LINK'])): ?>
							<a href="<?=$arItem['PRODUCT_LINK']?>">
						<?endif;?>
							<img src="<?=$templateFolder?>/images/img3.png" />
						<?if(!empty($arItem['PRODUCT_LINK'])): ?>
							</a>
						<?endif;?>
					</div>
				</div>
				<div class="imagePl" style="<?=($arItem['PREVIEW_PICTURE']) ? 'background-image: url(' . $arItem['PREVIEW_PICTURE']["SRC"] . ');' : ''?><?=($arResult['BANNER_HEIGHT']) ? 'height: ' . $arResult['BANNER_HEIGHT'] . ';' : ''?>>">
				<?if($arItem['PREVIEW_PICTURE']) :?>
					<?if(!empty($arItem['PRODUCT_LINK'])): ?>
						<a href="<?=$arItem['PRODUCT_LINK']?>"></a>
					<?endif;?>
				<?endif;?>
				</div>
					
			</div>
			
        </div>
    <?php endforeach; ?>
    </div>
    
    <div class="rs-banners_bottom-line"></div>
    
</div>
<div class="js-preloader rs_banner-preloader preloader" style="width: 100%;"></div>