<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?><a class="basketinhead" href="<?=$arParams['PATH_TO_BASKET']?>"><?
    ?><div class="aprimary hidden-xs"><?=GetMessage('RS.MONOPOLY.SMALLBASKET_TITLE')?></div><?
    ?><div id="basketinfo" class="descr"><?
        $frame = $this->createFrame('basketinfo',false)->begin();
        if($arResult['NUM_PRODUCTS']>0) {
            ?><div><?=$arResult["NUM_PRODUCTS"]?><span class="hidden-xs"> <?=GetMessage('RS.MONOPOLY.SMALLBASKET_TOVAR')?><?=$arResult['RIGHT_WORD']?> <?=GetMessage('RS.MONOPOLY.SMALLBASKET_NA')?></span></div><div class="hidden-xs"><?=$arResult['PRINT_FULL_PRICE']?></div><?
        } else {
            echo GetMessage('RS.MONOPOLY.SMALLBASKET_PUSTO');
        }
        $frame->beginStub();
        echo GetMessage('RS.MONOPOLY.SMALLBASKET_PUSTO');
        $frame->end();
    ?></div><?
?></a><?