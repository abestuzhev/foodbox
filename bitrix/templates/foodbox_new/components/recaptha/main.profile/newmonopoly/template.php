<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();



//echo "<pre>"; echo print_r($arResult['arUser']); echo "</pre>";

?>





<div class="profile">
	<div class="row">
		<div class="col col-sm-7 col-md-7">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Личная информация</div>
				<form class="c-form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<div class="c-form_item">
						<label for="profile_name">Ф.И.О:</label>
						<input type="text" id="profile_name" name="PFIO" placeholder="Иванов Иван Иванович" 

							value="<?=trim($arResult['arUser']['LAST_NAME']." ".$arResult['arUser']['NAME'])?>">
					</div>
					<div class="row">
						<div class="col col-md-8">
							<label for="possible-answer-4">Ваш пол:</label>
							<div class="c-form_item c-form_item--inline">
								<input type="radio" name="profile_gender" name="PERSONAL_GENDER" id="profile_gender-man" 
								<?if($arResult['arUser']['PERSONAL_GENDER']=="Мужской"):?> checked=""<?endif?>>
								<label for="profile_gender-man">Мужской</label>
							</div>
							<div class="c-form_item c-form_item--inline">
								<input type="radio" name="profile_gender" name="PERSONAL_GENDER" id="profile_gender-woman"
								<?if($arResult['arUser']['PERSONAL_GENDER']=="Женский"):?> checked=""<?endif?>>
								<label for="profile_gender-woman">Женский</label>
							</div>
						</div>
						<div class="col col-md-4">
							<div class="c-form_item">
								<label for="profile_date">Дата рождения:</label>
								<input type="text" id="profile_date" name="PERSONAL_BIRTHDAY" value="<?=$arResult['arUser']['PERSONAL_BIRTHDATE']?>" class="js-profile_date" placeholder="__.__._____">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".avatar-upload_title").on('click',function(){
		$('.typefile').click();
	});
});
</script>
		<div class="col col-sm-5 col-md-5">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Аватарка</div>
				<label>Будет видна в отзывах к товарам</label>
				<div class="avatar-upload">
				
					
					<div class="avatar-upload_title" id="loadphoto">загрузить</div>
				<div class="avatar-upload__shell">
				<div class="avatar-upload__wrapper avatar-upload--complete">
				<div class="avatar-upload__image-wrapper">
				<?if($arResult['arUser']['PERSONAL_PHONE']==""):?>
				<img src="<?=SITE_TEMPLATE_PATH?>/images/avatar-default.jpg">
				<?else:?>
				<img src="<?=$arResult['arUser']['PERSONAL_PHONE']?>">
				<?endif;?>
				</div>
				<img src="https://abestuzhev.github.io/foodbox/bitrix/templates/mshop_default/images/avatar-default.jpg" class="avatar-upload__faded-image">
				<div class="avatar-upload__progress-wrapper">
				<span>0%</span></div>
				<div style="display: none;">
					<?=$arResult['arUser']['PERSONAL_PHOTO_INPUT']?>
				</div>
				
				</div></div></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-sm-7 col-md-7">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Контактная информация</div>
				<form class="c-form" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<div class="c-form_item">
						<label for="profile_phone">Телефон:</label>
						<div class="input-group">
							<input type="text" id="profile_phone" name="PERSONAL_PHONE" placeholder="Тел: +7(___)___-__-__" class="phone-mask">
							<div class="input-group-btn"><button class="c-form_button">Получить код</button></div>
						</div>
					</div>
					<div class="c-form_item">
						<label for="profile_code">Полученный код активации: <span class="c-form_note-example">Пример: 65609</span>
							<a href="#" class="c-form_link">Не пришло СМС-сообщение?</a></label>
						<div class="input-group">
							<input type="password" id="profile_code" placeholder="Введите код">
							<div class="input-group-btn"><button class="c-form_button bg-grey">Подтвердить</button></div>
						</div>
					</div>
					<div class="c-form_item">
						<label for="profile_newPass">Дополнительный номер:</label>
						<div class="l-form_button"><button class="c-form_button">Добавить</button></div>
					</div>
					<div class="c-form_item">
						<label for="profile_email">Электронная почта:</label>
						<div class="input-group">
							<input type="password" id="profile_email" name="EMAIL" placeholder="yourname@example.com">
							<div class="input-group-btn"><button class="c-form_button">Подтвердить</button></div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col col-sm-5 col-md-5">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Изменение пароля</div>
				<form class="c-form" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<div class="c-form_item">
						<label for="profile_oldPass">Старый пароль</label>
						<input type="password" name="OLD_PASSWORD" id="profile_oldPass">
					</div>
					<div class="c-form_item">
						<label for="profile_newPass">Новый пароль:</label>
						<input type="password" name="NEW_PASSWORD" id="profile_newPass">
					</div>
					<div class="c-form_item">
						<label for="profile_newPass-confirmation">Новый пароль еще раз:</label>
						<input type="password" name="NEW_PASSWORD_CONFIRM" id="profile_newPass-confirmation">
						<div class="c-popup_note">Придумайте сложный пароль, который нельзя подобрать: от 6 до 20 символов -
							цифры, английские буквы и спецсимволы.</div>
					</div>
					<div class="l-form_button btn-right"><button class="c-form_button">Изменить</button></div>
				</form>
			</div>
		</div>
	</div>
