<?php
use \Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

$this->setFrameMode(false);
?>

<div class="row constructor-wrapper" id="set_constructor">
	<div class="section-cart col-md-12">
		<h2 class="coolHeading">
			<span class="secondLine"><?=Loc::getMessage("SET_CONSTRUCTOR_TITLE")?></span>
		</h2>
	</div>	
	<div class = " col-md-12 section-cart">
	
		<div class = "set-constructor js-constructor"
			data-iblockid="<?=$arParams['IBLOCK_ID']?>"
			data-ajaxpath="<?=$this->GetFolder();?>/ajax.php",
			data-lid="<?=SITE_ID?>" 
			data-setOffersCartProps = "<?=CUtil::PhpToJSObject($arParams["OFFERS_CART_PROPERTIES"])?>" 
			data-currency = "<?=$arResult['ELEMENT']['PRICE_CURRENCY']?>" 
		>
			<div 
                class = "selected-items owlslider set owl"
                data-margn = "24",
                data-nav = "true",
                data-loop = "false"
                data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"}, "956":{"items":"4"}}'
            >
			
				<? $arItem = $arResult["ELEMENT"]; ?>
				<div class = "item" 
						 data-elementid="<?=$arItem['ID']?>"
						 data-price = "<?=$arItem['PRICE_DISCOUNT_VALUE']?>"
						 data-oldprice = "<?=$arItem['PRICE_VALUE']?>"
						 data-discount = "<?=$arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE']?>
				 ">
					<div class = "pic">
						<a href = "<?=$arItem['DETAIL_PAGE_URL']?>">
							<img id="imgItem<?=$arItem['ID']?>" src = "<?=$arItem["DETAIL_PICTURE"]["src"] ? $arItem["DETAIL_PICTURE"]["src"] : $arResult['NO_PHOTO']['src']?>" alt = "<?=$arItem["NAME"]?>">
						</a>
					</div>
					<div class = "data">
						<div class = "name">
							<a class = "aprimary" href = "<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a>
						</div>
						<div class = "prices">
							<? if($arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE'] > 0): ?>
									<div class = "price old">
										<?=$arItem['PRICE_PRINT_VALUE']?>
									</div>
									<div class = "price cool">
										<?=$arItem['PRICE_PRINT_DISCOUNT_VALUE']?>
									</div>
								<? else: ?>
									<div class = "price cool">
										<?=$arItem['PRICE_PRINT_VALUE']?>
									</div>
								<? endif; ?>
						</div>	
					</div>
				</div>
				<? foreach ($arResult["SET_ITEMS"]["DEFAULT"] as $index => $arItem): ?>
					<div class = "item" 
						 data-elementid="<?=$arItem['ID']?>"
						 data-price = "<?=$arItem['PRICE_DISCOUNT_VALUE']?>"
						 data-oldprice = "<?=$arItem['PRICE_VALUE']?>"
						 data-discount = "<?=$arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE']?>
					">
						<div class = "remove"></div>
						<div class = "pic">
							<a href = "<?=$arItem['DETAIL_PAGE_URL']?>">
								<img id="imgItem<?=$arItem['ID']?>" src = "<?=!empty($arItem["DETAIL_PICTURE"]["src"]) ? $arItem["DETAIL_PICTURE"]["src"]:$arResult["NO_PHOTO"]["src"]?>" alt = "<?=$arItem["NAME"]?>">
							</a>
						</div>
						<div class = "data">
							<div class = "name">
								<a class = "aprimary" href = "<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a>
							</div>
							<div class = "prices">
								<? if($arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE'] > 0): ?>
										<div class = "price old">
											<?=$arItem['PRICE_PRINT_VALUE']?>
										</div>
										<div class = "price new cool">
											<?=$arItem['PRICE_PRINT_DISCOUNT_VALUE']?>
										</div>
									<? else: ?>
										<div class = "price cool">
											<?=$arItem['PRICE_PRINT_VALUE']?>
										</div>
									<? endif; ?>
							</div>	
						</div>
						<div class = "separator plus"></div>
					</div>	
				<? endforeach; ?>
			</div>
			
			<div class="panel panel-default">
		  		<div class="panel-body set-panel">
					<div class = "row">
						<div class = "col col-md-6">
							<a href = "#set_constructor" class = "btn btn-default my-sets_link"><?=Loc::getMessage('MY_SET')?></a>
						</div>
						<div class = "col col-md-6">
							<div class = "row">
								<div class = "col col-md-12 rightpart clearfix">
									<div class = "pull-left">
										<? if($arResult['SET_ITEMS']['OLD_PRICE'] != 0): ?>
										<?=Loc::getMessage('CONTRACT_PRICE');?>: <span class = "price old"><?=$arResult['SET_ITEMS']['OLD_PRICE']; ?></span><br>
										<? endif; ?>
										<span class = "price cool"><?=$arResult['SET_ITEMS']['PRICE']; ?></span>
											<span class = "text-danger">
												<?=Loc::getMessage('YOUR_PROFIT');?>: 
												<span class = "price discount"><?=$arResult['SET_ITEMS']['PRICE_DISCOUNT_DIFFERENCE']?></span>
											</span>
									</div>
									<div class = "pull-right rightpart hidden-xs hidden-sm">
										<a class = "btn btn-primary set_add2basket"><?=Loc::getMessage('IN_BASKET')?></a>
										<a class = "btn btn-default fancyajax fancybox.ajax setbuy1click" 
										   href = "<?=SITE_DIR?>forms/buy1click/" 
										   title="<?=Loc::getMessage('BUY_1CLICK')?>"><?=Loc::getMessage('BUY_1CLICK')?></a>
									</div>
								</div>
								<div class = "col col-md-12 hidden-lg hidden-md rightpart">
									<a class = "btn btn-primary set_add2basket"><?=Loc::getMessage('IN_BASKET')?></a>
									<a class = "btn btn-default fancyajax fancybox.ajax setbuy1click" 
									   href = "<?=SITE_DIR?>forms/buy1click/" 
									   title="<?=Loc::getMessage('BUY_1CLICK')?>"><?=Loc::getMessage('BUY_1CLICK')?></a>

								</div>
							</div>
						</div>
					</div>
		  		</div>	
			</div>
			
			<div
                class = "allitems owlslider set my-set owl" 
                style = "display: none;"
                data-margn = "24",
                data-nav = "true",
                data-loop = "false"
                data-responsive = '{"0":{"items":"2"},"768":{"items":"3"}, "956":{"items":"4"}}'
            >
				<? foreach (array("DEFAULT", "OTHER") as $type): ?>	
					<? foreach ($arResult["SET_ITEMS"][$type] as $arItem): ?>
						<div class = "item" 
							 data-elementid="<?=$arItem['ID']?>"
							 data-price = "<?=$arItem['PRICE_DISCOUNT_VALUE']?>"
							 data-oldprice = "<?=$arItem['PRICE_VALUE']?>"
							 data-discount = "<?=$arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE']?>
						">
							<div class = "checkbox <?=$type=="DEFAULT"?"selected":""?>">
							</div>
							<div class = "pic">
								<a href = "<?=$arItem['DETAIL_PAGE_URL']?>">
									<img id="imgItem<?=$arItem['ID']?>" src = "<?=!empty($arItem["DETAIL_PICTURE"]["src"]) ? $arItem["DETAIL_PICTURE"]["src"]:$arResult["NO_PHOTO"]["src"]?>" alt = "<?=$arItem["NAME"]?>">
								</a>
							</div>
							<div class = "data">
								<div class = "name">
									<a class = "aprimary" href = "<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a>
								</div>
								<div class = "prices">
									<? if($arItem['PRICE_DISCOUNT_DIFFERENCE_VALUE'] > 0): ?>
											<div class = "price old">
												<?=$arItem['PRICE_PRINT_VALUE']?>
											</div>
											<div class = "price new cool">
												<?=$arItem['PRICE_PRINT_DISCOUNT_VALUE']?>
											</div>
										<? else: ?>
											<div class = "price cool">
												<?=$arItem['PRICE_PRINT_VALUE']?>
											</div>
										<? endif; ?>
								</div>	
							</div>

						</div>	
					<? endforeach; ?>
				<? endforeach; ?>
			</div>
			
		</div>
	
	</div>
</div>