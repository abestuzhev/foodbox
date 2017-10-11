<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php 
if(!is_array($arResult['ITEMS']) || count($arResult['ITEMS'])<1)
	return;
?>
<div class = "row">
	<div class = "col col-md-12 section-cart sale-recommended">
		<div class = "section-cart_title">
			<span><?=GetMessage('RS.MONOPOLY.SLP_TITLE')?></span>
		</div>
		<div 
            class = "products owlslider owl"
            data-margin = "35"
            data-items = "6"
            data-responsive = '{"0":{"items":"2"},"768":{"items":"4"}, "956":{"items":"6"}}'
        >
			<? foreach ($arResult['ITEMS'] as $arItem):
					if(empty($arItem['OFFERS'])){ $HAVE_OFFERS = false; $PRODUCT = &$arItem; } else { $HAVE_OFFERS = true; $PRODUCT = &$arItem['OFFERS'][0]; }
			?>
				<div class = "item 
							js-element
							<?= isset($arItem['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2'])? "da2" : ""?>
							<?= isset($arItem['QUICKBUY']) || isset($PRODUCT['QUICKBUY'])? "qb" : ""?>" 
				>
				<div class="da2_icon hidden-xs"><?=GetMessage('DA2_ICON_TITLE')?></div>
				<div class="qb_icon hidden-xs"><?=GetMessage('QB_ICON_TITLE')?></div>
					<?
						if($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y") {
							?><div 
								class = "favorite favorite-heart" 
								data-elementid = "<?=$arItem['ID']?>"
								data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>"
							>
							</div><?
						}
					?>
					<div class = "pic">
						<a class="js-detail_page_url" href="<?=$PRODUCT['DETAIL_PAGE_URL']?>"><?
							if( isset($PRODUCT['FIRST_PIC']['RESIZE']['src']) && trim($arItem['FIRST_PIC']['RESIZE']['src'])!='' ) {
								?><img id="imgItem<?=$arItem['ID']?>" src="<?=$PRODUCT['FIRST_PIC']['RESIZE']['src']?>" alt="<?=$PRODUCT['FIRST_PIC']['ALT']?>" /><?
							} else {
								?><img id="imgItem<?=$arItem['ID']?>" src="<?=$arResult['NO_PHOTO']['src']?>" alt="<?=$PRODUCT['NAME']?>" /><?
							}
						?></a>
					</div>
					<div class = "data">
						<div class = "name">
							<a class="aprimary" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a><br />
						</div>
						<div class = "buy">
						
							<div class = "prices">
								<?if( IntVal($PRODUCT['MIN_PRICE']['DISCOUNT_DIFF'])>0 ) {
									?><div class="price old"><?=$PRODUCT['MIN_PRICE']['PRINT_VALUE']?></div><?
									?><div class="price cool new"><?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div><?
								} else {
									?><div class="price cool"><?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div><?
								}?>
							</div>
						</div>
					</div>
				</div>
			<? endforeach; ?>
		</div>
	</div>
</div>