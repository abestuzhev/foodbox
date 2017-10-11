<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

if ($arParams['DISPLAY_TOP_PAGER'] == 'Y') {
    echo $arResult['NAV_STRING'];
}
ob_start();
?>

<?php if (!(is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)): ?>
    <div class="alert alert-info" role="alert">
        <?= Loc::getMessage('RS.MONOPOLY.NO_PRODUCTS') ?>
    </div>
    <?php $templateData = ob_get_flush(); ?>
    <? return; ?>
<?php endif; ?>


<?
if ($isAjaxShowMore) {
    $APPLICATION->RestartBuffer();
}
?>
<section id="promoSlider" class="sidePromotion">
		<div data-bcid="mp_block_day" data-bcp="2" class="bc bcSmall">
			<div class="sidePromotion_title">Товар дня</div>
			<div class="sidePromosSliderWrap">
				<div id="day">
					<div class="swiper-container swiper-container--good-of-day swiper-container-horizontal">
						<div class="swiper-wrapper">
    <?php foreach ($arResult['ITEMS'] as $key => $arItem): ?>
        <?php
        $this->AddEditAction(
                $arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT')
        );
        $this->AddDeleteAction(
                $arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID(
                        $arParams['IBLOCK_ID'], 'ELEMENT_DELETE'
                ), array(
            'CONFIRM' => Loc::getMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')
                )
        );

        $haveOffers = false;
        if (!empty($arItem['OFFERS'])) {
            $haveOffers = true;
            $product = &$arItem['OFFERS'][0];
        } else {
            $product = &$arItem;
        }
        ?>
		<article data-product-id="<?=$arItem["ID"]?>" data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>" data-product-title="<?=$arItem["NAME"]?>" class="product prod<?=$arItem["ID"]?> js-element in" data-swiper-slide-index="<?=count($arResult["ITEMS"])?>">
		
			<div class="js-list-prod_fav-item prod_fav">
				<div class="name" style="display:none"><a><?=$arItem['NAME']?></a></div>
				<span class="align_helper"></span>
				<span class="font-icon-heart-empty js-btn_fav btn_fav" data-object="catalog" data-object-id="<?=$arItem["ID"]?>" data-image="<?php
                                if (!empty($arItem['FIRST_PIC']['RESIZE']['src']) && trim($arItem['FIRST_PIC']['RESIZE']['src']) != ''):
                                    ?>
										<?= $arItem['FIRST_PIC']['RESIZE']['src'] ?>
                                    <?php else: ?>
										<?= $arResult['NO_PHOTO']['src'] ?>
                                    <?php endif; ?>"></span>
			</div>
			<? if($arResult["ITEMS"][0]["PROPERTIES"]["SHILDIK"]["VALUE_ENUM_ID"] == 18): ?>
			<span class="labels ">
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
					<span class="badge action" data-keep-on-tip="false" data-show-event="mouseenter" data-tooltip="ТОВАР ДНЯ">акция</span>
				</a>
			</span>
			<? elseif($arResult["ITEMS"][0]["PROPERTIES"]["SHILDIK"]["VALUE_ENUM_ID"] == 19):?>
			<span class="labels new">
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
					<span class="badge action" data-keep-on-tip="false" data-show-event="mouseenter" data-tooltip="ТОВАР ДНЯ">новинка</span>
				</a>
			</span>
			<? elseif($arResult["ITEMS"][0]["PROPERTIES"]["SHILDIK"]["VALUE_ENUM_ID"] == 34):?>
			<span class="labels sale">
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
					<span class="badge action" data-keep-on-tip="false" data-show-event="mouseenter" data-tooltip="ТОВАР ДНЯ">скидка</span>
				</a>
			</span>
			<? endif; ?>
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="product-list-item-link ">
				<figure><span class="product_img pic"><img alt="<?=$arItem['NAME']?>" src="<?php
                                if (!empty($arItem['FIRST_PIC']['RESIZE']['src']) && trim($arItem['FIRST_PIC']['RESIZE']['src']) != ''):
                                    ?>
										<?= $arItem['FIRST_PIC']['RESIZE']['src'] ?>
                                    <?php else: ?>
										<?= $arResult['NO_PHOTO']['src'] ?>
                                    <?php endif; ?>"></span>
					<figcaption>
					
						<span class="productHeader"><?=$arItem['NAME']?></span>
						<span class="productDescription productDescription--hide">Куплено <span>1555</span> раз<small>артикул <?=$arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></small></span>
						<noindex>
							<span class="productDescription"><?=$arItem["PREVIEW_TEXT"]?></span>
						</noindex>

						<span class="productArticule">Артикул <span><?=$arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span></span>
						<? if($arItem["CATALOG_AVAILABLE"] == "Y"): ?>
							<span class="productAvailability">Наличие на складе: <span class="productAvailability-yes">Да</span></span>
						<? else: ?>
							<span class="productAvailability">Наличие на складе: <span class="productAvailability-no">Нет</span></span>
						<? endif; ?>
					</figcaption>
				</figure>
				<span class="price"><span class="priceWrap"><?=$arItem["MIN_PRICE"]["VALUE"]?></span><span> р./<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?> </span></span>
			</a>
			<!--add-->
			
				<form
                                                class="
                                                add2basketform 
                                                js-buyform<?= $arItem['ID'] ?>
                                                <?php
													if (!$product['CAN_BUY']) 
													echo 'cantbuy';
												
                                                ?>
                                                "
                                                name="add2basketform"
												action="<?=$arItem['DETAIL_PAGE_URL']?>"
                                                >

                                               
                                                        <input type="hidden" class="js-quantity text-center" name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>" value="<?= $arItem['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? $arResult['START_MEASURE_RATIO'] : $arItem['CATALOG_MEASURE_RATIO'] ?>" data-ratio="<?= $arItem['CATALOG_MEASURE_RATIO'] ?>" id="bx_quantity_<?= $arItem['ID'] ?>">
                                                
                                              


                                                <input type="hidden" name="action" value="ADD2BASKET">
                                                <input
                                                    type="hidden" 
                                                    name="<?= $arParams['PRODUCT_ID_VARIABLE'] ?>" 
                                                    class="js-add2basketpid" 
                                                    value="<?= $product['ID'] ?>"
                                                    >
                                                <button type="submit" rel="nofollow" class="submit js-add2basketlink" value="">
                                                    Купить
                                                </button>
                                                
												<a class="inbasket" href="<?= $arParams['BASKET_URL'] ?>">В корзине</a>
                                                
                                            </form>
				
				
			<!--end add-->
		</article>
		
		
         <?
        if ($arItem['CATALOG_MEASURE'] == 4 && $arItem['SHOW_NEW_RATIO']) {
            $arJSParams = array(
                'ID' => $arItem['ID'],
                'START_RATIO' => $arItem['START_MEASURE_RATIO'],
                'MIDDLE_RATIO' => $arItem['MIDDLE_MEASURE_RATIO'],
                'RATIO' => $arItem['NEXT_MEASURE_RATIO'],
            );
            $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
            ?>
            <script type="text/javascript">
                var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
            </script>
        <? } ?>

          
    <? endforeach; ?>

<?



$templateData = ob_get_flush();
?>
</div>
					<div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
					<div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
					</div>
				</div>
			</div>
		</div>
	</section>
