<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(isset($arParams['~AUTH_RESULT']) && is_array($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']['TYPE']=='ERROR') {
	?><div class="alert alert-danger" role="alert"><?= $arParams['~AUTH_RESULT']['MESSAGE'] ?></div><?
} elseif (!is_array($arParams['~AUTH_RESULT']) && $arParams['~AUTH_RESULT']!='') {
	?><div class="alert alert-danger" role="alert"><?= $arParams['~AUTH_RESULT'] ?></div><?
} else {
	ShowMessage($arParams["~AUTH_RESULT"]);
}
if($arResult['ERROR_MESSAGE']!='') {
	?><div class="alert alert-danger" role="alert"><?=$arResult['ERROR_MESSAGE']?></div><?
} else {
	ShowMessage($arResult["ERROR_MESSAGE"]);
}


?><form class="form-horizontal" name="form_auth" method="post" target="_top" action="<?=$arResult['AUTH_URL']?>"><?

	?><input type="hidden" name="AUTH_FORM" value="Y" /><?
	?><input type="hidden" name="TYPE" value="AUTH" /><?
	if(strlen($arResult['BACKURL'])>0) {
		?><input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>" /><?
	}
	foreach($arResult['POST'] as $key => $value) {
		?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?
	}

	?><div class="form-group"><?
		?><label for="authFormLogin" class="col-sm-2 control-label"><?=GetMessage("AUTH_LOGIN")?></label><?
		?><div class="col-sm-10"><?
			?><input class="form-control" type="text" name="USER_LOGIN" id="authFormLogin" maxlength="255" value="<?=$arResult['LAST_LOGIN']?>" placeholder="" /><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><label for="authFormPassword" class="col-sm-2 control-label"><?=GetMessage("AUTH_PASSWORD")?></label><?
		?><div class="col-sm-10"><?
			?><input class="form-control" class="text" type="password" id="authFormPassword" name="USER_PASSWORD" maxlength="255" placeholder="" /><?
		?></div><?
	?></div><?

	if($arResult['SECURE_AUTH']) {
		?><div class="form-group"><?
			?><div class="col-sm-offset-2 col-sm-10"><?
				?><noscript><?
				ShowError( GetMessage('AUTH_NONSECURE_NOTE') );
				?></noscript><?
			?></div><?
		?></div><?
	}

	// CAPTCHA
	if($arResult['CAPTCHA_CODE']) {
		?><div class="form-group"><?
			?><div class="col-sm-offset-2 col-sm-10"><?
				?><input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" /><?
				?><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" /><?
				?><input class="form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?=GetMessage('AUTH_CAPTCHA_PROMT')?>" /><?
			?></div><?
		?></div><?
	}
	// /CAPTCHA

	if($arResult['STORE_PASSWORD']=='Y') {
		?><div class="form-group"><?
			?><div class="col-sm-offset-2 col-sm-10"><?
				?><div class="checkbox"><?
					?><input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/><label for="USER_REMEMBER">&nbsp;<?= GetMessage('AUTH_REMEMBER_ME') ?></label><?
				?></div><?
			?></div><?
		?></div><?
	}

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><input class="btn btn-primary" type="submit" name="Login" value="<?=GetMessage('AUTH_AUTHORIZE')?>" /><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><div class="col-sm-offset-2 col-sm-10"><?
			?><div><a class="aprimary" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage('AUTH_REGISTER')?></a></div><?
			?><div><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></div><?
		?></div><?
	?></div><?

?></form><?

?><script type="text/javascript">
<?if(strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script><?

if($arResult["AUTH_SERVICES"])
{
	?><?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
		array(
			"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
			"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
			"AUTH_URL" => $arResult["AUTH_URL"],
			"POST" => $arResult["POST"],
			"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
			"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
			"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
		),
		$component,
		array("HIDE_ICONS"=>"Y")
	);?><?
}