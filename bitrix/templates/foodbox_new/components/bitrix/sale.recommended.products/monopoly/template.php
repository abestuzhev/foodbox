<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
if (!is_array($arResult['ITEMS']) || count($arResult['ITEMS']) < 1)
    return;
?>
<div class="row">
    <div class="col col-md-12 section-cart sale-recommended">
        <h2 class="coolHeading">
            <span class="secondLine"><?= GetMessage('RS.MONOPOLY.SLP_TITLE') ?></span>
        </h2>
        <div 
            class = "products showcase owlslider owl"
            data-margin = "35"
            data-items = "5"
            data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"4"}, "956":{"items":"5"}}'
            >
                <?
                foreach ($arResult['ITEMS'] as $arItem):
                    if (empty($arItem['OFFERS'])) {
                        $HAVE_OFFERS = false;
                        $PRODUCT = &$arItem;
                    } else {
                        $HAVE_OFFERS = true;
                        $PRODUCT = &$arItem['OFFERS'][0];
                    }
                    ?>
                <div class = "item 
                     js-element
                     <?= isset($arItem['DAYSARTICLE2']) || isset($PRODUCT['DAYSARTICLE2']) ? "da2" : "" ?>
                     <?= isset($arItem['QUICKBUY']) || isset($PRODUCT['QUICKBUY']) ? "qb" : "" ?>" 
                     >
                    <div class="in">
                        <div class="da2_icon hidden-xs"><?= GetMessage('DA2_ICON_TITLE') ?></div>
                        <div class="qb_icon hidden-xs"><?= GetMessage('QB_ICON_TITLE') ?></div>
                        <? if ($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]): ?>
                            <div class="<?= (strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : 'new_icon' ?> hidden-xs"><?= $arItem["PROPERTIES"]["SHILDIK"]["VALUE"] ?></div>
                        <? endif; ?>

                        <div class = "pic">
                            <a class="js-detail_page_url" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?
                                if (isset($arItem['FIRST_PIC']['RESIZE']['src']) && trim($arItem['FIRST_PIC']['RESIZE']['src']) != '') {
                                    ?><img src="<?= $arItem['FIRST_PIC']['RESIZE']['src'] ?>" alt="<?= $arItem['FIRST_PIC']['ALT'] ?>" title="<?= $arItem['FIRST_PIC']['TITLE'] ?>" /><?
                                } else {
                                    ?><img src="<?= $arResult['NO_PHOTO']['src'] ?>" title="<?= $arItem['NAME'] ?>" alt="<?= $arItem['NAME'] ?>" /><?
                                }
                                ?></a>
                        </div>
                        <div class = "data">
                            <div class = "name recomend">
                                <a class="aprimary" href="<?= $arItem['DETAIL_PAGE_URL'] ?>" title="<?= $arItem['NAME'] ?>"><?= $arItem['NAME'] ?></a><br />
                            </div>
                            <div class = "row buy">

                                <div class = "col col-xs-12 text-center prices">
                                    <? if (IntVal($PRODUCT['MIN_PRICE']['DISCOUNT_DIFF']) > 0) {
                                        ?><div class="price old"><?= $PRODUCT['MIN_PRICE']['PRINT_VALUE'] ?>/<?= $PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div><? ?><div class="price cool new"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div><?
                                    } else {
                                        ?><div class="price cool"><?= $PRODUCT['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $PRODUCT["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div><? }
                                    ?>
                                </div>
                            </div>

                            <div class="row bot">
                                <div class="col col-md-12 text-center buybtn">
                                    <?php if ($haveOffers): ?>
                                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-primary">
                                            <?= GetMessage('RS.MONOPOLY.BTN_MORE') ?>
                                        </a>
                                    <?php else: ?>
                                        <noindex>
                                            <form
                                                class="
                                                add2basketform 
                                                js-buyform<?= $arItem['ID'] ?>
                                                <?php
                                                if (!$PRODUCT['CAN_BUY']) {
                                                    echo 'cantbuy';
                                                }
                                                ?>
                                                "
                                                name="add2basketform"
                                                >
                                                <span class="quantity"><? ?><a class="minus js-minus"><i class="fa"></i></a><? ?><input onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" type="text" class="js-quantity text-center" name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>" value="<?= $arItem['CATALOG_MEASURE_RATIO'] ?>" data-ratio="<?= $arItem['CATALOG_MEASURE_RATIO'] ?>"><? ?><a class="plus js-plus"><i class="fa"></i></a><? ?><span class="js-measurename"><?= $arItem['CATALOG_MEASURE_NAME'] ?></span><? ?></span>
                                                <input type="hidden" name="action" value="ADD2BASKET">
                                                <input
                                                    type="hidden" 
                                                    name="<?= $arParams['PRODUCT_ID_VARIABLE'] ?>" 
                                                    class="js-add2basketpid" 
                                                    value="<?= $PRODUCT['ID'] ?>"
                                                    >
                                                <button type="submit" rel="nofollow" class="submit js-add2basketlink" value="">
                                                    <?= GetMessage('RS.MONOPOLY.BTN_BUY') ?>
                                                </button>
                                                <a class="inbasket" href="<?= $arParams['BASKET_URL'] ?>">
                                                    <?= GetMessage('RS.MONOPOLY.BTN_GO2BASKET') ?>
                                                </a>
                                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-primary js-morebtn buybtn">
                                                    <?= GetMessage('RS.MONOPOLY.BTN_MORE') ?>
                                                </a>
                                            </form>
                                        </noindex>
                                    <?php endif; ?>
                                </div>

                                <?php if ($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y"): ?>
                                    <div 
                                        class="favorite favorite-heart"
                                        data-elementid = "<?= $arItem['ID'] ?>"
                                        data-detailpageurl="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                        ></div>
                                    <?php endif; ?>
                                    <? /*
                                      <div class="col col-xs-6 compare">
                                      <?php if($arParams['DISPLAY_COMPARE']=='Y'): ?>
                                      <a
                                      class="js-compare link"
                                      href="<?=$arItem['COMPARE_URL']?>"
                                      >
                                      <span>
                                      <?=GetMessage('RS.MONOPOLY.COMPARE')?>
                                      </span>
                                      <span class="count"></span>
                                      </a>
                                      <?php endif;?>
                                      </div>

                                      <div class="col col-xs-6 text-right">
                                      <?php if($arParams['USE_STORE'] != ""): ?>
                                      <?php
                                      $APPLICATION->IncludeComponent(
                                      'bitrix:catalog.store.amount',
                                      'monopoly',
                                      array(
                                      "ELEMENT_ID" => $arItem["ID"],
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
                                      'DATA_QUANTITY' => $arItem['DATA_QUANTITY'],
                                      'FIRST_ELEMENT_ID' => $product['ID'],
                                      ),
                                      $component,
                                      array('HIDE_ICONS'=>'Y')
                                      );
                                      ?>
                                      <?php endif; ?>
                                      </div>
                                     */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>