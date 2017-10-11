<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

use \Bitrix\Main\Security\Sign\Signer;
use    \Bitrix\Main\Localization\Loc;

$frame = $this->createFrame()->begin("");
$injectId = 'bigdata_recommeded_products_'.rand();
?>
<script>
    BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
    BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
    BX.current_server_time = '<?=time()?>';

    BX.ready(function(){
        bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
    });
</script>

<?php if(isset($arResult['REQUEST_ITEMS'])): ?>

    <?php 
    CJSCore::Init(array('ajax'));
    $signer = new Signer;
    $signedParameters = $signer->sign(
        base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
        'bx.bd.products.recommendation'
    );
    
    $signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');
    ?>
    <div id="<?=$injectId?>" class="bigdata_recommended_products_container"></div>
    <script>
        BX.ready(function() {
            bx_rcm_get_from_cloud(
                '<?=CUtil::JSEscape($injectId)?>',
                <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
                {
                    'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
                    'template': '<?=CUtil::JSEscape($signedTemplate)?>',
                    'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
                    'rcm': 'yes'
                }
            );
        });
    </script>
    
    <?php 
    $frame->end();
    return;    
    ?>
    
<?php endif; ?>

<?php if(!empty($arResult['ITEMS'])): ?>
    <div id="<?=$injectId?>_items" class="bigdata_recommended_products_items section-cart row">
        <input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
        <div class="col col-md-12">
            <h2 class="coolHeading">
                <span class="secondLine"><?=Loc::getMessage("RS.MONOPOLY.RCM");?></span>
            </h2>
        </div>
        <div class="col-md-12">
            <div class="products showcase little owlslider owlbigdata" 
                data-items = "<?=$arParams['SIDEBAR'] == "Y"? 3 : 5;?>"
				data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"4"}, "956":{"items":"5"}}'
            >
                <?php foreach($arResult['ITEMS'] as $arItem): ?>
                    <?php
                    if(empty($arItem['OFFERS'])) { 
                        $HAVE_OFFERS = false; $PRODUCT = &$arItem;
                    } else { 
                        $HAVE_OFFERS = true; $PRODUCT = &$arItem['OFFERS'][0];
                    }
                    ?>
                    
                    <div class ="
                                    item
                                    js-element
                                    js-elementid<?=$arItem['ID']?>
                                "
                        data-elementid="<?=$arItem['ID']?>"
                        data-detailpageurl="<?=$arItem['DETAIL_PAGE_URL']?>"
                    >
                    
                        <div class="in">
							<?if ($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]):?>
								<div class="<?=(strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : 'new_icon'?> hidden-xs"><?=$arItem["PROPERTIES"]["SHILDIK"]["VALUE"]?></div>
							<?endif;?>
							
                            <div class="pic">
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <?php if(!empty($arItem['FIRST_PIC'])): ?>
                                    <img id="imgItem<?=$arItem['ID']?>" src="<?=$arItem['FIRST_PIC']['RESIZE']['src']?>"
                                        alt="<?=$arItem['FIRST_PIC']['ALT']?>" 
                                    >
                                <?php else: ?>
                                
                                    <img id="imgItem<?=$arItem['ID']?>" src="<?=$arResult['NO_PHOTO']['src']?>"
                                        alt="<?=$arItem['NAME']?>"
                                    >
                                <?php endif; ?>
                                </a>
                            </div>
                            <div class="data">
                            
                                <?php if($arParams['SHOW_NAME'] == "Y"): ?>                                    
                                    <div class="name bigdata">
                                        <a class="aprimary" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                            <?=$arItem['NAME']?></a><br>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="row buy">
                                
                                    <div class="col col-xs-6 prices">
                                    
                                        <?php if((int)$PRODUCT['MIN_PRICE']['DISCOUNT_DIFF'] > 0): ?>
                                            <div class="price old">
                                                <?=$PRODUCT['MIN_PRICE']['PRINT_VALUE']?>/<?=$PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                            </div>
                                            <div class="price cool new">
                                                <?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>/<?=$PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                            </div>
                                        <?php else: ?>
                                            <div class="price cool">
                                                <?=$PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?>/<?=$PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="row bot">
									
                                    <div class="col col-md-12 text-center buybtn">
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
                                                        <?=!$PRODUCT['CAN_BUY'] ? 'cantbuy' : ''?>
                                                        <?=$arParams['USE_PRODUCT_QUANTITY'] ? 'usequantity' : ''?>
                                                    "
                                                    name="add2basketform"
                                                >
													<?if($arParams['USE_PRODUCT_QUANTITY']){
														
														?><span class="quantity"><?
															?><a class="minus js-minus"><i class="fa"></i></a><?
															?><input onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" type="text" class="js-quantity text-center" name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>" value="<?=$arItem['CATALOG_MEASURE_RATIO']?>" data-ratio="<?=$arItem['CATALOG_MEASURE_RATIO']?>"><?
															?><a class="plus js-plus"><i class="fa"></i></a><?
															?><span class="js-measurename"><?=$arItem['CATALOG_MEASURE_NAME']?></span><?
														?></span><?
														
													}?>
                                                    <input type="hidden" name="action" value="ADD2BASKET">
                                                    <input 
                                                        type="hidden" 
                                                        name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" 
                                                        class="js-add2basketpid" value="<?=$PRODUCT['ID']?>"
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
    </div>
<?php endif; ?>

<?php
$frame->end();