<?php

use \Bitrix\Main\Localization\Loc;

function showItems($arItems, $arParams) {
    foreach($arItems as $arItem) {
        if(!empty($arItem['OFFERS'])) {
            foreach($arItem['OFFERS'] as $arOffer) {
                showItem($arItem, $arParams, $arOffer);
            }
        } else {
            showItem($arItem, $arParams);
        }
    }
}

function showItem($arItem, $arParams, $product = null) {
    
    global $arResult;

    if(!$product) {
        $product = &$arItem;
    }
    
    $arImage = array();
    if(!empty($arItem['OFFERS'])) {
        if(!empty($product['DETAIL_PICTURE'])) {
            $arImage = $product['DETAIL_PICTURE'];
        } elseif(!empty($product['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'][0])) {
            $arImage = $product['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'][0];
        }
    } else {
        $arImage = $arItem['FIRST_PIC'];
    }
    ?>
    <div class = "item 
        js-element
        <?= isset($arItem['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2'])? "da2" : ""?>
        <?= isset($arItem['QUICKBUY']) || isset($PRODUCT['QUICKBUY'])? "qb" : ""?>" 
    >
        <div class="da2_icon hidden-xs"><?=Loc::getMessage('DA2_ICON_TITLE')?></div>
        <div class="qb_icon hidden-xs"><?=Loc::getMessage('QB_ICON_TITLE')?></div>
        <div class="product-icons">
            <?php if($product['CAN_BUY']): ?>
                <form class="add2basketform js-buyform<?=$arItem['ID']?>" name="add2basketform">
                    <input type="hidden" name="action" value="ADD2BASKET">
                    <input type="hidden" name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" class="js-add2basketpid" value="<?=$product['ID']?>">
                    <button type="submit" class="product-icons_icon add2basket-icon submit js-add2basketlink"></button>
                    <a class="inbasket product-icons_icon add2basket-icon" href="<?=$arParams['BASKET_URL']?>"></a>
                </form>
            <?php endif; ?>
        </div>
        
        <div class = "pic">
            <a class="js-detail_page_url" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <?php if(isset($arImage['RESIZE']['src']) && trim($arImage['RESIZE']['src'])!=''): ?>
                    <img 
						id="imgItem<?=$arItem['ID']?>"
                        src="<?=$arImage['RESIZE']['src']?>" 
                        alt="<?=$arImage['ALT']?>"
                    />
                <?php else: ?>
                    <img
						id="imgItem<?=$arItem['ID']?>"
                        src="<?=$arResult['NO_PHOTO']['src']?>" 
                        alt="<?=$arItem['NAME']?>"
                    />
                <?php endif; ?>
            </a>
        </div>
        <div class = "data">
            <div class="js-vardump" style="display: none;">
                <? var_dump($product['CAN_BUY']); ?>
            </div>
            <div class = "name">
                <a class="aprimary" href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>">
                    <?=$arItem['NAME']?>
                </a><br />
            </div>
            <div class = "buy">
            
                <div class = "prices">
                    <?php if((int) $product['MIN_PRICE']['DISCOUNT_DIFF']): ?>
                        <div class="price old"><?=$product['MIN_PRICE']['PRINT_VALUE']?></div>
                        <div class="price cool new"><?=$product['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
                    <?php else: ?>
                        <div class="price cool"><?=$product['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?
}