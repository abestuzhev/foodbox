<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$this->setFrameMode(true);
if (empty($arResult['OFFERS'])) {
    $HAVE_OFFERS = false;
    $PRODUCT = &$arResult;
} else {
    $HAVE_OFFERS = true;
    $PRODUCT = &$arResult['OFFERS'][0];
}

// pictures
$arImages = array();
$offerId = (int) $_GET['OFFER_ID'];
if ($HAVE_OFFERS) {
    foreach ($arResult['OFFERS'] as $key1 => $arOffer) {

        //if($arOffer['ID'] == $offerId) {
        //    $PRODUCT = &$arResult['OFFERS'][$key1];
        //}

        if (is_array($arOffer['DETAIL_PICTURE']['RESIZE'])) {
            $arImages[] = array(
                'DATA' => array(
                    'OFFER_KEY' => $key1,
                    'OFFER_ID' => $arOffer['ID'],
                ),
                'PIC' => $arOffer['DETAIL_PICTURE'],
            );
        }
        if (is_array($arOffer['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'][0]['RESIZE'])) {
            foreach ($arOffer['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_MORE_PHOTO']]['VALUE'] as $arImage) {
                $arImages[] = array(
                    'DATA' => array(
                        'OFFER_KEY' => $key1,
                        'OFFER_ID' => $arOffer['ID'],
                    ),
                    'PIC' => $arImage,
                );
            }
        }
    }
}
if (is_array($arResult['DETAIL_PICTURE']['RESIZE'])) {
    $arImages[] = array(
        'DATA' => array(
            'OFFER_KEY' => 0,
            'OFFER_ID' => 0,
        ),
        'PIC' => $arResult['DETAIL_PICTURE'],
    );
}
if (is_array($arResult['PROPERTIES'][$arParams['RSMONOPOLY_PROP_MORE_PHOTO']]['VALUE'][0]['RESIZE'])) {
    foreach ($arResult['PROPERTIES'][$arParams['RSMONOPOLY_PROP_MORE_PHOTO']]['VALUE'] as $arImage) {
        $arImages[] = array(
            'DATA' => array(
                'OFFER_KEY' => 0,
                'OFFER_ID' => 0,
            ),
            'PIC' => $arImage,
        );
    }
}


// multy price
$i = 0;
if (is_array($arResult['CAT_PRICES']) && count($arResult['CAT_PRICES']) > 0) {
    foreach ($arResult['CAT_PRICES'] as $PRICE_CODE => $arPrice) {
        if (!$arPrice['CAN_VIEW']) {
            continue;
        }
        $i++;
    }
}
$multyPrice = ( $i > 1 ? true : false );
$multyPrice = ( $multyPrice && is_array($PRODUCT['PRICES']) && count($PRODUCT['PRICES']) > 1 ? true : false );

// TIMERS
$arTimers = array();
if ($arResult['HAVE_DA2'] == 'Y') {
    if (isset($arResult['DAYSARTICLE2'])) {
        $arTimers[] = $arResult['DAYSARTICLE2'];
    } elseif ($HAVE_OFFERS) {
        foreach ($arResult['OFFERS'] as $arOffer) {
            if (isset($arOffer['DAYSARTICLE2'])) {
                $arTimers[] = $arOffer['DAYSARTICLE2'];
            }
        }
    }
}
if ($arResult['HAVE_QB'] == 'Y') {
    if (isset($arResult['QUICKBUY'])) {
        $arTimers[] = $arResult['QUICKBUY'];
    } elseif ($HAVE_OFFERS) {
        foreach ($arResult['OFFERS'] as $arOffer) {
            if (isset($arOffer['QUICKBUY'])) {
                $arTimers[] = $arOffer['QUICKBUY'];
            }
        }
    }
}

