<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
?>
<div class = "row">

	<div class = "col col-md-12">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<?
						$bPreviewPicture = false;
						$bDetailPicture = false;
						$imgCount = 0;

						// prelimenary column handling
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
						{
							if ($arColumn["id"] == "PROPS")
								$bPropsColumn = true;

							if ($arColumn["id"] == "NOTES")
								$bPriceType = true;

							if ($arColumn["id"] == "PREVIEW_PICTURE")
								$bPreviewPicture = true;

							if ($arColumn["id"] == "DETAIL_PICTURE")
								$bDetailPicture = true;
						}

						if ($bPreviewPicture || $bDetailPicture)
							$bShowNameWithPicture = true;


						foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

							if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
								continue;

							if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
								continue;

							if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
							?>
								<td class="item" colspan="2">
							<?
								echo GetMessage("SALE_PRODUCTS");
							elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
							?>
								<td class="item">
							<?
								echo $arColumn["name"];
							elseif ($arColumn["id"] == "PRICE"):
							?>
								<td class="price">
							<?
								echo $arColumn["name"];
							else:
							?>
								<td class="custom PROP_<?=$arColumn["id"]?>">
							<?
								echo $arColumn["name"];
							endif;
							?>
								</td>
						<?endforeach;?>
					</tr>
				</thead>

				<tbody>
					<?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
					<tr>
						<?
						if ($bShowNameWithPicture):
						?>
							<td class="itemphoto">
								<div class="bx_ordercart_photo_container">
									<?
									if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
										$url = $arData["data"]["PREVIEW_PICTURE_SRC"];
									elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
										$url = $arData["data"]["DETAIL_PICTURE_SRC"];
									else:
										$url = $arResult['NO_PHOTO']['src'];
									endif;

									if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<img src="<?=$url?>" alt="" />
									<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								</div>
								<?
								if (!empty($arData["data"]["BRAND"])):
								?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arData["data"]["BRAND"]?>" />
									</div>
								<?
								endif;
								?>
							</td>
						<?
						endif;

						// prelimenary check for images to count column width
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
						{
							$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
							if (is_array($arItem[$arColumn["id"]]))
							{
								foreach ($arItem[$arColumn["id"]] as $arValues)
								{
									if ($arValues["type"] == "image")
										$imgCount++;
								}
							}
						}

						foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

							$class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

							if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
								continue;

							if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
								continue;

							$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

							if ($arColumn["id"] == "NAME"):
								$width = 70 - ($imgCount * 20);
							?>
								<td class="item PROP_<?=$arColumn["id"]?>" style="width:<?=$width?>%">

									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="aprimary" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<?=$arItem["NAME"]?>
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									
									<?/**********************/
									/***********************/?>
									<div class="hiddenDesctop">
									<table class="table table-condensed">
									<?foreach ($arResult["GRID"]["HEADERS"] as $id2 => $arColumn2):

										$class = ($arColumn2["id"] == "PRICE_FORMATED") ? "price" : "";

										if (in_array($arColumn2["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
											continue;

										if ($arColumn2["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
											continue;
										
										if ($arColumn2["id"] == "NAME")
											continue;

										$arItem = (isset($arData["columns"][$arColumn2["id"]])) ? $arData["columns"] : $arData["data"];
									
										if ($arColumn2["id"] == "PRICE_FORMATED"):
									?>
									<tr>
										<td class="price right"><?=$arColumn2["name"]?></td>
										<td class="price right">
											<div class="price current_price text-nowrap"><?=$arItem["PRICE_FORMATED"]?></div>
											<div class="price old old_price text-nowrap">
												<?
												if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
													echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
													$bUseDiscount = true;
												endif;
												?>
											</div>
										</td>
									</tr>
									<?
									elseif ($arColumn2["id"] == "DISCOUNT"):
									?>
									<tr>
										<td class="custom right"><?=$arColumn2["name"]?></td>
										<td class="custom right">
											<span><?=getColumnName($arColumn2)?>:</span>
											<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
										</td>
									</tr>
									<?
									elseif ($arColumn2["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
									?>
									<tr>
										<td class="itemphoto"><?=$arColumn2["name"]?></td>
										<td class="itemphoto">
											<div class="bx_ordercart_photo_container">
												<?
												$url = "";
												if ($arColumn2["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
													$url = $arData["data"]["DETAIL_PICTURE_SRC"];

												if ($url == "")
													$url = $arResult['NO_PHOTO']['src'];

												if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
													<img src="<?=$url?>" alt="" />
												<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
											</div>
										</td>
									</tr>
									<?
									elseif (in_array($arColumn2["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED"))):
									?>
									<tr>
										<td class="custom right"><?=$arColumn2["name"]?></td>
										<td class="custom right">
											<?=$arItem[$arColumn2["id"]]?>
										</td>
									</tr>
									<?
									elseif (in_array($arColumn2["id"], array("SUM"))):
									?>
									<tr>
										<td class="custom right"><?=$arColumn2["name"]?></td>
										<td class="custom right">
											<span class="text-nowrap"><?=$arItem[$arColumn2["id"]]?></span>
										</td>
									</tr>
									<?
									else: // some property value

										if (is_array($arItem[$arColumn2["id"]])):

											foreach ($arItem[$arColumn2["id"]] as $arValues)
												if ($arValues["type"] == "image")
													$columnStyle = "width:20%";
										?>
									<tr>
										<td class="custom right"><?=$arColumn2["name"]?></td>
										<td class="custom" style="<?=$columnStyle?>">
											<?
											foreach ($arItem[$arColumn2["id"]] as $arValues):
												if ($arValues["type"] == "image"):
												?>
													<div class="bx_ordercart_photo_container">
														<img src="<?=$arValues["value"]?>" alt="" />
													</div>
												<?
												else: // not image
													echo $arValues["value"]."<br/>";
												endif;
											endforeach;
											?>
										</td>
									</tr>
										<?
										else: // not array, but simple value
										?>
									<tr>
										<td class="custom right"><?=$arColumn2["name"]?></td>
										<td class="custom" style="<?=$columnStyle?>">
											<?
												echo $arItem[$arColumn2["id"]];
											?>
										</td>
									</tr>
										<?
										endif;?>
									<?
										endif;?>
									<?endforeach;?>
									</table>
									</div>
									
									
									
								</td>
							<?
							elseif ($arColumn["id"] == "PRICE_FORMATED"):
							?>
								<td class="price right PROP_<?=$arColumn["id"]?>">
									<div class="price current_price text-nowrap"><?=$arItem["PRICE_FORMATED"]?></div>
									<div class="price old old_price text-nowrap">
										<?
										if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
											echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
											$bUseDiscount = true;
										endif;
										?>
									</div>

									<?/*if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div style="text-align: left">
											<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
											<div class="type_price_value"><?=$arItem["NOTES"]?></div>
										</div>
									<?endif;*/?>
								</td>
							<?
							elseif ($arColumn["id"] == "DISCOUNT"):
							?>
								<td class="custom right PROP_<?=$arColumn["id"]?>">
									<span><?=getColumnName($arColumn)?>:</span>
									<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
								</td>
							<?
							elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
							?>
								<td class="itemphoto PROP_<?=$arColumn["id"]?>">
									<div class="bx_ordercart_photo_container">
										<?
										$url = "";
										if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
											$url = $arData["data"]["DETAIL_PICTURE_SRC"];

										if ($url == "")
											$url = $arResult['NO_PHOTO']['src'];

										if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<img src="<?=$url?>" alt="" />
										<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
								</td>
							<?
							elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED"))):
							?>
								<td class="custom right PROP_<?=$arColumn["id"]?>">
									<?=$arItem[$arColumn["id"]]?>
								</td>
							<?
							elseif (in_array($arColumn["id"], array("SUM"))):
							?>
								<td class="custom right PROP_<?=$arColumn["id"]?>">
									<span class="text-nowrap"><?=$arItem[$arColumn["id"]]?></span>
								</td>
							<?
							else: // some property value

								if (is_array($arItem[$arColumn["id"]])):

									foreach ($arItem[$arColumn["id"]] as $arValues)
										if ($arValues["type"] == "image")
											$columnStyle = "width:20%";
								?>
								<td class="custom PROP_<?=$arColumn["id"]?>" style="<?=$columnStyle?>">
									<?
									foreach ($arItem[$arColumn["id"]] as $arValues):
										if ($arValues["type"] == "image"):
										?>
											<div class="bx_ordercart_photo_container">
												<img src="<?=$arValues["value"]?>" alt="" />
											</div>
										<?
										else: // not image
											echo $arValues["value"]."<br/>";
										endif;
									endforeach;
									?>
								</td>
								<?
								else: // not array, but simple value
								?>
								<td class="custom PROP_<?=$arColumn["id"]?>" style="<?=$columnStyle?>">
									<?
										echo $arItem[$arColumn["id"]];
									?>
								</td>
								<?
								endif;
							endif;

						endforeach;
						?>
					</tr>
					<?endforeach;?>
				</tbody>
			</table>
		</div>
	</div>

	<div class = "col col-md-12 text-right ws_formated">
		<span class = ""> <?=Loc::getMessage('SOA_TEMPL_ITEMS_COUNT')?> <?=count($arResult['BASKET_ITEMS'])?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_SUMMARY')?> <?=$arResult['ORDER_PRICE_FORMATED']?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_WEIGHT_SUM')?> <?=$arResult['ORDER_WEIGHT_FORMATED']?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_DELIVERY')?> <?=$arResult['DELIVERY_PRICE_FORMATED']?> </span>
	</div>
	<div class = "col col-md-12">
		<div class = "panel panel-order">
			<div class = "panel-body">
                <div class="row orderline">
                
                    <div class="col col-xs-6 col-md-5 buttons">
						<div class="row">
							<div class="col col-xs-6 col-md-6 buttons">
								<a onClick="SendAnalyticsGoal('modify');" href="<?=$arParams['PATH_TO_BASKET']?>" class="btn btn-default">
									<?=Loc::getMessage("SOA_TEMPL_BUTTON_EDIT_BASKET")?>
								</a>
							</div>
							<div class="col col-xs-6 col-md-6">
								<a href="/catalog/" class="btn btn-default">
									<?=Loc::getMessage("SALE_RETURN_TO_CATALOG")?>
								</a>
							</div>
						</div>
                    </div>
                    <div class="col col-xs-6 col-md-3 col-md-push-4 text-right buttons">
                        <a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="checkout btn btn-primary btn-order">
                            <?=Loc::getMessage("SOA_TEMPL_BUTTON")?>
                        </a>
                    </div>
                    <div class="col col-xs-12 col-md-4 col-md-pull-3 col-lg-pull-2 text-right">
                        <?=Loc::getMessage('SOA_TEMPL_SUM_IT')?>
                        <span class = "price cool"> <?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></span>
                        
                        <div class = "price vat text-right">
                            <?=Loc::getMessage('SOA_TEMPL_SUM_VAT'); ?>
                            <?=$arResult['VAT_SUM_FORMATED']?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>