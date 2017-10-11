<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<div class="input-group calendar">
	<input type="text" class="form-control" id="<?=$arParams['INPUT_NAME']?>" name="<?=$arParams['INPUT_NAME']?>" value="<?=$arParams['INPUT_VALUE']?>">
	<span class="input-group-btn">
		<button 
			class="btn btn-primary calendar-icon" 
			type="button"
			onclick="BX.calendar({node:this, field:'<?= htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'])) ?>', form: '<?if ($arParams['FORM_NAME'] != '') {echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', bTime: true, currentTime: '<?= (time() + date("Z") + CTimeZone::GetOffset()) ?>', bHideTime: true});"
		>
		</button>
	</span>
</div>