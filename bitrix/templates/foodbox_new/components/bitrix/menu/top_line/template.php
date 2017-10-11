<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult)){
    ?><span class="top_line_menu_responsive dropdown visible-xs visible-sm"><?
        ?><a class="dropdown-toggle" id="ddTopLineMenu" data-toggle="dropdown" href="#"><i class="fa"></i><?=GetMessage('RS.MONOPOLY.MENU')?></a><?
        ?><ul class="dropdown-menu list-unstyled" aria-labelledby="ddTopLineMenu"><?
        foreach($arResult as $arItem){
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?><li><a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="selected"<?endif;?>><?=$arItem["TEXT"]?></a></li> <?
        }
        ?></ul><?
    ?></span><?
    ?><ul class="top_line_menu list-unstyled clearfix hidden-xs hidden-sm"><?
        foreach($arResult as $arItem){
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?><li><a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="selected"<?endif;?>><?=$arItem["TEXT"]?></a></li> <?
        }
    ?>
	</ul><?
}