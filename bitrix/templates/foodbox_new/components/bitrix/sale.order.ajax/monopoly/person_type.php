<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
?>
<div class = "col col-md-12">
	<?
	if(count($arResult["PERSON_TYPE"]) > 1)
	{
		?>
		<div class = "form-group">
			<label><?=Loc::getMessage('SOA_TEMPL_PERSON_TYPE')?></label><br>
			<? foreach ($arResult["PERSON_TYPE"] as $v):?>
				<label for="PERSON_TYPE_<?=$v["ID"]?>">
					<input type = "radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>" <?=$v['CHECKED'] == 'Y'?'checked':''?> onClick="submitForm()">
					<span class = "btn <?=$v['CHECKED'] == 'Y'?'btn-primary':'btn-default'?>">
						<?=$v["NAME"]?>
					</span>
				</label>
			<? endforeach; ?>
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>">
		</div>
		<?
	}
	else
	{
		if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
		{
			//for IE 8, problems with input hidden after ajax
			?>
			<span style="display:none;">
			<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
			<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
			</span>
			<?
		}
		else
		{
			foreach($arResult["PERSON_TYPE"] as $v)
			{
				?>
				<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
				<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
				<?
			}
		}
	}
	?>
</div>