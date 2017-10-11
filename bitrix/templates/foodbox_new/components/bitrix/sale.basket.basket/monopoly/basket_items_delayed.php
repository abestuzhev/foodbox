<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
?>
<div id="basket_items_delayed" class="bx_ordercart_order_table_container table-responsive" style="display:none">
	<table class="table table-striped" id="delayed_items">
		<thead>
			<tr>
				<?
				foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
					$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
					if ($arHeader["name"] == '')
						$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
					if (in_array($arHeader["id"], array("TYPE"))) // some header columns are shown differently
					{
						continue;
					}
					elseif ($arHeader["id"] == "PROPS")
					{
						$bPropsColumn = true;
						continue;
					}
					elseif ($arHeader["id"] == "DELAY")
					{
						continue;
					}
					elseif ($arHeader["id"] == "DELETE")
					{
						$bDeleteColumn = true;
						continue;
					}
					elseif ($arHeader["id"] == "WEIGHT")
					{
						$bWeightColumn = true;
					}

					if ($arHeader["id"] == "NAME"):
					?>
						<td class="item" colspan="2">
					<?
					elseif ($arHeader["id"] == "PRICE"):
					?>
						<td class="price">
					<?
					else:
					?>
						<td class="custom">
					<?
					endif;
					?>
						<?=$arHeader["name"]; ?>
						</td>
				<?
				endforeach;

				if ($bDeleteColumn || $bDelayColumn):
				?>
					<td class="custom"></td>
				<?
				endif;
				?>
			</tr>
		</thead>

		<tbody>
			<?
			foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

				if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y"):
			?>
				<tr id="<?=$arItem["ID"]?>">
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in columns in this template
							continue;

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="itemphoto">
								<div class="bx_ordercart_photo_container">
									<?
									if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
										$url = $arItem["PREVIEW_PICTURE_SRC"];
									elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
										$url = $arItem["DETAIL_PICTURE_SRC"];
									else:
										$url = $arResult['NO_PHOTO']['src'];
									endif;
									?>
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<img alt="" src="<?=$url?>" />
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								</div>
								<?
								if (!empty($arItem["BRAND"])):
								?>
								<div class="bx_ordercart_brand">
									<img alt="" src="<?=$arItem["BRAND"]?>" />
								</div>
								<?
								endif;
								?>
							</td>

							<td class="item">
								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="aprimary" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<?=$arItem["NAME"]?>
								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								<input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y"/>
							</td>
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<td class="custom">
								<?if($arHeader["name"]!=''):?>
									<span><?=$arHeader["name"]; ?>:</span>
								<?endif;?>
								<div style="text-align: center;">
									<?echo $arItem["QUANTITY"];
										if (isset($arItem["MEASURE_TEXT"]))
											echo "&nbsp;".$arItem["MEASURE_TEXT"];
									?>
								</div>
							</td>
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td>
								<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
									<div class="price current_price text-nowrap"><?=$arItem["PRICE_FORMATED"]?></div>
									<div class="price old old_price text-nowrap"><?=$arItem["FULL_PRICE_FORMATED"]?></div>
								<?else:?>
									<div class="price current_price text-nowrap"><?=$arItem["PRICE_FORMATED"];?></div>
								<?endif?>

								<?/*if (strlen($arItem["NOTES"]) > 0):?>
									<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
									<div class="type_price_value"><?=$arItem["NOTES"]?></div>
								<?endif;*/?>
							</td>
						<?
						elseif ($arHeader["id"] == "DISCOUNT"):
						?>
							<td class="custom">
								<?if($arHeader["name"]!=''):?>
									<span><?=$arHeader["name"]; ?>:</span>
								<?endif;?>
								<span class="price discount"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span>
							</td>
						<?
						elseif ($arHeader["id"] == "WEIGHT"):
						?>
							<td class="custom">
								<?if($arHeader["name"]!=''):?>
									<span><?=$arHeader["name"]; ?>:</span>
								<?endif;?>
								<?=$arItem["WEIGHT_FORMATED"]?>
							</td>
						<?
						else:
						?>
							<td class="custom">
								<?if($arHeader["name"]!=''):?>
									<span><?=$arHeader["name"]; ?>:</span>
								<?endif;?>
								<?=$arItem[$arHeader["id"]]?>
							</td>
						<?
						endif;
					endforeach;

					if ($bDelayColumn || $bDeleteColumn):
					?>
						<td class="control">
							<a class="aprimary text-nowrap" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><?=GetMessage("SALE_ADD_TO_BASKET")?></a><br />
							<?
							if ($bDeleteColumn):
							?>
								<a class="aprimary text-nowrap" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=GetMessage("SALE_DELETE")?></a><br />
							<?
							endif;
							?>
						</td>
					<?
					endif;
					?>
				</tr>
				<?
				endif;
			endforeach;
			?>
		</tbody>

	</table>
</div>
<?