<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arParams['DISPLAY_TOP_PAGER']=='Y') {
	echo $arResult['NAV_STRING'];
}

if(is_array($arResult['ITEMS']) && count($arResult['ITEMS'])>0) {
	?><div class="row products <?=$arResult['TEMPLATE_DEFAULT']['CSS']?>"><?
		foreach($arResult['ITEMS'] as $key1 => $arItem) {
 			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			if(empty($arItem['OFFERS'])){ $HAVE_OFFERS = false; $PRODUCT = &$arItem; } else { $HAVE_OFFERS = true; $PRODUCT = &$arItem['OFFERS'][0]; }
			?><div class="item <?
				?>js-element <?
				?>js-elementid<?=$arItem['ID']?> <?
				?>col col-sm-6 col-md-<?if($arParams["SIDEBAR"]=='Y'):?>6<?else:?>4<?endif;?> col-lg-<?if($arParams["SIDEBAR"]=='Y'):?>4<?else:?>3<?endif;?> <?
				if( isset($arItem['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2']) ) { echo ' da2'; }
				if( isset($arItem['QUICKBUY']) || isset($PRODUCT['QUICKBUY']) ) { echo ' qb'; }
				?>" <?
				?>data-elementid="<?=$arItem['ID']?>" <?
                ?>data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>" <?
				?>id="<?=$this->GetEditAreaId($arItem["ID"]);?>"<?
				?>><?
				?><div class="da2_icon hidden-xs"><?=GetMessage('DA2_ICON_TITLE')?></div><?
				?><div class="qb_icon hidden-xs"><?=GetMessage('QB_ICON_TITLE')?></div><?
				?><div class="row"><?
					?><div class="col col-md-12"><?
						?><div class = "in"><?
							if($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y") {
								?><div 
									class = "favorite favorite-heart" 
									data-elementid = "<?=$arItem['ID']?>"
									data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>"
								>
								</div><?
							}
							// PICTURE
							?><div class="pic"><?
								?><a class="js-detail_page_url" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?
									if( isset($arItem['FIRST_PIC']['RESIZE']['src']) && trim($arItem['FIRST_PIC']['RESIZE']['src'])!='' ) {
										?><img src="<?=$arItem['FIRST_PIC']['RESIZE']['src']?>" alt="<?=$arItem['FIRST_PIC']['ALT']?>" title="<?=$arItem['FIRST_PIC']['TITLE']?>" /><?
									} else {
										?><img src="<?=$arResult['NO_PHOTO']['src']?>" title="<?=$arItem['NAME']?>" alt="<?=$arItem['NAME']?>" /><?
									}
								?></a><?
							?></div><?
							?><div class="data"><?
								// NAME
								?><div class="name"><?
									?><a class="aprimary" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a><br /><?
								?></div><?
								?><div class="row buy"><?
									// PRICES
									?><div class="col col-xs-6 prices"><?
										if( IntVal($PRODUCT['MIN_PRICE']['DISCOUNT_DIFF'])>0 ) {
											?><div class="price old"><?=$PRODUCT['MIN_PRICE']['PRINT_VALUE']?></div><?
											?><div class="price cool new"><?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div><?
										} else {
											?><div class="price cool"><?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div><?
										}
									?></div><?
									// ADD2BASKET
									?><div class="col col-xs-6 text-right buybtn"><?
										if($HAVE_OFFERS){
											?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn-primary"><?=GetMessage('RS.MONOPOLY.BTN_MORE')?></a><?
										} else {
											?><noindex><?
												?><form class="add2basketform js-buyform<?=$arItem['ID']?><?if(!$PRODUCT['CAN_BUY']):?> cantbuy<?endif;?><?if($arParams['USE_PRODUCT_QUANTITY']):?> usequantity<?endif;?>" name="add2basketform"><?
													?><input type="hidden" name="action" value="ADD2BASKET"><?
													?><input type="hidden" name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" class="js-add2basketpid" value="<?=$PRODUCT['ID']?>"><?
													/*if($arParams['USE_PRODUCT_QUANTITY']){
														?><span class="quantity"><?
															?><a class="minus js-minus"><i class="fa"></i></a><?
															?><input type="text" class="js-quantity form-control text-center" name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>" value="<?=$PRODUCT['CATALOG_MEASURE_RATIO']?>" data-ratio="<?=$PRODUCT['CATALOG_MEASURE_RATIO']?>"><?
															?><a class="plus js-plus"><i class="fa"></i></a><?
															?><span class="js-measurename"><?=$PRODUCT['CATALOG_MEASURE_NAME']?></span><?
														?></span><?
													}*/
													?><button type="submit" rel="nofollow" class="btn btn-primary submit js-add2basketlink" value=""><?=GetMessage('RS.MONOPOLY.BTN_BUY')?></button><?
													?><a class="btn btn-primary inbasket" href="<?=$arParams['BASKET_URL']?>"><?=GetMessage('RS.MONOPOLY.BTN_GO2BASKET')?></a><?
													?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn-primary js-morebtn buybtn"><?=GetMessage('RS.MONOPOLY.BTN_MORE')?></a><?
												?></form><?
											?></noindex><?
										}
									?></div><?
								?></div><?
								?><div class="row bot"><?
									// COMPARE
									?><div class="col col-xs-6 compare"><?
										if($arParams['DISPLAY_COMPARE']=='Y'){
											?><a class="js-compare link" href="<?=$arItem['COMPARE_URL']?>"><span><?=GetMessage('RS.MONOPOLY.COMPARE')?></span><span class="count"></span></a><?
										}
									?></div><?
									// STORES
									if( $arParams['USE_STORE']!='' ) {
										?><div class="col col-xs-6 text-right"><?
$APPLICATION->IncludeComponent(
	'bitrix:catalog.store.amount',
	'monopoly',
	array(
		"ELEMENT_ID" => $arItem["ID"],
		"STORE_PATH" => $arParams["STORE_PATH"],
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000",
		"MAIN_TITLE" => $arParams["MAIN_TITLE"],
		"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
		"SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
		"USE_MIN_AMOUNT" => "N",
		"MONOPOLY_USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
		"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
		"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
		"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
		"USER_FIELDS" => $arParams['USER_FIELDS'],
		"FIELDS" => $arParams['STORES_FIELDS'],
		// monopoly
		'DATA_QUANTITY' => $arItem['DATA_QUANTITY'],
		'FIRST_ELEMENT_ID' => $PRODUCT['ID'],
	),
	$component,
	array('HIDE_ICONS'=>'Y')
);
										?></div><?
									}
								?></div><?
							?></div><?
						?></div><?
					?></div><?
				?></div><?
			?></div><?

		}

	?></div><?

} else {
	?><div class="alert alert-info" role="alert"><?=GetMessage('RS.MONOPOLY.NO_PRODUCTS')?></div><?
}

if($arParams['DISPLAY_BOTTOM_PAGER']=='Y') {
	echo $arResult['NAV_STRING'];
}