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
<div class="row products <?= $arResult['TEMPLATE_DEFAULT']['CSS'] ?>">

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

        <div 
            class = "
            item 
            js-element
            js-elementid<?= $arItem['ID'] ?>
            col col-md-12
            <?php
            if (!empty($product['DAYSARTICLE2'])) {
                echo 'da2';
            }
            ?>
            <?php
            if (!empty($product['QUICKBUY'])) {
                echo 'qb';
            }
            ?>
            "
            data-elementid = "<?= $arItem['ID'] ?>"
            data-detailpageurl="<?= $arItem['DETAIL_PAGE_URL'] ?>"
            id="<?= $this->GetEditAreaId($arItem["ID"]); ?>"
            >
            <div class="da2_icon hidden-xs">
                <span><?= Loc::getMessage('DA2_ICON_TITLE') ?></span>
            </div>
            <div class="qb_icon hidden-xs">
                <span><?= Loc::getMessage('QB_ICON_TITLE') ?></span>
            </div>
            <? if ($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]): ?>
                <div class="<?= (strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : 'new_icon' ?> hidden-xs"><?= $arItem["PROPERTIES"]["SHILDIK"]["VALUE"] ?></div>
            <? endif; ?>

            <div class="row">
                <div class="col col-md-12">
                    <div class="in">
                        <div class="row">
                            <div class="col col-xs-4 col-sm-3 col-md-2 part part1">
                                <div class="pic text-center">
                                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                        <?php
                                        if (
                                                !empty($arItem['FIRST_PIC']['RESIZE']['src']) &&
                                                trim($arItem['FIRST_PIC']['RESIZE']['src']) != ''
                                        ):
                                            ?>
                                            <img 
                                                id="imgItem<?= $arItem['ID'] ?>"
                                                src="<?= $arItem['FIRST_PIC']['RESIZE']['src'] ?>"
                                                alt="<?= $arItem['FIRST_PIC']['ALT'] ?>" 
                                                >
                                            <?php else: ?>
                                            <img 
                                                id="imgItem<?= $arItem['ID'] ?>"
                                                src="<?= $arResult['NO_PHOTO']['src'] ?>"
                                                alt="<?= $arItem['NAME'] ?>"
                                                >
                                            <?php endif; ?>
                                    </a>
                                </div>
                            </div>

                            <div class="col col-xs-8 col-sm-9 col-md-10 part part2">
                                <div class="data">
                                    <div class="row">
                                        <div 
                                            class="
                                            col 
                                            col-md-9
                                            col-sm-6"
                                            >

                                            <div class="limiter">
                                                <div class="name">
                                                    <a class="aprimary" href="<?= $arItem['DETAIL_PAGE_URL'] ?>" title="<?= $arItem['NAME'] ?>">
                                                        <?= $arItem['NAME'] ?>
                                                    </a>
                                                    <? /* php if($arItem['PREVIEW_TEXT']!=''): ?>
                                                      <div class="descr hidden-xs">
                                                      <?=$arItem['PREVIEW_TEXT']?>
                                                      </div>
                                                      <?php endif; */ ?>

                                                </div>
                                            </div>
                                            <div class="prop hidden-xs">
                                                <ul>
                                                    <li><span>Минимальное количество</span> <span><?= $arItem["CATALOG_MEASURE_RATIO"] ?></span></li>
                                                    <li><span>Единица измерения</span> <span><?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></span></li>
                                                </ul>
                                            </div>
                                            <? /*
                                              <div class="bot">
                                              <div class="row">
                                              <div class="col col-xs-12 artstorcompare">
                                              <?php
                                              if(
                                              $arParams['RSMONOPOLY_PROP_ARTICLE']!='' &&
                                              $arItem['PROPERTIES'][$arParams['RSMONOPOLY_PROP_ARTICLE']]['VALUE']!=''
                                              ):
                                              ?>
                                              <span class="article text-nowrap">
                                              <?=Loc::getMessage('RS.MONOPOLY.ARTICLE')?>:
                                              <?=$arItem['PROPERTIES'][$arParams['RSMONOPOLY_PROP_ARTICLE']]['VALUE']?>
                                              </span>
                                              <?php endif; ?>

                                              <?php if($arParams['USE_STORE']!=''): ?>
                                              <span>
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
                                              </span>
                                              <?php endif; ?>
                                              <?php if($arParams['DISPLAY_COMPARE']=='Y'): ?>
                                              <span class="compare text-nowrap">
                                              <a class="js-compare link" href="<?=$arItem['COMPARE_URL']?>">
                                              <span><?=Loc::getMessage('RS.MONOPOLY.COMPARE'); ?> </span>
                                              <span class="count"></span>
                                              </a>
                                              </span>
                                              <?php endif; ?>
                                              </div>
                                              </div>
                                              </div>
                                             */ ?>
                                        </div>


                                        <div class="col col-md-<? if ($arParams["SIDEBAR"] == 'Y'): ?>3<? else: ?>2<? endif; ?> col-sm-3 text-right">
                                            <div class="prices">
                                                <div>
                                                    <?php if ((int) $product['MIN_PRICE']['DISCOUNT_DIFF'] > 0): ?>
                                                        <div class="price old"><?= $product['MIN_PRICE']['PRINT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div>
                                                        <div class="price cool new"><?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div>
                                                    <?php else: ?>
                                                        <div class="price cool"><?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="buybtn">
                                                <div>
                                                    <?php if ($haveOffers): ?>
                                                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-primary">
                                                            <?= Loc::getMessage('RS.MONOPOLY.BTN_MORE') ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <noindex>
                                                            <form
                                                                class="
                                                                add2basketform
                                                                js-buyform<?= $arItem['ID'] ?>
                                                                <? if (!$product['CAN_BUY']): ?> cantbuy<? endif; ?>
                                                                "
                                                                name="add2basketform"
                                                                >

                                                                <? if ($arParams['USE_PRODUCT_QUANTITY']) { ?>
                                                                    <span class="quantity">
                                                                        <a class="minus <?= $arItem['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? '' : 'js-minus' ?>" id="bx_down_<?= $arItem['ID'] ?>"><i class="fa"></i></a>
                                                                        <input onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" type="text" class="js-quantity text-center" name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>" value="<?= $arItem['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? $arResult['START_MEASURE_RATIO'] : $arItem['CATALOG_MEASURE_RATIO'] ?>" data-ratio="<?= $arItem['CATALOG_MEASURE_RATIO'] ?>" id="bx_quantity_<?= $arItem['ID'] ?>">

                                                                        <a class="plus <?= $arItem['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO'] ? '' : 'js-plus' ?>" id="bx_up_<?= $arItem['ID'] ?>"><i class="fa"></i></a>
                                                                        <span class="js-measurename"><?= $arItem['CATALOG_MEASURE_NAME'] ?></span>
                                                                    </span>
                                                                    <?
                                                                }
                                                                // LEEFT
                                                                ?>


                                                                <input type="hidden" name="action" value="ADD2BASKET">
                                                                <input type="hidden" 
                                                                       name="<?= $arParams['PRODUCT_ID_VARIABLE'] ?>"
                                                                       class="js-add2basketpid" 
                                                                       value="<?= $product['ID'] ?>"]
                                                                       >
                                                                <button
                                                                    type="submit"
                                                                    rel="nofollow" 
                                                                    class="submit js-add2basketlink"
                                                                    value=""><?= Loc::getMessage('RS.MONOPOLY.BTN_BUY') ?>
                                                                </button>
                                                                <a class="inbasket" href="<?= $arParams['BASKET_URL'] ?>">
                                                                    <?= Loc::getMessage('RS.MONOPOLY.BTN_GO2BASKET') ?>
                                                                </a>
                                                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-primary js-morebtn">
                                                                    <?= Loc::getMessage('RS.MONOPOLY.BTN_MORE') ?>
                                                                </a>
                                                            </form>
                                                        </noindex>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if ($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y"): ?>
                                                <div 
                                                    class="favorite favorite-heart"
                                                    data-elementid = "<?= $arItem['ID'] ?>"
                                                    data-detailpageurl="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                                    ><span><?= Loc::getMessage('RS.MONOPOLY.BTN_BOX') ?></span></div>

                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?
        if ($arItem['CATALOG_MEASURE'] == 4 && $arResult['SHOW_NEW_RATIO']) {
            $arJSParams = array(
                'ID' => $arItem['ID'],
                'START_RATIO' => $arResult['START_MEASURE_RATIO'],
                'MIDDLE_RATIO' => $arResult['MIDDLE_MEASURE_RATIO'],
                'RATIO' => $arResult['NEXT_MEASURE_RATIO'],
            );
            $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
            ?>
            <script type="text/javascript">
                var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
            </script>
        <? } ?>
    <?php endforeach; ?>
</div>
<?
if ($isAjaxShowMore) {
    if ($arParams['DISPLAY_BOTTOM_PAGER'] == 'Y') {
        echo $arResult['NAV_STRING'];
    }
    die();
}
?>

<div class="show-more" style="text-align: center;">
    <input class="btn btn-primary bx_filter_search_button" type="button"  value="Показать еще" data-pages="<?= $arResult['NAV_RESULT']->NavPageCount ?>" onclick="showMore(this); return false;" data-start="2">
</div>
<?php
if ($arParams['DISPLAY_BOTTOM_PAGER'] == 'Y') {
    echo $arResult['NAV_STRING'];
}


$templateData = ob_get_flush();
