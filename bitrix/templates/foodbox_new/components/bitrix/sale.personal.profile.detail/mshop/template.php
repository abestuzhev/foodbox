<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;

?><form class="form-horizontal" method="post" action="<?=POST_FORM_ACTION_URI?>"><?
	echo bitrix_sessid_post();
	?><input type="hidden" name="ID" value="<?=$arResult["ID"]?>"><?

	?><div class="form-group"><?
		?><label class="col-sm-3 control-label"> </label><?
		?><div class="col-sm-9"><?
			?><p class="form-control-static"><b><?=str_replace("#ID#", $arResult["ID"], GetMessage("SPPD_PROFILE_NO"))?></b></p><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><label for="TITLE" class="col-sm-3 control-label text-nowrap"><?=Loc::getMessage('SALE_PERS_TYPE')?>:</label><?
		?><div class="col-sm-9"><?
			?><p class="form-control-static"><?=$arResult["PERSON_TYPE"]["NAME"]?></p><?
		?></div><?
	?></div><?

	?><div class="form-group"><?
		?><label for="TITLE" class="col-sm-3 control-label text-nowrap"><?=Loc::getMessage('SALE_PNAME')?>:</label><?
		?><div class="col-sm-9"><?
			?><input class="form-control" type="text" name="NAME" value="<?=$arResult["NAME"]?>" size="40"><?
		?></div><?
	?></div><?

	foreach($arResult["ORDER_PROPS"] as $val){
		if(!empty($val["PROPS"])){

			?><hr><?
			?><div class="form-group"><?
				?><label class="col-sm-3 control-label"> </label><?
				?><div class="col-sm-9"><?
					?><p class="form-control-static"><b><?=$val["NAME"]?></b></p><?
				?></div><?
			?></div><?

			foreach($val["PROPS"] as $vval){
				$currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];
				$name = "ORDER_PROP_".$vval["ID"];

				?><div class="form-group"><?
					?><label for="TITLE" class="col-sm-3 control-label text-nowrap"><?
						?><?=$vval["NAME"]?><?
						if ($vval["REQUIED"]=="Y")
						{
							?><span class="req">*</span><?
						}
					?>:</label><?
					?><div class="col-sm-9"><?

						if ($vval["TYPE"]=="CHECKBOX") {
							?><input type="hidden" name="<?= $name ?>" value=""><?
							?><input type="checkbox" name="<?= $name ?>"
									 value="Y"<? if ($currentValue == "Y" || !isset($currentValue) && $vval["DEFAULT_VALUE"] == "Y") echo " checked"; ?>><?
						} elseif ($vval["TYPE"]=="TEXT") {
							?><input class="form-control" type="text"
									 size="<? echo (IntVal($vval["SIZE1"]) > 0) ? $vval["SIZE1"] : 30; ?>"
									 maxlength="250"
									 value="<? echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"]; ?>"
									 name="<?= $name ?>"><?
						} elseif ($vval["TYPE"]=="SELECT") {
							?><select class="form-control" name="<?= $name ?>"
									  size="<? echo (IntVal($vval["SIZE1"]) > 0) ? $vval["SIZE1"] : 1; ?>"><?
							foreach ($vval["VALUES"] as $vvval) {
								?><option value="<? echo $vvval["VALUE"] ?>"<? if ($vvval["VALUE"] == $currentValue || !isset($currentValue) && $vvval["VALUE"] == $vval["DEFAULT_VALUE"]) echo " selected" ?>><? echo $vvval["NAME"] ?></option><?
							}
							?></select><?
						} elseif ($vval["TYPE"]=="MULTISELECT") {
							?><select class="form-control" multiple name="<?= $name ?>[]"
									  size="<? echo (IntVal($vval["SIZE1"]) > 0) ? $vval["SIZE1"] : 5; ?>"><?
							$arCurVal = array();
							$arCurVal = explode(",", $currentValue);
							for ($i = 0, $cnt = count($arCurVal); $i < $cnt; $i++)
								$arCurVal[$i] = trim($arCurVal[$i]);
							$arDefVal = explode(",", $vval["DEFAULT_VALUE"]);
							for ($i = 0, $cnt = count($arDefVal); $i < $cnt; $i++)
								$arDefVal[$i] = trim($arDefVal[$i]);
							foreach ($vval["VALUES"] as $vvval) {
								?><option value="<? echo $vvval["VALUE"] ?>"<? if (in_array($vvval["VALUE"], $arCurVal) || !isset($currentValue) && in_array($vvval["VALUE"], $arDefVal)) echo " selected" ?>><? echo $vvval["NAME"] ?></option><?
							}
							?></select><?
						} elseif ($vval["TYPE"]=="TEXTAREA") {
							?><textarea class="form-control"
										rows="<? echo (IntVal($vval["SIZE2"]) > 0) ? $vval["SIZE2"] : 4; ?>"
										cols="<? echo (IntVal($vval["SIZE1"]) > 0) ? $vval["SIZE1"] : 40; ?>"
										name="<?= $name ?>"><? echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"]; ?></textarea><?
						} elseif ($vval["TYPE"]=="LOCATION") {
							if ($arParams['USE_AJAX_LOCATIONS'] == 'Y') {
								$locationValue = intval($currentValue) ? $currentValue : $vval["DEFAULT_VALUE"];
								?><? CSaleLocation::proxySaleAjaxLocationsComponent(
									array(
										"AJAX_CALL" => "N",
										'CITY_OUT_LOCATION' => 'Y',
										'COUNTRY_INPUT_NAME' => $name . '_COUNTRY',
										'CITY_INPUT_NAME' => $name,
										'LOCATION_VALUE' => $locationValue,
									),
									array(),
									$locationTemplate,
									true,
									'location-block-wrapper'
								) ?><?
							} else {
								?><select class="form-control" name="<?= $name ?>"
										  size="<? echo (IntVal($vval["SIZE1"]) > 0) ? $vval["SIZE1"] : 1; ?>"><?
								foreach ($vval["VALUES"] as $vvval) {
									?><option value="<? echo $vvval["ID"] ?>"<? if (IntVal($vvval["ID"]) == IntVal($currentValue) || !isset($currentValue) && IntVal($vvval["ID"]) == IntVal($vval["DEFAULT_VALUE"])) echo " selected" ?>><? echo $vvval["COUNTRY_NAME"] . " - " . $vvval["CITY_NAME"] ?></option><?
								}
								?></select><?
							}
						} elseif ($vval["TYPE"]=="RADIO") {
							foreach ($vval["VALUES"] as $vvval) {
								?><input type="radio"
										 name="<?= $name ?>" value="<? echo $vvval["VALUE"] ?>"<? if ($vvval["VALUE"] == $currentValue || !isset($currentValue) && $vvval["VALUE"] == $vval["DEFAULT_VALUE"]) echo " checked" ?>><? echo $vvval["NAME"] ?>
								<br/><?
							}
						}

						if (strlen($vval["DESCRIPTION"])>0) {
							?><br/><small><? echo $vval["DESCRIPTION"] ?></small><?
						}

					?></div><?
				?></div><?

			}

		}
	}

	?><div class="form-group"><?
		?><div class="col-sm-offset-3 col-sm-9"><?
			?><input class="btn btn-primary" type="submit" name="save" value="<?=Loc::getMessage("SALE_SAVE")?>"><?
			?>&nbsp;<?
			?><input class="btn btn-default" type="submit" name="apply" value="<?=Loc::getMessage("SALE_APPLY")?>"><?
			?>&nbsp;<?
			?><input class="btn btn-default" type="submit" name="reset" value="<?=Loc::getMessage("SALE_RESET")?>"><?
		?></div><?
	?></div><?

?></form><?

?><div class="row backshare mt"><?
	?><div class="col col-md-6"><?
		?><a class="detailback" href="<?=$arParams["PATH_TO_LIST"]?>"><i class="fa"></i><span><?=Loc::getMessage("RS.MSHOP.BACK")?></span></a><?
	?></div><?
?></div>