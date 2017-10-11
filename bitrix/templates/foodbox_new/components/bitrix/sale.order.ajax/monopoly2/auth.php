<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
<!--
function ChangeGenerate(val)
{
	if(val)
	{
		document.getElementById("sof_choose_login").style.display='none';
	}
	else
	{
		document.getElementById("sof_choose_login").style.display='block';
		document.getElementById("NEW_GENERATE_N").checked = true;
	}

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}
//-->
</script>
<div class="row">
	<div class="col col-sm-12 col-md-6">
		<form class="form-horizontal" method="post" action="" name="order_auth_form">
			<?=bitrix_sessid_post()?>
			<?
			foreach ($arResult["POST"] as $key => $value)
			{
			?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?
			}
			?>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
						<b><?echo GetMessage("STOF_2REG")?></b>
					<?endif;?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<?echo GetMessage("STOF_LOGIN_PROMT")?>
				</div>
			</div>
			<div class="form-group">
				<label for="USER_LOGIN" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_LOGIN")?> <span class="starrequired">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="USER_LOGIN" id="USER_LOGIN" value="<?=$arResult["AUTH"]["USER_LOGIN"]?>">
				</div>
			</div>
			<div class="form-group">
				<label for="USER_PASSWORD" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_PASSWORD")?> <span class="starrequired">*</span></label>
				<div class="col-sm-9">
					<input class="form-control" type="password" name="USER_PASSWORD" id="USER_PASSWORD" value="">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<a class="aprimary" href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($APPLICATION->GetCurPageParam()); ?>"><?echo GetMessage("STOF_FORGET_PASSWORD")?></a>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<input class="btn btn-primary" type="submit" value="<?echo GetMessage("STOF_NEXT_STEP")?>">
					<input type="hidden" name="do_authorize" value="Y">
				</div>
			</div>
		</form>
	</div>
	<div class="col col-sm-12 col-md-6">
		<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
			<form class="form-horizontal" method="post" action="" name="order_reg_form">
				<?=bitrix_sessid_post()?>
				<?
				foreach ($arResult["POST"] as $key => $value)
				{
				?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?
				}
				?>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
							<b><?echo GetMessage("STOF_2NEW")?></b>
						<?endif;?>
					</div>
				</div>
				<div class="form-group">
					<label for="NEW_NAME" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_NAME")?> <span class="starrequired">*</span></label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="NEW_NAME" id="NEW_NAME" value="<?=$arResult["AUTH"]["NEW_NAME"]?>">
					</div>
				</div>
				<div class="form-group">
					<label for="NEW_LAST_NAME" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_LASTNAME")?> <span class="starrequired">*</span></label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="NEW_LAST_NAME" id="NEW_LAST_NAME" value="<?=$arResult["AUTH"]["NEW_LAST_NAME"]?>">
					</div>
				</div>
				<div class="form-group">
					<label for="NEW_EMAIL" class="col-sm-3 control-label text-nowrap">E-Mail <span class="starrequired">*</span></label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="NEW_EMAIL" id="NEW_EMAIL" value="<?=$arResult["AUTH"]["NEW_EMAIL"]?>">
					</div>
				</div>
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					<div class="form-group"><?
						?><div class="col-sm-offset-3 col-sm-9"><?
							?><div class="radio"><?
								?><input type="radio" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N" OnClick="ChangeGenerate(false)"<?if ($_POST["NEW_GENERATE"] == "N") echo " checked";?>/><label for="NEW_GENERATE_N">&nbsp;<?= GetMessage('STOF_MY_PASSWORD') ?></label><?
							?></div><?
						?></div><?
					?></div>
				<?endif;?>
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					<div id="sof_choose_login">
						<div class="form-group">
							<label for="NEW_LOGIN" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_LOGIN")?> <span class="starrequired">*</span></label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="NEW_LOGIN" id="NEW_LOGIN" value="<?=$arResult["AUTH"]["NEW_LOGIN"]?>">
							</div>
						</div>
						<div class="form-group">
							<label for="NEW_PASSWORD" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_PASSWORD")?> <span class="starrequired">*</span></label>
							<div class="col-sm-9">
								<input class="form-control" type="password" name="NEW_PASSWORD" id="NEW_PASSWORD" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="NEW_PASSWORD_CONFIRM" class="col-sm-3 control-label text-nowrap"><?echo GetMessage("STOF_RE_PASSWORD")?> <span class="starrequired">*</span></label>
							<div class="col-sm-9">
								<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" id="NEW_PASSWORD_CONFIRM" value="">
							</div>
						</div>
					</div>
				<?endif;?>
				<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
					<div class="form-group"><?
						?><div class="col-sm-offset-3 col-sm-9"><?
							?><div class="radio"><?
								?><input type="radio" id="NEW_GENERATE_Y" name="NEW_GENERATE" value="Y" OnClick="ChangeGenerate(true)"<?if ($_POST["NEW_GENERATE"] != "N") echo " checked";?>/><label for="NEW_GENERATE_Y">&nbsp;<?= GetMessage('STOF_SYS_PASSWORD') ?></label><?
							?></div><?
						?></div><?
					?></div>
					<script 
						<!--
						ChangeGenerate(<?= (($_POST["NEW_GENERATE"] != "N") ? "true" : "false") ?>);
						//-->
					</script>
				<?endif;?>
				<?if($arResult["AUTH"]["captcha_registration"] == "Y"):?>
					<div class="form-group"><?
						?><div class="col-sm-offset-3 col-sm-9"><?
							?><input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" /><?
							?><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA"><?
							?><input class="form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?=GetMessage('CAPTCHA_REGF_PROMT')?>" /><?
						?></div><?
					?></div>
				<?endif;?>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<input class="btn btn-primary" type="submit" value="<?=GetMessage('STOF_NEXT_STEP')?>" />
						<input type="hidden" name="do_register" value="Y">
					</div>
				</div>


			</form>
		<?endif;?>

	</div>
</div>

<br /><br />
<?echo GetMessage("STOF_REQUIED_FIELDS_NOTE")?><br /><br />
<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
	<?echo GetMessage("STOF_EMAIL_NOTE")?><br /><br />
<?endif;?>
<?echo GetMessage("STOF_PRIVATE_NOTES")?>
