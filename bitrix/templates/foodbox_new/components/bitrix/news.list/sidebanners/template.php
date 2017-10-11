<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
?>
<div class="sidebanners">
    <?php foreach($arResult['ITEMS'] as $arItem): ?>    
        <div class="sidebanner">
            <a href="<?=$arItem["DISPLAY_PROPERTIES"]["HREF"]["DISPLAY_VALUE"]?>">
                 <h4><?=$arItem["DISPLAY_PROPERTIES"]["TITLE"]["DISPLAY_VALUE"]?></h4>
                <p>
                    <?=$arItem["DISPLAY_PROPERTIES"]["TEXT"]["DISPLAY_VALUE"]?>
                </p>
            </a>           
        </div>
    <?php endforeach; ?>
</div>