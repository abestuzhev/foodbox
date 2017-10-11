<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?><p><?=$arResult["MESSAGE_TEXT"]?></p>
<?//here you can place your own messages
	switch($arResult["MESSAGE_CODE"])
	{
	case "E01":
		?><? //When user not found
		break;
	case "E02":
		?><? //User was successfully authorized after confirmation
		break;
	case "E03":
		?><? //User already confirm his registration
		break;
	case "E04":
		?><? //Missed confirmation code
		break;
	case "E05":
		?><? //Confirmation code provided does not match stored one
		break;
	case "E06":
		?><? //Confirmation was successfull
		break;
	case "E07":
		?><? //Some error occured during confirmation
		break;
	}

if($arResult['SHOW_FORM'])
{echo "<pre>"; echo print_r($arResult); echo "</pre>";
	?><form class="form-horizontal" method="post" action="<?=$arResult['FORM_ACTION']?>"><?

		?><input type="hidden" name="<?=$arParams["USER_ID"]?>" value="<?=$arResult['USER_ID']?>" /><?

		?><div class="form-group"><?
			?><label for="<?=$arParams['LOGIN']?>" class="col-sm-2 control-label"><?=GetMessage("CT_BSAC_LOGIN")?></label><?
			?><div class="col-sm-10"><?
				?><input type="text" name="<?=$arParams['LOGIN']?>" id="<?=$arParams['LOGIN']?>" maxlength="50" value="<?=(strlen($arResult['LOGIN']) > 0 ? $arResult['LOGIN']: $arResult['USER']['LOGIN'])?>" size="17" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="<?=$arParams['CONFIRM_CODE']?>" class="col-sm-2 control-label"><?=GetMessage("CT_BSAC_CONFIRM_CODE")?></label><?
			?><div class="col-sm-10"><?
				?><input type="text" name="<?=$arParams['CONFIRM_CODE']?>" id="<?=$arParams['CONFIRM_CODE']?>" maxlength="50" value="<?=$arResult['CONFIRM_CODE']?>" size="17" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><div class="col-sm-offset-2 col-sm-10"><?
				?><input class="btn btn-primary" type="submit" value="<?=GetMessage('CT_BSAC_CONFIRM')?>" /><?
			?></div><?
		?></div><?

	?></form><?

} elseif(!$USER->IsAuthorized()) {
	?><?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array());?><?
}