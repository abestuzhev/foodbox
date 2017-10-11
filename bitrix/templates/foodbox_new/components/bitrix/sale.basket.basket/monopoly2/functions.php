<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;

function showTableWithItems($arParams) {
	
	$arItems = isset($arParams['ITEMS']) && count($arParams['ITEMS']) > 0 ? $arParams['ITEMS'] : array();
	$skipProperties = isset($arParams['SKIP_PROP']) && count($arParams['SKIP_PROP']) > 0 ? $arParams['SKIP_PROP'] : array();
	$arUrls = isset($arParams['URLS']) && count($arParams['SKIP_PROP']) > 0 ? $arParams['URLS'] : array();
	$arHeaders = isset($arParams['HEADERS']) && count($arParams['HEADERS']) > 0 ? $arParams['HEADERS'] : array();
	$idTable = isset($arParams['ID_TABLE']) ? $arParams['ID_TABLE'] : 'basket_items';
	
	$isDeleteButton = false;
	$isDelayButton = false;
?>
<div class = "table-responsive">

	<table class = "table basket_table" id="<?=$idTable?>">
		<thead>
			<tr>
				<th> </th>
				<? foreach ($arHeaders as &$arHeader): ?>
					<?	
						if($arHeader['id'] == 'DELAY' && !in_array($arHeader['id'], $skipProperties)) {
							$isDelayButton = true;
							continue;
						} elseif($arHeader['id'] == 'DELETE' && !in_array($arHeader['id'], $skipProperties)) {
							$isDeleteButton = true;
							continue;
						} elseif(in_array($arHeader['id'], $skipProperties)) {
							continue;
						}
					?>
					<? $arHeader["NAME"] = $arHeader["NAME"] != '' ? $arHeader["NAME"] : Loc::getMessage("SALE_".$arHeader["id"]); ?>
					<? if($arHeader['id'] == 'NAME'): ?>
						<th colspan = "2" class = "col_<?=$arHeader['id']?> responsiveHidden<?=$arHeader['id']?>"><?=$arHeader["NAME"]?></th>
					<? else: ?>
						<th class = "col_<?=$arHeader['id']?> responsiveHidden<?=$arHeader['id']?>">
							<? if($arHeader["NAME"]): ?>
								<?=$arHeader["NAME"]?>
							<? else: ?>
								<?=$arHeader["name"];?>
							<? endif; ?>
						</th>
					<? endif; ?>
				<? endforeach; ?>
				<? unset($arHeader) ?>
				<th class = "control responsiveHiddenACTION"> </th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($arItems as $n => $arItem): ?>
				<tr class="trBody" id = "<?=$arItem['ID']?>" 
					data-elementid = "<?=$arItem['ID']?>"
					data-elementname = "<?=$arItem['NAME']?>"
				>
					<td> 
						<?=$n+1?>
						<input type="checkbox" name="DELETE_<?=$arItem['ID']?>" id="DELETE_<?=$arItem['ID']?>" value="Y">
					</td>
					<? foreach ($arHeaders as $arHeader): ?>
						<?
							if(in_array($arHeader['id'], array_merge(array('DELAY', 'DELETE'), $skipProperties))) {
								continue;
							}
						?>
						<? /* ITEM */ ?>
						<? if($arHeader['id'] == 'NAME'): ?>
							<td class = "picture responsiveHidden<?=$arHeader['id']?>">
								<?
								if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
									$url = $arItem["PREVIEW_PICTURE_SRC"];
								elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
									$url = $arItem["DETAIL_PICTURE_SRC"];
								elseif ($arParams['NO_PHOTO']):
									$url = $arParams['NO_PHOTO']['src'];
								endif;
								?>

								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<img alt="" class = "outline" src="<?=$url?>" />
								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
							</td>
							<td class = "item responsiveHidden<?=$arHeader['id']?>">
								<? if($arItem["DETAIL_PAGE_URL"] != ''): ?>
									<a class="aprimary" href = "<?=$arItem["DETAIL_PAGE_URL"] ?>">
										<?=$arItem[$arHeader["id"]]?>
									</a>
								<? else: ?>
									<?=$arItem[$arHeader["id"]]?>
								<? endif; ?>
								<?if($arItem['DELAY'] == 'Y'): ?>
									<input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y">
								<? endif; ?>
								<br>
								<? if($arItem['PROPERTY_CML2_ARTICLE_VALUE']): ?>								
									<span class = "">
										<?=Loc::getMessage('ITEM_CODE')?>
										<?=$arItem['PROPERTY_CML2_ARTICLE_VALUE']?>
									</span>
								<? endif; ?>
								
								<div class="hiddenAjaxColResponsive ajaxColResponsive<?=$arItem['ID']?>">
									<div class="discountRes<?=$arItem['ID']?> discountAdapt"><span>Скидка:</span> <div class="value"></div></div>
									<div class="countRes<?=$arItem['ID']?> quantity quantityAdapt"><div class="value"></div></div>
									<div class="priceRes<?=$arItem['ID']?> priceAdapt"><span>Цена:</span> <div class="value"></div></div>
									<div class="sumRes<?=$arItem['ID']?> sumAdapt"><span>Сумма:</span> <div class="value"></div></div>
								</div>
								
							</td>
						<? /* QUANTITY */ ?>
						<? elseif($arHeader['id'] == 'QUANTITY'): ?>
							<?
								$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
								$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
								$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
							?>
							<td id = "count_value_<?=$arItem['ID']?>" class = "quantity custom responsiveHidden<?=$arHeader['id']?>" >
								<?if($arItem['DELAY'] == 'Y' || $arItem['CAN_BUY'] == 'N'): ?>
									<?=$arItem['QUANTITY']?>
									<? if(isset($arItem["MEASURE_TEXT"])): ?>
										<span class = "quantity_measure"><?=$arItem["MEASURE_TEXT"]?></span>
									<? endif; ?>
									<? continue; ?>
								<? endif; ?>
								<span class = "fa minus js-minus"></span>
								<input 
									type = "text"
									class = "quantity_number js-quantity form-control"
									size = "2" 
									value="<?=$arItem["QUANTITY"]?>"
									id="QUANTITY_INPUT_<?=$arItem['ID']?>"
									name="QUANTITY_INPUT_<?=$arItem['ID']?>"
									data-ratio = <?=$ratio?>
									onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
									onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');"
								>
								<span class = "fa plus js-plus"></span>
								<? if(isset($arItem["MEASURE_TEXT"])): ?>
									<span class = "quantity_measure"><?=$arItem["MEASURE_TEXT"]?></span>
								<? endif; ?>
								<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>">
							</td>
						<? /* PRICE */ ?>
						<? elseif($arHeader['id'] == 'PRICE'): ?>
							<? // todo: вывести тип цены ?>
							<td id = "price_value_<?=$arItem['ID']?>" class = "price custom responsiveHidden<?=$arHeader['id']?>">
								<div class="price current_price text-nowrap" id="current_price_<?=$arItem["ID"]?>">
									<?=$arItem["PRICE_FORMATED"]?>
								</div>
								<div class="price old old_price text-nowrap" id="old_price_<?=$arItem["ID"]?>">
									<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
										<?=$arItem["FULL_PRICE_FORMATED"]?>
									<?endif;?>
								</div>
							</td>
						<? /* DISCOUNT */ ?>
						<? elseif($arHeader['id'] == 'DISCOUNT'): ?>
							<td class = "discount responsiveHidden<?=$arHeader['id']?>" id = "discount_value_<?=$arItem['ID']?>">
								<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
							</td>
						<? /* SUM */ ?>
						<? elseif($arHeader['id'] == 'SUM'): ?>
							<td class = "custom responsiveHidden<?=$arHeader['id']?>" id="sum_<?=$arItem['ID']?>">
								<?=$arItem['SUM']?>
							</td>
						<? /* CUSTOM */ ?>
						<? else: ?>
							<td class = "custom responsiveHidden<?=$arHeader['id']?>"><?=$arItem[$arHeader["id"]]?></td>
						<? endif; ?>
						
					<? endforeach; ?>
					<? /* CONTROLS */ ?>
					<td class = "control responsiveHiddenACTION">
						<?/* if($arItem['DELAY'] == "Y"): ?>
							<a class="aprimary text-nowrap" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><?=Loc::getMessage("SALE_ADD_TO_BASKET")?></a><br />
						<? endif; */?>
						<? if($isDeleteButton): ?>
							<a class="aprimary text-nowrap" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=Loc::getMessage("SALE_DELETE")?></a><br />
						<? endif ?>
						<?/* if($isDelayButton): ?>
							<a class="aprimary text-nowrap" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=Loc::getMessage("SALE_DELAY")?></a>
						<? endif */?>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</div>

<?
}

function identIdHeaderFromArray($ar) {
	return $ar['id'];
}

function getRecommendedIds($items) {
	
	$filterIds = array();
	
	foreach ($items as $item) {
		$similarProducts = !empty($item['CATALOG']['PROPERTIES']['SIMILAR_PRODUCTS']) ?
								$item['CATALOG']['PROPERTIES']['SIMILAR_PRODUCTS']['VALUE'] : 
								false;
		if($similarProducts) {
			$filterIds = array_merge($filterIds, $similarProducts);
		}
	}
	
	
	return $filterIds;
}	