<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

if(isset($arParams['~AUTH_RESULT']) && is_array($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE']=='ERROR') {
	?><div class="alert alert-danger" role="alert"><?=$arParams['~AUTH_RESULT']['MESSAGE']?></div><?
} else {
	ShowMessage($arParams["~AUTH_RESULT"]);
}

?><form class="form-horizontal" name="bform" method="post" target="_top" action="<?=$arResult['AUTH_URL']?>"><?

	if(strlen($arResult["BACKURL"])>0)
	{
		?><input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>" /><?
	}

	?><input type="hidden" name="AUTH_FORM" value="Y"><?
	?><input type="hidden" name="TYPE" value="SEND_PWD"><?

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><?=GetMessage('AUTH_FORGOT_PASSWORD_1')?><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><label for="USER_LOGIN" class="col-sm-2 control-label"><?=GetMessage('AUTH_LOGIN')?></label><?
		?><div class="col-sm-10"><?
			?><input class="form-control" type="text" name="USER_LOGIN" רג="USER_LOGIN" maxlength="50" value="<?=$arResult['LAST_LOGIN']?>" /><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><?=GetMessage('AUTH_OR')?><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><label for="USER_EMAIL" class="col-sm-2 control-label"><?=GetMessage('AUTH_EMAIL')?></label><?
		?><div class="col-sm-10"><?
			?><input class="form-control" type="text" name="USER_EMAIL" id="USER_EMAIL" maxlength="255" /><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><input class="btn btn-primary" type="submit" name="send_account_info" value="<?=GetMessage('AUTH_SEND')?>" /><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><div><a href="<?=$arResult['AUTH_AUTH_URL']?>"><?=GetMessage('AUTH_AUTH')?></a></div><?
		?></div><?
	?></div><?

?></form><?

?><script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>