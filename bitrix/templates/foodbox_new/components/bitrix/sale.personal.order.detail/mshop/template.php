<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;

if(strlen($arResult["ERROR_MESSAGE"])) {
	echo ShowError($arResult["ERROR_MESSAGE"]);
	return;
}

$orderTitle = Loc::getMessage('SPOD_ORDER').' '.Loc::getMessage('SPOD_NUM_SIGN').$arResult["ACCOUNT_NUMBER"];
if(strlen($arResult["DATE_INSERT_FORMATED"])) {
	$orderTitle .= " ".Loc::getMessage('SPOD_FROM'). " ".$arResult["DATE_INSERT_FORMATED"];
}
$APPLICATION->setTitle($orderTitle);

?><div class="order-detail"><?

	// Basic Info
	?><div class="row"><?
		?><div class="col col-md-3"><?
			?><?=Loc::getMessage('SPOD_ORDER_STATUS')?><?
		?></div><?
		?><div class="col col-md-5"><?

			if($arResult["CANCELED"] == "Y"){
				?><span class = "label label-danger"><?=Loc::getMessage('SPOD_ORDER_CANCELED')?></span><?
				if(strlen($arResult["DATE_CANCELED_FORMATED"])){
					?> (<?= Loc::getMessage('SPOD_FROM') ?> <?= $arResult["DATE_CANCELED_FORMATED"] ?>)<?
				}
			} else {
				$CSSClass = 'label label-success';
				if($arResult["STATUS"]['COLOR']=='yellow'){
					$CSSClass = 'label label-warning';
				} elseif($arResult["STATUS"]['COLOR']==='red'){
					$CSSClass = 'label label-danger';
				} elseif($arResult["STATUS"]['COLOR']==='gray'){
					$CSSClass = 'label label-info';
				}
				?><span class="<?=$CSSClass;?>"><?=$arResult["STATUS"]['NAME']?></span><?
				if(strlen($arResult["DATE_STATUS_FORMATED"])){
					?> (<?=Loc::getMessage("SPOD_FROM")?> <?=$arResult["DATE_STATUS_FORMATED"]?>)<?
				}
			}
		?></div><?

		?><div class = "col-md-4 clearfix"><?
			if($arResult["CAN_CANCEL"] == "Y"){
				?><a class="aprimary pull-left" href="<?=$arResult["URL_TO_CANCEL"]?>"><?=Loc::getMessage("SPOD_ORDER_CANCEL")?></a><?
			}
			?><a class="aprimary pull-right" href = "<?=$order["ORDER"]["URL_TO_COPY"]?>"><?=Loc::getMessage('SPOL_REPEAT_ORDER');?></a><?
		?></div><?
		?><div class="col col-md-12 mt"><?
			if(floatval($arResult["ORDER_WEIGHT"])){
				?><?=Loc::getMessage('SPOD_TOTAL_WEIGHT')?>: <?=$arResult['ORDER_WEIGHT_FORMATED']?><br><?
			}
			?><?=Loc::getMessage('SPOD_PRODUCT_SUM')?>: <?=$arResult['PRODUCT_SUM_FORMATTED']?><br><?
			if(strlen($arResult["PRICE_DELIVERY_FORMATED"])){
				?><?=Loc::getMessage('SPOD_DELIVERY')?>: <?=$arResult['PRICE_DELIVERY_FORMATED']?><br><?
			}
			if(floatval($arResult["TAX_VALUE"])){
				?><?=Loc::getMessage('SPOD_TAX')?>: <?=$arResult['TAX_VALUE_FORMATED']?><br><?
			}
			if(floatval($arResult["DISCOUNT_VALUE"])){
				?><?=Loc::getMessage('SPOD_DISCOUNT')?>: <?=$arResult['DISCOUNT_VALUE_FORMATED']?><br><?
			}
			?><?=Loc::getMessage('SPOD_SUMMARY');?>: <?=$arResult["PRICE_FORMATED"]?><?
		?></div><?
	?></div><?

	// Basket
	?><div class="row mt p_basket"><?
		?><div class="col col-md-12"><?
			?><h5><?=Loc::getMessage('SPOD_ORDER_BASKET')?></h5><?
			?><div class="table-responsive"><?
				?><table class="table basket_table"><?
					?><tbody><?
						$i=1;
						foreach($arResult["BASKET"] as $prod){
							?><tr><?
								?><td><?=($i++)?></td><?
								$hasLink = !empty($prod["DETAIL_PAGE_URL"]);
								?><td class="picture" width="1%"><?
									if($hasLink){
										?><a href="<?= $prod["DETAIL_PAGE_URL"] ?>" target="_blank"><?
									}
									if($prod['PICTURE']['SRC']){
										?><img class="outline" src="<?=$prod['PICTURE']['SRC']?>" alt="<?=$prod['NAME']?>" /><?
									}
									if($hasLink){
										?></a><?
									}
								?></td><?
								?><td><?
									if($hasLink){
										?><a class="aprimary" href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank"><?
									}
									?><?=htmlspecialcharsEx($prod["NAME"])?><?
									if($hasLink){
										?></a><?
									}
									?><br><?=Loc::getMessage('PROD_CODE')?>: <?=$prod["PRODUCT_ID"]?><?
								?></td><?

								?><td><?
									echo '<br>'.$prod["QUANTITY"].' ';
									if(strlen($prod['MEASURE_TEXT'])){
										echo $prod['MEASURE_TEXT'];
									} else {
										echo GetMessage('SPOD_DEFAULT_MEASURE');
									}
								?></td><?

								?><td align="right"><?
									?><small><?=htmlspecialcharsEx($prod["NOTES"])?></small><br><?=$prod["PRICE_FORMATED"]?><?
								?></td><?

							?></tr><?
						}
					?></tbody><?
				?></table><?
			?></div><?
		?></div><?
	?></div><?

	// Account info
	?><div class="row mt"><?
		?><div class="col col-md-12"><?
			?><h5><?=Loc::getMessage('SPOD_ACCOUNT_DATA')?></h5><?
			?><table class="spod"><?
				if(strlen($arResult["USER_NAME"])){
					?><tr><?
						?><td><?=Loc::getMessage('SPOD_ACCOUNT') ?></td><?
						?><td><?=$arResult["USER_NAME"] ?></td><?
					?></tr><?
				}
				?><tr><?
					?><td><?=Loc::getMessage('SPOD_LOGIN');?></td><?
					?><td><?=$arResult["USER"]["LOGIN"]?></td><?
				?></tr><?
				?><tr><?
					?><td><?=Loc::getMessage('SPOD_EMAIL');?></td><?
					?><td><?
						?><a href="mailto:<?=$arResult["USER"]["EMAIL"]?>"><?=$arResult["USER"]["EMAIL"]?></a><?
					?></td><?
				?></tr><?
			?></table><?
		?></div><?
	?></div><?

	// order params
	?><div class="row mt"><?
		?><div class="col col-md-12"><?
			?><h5><?=Loc::getMessage('SPOD_ORDER_PROPERTIES')?></h5><?
			?><table class="spod"><?
				?><tr><?
					?><td><?=Loc::getMessage('SPOD_ORDER_PERS_TYPE');?></td><?
					?><td><?=$arResult["PERSON_TYPE"]["NAME"]?></td><?
				?></tr><?
			?></table><?
		?></div><?
	?></div><?

	// order props
	?><div class="row mt"><?
		?><div class="col col-md-12"><?
			$i=0;
			foreach($arResult["ORDER_PROPS"] as $prop){
				if($prop["SHOW_GROUP_NAME"] == "Y"){
					if($i>0){
						?></table><?
					}
					?><h5><?=$prop["GROUP_NAME"]?></h5><?
					?><table class="spod"><?
				}
				?><tr><?
					?><td><?=$prop['NAME']?>:</td><?
					?><td><?
						if($prop["TYPE"] == "CHECKBOX"){
							?><?= GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO')) ?><?
						} else {
							?><?= $prop["VALUE"] ?><?
						}
					?></td><?
				?></tr><?
				$i++;
			}
			?></table><?
		?></div><?
	?></div><?

	// delivery and payment
	?><div class="row mt"><?
		?><div class="col col-md-12"><?
			?><h5><?=Loc::getMessage('SPOD_ORDER_PAYMENT')?></h5><?
			?><table class="spod"><?
				?><tr><?
					?><td><?=GetMessage('SPOD_PAY_SYSTEM')?>:</td><?
					?><td><?
						if(intval($arResult["PAY_SYSTEM_ID"])){
							echo $arResult["PAY_SYSTEM"]["NAME"];
						} else {
							echo GetMessage("SPOD_NONE");
						}
					?></td><?
				?></tr><?
				?><tr><?
					?><td><?=GetMessage('SPOD_ORDER_PAYED')?>:</td><?
					?><td><?
						if($arResult["PAYED"] == "Y"){
							echo GetMessage('SPOD_YES');
							if(strlen($arResult["DATE_PAYED_FORMATED"])){
								?>(<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)<?
							}
						} else {
							echo GetMessage('SPOD_NO');
							if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"){
								?>&nbsp;&nbsp;&nbsp;[<a href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>]<?
							}
						}
					?></td><?
				?></tr><?
				?><tr><?
					?><td><?=GetMessage("SPOD_ORDER_DELIVERY")?>:</td><?
					?><td><?
						if(strpos($arResult["DELIVERY_ID"], ":") !== false || intval($arResult["DELIVERY_ID"])){
							echo $arResult["DELIVERY"]["NAME"];
							if(intval($arResult['STORE_ID']) && !empty($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']])){
								$store = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']];
								?><div class="bx_ol_store"><?
									?><div class="bx_old_s_row_title"><?
										?><?=GetMessage('SPOD_TAKE_FROM_STORE')?>: <b><?=$store['TITLE']?></b><?
										if(!empty($store['DESCRIPTION'])){
											?><div class="bx_ild_s_desc"><?=$store['DESCRIPTION']?></div><?
										}
									?></div><?
									if(!empty($store['ADDRESS'])){
										?><div class="bx_old_s_row"><?
											?><b><?=GetMessage('SPOD_STORE_ADDRESS')?></b>: <?=$store['ADDRESS']?><?
										?></div><?
									}
									if(!empty($store['SCHEDULE'])){
										?><div class="bx_old_s_row"><?
											?><b><?=GetMessage('SPOD_STORE_WORKTIME')?></b>: <?=$store['SCHEDULE']?><?
										?></div><?
									}
									if(!empty($store['PHONE'])){
										?><div class="bx_old_s_row"><?
											?><b><?=GetMessage('SPOD_STORE_PHONE')?></b>: <?=$store['PHONE']?><?
										?></div><?
									}
									if(!empty($store['EMAIL'])){
										?><div class="bx_old_s_row"><?
											?><b><?=GetMessage('SPOD_STORE_EMAIL')?></b>: <a href="mailto:<?=$store['EMAIL']?>"><?=$store['EMAIL']?></a><?
										?></div><?
									}
									if(($store['GPS_N'] = floatval($store['GPS_N'])) && ($store['GPS_S'] = floatval($store['GPS_S']))){
										?><div id="bx_old_s_map"><?
											?><div class="bx_map_buttons"><?
												?><a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-show"><?
													?><?=GetMessage('SPOD_SHOW_MAP')?><?
												?></a><?
												?><a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-hide"><?
													?><?=GetMessage('SPOD_HIDE_MAP')?><?
												?></a><?
											?></div><?
											ob_start();
											?><div><?
											$mg = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'];
											if(!empty($mg['SRC'])):?><img src="<?=$mg['SRC']?>" width="<?=$mg['WIDTH']?>" height="<?=$mg['HEIGHT']?>"><br /><br /><?endif?><?
											?><?=$store['TITLE']?></div><?
											$ballon = ob_get_contents();
											ob_end_clean();
											$mapId = '__store_map';
											$mapParams = array(
												'yandex_lat' => $store['GPS_N'],
												'yandex_lon' => $store['GPS_S'],
												'yandex_scale' => 16,
												'PLACEMARKS' => array(
													array(
														'LON' => $store['GPS_S'],
														'LAT' => $store['GPS_N'],
														'TEXT' => $ballon
													)
												)
											);
											?><div id="map-container"><?
												?><?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
													"INIT_MAP_TYPE" => "MAP",
													"MAP_DATA" => serialize($mapParams),
													"MAP_WIDTH" => "100%",
													"MAP_HEIGHT" => "200",
													"CONTROLS" => array(
														0 => "SMALLZOOM",
													),
													"OPTIONS" => array(
														0 => "ENABLE_SCROLL_ZOOM",
														1 => "ENABLE_DBLCLICK_ZOOM",
														2 => "ENABLE_DRAGGING",
													),
													"MAP_ID" => $mapId
												),
												false
												);?><?
											?></div><?
											CJSCore::Init();
											?><script>new CStoreMap({mapId:"<?=$mapId?>", area: '.bx_old_s_map'});</script><?
										?></div><?
									}
								?></div><?
							}
						} else {
							echo GetMessage("SPOD_NONE");
						}
					?></td><?
				?></tr><?
				if($arResult["TRACKING_NUMBER"]){
					?><tr><?
						?><td><?=GetMessage('SPOD_ORDER_TRACKING_NUMBER')?>:</td><?
						?><td><?=$arResult["TRACKING_NUMBER"]?></td><?
					?></tr><?
				}
			?></table><?
		?></div><?
	?></div><?

	// summary
	?><div class="row"><?
		?><div class="col col-md-12"><?
			?><hr><?
			if(floatval($arResult["ORDER_WEIGHT"])){
				?><?=Loc::getMessage('SPOD_TOTAL_WEIGHT')?>: <?=$arResult['ORDER_WEIGHT_FORMATED']?><br><?
			}
			?><?=Loc::getMessage('SPOD_PRODUCT_SUM')?>: <?=$arResult['PRODUCT_SUM_FORMATTED']?><br><?
			if(strlen($arResult["PRICE_DELIVERY_FORMATED"])){
				?><?=Loc::getMessage('SPOD_DELIVERY')?>: <?=$arResult['PRICE_DELIVERY_FORMATED']?><br><?
			}
			if(floatval($arResult["TAX_VALUE"])){
				?><?=Loc::getMessage('SPOD_TAX')?>: <?=$arResult['TAX_VALUE_FORMATED']?><br><?
			}
			if(floatval($arResult["DISCOUNT_VALUE"])){
				?><?=Loc::getMessage('SPOD_DISCOUNT')?>: <?=$arResult['DISCOUNT_VALUE_FORMATED']?><br><?
			}
			?><?=Loc::getMessage('SPOD_SUMMARY');?>: <?=$arResult["PRICE_FORMATED"]?><?
		?></div><?
	?></div><?

	// back
	?><br><?
	?><div class="row backshare mt"><?
		?><div class="col col-md-6"><?
			?><a class="detailback" href="<?=$arResult["URL_TO_LIST"]?>"><?
				?><i class="fa"></i><span><?=Loc::getMessage('SPOD_GO_BACK2')?></span><?
			?></a><?
		?></div><?
	?></div><?

?></div><?