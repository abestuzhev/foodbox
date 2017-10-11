<?php

use \Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

if(!is_array($arResult['ITEMS']) || count($arResult['ITEMS'])<1) {
	return;
}
?>

<div class = "row section-cart">
    <div class = "col col-md-12">
        <h2 class="coolHeading">
			<span class="secondLine"><?=$title?></span>
		</h2>
    </div>
    <div class = "col col-md-12 products showcase owlslider owl"
        data-margin = "35"
        data-items = "5"
        data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"4"}, "956":{"items":"5"}}'
    >
        <?php foreach($arResult['ITEMS'] as $arItem): ?>
            <?php 
                $product = &$arItem;
                if(!empty($arItem['OFFER']) && count($arItem) > 0) {
                    $product = &$arItem['OFFER'][0];
                }
                
                $arImage = null;
                if(!empty($product['DETAIL_PICTURE'])) {
                    $arImage = $product['DETAIL_PICTURE'];
                } elseif($product['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'][0]) {
                    $arImage = $product['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'][0];
                } else {
                    $arImage = $arItem['FIRST_PIC'];
                }
            ?>
            
		<div class = "item 
                js-element
                <?=isset($arItem['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2'])? "da2" : ""?>
                <?=isset($arItem['QUICKBUY']) || isset($PRODUCT['QUICKBUY'])? "qb" : ""?>" 
            >
			<div class="in">
                <div class="da2_icon hidden-xs"><?=GetMessage('DA2_ICON_TITLE')?></div>
                <div class="qb_icon hidden-xs"><?=GetMessage('QB_ICON_TITLE')?></div>
                <?if ($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]):?>
					<div class="<?=(strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : 'new_icon'?> hidden-xs"><?=$arItem["PROPERTIES"]["SHILDIK"]["VALUE"]?></div>
				<?endif;?>
                <div class = "pic">
                    <a class="js-detail_page_url" href="<?=$product['DETAIL_PAGE_URL']?>">
                        <?php 
                            if(!empty($arImage)):
                        ?>
                            <img 
                                src="<?=$product['FIRST_PIC']['RESIZE']['src']?>"
                                alt="<?=$product['FIRST_PIC']['ALT']?>" 
                                title="<?=$product['FIRST_PIC']['TITLE']?>"
                            >
                        <?php else: ?>
                            <img 
                                src="<?=$arResult['NO_PHOTO']['src']?>"
                                title="<?=$product['NAME']?>"
                                alt="<?=$product['NAME']?>"
                            >
                        <?php endif; ?>
                    </a>
                </div>
                <div class = "data">
                    <div class = "name">
                        <a class="aprimary"
                            href="<?=$arItem['DETAIL_PAGE_URL']?>"
                            title="<?=$arItem['NAME']?>"
                        >
                            <?=$arItem['NAME']?>
                        </a><br>
                    </div>
                    <div class = "row buy">
                        <div class = "col col-xs-6 prices">
                            <?php if((int) $product['MIN_PRICE']['DISCOUNT_DIFF']): ?>
                                <div class="price old"
                                    ><?=$product['MIN_PRICE']['PRINT_VALUE']?>/<?=$product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                </div>
                                <div class="price cool new">
                                    <?=$product['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>/<?=$product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                </div>
                            <?php else: ?>
                                <div class="price cool">
                                    <?=$product['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>/<?=$product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
					
					<div class="row bot">	
						<div class="col col-xs-6 text-right buybtn">
							<?php if($HAVE_OFFERS): ?>
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn-primary">
									<?=Loc::getMessage('RS.MONOPOLY.BTN_MORE')?>
								</a>
							<?php else: ?>
								<noindex>
									<form
										class="
											add2basketform
											js-buyform<?=$arItem['ID']?>
											<?=!$product['CAN_BUY'] ? 'cantbuy' : ''?>
											<?=$arParams['USE_PRODUCT_QUANTITY'] ? 'usequantity' : ''?>
										"
										name="add2basketform"
									>
										<input type="hidden" name="action" value="ADD2BASKET">
										<input 
											type="hidden" 
											name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" 
											class="js-add2basketpid" value="<?=$product['ID']?>"
										>
										
										<button type="submit" rel="nofollow" class="btn btn-primary submit js-add2basketlink" value="">
											<?=Loc::getMessage('RS.MONOPOLY.BTN_BUY')?>
										</button>
										<a class="btn btn-primary inbasket" href="<?=$arParams['BASKET_URL']?>">
											<?=Loc::getMessage('RS.MONOPOLY.BTN_GO2BASKET')?>
										</a>
									</form>
								</noindex>
							<?php endif; ?>
						</div>
						
						<?php if($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y"): ?>
							<div class="favorite favorite-heart"
								 data-elementid = "<?=$arItem['ID']?>"
								 data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>"
							>
							</div>
						<?php endif;?>
					
					</div>
					
                </div>
            </div>
		</div>
        <?php endforeach; ?>
    </div>
</div>