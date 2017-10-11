<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?><div class="locationbig"><?

	ShowMessage($arResult['ERROR_MESSAGE']);
	
	?><form id="locforma" class="forma" action="<?=$arResult["ACTION_URL"]?>" method="POST"><?
		
		echo bitrix_sessid_post();
		?><input type="hidden" name="<?=$arParams["REQUEST_PARAM_NAME"]?>" value="Y" /><?
		?><input type="hidden" name="PARAMS_HASH" value="<?=$arParams["PARAMS_HASH"]?>" /><?
		
		?><div class="title"><?=GetMessage("RSLOC_CHOOSE_FROM_LIST")?></div><?
		
		if(is_array($arResult["LOCATIONS"]) && count($arResult["LOCATIONS"])>0) {
			?><div class="items clearfix"><?
				?><div class="item"><?
					?><input type="radio" name="<?=$arParams["CITY_ID"]?>" value="<?=$arResult["LOCATION"]["ID"]?>" <?
						?>id="rsloc_<?=$arResult["LOCATION"]["ID"]?>" checked="checked" <?
						?>onclick="RSMSHOPSelectCity(this,'<?=$arParams["CITY_ID"]?>')" /><?
						?><label for="rsloc_<?=$arResult["LOCATION"]["ID"]?>"><?=$arResult["LOCATION"]["CITY_NAME"]?></label><?
				?></div><?
				foreach($arResult["LOCATIONS"] as $arLocation) {
					if($arResult["LOCATION"]["ID"]!=$arLocation["ID"]) {
						?><div class="item"><?
							?><input type="radio" name="<?=$arParams["CITY_ID"]?>" value="<?=$arLocation["ID"]?>" <?
								?>id="rsloc_<?=$arLocation["ID"]?>" <?
								?>onclick="RSMSHOPSelectCity(this,'<?=$arParams["CITY_ID"]?>')" /><?
								?><label for="rsloc_<?=$arLocation["ID"]?>"><?=$arLocation["CITY_NAME"]?></label><?
						?></div><?
					}
				}
			?></div><?
		}
		?><div class="ajaxlocation"><?
			?><div class="line"></div><?
			?><div class="title"><?=GetMessage('RSLOC_OR_ENTER')?></div><?
			?><div class="cominput"><?
				$value = $arResult['LOCATION']['ID'];
				CSaleLocation::proxySaleAjaxLocationsComponent(array(
					"AJAX_CALL" => "N",
					"COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
					"REGION_INPUT_NAME" => "REGION_tmp",
					"CITY_INPUT_NAME" => $arParams['CITY_ID'],
					"CITY_OUT_LOCATION" => "Y",
					"LOCATION_VALUE" => $value,
					"ORDER_PROPS_ID" => '',
					"ONCITYCHANGE" => '',
					"SIZE1" => '',
				),
					array(
						"ID" => $value,
						"CODE" => "",
						"SHOW_DEFAULT_LOCATIONS" => "Y",

						// function called on each location change caused by user or by program
						// it may be replaced with global component dispatch mechanism coming soon
						"JS_CALLBACK" => "submitFormProxy",

						// function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
						// it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
						"JS_CONTROL_DEFERRED_INIT" => '',

						// an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
						// it may be replaced with global component dispatch mechanism coming soon
						"JS_CONTROL_GLOBAL_ID" => '',

						"DISABLE_KEYBOARD_INPUT" => "Y",
						"PRECACHE_LAST_LEVEL" => "Y",
						"PRESELECT_TREE_TRUNK" => "Y",
						"SUPPRESS_ERRORS" => "Y"
					),
					'popup',
					true,
					'location-block-wrapper'
				);
			?></div><?
		?><br /><input class="clickforsubmit btn btn-primary" type="submit" name="submit" value="<?=GetMessage('RSLOC_BTN_YES')?>" /><?
	?></div><?
		
	?></form><?

?></div><?
?><script>
	$(document).ready(function(){
		setTimeout(function(){
			if( $('.fancybox-inner').find('.locationbig').length>0 )
			{
				$('.fancybox-inner').css({overflow:'visible'});
				$('.fancybox-inner').find('.locationbig').find('.forma').attr('action', window.location.href );
			}
		},50);
	});
</script>