$tabDescription = ($arResult['DETAIL_TEXT'] != '') ? true : false;
$tabProperties = (is_array($arResult['DISPLAY_PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) > 0) ? true : false;
$tabDocs = false;
?><div class="row"><?
?><div class="js-detail <?
?>js-element <?
?>js-elementid<?= $arResult['ID'] ?> <?
?>col col-md-12 <?
         if (isset($arResult['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2'])) {
             echo ' da2';
         }
         if (isset($arResult['QUICKBUY']) || isset($PRODUCT['QUICKBUY'])) {
             echo ' qb';
         }
         ?>" <?
         ?>data-elementid="<?= $arResult['ID'] ?>" <?
         ?>data-detailpageurl="<?= $arResult['DETAIL_PAGE_URL'] ?>" <?
         ?>data-elementname="<?= CUtil::JSEscape($arResult['NAME']) ?>" <? ?>data-curerntofferid="<?= $PRODUCT['ID'] ?>" <? ?>><?
         ?><div class="row"><?
         ?><div class="col col-md-8"><?
         ?><div class="row"><?
         ?><div class="col col-md-<? if ($arParams['HEAD_TYPE'] == 'type3'): ?>6<? else: ?>5<? endif; ?>"><?
         ?><div class="row"><?
                        // general picture
                        ?><div class="col col-md-12 pic">
                                <div class="backLink">&lt; <a title="<?= $arResult["SECTION"]["NAME"] ?>" href="<?= $arResult["SECTION"]["SECTION_PAGE_URL"] ?>">Назад к списку товаров</a></div><?
                        ?><div class="da2_icon hidden-xs"><?= GetMessage('DA2_ICON_TITLE'); ?></div><?
                        ?><div class="qb_icon hidden-xs"><?= GetMessage('QB_ICON_TITLE'); ?></div><?
                                /* ?><div class="product-icons ri visible-xs"><?
                                  ?><div class="product-icons_icon favorite-icon favorite" data-elementid = "<?=$arResult['ID']?>" data-detailpageurl="<?=$arResult['DETAIL_PAGE_URL']?>"></div><?
                                  ?><div class="product-icons_icon compare-icon js-compare"></div><?
                                  ?></div><? */

                                if (is_array($arImages) && count($arImages) > 0) {
                                    ?><div <?
                                    ?>class="js-general_images"<? ?>><?
                                        $cellImg = 0;
                                        foreach ($arImages as $arImage) {
                                            if (IntVal($arImage['DATA']['OFFER_ID']) > 0 && $arImage['DATA']['OFFER_ID'] != $PRODUCT['ID']) {
                                                continue;
                                            }
                                            ?><div class="
                                                 changeFromSlider 
                                                 fancybox.ajax
                                                 fancyajax
                                                 <?= (int) $arImage['DATA']['OFFER_ID'] > 0 ? 'imgoffer' : '' ?>"  
                                                 href="<?= $arResult["DETAIL_PAGE_URL"] ?>?OFFER_ID=<?= $PRODUCT["ID"] ?>" title="<?= $arResult["NAME"] ?>"><?
                                                 ?><img <?= (!$cellImg) ? 'id="imgItem' . $arResult['ID'] . '"' : '' ?> src="<?= $arImage['PIC']['SRC'] ?>" alt="<?= $arImage['PIC']['ALT'] ?>" data-index="<?= $arImage['PIC']['ID'] ?>"><?
                                                 ?></div><?
                                            $cellImg++;
                                        }
                                        ?></div><?
                                    } else {
                                        ?><img id="imgItem<?= $arResult['ID'] ?>" src="<?= $arResult['NO_PHOTO']['src'] ?>" alt="<?= $arResult['NAME'] ?>" /><?
                                    }
                                    ?></div><?
                            // slider
                            if (is_array($arImages) && count($arImages) > 0) {
                                ?><div class="col col-md-12 hidden-xs"><?
                                ?><div class="thumbs" ><?
                                ?><div class="owlslider images js-images owl" data-margin="15" data-responsive='{"0":{"items": "2"},"768":{"items": "3"}}'><?
                                        $index = 0;
                                        foreach ($arImages as $arImage) {
                                            if (IntVal($arImage['DATA']['OFFER_ID']) > 0 && $arImage['DATA']['OFFER_ID'] != $PRODUCT['ID']) {
                                                continue;
                                            }
                                            ?><div class="changeimage scrollitem <?
                                            ?>pic<?= $arImage['PIC']['ID'] ?> <? if ($index < 1) { ?>checked <? }
                                            ?>thumb <? if (IntVal($arImage['DATA']['OFFER_ID']) > 0) { ?> imgoffer imgofferid<?= $arImage['DATA']['OFFER_ID'] ?><? }
                                            ?>"><?
                                            ?><a href="<?= $arImage['PIC']['SRC'] ?>" data-index="<?= $arImage['PIC']['ID'] ?>" style="background-image: url('<?= $arImage['PIC']['RESIZE']['src'] ?>');"><?
                                            ?><div class="overlay"></div><?
                                            ?><i class="fa"></i><?
                                            ?></a><?
                                            ?></div><?
                                                $index++;
                                            }
                                            ?></div><?
                                            ?></div><?
                                            ?></div><?
                            }
                            ?></div><?
                            ?></div><?
                            ?><div class="col col-md-<? if ($arParams['HEAD_TYPE'] == 'type3'): ?>6<? else: ?>7<? endif; ?>"><?
                            ?><div class="row element-detail-header"><?
                        // breaadcrumb and title
                        ?><div class="col col-md-12 brcrtitle"><?
                        ?><div class="brcr"></div><?
                        ?><div class="ttl"></div><?
                                /* ?><div class="row"><div class="col col-md-12 text-right"><?
                                  $articleSku = $PRODUCT['PROPERTIES'][$arParams['RSMONOPOLY_PROP_SKU_ARTICLE']]['VALUE'];
                                  $article = ( (isset($articleSku) && $articleSku!='') ? $articleSku : $PRODUCT['PROPERTIES'][$arParams['RSMONOPOLY_PROP_ARTICLE']]['VALUE'] );
                                  if( isset($article) && $article!='' ) {
                                  ?><span><?=GetMessage('RS.MONOPOLY.ARTICLE')?>: <span class="js-article" <?
                                  ?>data-prodarticle="<?=$article?>"><?=$article?></span></span><?
                                  } else {
                                  ?><span style="display:none;"><?=GetMessage('RS.MONOPOLY.ARTICLE')?>: <span class="js-article"></span></span><?
                                  }
                                  ?></div></div><? */
                                ?></div><?
                                if ($arResult["PROPERTIES"]["COMMENT_SITE"]["VALUE"]) :
                                    ?><div class="col col-md-12 textSkvozniy clearfix">
                                    <div class="title">Комментарий магазина</div>
                                    <?
                                    echo $arResult["PROPERTIES"]["COMMENT_SITE"]["VALUE"];
                                    ?></div><?
                            endif;
                            // PROPERTIES
                            if (is_array($arResult['OFFERS_EXT']['PROPERTIES']) && count($arResult['OFFERS_EXT']['PROPERTIES']) > 0) {
                                ?><div class="col col-md-12 properties clearfix"><?
                                    foreach ($arResult['OFFERS_EXT']['PROPERTIES'] as $propCode => $arProperty) {
                                        $isColor = false;
                                        if (is_array($arParams['RSMONOPOLY_PROPS_ATTRIBUTES_COLOR']) && in_array($propCode, $arParams['RSMONOPOLY_PROPS_ATTRIBUTES_COLOR'])) {
                                            $isColor = true;
                                        }
                                        ?><div class="offer_prop prop_<?= $propCode ?> closed <? if ($isColor): ?>color<? else: ?>simple<? endif; ?> clearfix" data-code="<?= $propCode ?>"><?
                                        ?><span class="offer_prop-name"><?= $arResult['OFFERS_EXT']['PROPS'][$propCode]['NAME'] ?>: </span><?
                                        ?><div class="div_select"><?
                                        ?><div class="div_options"><?
                                                $firstVal = false;
                                                foreach ($arProperty as $value => $arValue) {
                                                    ?><div class="div_option<? if ($arValue['FIRST_OFFER'] == 'Y'): ?> selected<? elseif ($arValue['DISABLED_FOR_FIRST'] == 'Y'):
                                                        ?> disabled<? endif;
                                                    ?>" data-value="<?= htmlspecialcharsbx($arValue['VALUE']) ?>"><?
                                                                 if ($isColor) {
                                                                     ?><span style="background-image:url('<?= $arValue['PICT']['SRC'] ?>');" title="<?= $arValue['VALUE'] ?>"></span><?
                                                            } else {
                                                                ?><span><?= $arValue['VALUE'] ?></span><?
                                                            }
                                                            ?></div><?
                                                            if ($arValue['FIRST_OFFER'] == 'Y') {
                                                                $firstVal = $arValue;
                                                            }
                                                        }
                                                        ?></div><?
                                                    if (is_array($firstVal)) {
                                                        ?><div class="<? if (!$isColor): ?>btn btn-default dropdown-toggle <? endif; ?>div_selected"><?
                                                        if ($isColor) {
                                                            ?><span style="background-image:url('<?= $firstVal['PICT']['SRC'] ?>');" title="<?= $firstVal['VALUE'] ?>"></span><?
                                                        } else {
                                                            ?><span><?= $firstVal['VALUE'] ?></span><?
                                                        }
                                                        ?><i class="fa"></i></div><?
                                                        }
                                                        ?></div><?
                                                        ?></div><?
                                    }
                                    ?></div><?
                                }
                                // preview text
                                if ($tabDescription) {
                                    ?><div class="col col-md-12 previewtext"><?
                                    ?><div class="title">Описание</div><?
                                    ?><?= $arResult['DETAIL_TEXT'] ?><?
                                    ?></div><?
                            }

                            // preview text
                            if ($arResult['PROPERTIES']['ADDITIONAL_INFO']['VALUE']) {
                                ?><div class="col col-md-12 previewtext">
                                    <table width="100%" style="border:1px grey dashed;"><tr>
                                            <td style="padding:5px;"><img src="<?= $templateFolder ?>/img/znak.png"></td>
                                            <td><?= $arResult['PROPERTIES']['ADDITIONAL_INFO']['VALUE'] ?></td>
                                        </tr>
                                    </table>
                                </div><?
                            }
                            // compare
                            /* ?><div class="col col-md-4 compare hidden-xs"><?
                              if($arParams['DISPLAY_COMPARE']=='Y') {
                              ?><a class="js-compare link" href="<?=$arResult['COMPARE_URL']?>"><span><?=GetMessage('RS.MONOPOLY.COMPARE')?></span><span class="count"></span></a><?
                              }
                              ?></div><? */

                            // properties
                            if ($tabProperties) {
                                ?><div id="properties"><?
                                $APPLICATION->IncludeComponent('redsign:grupper.list', 'monopoly', array(
                                    'DISPLAY_PROPERTIES' => $arResult['DISPLAY_PROPERTIES'],
                                    'CACHE_TIME' => 36000,
                                        ), $component, array('HIDE_ICONS' => 'Y')
                                );
                                ?></div><?
                            }
                            /* if( is_array($arResult['DISPLAY_PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES'])>0 ) {
                              ?><div class="col col-md-12 proptable hidden-xs hidden-sm"><?
                              ?><div class="title">Характеристики</div><?
                              ?><table><?
                              ?><tbody><?
                              $cnt = 0;
                              foreach($arResult['DISPLAY_PROPERTIES'] as $code => $arProp) {
                              $cnt++;
                              ?><tr class="prop_<?=$code?>"><?
                              ?><td class="name"><span><?=$arProp['NAME']?></span><div class="border"></div></td><?
                              ?><td class="val"><span><?
                              if(is_array($arProp['DISPLAY_VALUE']))
                              echo implode(' / ',$arProp['DISPLAY_VALUE']);
                              else
                              echo $arProp['DISPLAY_VALUE'];
                              ?></span></td><?
                              ?></tr><?
                              if($cnt>4) { break; }
                              }
                              if(count($arResult['COLLECTION']) > 0) {
                              ?><tr  class="prop_collections"><?
                              ?><td class="name"><span><?=GetMessage('RS.MONOPOLY.PRODUCT_COLLECTION')?> </span></td><?
                              ?><td class="val"><span><?
                              foreach($arResult['COLLECTION'] as $arCollection) {
                              ?> <a href="<?=$arCollection['DETAIL_PAGE_URL']?>"><?=$arCollection['NAME']?></a> <?
                              }
                              ?></span></td><?
                              ?></tr><?
                              }
                              ?></tbody><?
                              ?></table><?
                              ?><br /><a class="moreprops" href="#tabs"><?=GetMessage('RS.MONOPOLY.MORE_PROPS')?></a><?
                              ?></div><?
                              } */
                            ?></div><?
                            ?></div><?
                            ?></div><?
                            ?></div><?
                            ?><div class="visible-xs visible-sm"><p></p></div><?
                            ?><div class="col col-md-4"><?
                            ?><div class="buyblock"><?
                            ?><div class="row"><?
                    // prices
                    if (is_array($arResult['CAT_PRICES']) && count($arResult['CAT_PRICES']) > 0) {
                        ?><div class="col col-md-12 prices"><?
                            if ($multyPrice) {
                                ?><div class="multy_prices"><?
                                    foreach ($arResult['CAT_PRICES'] as $PRICE_CODE => $arResPrice) {
                                        $arPrice = $PRODUCT['PRICES'][$PRICE_CODE];
                                        ?><div class="one_price"><?
                                        ?><?= $arResPrice['TITLE'] ?>: <? if (IntVal($arPrice['DISCOUNT_DIFF']) > 0) {
                                            ?><span class="price old price_pv_<?= $PRICE_CODE ?>"><?= $arPrice['PRINT_VALUE'] ?></span><?
                                            ?><div><span class="price cool new price_pdv_<?= $PRICE_CODE ?>"><?= $arPrice['PRINT_DISCOUNT_VALUE'] ?> за <?= $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></span><?
                                            ?><span class="discount"><?= GetMessage('RS.MONOPOLY.DISCOUNT') ?>: <span class="price_pdd_<?= $PRICE_CODE ?>"><?= $arPrice['PRINT_DISCOUNT_DIFF'] ?></span></span></div><?
                                                    } else {
                                                        ?><span class="price old price_pv_pricemin"></span><?
                                                        ?><div><span class="price cool new price_pdv_<?= $PRICE_CODE ?>"><?= $arPrice['PRINT_DISCOUNT_VALUE'] ?> за <?= $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></span><?
                                                        ?><span class="discount js-discound" style="display:none;"><?= GetMessage('RS.MONOPOLY.DISCOUNT') ?>:  <span class="price_pdd_pricemin"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_DIFF'] ?></span></span></div><?
                                                    }
                                                    ?></div><?
                                                }
                                                ?></div><?
                                    } else {
                                        ?>
                                        <? if (IntVal($PRODUCT['MIN_PRICE']['DISCOUNT_DIFF']) > 0) {
                                            ?><center><span class="price old price_pv_pricemin"><?= $PRODUCT['MIN_PRICE']['PRINT_VALUE'] ?></span></center><?
                                            ?><span class="price cool new price_pdv_pricemin"><span class="jsPrice" id="bx_price_<?=$arResult['ID']?>"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span> за <span class="jsUNIT"></span> <?= $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></span><?
                                            ?><center><span class="discount js-discound"><?= GetMessage('RS.MONOPOLY.DISCOUNT') ?>:  <span class="price_pdd_pricemin"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_DIFF'] ?></span></span></center><?
                                    } else {
                                        ?><span class="price old price_pv_pricemin"></span><?
                                        ?><span class="price cool new price_pdv_pricemin"><span class="jsPrice" id="bx_price_<?=$arResult['ID']?>"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span> за <span class="jsUNIT"></span> <?= $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></span><?
                                        ?><span class="discount js-discound" style="display:none;"><?= GetMessage('RS.MONOPOLY.DISCOUNT') ?>:  <span class="price_pdd_pricemin"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_DIFF'] ?></span></span><?
                                    }
                                    ?>
                                    <?
                                }
                                ?></div><?
                            }
                            // TIMERS
                            if (is_array($arTimers) && count($arTimers) > 0) {
                                ?><div class="col col-md-12 timers text-center"><?
                                $have_vis = false;
                                foreach ($arTimers as $arTimer) {
                                    $KY = 'TIMER';
                                    if (isset($arTimer['DINAMICA_EX'])) {
                                        $KY = 'DINAMICA_EX';
                                    }
                                    ?><div class="timer <? if (isset($arTimer['DINAMICA_EX'])): ?>da2<? else: ?>qb<? endif; ?> js-timer_id<?= $arTimer['ELEMENT_ID'] ?> clearfix" style="display:<?
                                    if (($arResult['ID'] == $arTimer['ELEMENT_ID'] || $PRODUCT['ID'] == $arTimer['ELEMENT_ID']) && !$have_vis) {
                                        ?>inline-block<?
                                             $have_vis = true;
                                         } else {
                                             ?>none<?
                                         }
                                         ?>;" data-datefrom="<?= $arTimer[$KY]['DATE_FROM'] ?>"><?
                                         ?><div class="title"><?= GetMessage('QB_AND_DA2_TITLE'); ?></div><?
                                         ?><div class="intimer clearfix" data-dateto="<?= $arTimer[$KY]['DATE_TO'] ?>"><?
                                        if ($arTimer[$KY]['DAYS'] > 0) {
                                            ?><div class="val"><div class="value robotolight result-day"><?
                                                echo($arTimer[$KY]['DAYS'] > 9 ? $arTimer[$KY]['DAYS'] : '0' . $arTimer[$KY]['DAYS'] )
                                                ?></div><div class="podpis"><?= GetMessage('QB_AND_DA2_DAY') ?></div></div><?
                                                    }
                                                    ?><div class="val"><div class="value robotolight result-hour"><?
                                                        echo($arTimer[$KY]['HOUR'] > 9 ? $arTimer[$KY]['HOUR'] : '0' . $arTimer[$KY]['HOUR'] )
                                                        ?></div><div class="podpis"><?= GetMessage('QB_AND_DA2_HOUR') ?></div></div><?
                                                        ?><div class="val"><div class="value robotolight result-minute"><?
                                            echo($arTimer[$KY]['MINUTE'] > 9 ? $arTimer[$KY]['MINUTE'] : '0' . $arTimer[$KY]['MINUTE'] )
                                            ?></div><div class="podpis "><?= GetMessage('QB_AND_DA2_MIN') ?></div></div><?
                                                    if ($arTimer[$KY]['DAYS'] < 1) {
                                                        ?><div class="val"><div class="value robotolight result-second"><?
                                                            echo($arTimer[$KY]['SECOND'] > 9 ? $arTimer[$KY]['SECOND'] : '0' . $arTimer[$KY]['SECOND'] )
                                                            ?></div><div class="podpis "><?= GetMessage('QB_AND_DA2_SEC') ?></div></div><?
                                                    }
                                                    if (isset($arTimer['DINAMICA_EX'])) {
                                                        ?><div class="val ml da2"><div class="value robotolight"><?
                                                            echo($arTimer[$KY]['PHP_DATA']['persent'] > 9 ? $arTimer[$KY]['PHP_DATA']['persent'] : '0' . $arTimer[$KY]['PHP_DATA']['persent'] )
                                                            ?></div><div class="podpis"><?= GetMessage('QB_AND_DA2_PERSENT') ?></div></div><?
                                                    } elseif (isset($arTimer['TIMER']) && IntVal($arTimer['QUANTITY']) > 0) {
                                                        ?><div class="val ml qb"><div class="value robotolight"><?
                                                            echo($arTimer['QUANTITY']);
                                                            ?><?= GetMessage('QB_AND_DA2_SHT') ?></div><div class="podpis"><?= GetMessage('QB_AND_DA2_SHT') ?></div></div><?
                                                    }
                                                    ?></div><?
                                                    if (isset($arTimer['DINAMICA_EX'])) {
                                                        ?><div class="progress"><?
                                                        ?><div class="progress-bar" <?
                                                        ?>role="progressbar" <?
                                                        ?>aria-valuemin="0" <?
                                                        ?>aria-valuemax="1000" <?
                                                        ?>aria-valuenow="<?= $arTimer[$KY]['PHP_DATA']['persent'] ?>" <?
                                                        ?>style="width:<?= $arTimer[$KY]['PHP_DATA']['persent'] ?>%;" <?
                                                        ?>><?
                                                        ?><span class="sr-only"></span><?
                                                        ?></div><?
                                                        ?></div><?
                                        }
                                        if (isset($arTimer['TIMER'])) {
                                            ?><div class="progress"><?
                                            ?><div class="progress-bar" <?
                                            ?>role="progressbar" <?
                                            ?>aria-valuemin="0" <?
                                            ?>aria-valuemax="1000" <?
                                            ?>aria-valuenow="50" <?
                                            ?>style="width:50%;" <?
                                            ?>><?
                                            ?><span class="sr-only"></span><?
                                            ?></div><?
                                            ?></div><?
                                        }
                                        ?></div><?
                                    }
                                    ?></div><?
                            }
                            ?>								
                        <div class="col col-md-12 buybtn">						
                            <?
                            $name = '[' . $arResult['ID'] . '] ' . $arResult['NAME'];
                            ?><form class="add2basketform js-buyform<?= $arReslt['ID'] ?><? if (!$PRODUCT['CAN_BUY']): ?> cantbuy<? endif; ?><? if ($arParams['USE_PRODUCT_QUANTITY']): ?> usequantity<? endif; ?>" name="add2basketform"><?
                            ?><input type="hidden" name="action" value="ADD2BASKET"><?
                            ?><input type="hidden" name="price" value="<?= $PRODUCT['MIN_PRICE']['DISCOUNT_VALUE'] ?>" class="js-price" id="bx_js_price_block_<?=$arResult['ID']?>"><? ?><input type="hidden" name="<?= $arParams['PRODUCT_ID_VARIABLE'] ?>" class="js-add2basketpid" value="<?= $PRODUCT['ID'] ?>"><?
                                /* ?><div class="row storesandquantity"><?
                                  ?><div class="col col-xs-5 col-md-12 col-lg-5 detailstores"><?
                                  if( $arParams['USE_STORE']=='Y' ) {
                                  $APPLICATION->IncludeComponent(
                                  'bitrix:catalog.store.amount',
                                  'monopoly',
                                  array(
                                  "ELEMENT_ID" => $arResult["ID"],
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
                                  'DATA_QUANTITY' => $arResult['DATA_QUANTITY'],
                                  'FIRST_ELEMENT_ID' => $PRODUCT['ID'],
                                  ),
                                  $component,
                                  array('HIDE_ICONS'=>'Y')
                                  );
                                  }
                                  ?></div><?
                                  ?></div><? */
                                ?><div class="row"><?
                                if ($arParams['USE_PRODUCT_QUANTITY']) {
                                    ?>
                                        <div class="col col-xs-12 col-md-12 col-lg-12 text-right wrapQuantity text-center">
                                            <span class="quantity">
                                                <a class="minus <?= $arResult['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? '' : 'js-minus' ?>"  id="bx_down_<?= $arResult['ID'] ?>"><i class="fa"></i></a>
                                                <input onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" type="text" class="js-quantity text-center" name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>" value="<?= $arResult['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? $arResult['START_MEASURE_RATIO'] : $PRODUCT['CATALOG_MEASURE_RATIO'] ?>" data-ratio="<?= $PRODUCT['CATALOG_MEASURE_RATIO'] ?>"  id="bx_quantity_<?= $arResult['ID'] ?>">
                                                <a class="plus <?= $arResult['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? '' : 'js-plus' ?>"  id="bx_up_<?= $arResult['ID'] ?>"><i class="fa"></i></a>
                                                <span class="js-measurename"><?= $PRODUCT['CATALOG_MEASURE_NAME'] ?></span>
                                            </span>
                                        </div><?
                                    }
                                    ?>

                                    <?
                                    if ($arResult['CATALOG_MEASURE_RATIO'] > 1) {
                                        echo "<div class='fromN col col-xs-12 col-md-12 col-lg-12 wrapBasket text-center'>";
                                        echo "Заказ по " . $arResult['CATALOG_MEASURE_RATIO'] . " шт.";
                                        echo '</div><br clear="all"><br>';
                                    }
                                    ?>

                                    <div class="col col-xs-12 col-md-12 col-lg-12 wrapBasket text-center"><?
                                    ?><noindex><?
                                    ?><button type="submit" rel="nofollow" class="submit js-add2basketlink" value=""><?= GetMessage('RS.MONOPOLY.BTN_BUY') ?></button><?
                                    ?><a class="inbasket" href="<?= $arParams['BASKET_URL'] ?>"><?= GetMessage('RS.MONOPOLY.BTN_GO2BASKET') ?></a><?
                                    ?></noindex><?
                                    ?></div></div><?
                                    ?></form><?
                            // favorite
                            if ($arParams['DISPLAY_COMPARE'] == 'Y') {
                                ?><div class="text-center"><a class="favorite favorite-heart" data-elementid = "<?= $arResult['ID'] ?>" data-detailpageurl="<?= $arResult['DETAIL_PAGE_URL'] ?>" href = "<?= $arResult['DETAIL_PAGE_URL'] . '?action=UPDATE_FAVORITE&element_id=' . $arResult['ID'] ?>"><span><?= GetMessage('RS.MONOPOLY.IN_FAVORITE') ?></span></a></div><?
                                }
                                /* ?><a class="fancyajax fancybox.ajax btn btn-default buy1click" <?
                                  ?>href="<?=SITE_DIR?>forms/buy1click/" <?
                                  ?>data-insertdata='{"RS_EXT_FIELD_0":"<?=CUtil::JSEscape($name)?>"}' <?
                                  ?>title="<?=GetMessage('RS.MONOPOLY.BUY_1_CLICK_TITLE')?>" <?
                                  ?>><?=GetMessage('RS.MONOPOLY.BUY_1_CLICK')?></a><? */
                                if ($arParams['RSMONOPOLY_SHOW_CREDIT_BTN'] == 'Y' && $arParams["RSMONOPOLY_CREDIT_BTN_LINK"] != '') {
                                    ?><form name="kreditform" action="<?= $arParams["RSMONOPOLY_CREDIT_BTN_LINK"] ?>" method="get"><?
                                    ?><input type="hidden" name="product_id" class="js-add2basketpid" value="<?= $PRODUCT['ID'] ?>"><?
                                    ?><button type="submit" rel="nofollow" class="btn btn-default" value=""><?= GetMessage('RS.MONOPOLY.CREDIT_BTN') ?></button><?
                                    ?></form><?
                            }
                            ?>

                        </div><?
                        /* ?><div class="col col-md-12 delivery"><?
                          ?><?$APPLICATION->IncludeFile(SITE_DIR."include_areas/catalog_delivery.php",array(),array("MODE"=>"html","HIDE_ICONS"=>"Y"));?><?
                          ?></div><?
                          ?><div class="col col-md-12 yashare"><?
                          ?><span><?=GetMessage("RS.MONOPOLY.YASHARE")?>:</span><?
                          ?><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="facebook,twitter,gplus"></div><?
                          ?></div><? */
                        ?>
                        <div class="col col-md-12 quantityStatus text-center">
                            Наличие на складе: <?
                            if (!$arResult["PROPERTIES"]["STATUS_SKLAD"]["VALUE"]) {
                                echo '<strong class="green">Да</strong>';
                            } elseif ($arResult["PROPERTIES"]["STATUS_SKLAD"]["VALUE"] == "Нет") {
                                echo '<strong class="red">Нет</strong>';
                            } else {
                                echo '<strong class="yellow">Под заказ</strong>';
                            }
                            ?>
                        </div>
                    </div><?
                            ?></div><?
                            ?><br><div class="buyblock"><?
                $stmp = getmicrotime();
                $stmp = AddToTimeStamp(array("DD" => 1), $stmp); // 1115454720
                ?><div class="dateDelivery">
                        <div class="icon">
                            <div class="number"><?= FormatDate("d", $stmp); ?></div>
                            <div class="mouth"><?= strtolower(FormatDate("M", $stmp)); ?></div>
                        </div>
                        Ближайшая доставка<br>
                        <b><?= strtolower(FormatDate("d F", $stmp)); ?></b>
                    </div><? ?><a target="_blank" rel="nofollow" href="/dostavka-i-oplata/" class="freeDelivery">
                        <b>Бесплатная доставка</b><br>
                        ваших заказов
                    </a>
                    <a target="_blank" rel="nofollow" href="/dostavka-i-oplata/" class="variantPay">
                        Принимаем к оплате<br>
                        <b>Банковские карты</b>
                    </a>
                    <? ?></div><? ?></div><? ?></div>

    </div>
</div>
<?
if ($arResult['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO']) {
    $arJSParams = array(
        'ID' => $arResult['ID'],
        'START_RATIO' => $arResult['START_MEASURE_RATIO'],
        'MIDDLE_RATIO' => $arResult['MIDDLE_MEASURE_RATIO'],
        'RATIO' => $arResult['NEXT_MEASURE_RATIO'],
    );
    $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
    ?>
    <script type="text/javascript">
        var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
    </script>
<? } ?>
<? /*
  <div class="row">
  <div class = "col col-md-12">
  <div class="row part2 js-detail"><?
  ?><div class="col col-md-12"><?
  ?><a name="tabs"></a><?
  ?><div class="tabs"><?
  ?><ul class="nav nav-tabs" id="detail-tabs"><?
  if($tabDescription) {
  ?><li><a class="detailtext" href="#description" data-toggle="tab"><?=GetMessage('RS.MONOPOLY.DESCRIPTION')?></a></li><?
  }
  if($tabProperties) {
  ?><li><a class="properties" href="#properties" data-toggle="tab"><?=GetMessage('RS.MONOPOLY.PROPERTIES')?></a></li><?
  }

  if($arResult['TABS']['PROPS_TABS']) {
  foreach($arParams['PROPS_TABS'] as $propCode){
  if(!empty($arResult['PROPERTIES'][$propCode]['VALUE'])) {
  ?><li><a class="<?=$propCode?>" href="#prop<?=$propCode?>" data-toggle="tab"><?=$arResult['PROPERTIES'][$propCode]['NAME']?></a></li><?
  }
  }
  }

  ?></ul><?
  ?><div class="tab-content"><?
  if($tabDescription) {
  ?><div class="tab-pane fade" id="description"><?
  ?><div class="row"><div class="col-md-12"><?
  ?><?=$arResult['DETAIL_TEXT']?><?
  ?></div></div><?
  ?></div><?
  }
  if($tabProperties) {
  ?><div class="tab-pane fade" id="properties"><?
  $APPLICATION->IncludeComponent('redsign:grupper.list',
  'monopoly',
  array(
  'DISPLAY_PROPERTIES' => $arResult['DISPLAY_PROPERTIES'],
  'CACHE_TIME' => 36000,
  ),
  $component,
  array('HIDE_ICONS'=>'Y')
  );
  ?></div><?
  }

  if($arResult['TABS']['PROPS_TABS']) {
  foreach($arParams['PROPS_TABS'] as $propCode) {

  if(empty($arResult['PROPERTIES'][$propCode]['VALUE'])) {
  continue;
  }

  ?><div class="tab-pane fade" id="prop<?=$propCode?>"><?

  if(
  $arResult['PROPERTIES'][$propCode]['PROPERTY_TYPE'] == 'E' &&
  count($arResult['PROPERTIES'][$propCode]['VALUE']) > 0
  )
  {
  global $lightFilter;
  $lightFilter = array(
  'ID' => $arResult['PROPERTIES'][$propCode]['VALUE']
  );

  $APPLICATION->includeComponent(
  'bitrix:catalog.section',
  'light',
  array(
  'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
  'IBLOCK_ID' => $arParams['IBLOCK_ID'],
  'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
  'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
  'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
  'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
  'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
  'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
  'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
  'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
  'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
  'BASKET_URL' => $arParams['BASKET_URL'],
  'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
  'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
  'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
  'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
  'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
  'FILTER_NAME' => 'lightFilter',
  'CACHE_TYPE' => $arParams['CACHE_TYPE'],
  'CACHE_TIME' => $arParams['CACHE_TIME'],
  'CACHE_FILTER' => $arParams['CACHE_FILTER'],
  'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
  'SET_TITLE' => $arParams['SET_TITLE'],
  'SET_STATUS_404' => $arParams['SET_STATUS_404'],
  'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
  'PAGE_ELEMENT_COUNT' => $arParams['PAGE_ELEMENT_COUNT'],
  'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
  'PRICE_CODE' => $arParams['PRICE_CODE'],
  'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
  'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

  'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
  'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
  'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
  'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
  'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],

  'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
  'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
  'PAGER_TITLE' => $arParams['PAGER_TITLE'],
  'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
  'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
  'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
  'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
  'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],

  'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
  'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
  'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
  'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
  'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
  'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
  'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
  'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],

  'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
  'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
  'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
  'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
  'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
  'CURRENCY_ID' => $arParams['CURRENCY_ID'],
  'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
  'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
  "SHOW_ALL_WO_SECTION" => "Y",
  "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
  // store
  'USE_STORE' => $arParams['USE_STORE'],
  'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
  'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
  'MAIN_TITLE' => $arParams['MAIN_TITLE'],
  'SHOW_GENERAL_STORE_INFORMATION' => 'Y',
  //"STORES_FIELDS" => $arParams['FIELDS'],
  // monopoly
  "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
  "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
  "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
  "SIDEBAR" => $arResult["SIDEBAR"],
  "RSMONOPOLY_TEMPLATE" => $alfaCTemplate,
  "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
  ),
  $component
  );

  } elseif (
  $arResult['PROPERTIES'][$propCode]['PROPERTY_TYPE']=='F' &&
  count($arResult['PROPERTIES'][$propCode]['VALUE']) > 0 &&
  $arResult['PROPERTIES'][$propCode]['VALUE']
  )
  {
  ?><div <?
  ?>class="docs docs-owl-slider owlslider owl"<?
  ?>data-margin="40"<?
  ?>data-items="3"<?
  ?>data-responsive='{"0":{"items":"2"},"768":{"items":"3"}}'<?
  ?>><?
  foreach($arResult['PROPERTIES'][$propCode]['VALUE'] as $arFile) {
  ?><div class = "item"><?
  ?><div class="image"><?
  ?><a href="<?=$arFile['SRC']?>"><?
  ?><img src="<?=$templateFolder?>/img/pic.jpg" alt="<?=$arFile['DESCRIPTION']?>" title="<?=$arFile['DESCRIPTION']?>" /><?
  ?><span><?=$arFile['EXTENSION']?></span><?
  ?></a><?
  ?></div><?
  ?><div class="data"><?
  ?><div class="info smaller"><?
  ?><div class="name"><?
  ?><span class="aprimary"><?=$arFile["ORIGINAL_NAME"]?></span><?
  ?></div><?
  ?><div class="descr"><?=$arFile["DESCRIPTION"]?></div><?
  ?></div><?
  ?><div class="dl">
  <a href="<?=$arFile['SRC']?>"><?=GetMessage("RSMONOPOLY_DS_DL")?>: <?=strtoupper($arFile['EXTENSION'])?>, <?=$arFile['SIZE']?></a><?
  ?></div><?
  ?></div><?
  ?></div><?
  }
  ?></div><?

  }
  else {
  ?><div class = "row"><?
  ?><div class = "col col-md-12"><?
  ?><?=$arResult['PROPERTIES'][$propCode]["VALUE"]?><?
  ?></div><?
  ?></div><?
  }

  ?></div><?
  }
  }
  ?></div><?
  ?></div><?
  ?></div><?
  ?></div><?
  ?></div><?
  ?></div><? */
?><script>
    if ($('.js-brcrtitle').length > 0 && $('.js-detail').find('.brcrtitle').length > 0) {
        $('.js-detail').find('.brcrtitle').find('.brcr').html($('.js-brcrtitle').html());
        $('.js-detail').find('.brcrtitle').find('.ttl').html($('.js-ttl').html());
        $('html').addClass('detailprodpage');
        RSMONOPOLY_PRODUCTS['<?= $arResult['ID'] ?>'] = {'IMAGES':<?= CUtil::PhpToJSObject($arImages) ?>};
    }
</script><?
?><?
