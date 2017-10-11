<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?><div class="profil-list"><?

	if(strlen($arResult["ERROR_MESSAGE"])>0) {
		ShowError($arResult["ERROR_MESSAGE"]);
	}

	if(strlen($arResult["NAV_STRING"]) > 0) {
		?><p><?=$arResult["NAV_STRING"]?></p><?
	}

	if(is_array($arResult["PROFILES"]) && count($arResult["PROFILES"])>0){

		?><div class="table-responsive"><?
			?><table class="table table-striped"><?
				?><tbody><?
					foreach($arResult["PROFILES"] as $val){
						?><tr><?
						?><td width="100%"><?
							?><a class="aprimary name" title="<?= GetMessage("SALE_DETAIL_DESCR") ?>" href="<?=$val["URL_TO_DETAIL"]?>"><?= $val["NAME"] ?></a><br><?
							?><?=GetMessage('P_DATE_UPDATE')?>: <?=$val["DATE_UPDATE"]?><br><?
							?><?=GetMessage('P_PERSON_TYPE')?>: <?=$val["PERSON_TYPE"]["NAME"]?><br><?
						?></td><?
						?><td><a class="aprimary" title="<?= GetMessage("SALE_DETAIL_DESCR") ?>" href="<?=$val["URL_TO_DETAIL"]?>"><?= GetMessage("SALE_DETAIL") ?></a></td><?
						?><td><a class="aprimary" title="<?= GetMessage("SALE_DELETE_DESCR") ?>" href="javascript:if(confirm('<?= GetMessage("STPPL_DELETE_CONFIRM") ?>')) window.location='<?=$val["URL_TO_DETELE"]?>'"><?= GetMessage("SALE_DELETE")?></a></td><?
						?></tr><?
					}
				?></tbody><?
			?></table><?
		?></div><?

		if(strlen($arResult["NAV_STRING"]) > 0) {
			?><p><?= $arResult["NAV_STRING"] ?></p><?
		}

	} else {
		?><div class="alert alert-info" role="alert"><?=GetMessage('RS.MSHOP.EMPTY_PROFILES')?></div><?
	}

?></div><?