</div><!--END profile-->





<?/*

?><div class="bx-auth-profile"><?

	if($arResult['strProfileError']!='') {
		?><div class="alert alert-danger" role="alert"><?=$arResult['strProfileError']?></div><?
	}

	if ($arResult['DATA_SAVED'] == 'Y')
		ShowNote(GetMessage('PROFILE_DATA_SAVED'));

	?><script type="text/javascript">
		<!--
		var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
//-->
var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
	</script><?

	?><form class="form-horizontal" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data"><?
		echo $arResult["BX_SESSION_CHECK"];
		?><input type="hidden" name="lang" value="<?=LANG?>" /><?
		?><input type="hidden" name="ID" value=<?=$arResult["ID"]?> /><?

		?><div class="form-group"><?
			?><label for="TITLE" class="col-sm-3 control-label text-nowrap"><?=GetMessage("main_profile_title")?></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="TITLE" id="TITLE" value="<?=$arResult["arUser"]["TITLE"]?>" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="NAME" class="col-sm-3 control-label text-nowrap"><?=GetMessage("NAME")?></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="NAME" id="NAME" value="<?=$arResult["arUser"]["NAME"]?>" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="LAST_NAME" class="col-sm-3 control-label text-nowrap"><?=GetMessage("LAST_NAME")?></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="LAST_NAME" id="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="SECOND_NAME" class="col-sm-3 control-label text-nowrap"><?=GetMessage("SECOND_NAME")?></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="SECOND_NAME" id="SECOND_NAME" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="EMAIL" class="col-sm-3 control-label text-nowrap"><?=GetMessage("EMAIL")?> <span class="starrequired">*</span></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="EMAIL" id="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>" /><?
			?></div><?
		?></div><?

		?><div class="form-group"><?
			?><label for="LOGIN" class="col-sm-3 control-label text-nowrap"><?=GetMessage("LOGIN")?> <span class="starrequired">*</span></label><?
			?><div class="col-sm-9"><?
				?><input class="form-control" type="text" name="LOGIN" id="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" /><?
			?></div><?
		?></div><?

		if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''){
			?><div class="form-group"><?
				?><label for="NEW_PASSWORD" class="col-sm-3 control-label text-nowrap"><?=GetMessage("NEW_PASSWORD_REQ")?> <span class="starrequired">*</span></label><?
				?><div class="col-sm-9"><?
					?><input class="form-control" type="password" name="NEW_PASSWORD" id="NEW_PASSWORD" value="" /><?
				?></div><?
			?></div><?

			?><div class="form-group"><?
				?><label for="NEW_PASSWORD_CONFIRM" class="col-sm-3 control-label"><?=GetMessage("NEW_PASSWORD_CONFIRM")?> <span class="starrequired">*</span></label><?
				?><div class="col-sm-9"><?
					?><input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" id="NEW_PASSWORD_CONFIRM" value="" /><?
				?></div><?
			?></div><?
		}

		?><div class="form-group"><?
			?><div class="col-sm-offset-3 col-sm-9"><?
				?><input class="btn btn-primary" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">&nbsp;&nbsp; <?
				?><input class="btn btn-default" type="reset" value="<?=GetMessage('MAIN_RESET');?>"><?
			?></div><?
		?></div><?
	?></form><?

?></div><?