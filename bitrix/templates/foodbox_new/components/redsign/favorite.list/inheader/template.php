<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?><a id="inheadfavorite" class="favoriteinhead" href="<?=SITE_DIR?>personal/favorite/"><?
    $frame = $this->createFrame('inheadfavorite',false)->begin();
    ?><span id="favorinfo" class="descr"><span class="js-favorinfo_count"><?=$arResult['COUNT']?></span></span><?
    $frame->beginStub();
    ?><span id="favorinfo" class="descr"><span class="js-favorinfo_count">0</span></span><?
    $frame->end();
?></a><?