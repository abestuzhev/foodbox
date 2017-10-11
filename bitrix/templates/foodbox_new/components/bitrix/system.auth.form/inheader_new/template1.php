<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?><div class="authinhead dropdown" id="authinhead"><?
	$frame = $this->createFrame('authinhead',false)->begin();
	$frame->setBrowserStorage(true);
		if($arResult["FORM_TYPE"]=="login"){
			?><a id="ddPersonalMenu" style="cursor: pointer;" class="js-reg">Регистрация</a><?
			?><a id="ddEntry" style="cursor: pointer;" class="js-entry">Вход</a><?
		} else {
			?><a class="dropdown-toggle" id="ddPersonalMenu" data-toggle="dropdown" href="<?=SITE_DIR?>personal/"><?=GetMessage('RS.MONOPOLY.PERSONAL_PAGE')?><i 
			class="fa hidden-xs"></i></a><?
			?><a class = "hidden-xs" href="?logout=yes"><?=GetMessage('RS.MONOPOLY.EXIT')?></a><?
            ?><ul class="dropdown-menu dropdown-menu-right list-unstyled" aria-labelledby="ddPersonalMenu"><?
                ?><li><a href="<?=SITE_DIR?>personal/"><?=GetMessage('RS.MONOPOLY.MENU_PERSONAL')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/profile/"><?=GetMessage('RS.MONOPOLY.MENU_PROFILE')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/cart/"><?=GetMessage('RS.MONOPOLY.MENU_BASKET')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/delivery/"><?=GetMessage('RS.MONOPOLY.MENU_DELIVERY_PROFIL')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/order/"><?=GetMessage('RS.MONOPOLY.MENU_ORDERS')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/favorite/"><?=GetMessage('RS.MONOPOLY.MENU_FAVORITE')?></a></li><?
                ?><li><a href="<?=SITE_DIR?>personal/viewed/"><?=GetMessage('RS.MONOPOLY.MENU_VIEWED')?></a></li><?
				?><li class = "visible-xs"><a href="?logout=yes"><?=GetMessage('RS.MONOPOLY.EXIT')?></a></li><?
            ?></ul><?
		}
	$frame->beginStub();
        ?><a href="<?=SITE_DIR?>auth/"><?=GetMessage('RS.MONOPOLY.PERSONAL_PAGE')?></a><?
	$frame->end();
?></div>
