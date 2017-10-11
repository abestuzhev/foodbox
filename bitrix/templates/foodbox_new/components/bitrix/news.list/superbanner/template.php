<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;
?>

<a 
    class="superbanner" href="<?=$arResult['LINK']?>">
    <div class="superbanner_text robotolight js-superbanner_text hidden-lg">
        <?php if(!empty($arResult['TITLE'])): ?>
            <div class="title">
                <p><span class="aprimary"><?=$arResult['TITLE']?></span></p>
            </div>
        <?php endif; ?>
        <?php if(!empty($arResult['DESC'])): ?>
            <div class="desc visible-lg">
                <p><span><?=$arResult['DESC']?></span></p>
            </div>
        <?php endif; ?>
    </div>
    <div class="superbanner_moved-area js-superbanner_moved-area">
    </div>
    <div 
        class="superbanner_banner js-superbanner visible-lg"
        data-width="<?=$arResult['BANNER_WIDTH']?>"
        data-height="<?=$arResult['BANNER_HEIGHT']?>"
    >
        <div 
            class="preloader" 
            style="width: <?=$arResult['BANNER_WIDTH']?>px; height: <?=$arResult['BANNER_HEIGHT']?>px;"
        ></div>
    </div>
    <div class="superbanner_banner js-superbanner_images" style="display:none;">
        <?php foreach($arResult['IMAGES'] as $imageUrl): ?>
            <img data-src="<?=$imageUrl;?>">
        <?php endforeach; ?>
    </div>
    <div class="superbanner_md js-superbanner_md hidden-lg">
        <img src="<?=$arResult['IMAGES'][0];?>" alt="<?=$arResult['TEXT']?>">
    </div>
</a>