<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?><span class="locationinfoot visible-xs dropdown"><?
	ShowMessage($arResult['ERROR_MESSAGE']);
	?><form action="<?=$arResult['ACTION_URL']?>" method="POST" id="locationinhead"><?
		$frame = $this->createFrame('locationinhead',false)->begin();
		$frame->setBrowserStorage(true);
        echo bitrix_sessid_post();
        ?><span class="dropdown"><?
            ?><input type="hidden" name="<?=$arParams['REQUEST_PARAM_NAME']?>" value="Y" /><?
            ?><input type="hidden" name="PARAMS_HASH" value="<?=$arParams['PARAMS_HASH']?>" /><?
            ?><input type="radio" name="<?=$arParams["CITY_ID"]?>" value="<?=$arResult["LOCATION"]["ID"]?>" <?
            ?>id="rsloc_<?=$arResult["LOCATION"]["ID"]?>" checked="checked" /><?
            ?><span><?=GetMessage('RS.MONOPOLY.YOUR_CITY')?>: </span><a class="dropdown-toggle" id="ddLocationMenu" data-toggle="dropdown" href="<?=SITE_DIR?>cities/"><span><?=$arResult['LOCATION']['CITY_NAME']?></span><i class="fa"></i></a><?
            if(is_array($arResult["LOCATIONS"]) && count($arResult["LOCATIONS"])>0) {
                ?><ul class="dropdown-menu list-unstyled" aria-labelledby="ddLocationMenu"><?
                    foreach($arResult["LOCATIONS"] as $arLocation){
                        ?><li><a href="#" onclick="document.getElementById('rsloc_<?= $arLocation["ID"] ?>').checked='checked'; document.getElementById('locationinhead').submit(); return false;"><?
                            ?><label for="rsloc_<?= $arLocation["ID"] ?>"><?= $arLocation["CITY_NAME"] ?></label><?
                            ?><input type="radio" name="<?= $arParams["CITY_ID"] ?>" value="<?= $arLocation["ID"] ?>" <?
                            ?>id="rsloc_<?= $arLocation["ID"] ?>" /><?
                        ?></a></li><?
                    }
                    ?><li><a href="<?=SITE_DIR?>cities/"><?=GetMessage('RS.MONOPOLY.ALL_CITIES')?></a></li><?
                ?></ul><?
            }
        ?></span><?
		$frame->beginStub();
        ?><span><?=GetMessage('RS.MONOPOLY.YOUR_CITY')?>: </span></a><?
		$frame->end();
	?></form><?
?></span>