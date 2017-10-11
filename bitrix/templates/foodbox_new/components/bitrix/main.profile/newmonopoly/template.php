<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();



//echo "<pre>"; echo print_r($arResult['arUser']); echo "</pre>";
//echo $arResult['arUser']['PERSONAL_GENDER'];

?>
<div class="profile">
	<div class="row">
	<form class="c-form" method="post" name="formPer" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
	<?echo $arResult["BX_SESSION_CHECK"];
		?><input type="hidden" name="lang" value="<?=LANG?>" /><?
		?><input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value="<?=$arResult['arUser']['LOGIN']?>">
		<input type="hidden" name="EMAIL" value="<?=$arResult['arUser']['EMAIL']?>">
		<div class="col col-sm-7 col-md-7">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Личная информация</div>
				
					<div class="c-form_item">
						<label for="profile_name">Ф.И.О:</label>
						<input type="text" id="profile_name" name="PFIO" placeholder="Иванов Иван Иванович" 

							value="<?=trim($arResult['arUser']['LAST_NAME']." ".$arResult['arUser']['NAME']." ".$arResult['arUser']['SECOND_NAME'])?>">
					</div>
					<div class="row">
						<div class="col col-md-8">
							<label for="possible-answer-4">Ваш пол:</label>
							<div class="c-form_item c-form_item--inline">
								<input type="radio" name="PERSONAL_GENDER"  id="profile_gender-man" 
								<?if($arResult['arUser']['PERSONAL_GENDER'] == 'M'):?> checked=""<?endif?> value="M">
								<label for="profile_gender-man">Мужской</label>
							</div>
							<div class="c-form_item c-form_item--inline">
								<input type="radio" name="PERSONAL_GENDER"  id="profile_gender-woman"
								<?if($arResult['arUser']['PERSONAL_GENDER'] == 'F'):?> checked=""<?endif?> value="F">
								<label for="profile_gender-woman">Женский</label>
							</div>
						</div>
						<div class="col col-md-4">
							<div class="c-form_item">
								<label for="profile_date">Дата рождения:</label>
								<input type="text" id="profile_date" name="PERSONAL_BIRTHDAY" value="<?=$arResult['arUser']['PERSONAL_BIRTHDAY']?>" class="js-profile_date" placeholder="__.__._____">
							</div>
							<button class="c-form_button" id="butpersonal" type="button">Изменить</button>
						</div>
					</div>
				
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
				<?if($arResult['arUser']['PERSONAL_PHOTO']==""):?>
				<img src="<?=SITE_TEMPLATE_PATH?>/images/avatar-default.jpg">
				<?else:?>
				<?=$arResult['arUser']['PERSONAL_PHOTO_HTML']?>
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
		
		<input class="btn btn-primary" id="butpersonalsend" type="submit" name="save" value="Изменить" style="display: none;">
	</form>
	</div>

	<div class="row">
		<div class="col col-sm-7 col-md-7">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Контактная информация</div>
				<form class="c-form" method="post" name="formCont" action="#" enctype="multipart/form-data">
					<div class="c-form_item">
						<label for="profile_phone">Телефон:</label>
						<div class="input-group">
							<input type="text" id="profile_phone" name="PERSONAL_PHONE" placeholder="Тел: +7(___)___-__-__" class="phone-mask" 
							value="<?=$arResult['arUser']['PERSONAL_PHONE']?>">
							<div class="input-group-btn">
							<button class="c-form_button" id="butGetCode" type="button">Получить код</button>
							</div>
						</div>
					</div>
					<div class="c-form_item">
						<label for="profile_code">Полученный код активации: <span class="c-form_note-example">Пример: 65609</span>
							<a  class="c-form_link" id="linkGetCode" style="cursor: pointer;">Не пришло СМС-сообщение?</a></label>
						<div class="input-group">
							<input type="password" id="profile_code" placeholder="Введите код">
							<div class="input-group-btn">
							<button class="c-form_button bg-grey" id="setCode" type="button">Подтвердить</button>
							</div>
						</div>
					</div>
					<!--<div class="c-form_item">
						<label for="profile_newPass">Дополнительный номер:</label>
						<div class="l-form_button">
						<button class="c-form_button" id="addTel" type="button">Добавить</button>
						</div>
					</div>-->
					<div class="c-form_item">
						<label for="profile_email">Электронная почта:</label>
						<div class="input-group">
							<input type="text" id="profile_email" name="EMAIL" placeholder="yourname@example.com" value="<?=$arResult['arUser']['EMAIL']?>">
							<div class="input-group-btn">
							<button class="c-form_button" id="setEmail" type="button">Подтвердить</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col col-sm-5 col-md-5">
			<div class="c-card-profile">
				<div class="c-card-profile_title">Изменение пароля</div>
				<form class="c-form" name="formPass" id="fpass" method="post" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				<?
		echo $arResult["BX_SESSION_CHECK"];
		?><input type="hidden" name="lang" value="<?=LANG?>" /><?
		?><input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<input type="hidden" name="LOGIN" value="<?=$arResult['arUser']['LOGIN']?>">
				<input type="hidden" name="EMAIL" value="<?=$arResult['arUser']['EMAIL']?>">
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
					<div class="l-form_button btn-right">
					<button class="c-form_button" id="butpass" type="button">Изменить</button>
					<input class="btn btn-primary" id="butpasssend" type="submit" name="save" value="Изменить" style="display: none;">
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!--END profile-->


