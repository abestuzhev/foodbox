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
            col col-xs-12
            col-sm-6
            col-lg-3 
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
                <?= Loc::getMessage('DA2_ICON_TITLE') ?>
            </div>
            <div class="qb_icon hidden-xs">
                <?= Loc::getMessage('QB_ICON_TITLE') ?>
            </div>
            <? if ($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]): ?>
                <div class="<?= ((strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : (strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'скидка' ? 'skidka_icon' : 'new_icon')) ?> hidden-xs"><?= $arItem["PROPERTIES"]["SHILDIK"]["VALUE"] ?></div>
            <? endif; ?>

            <div class="row">
                <div class="col col-md-12">
                    <div class="in">
                        <div class="pic">
                            <a class="js-detail_page_url" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
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
                        <div class="data">
                            <div class="name">
                                <a 
                                    class="aprimary" 
                                    href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                    title="<?= $arItem['NAME'] ?>">
                                        <?= $arItem['NAME'] ?>
                                </a><br>
                                <div class="article previewtext"><?= $arItem['PREVIEW_TEXT'] ?></div>
                                <div class="article">Артикул: <?= $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></div>
                                <div class="nalichei">
                                    Наличие на складе: <?
                                    if (!$arItem["PROPERTIES"]["STATUS_SKLAD"]["VALUE"]) {
                                        echo '<strong class="green">Да</strong>';
                                    } elseif ($arItem["PROPERTIES"]["STATUS_SKLAD"]["VALUE"] == "Нет") {
                                        echo '<strong class="red">Нет</strong>';
                                    } else {
                                        echo '<strong class="yellow">Под заказ</strong>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="row buy">

                                <div class="col col-xs-12 prices text-center">
                                    <?php if ((int) $product['MIN_PRICE']['DISCOUNT_DIFF'] > 0): ?>
                                        <div class="price old">
                                            <?= $product['MIN_PRICE']['PRINT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?>
                                        </div>
                                        <div class="price cool new">
                                            <?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="price cool">
                                            <?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>/<?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class='fromN'>
                                        <?
                                        if ($arItem['CATALOG_MEASURE_RATIO'] > 1) {
                                            echo "Заказ от " . $arItem['CATALOG_MEASURE_RATIO'] . " шт.";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row bot text-center">
                                <div class="col col-xs-12 text-left buybtn text-center">
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
                                                <?php
                                                if (!$product['CAN_BUY']) {
                                                    echo 'cantbuy';
                                                }
                                                ?>
                                                "
                                                name="add2basketform"
                                                >

                                                <? if ($arParams['USE_PRODUCT_QUANTITY']) { ?>
                                                    <span class="quantity">
                                                        <a class="minus <?= $arItem['CATALOG_MEASURE'] == 4 && $arItem['SHOW_NEW_RATIO'] ? '' : 'js-minus' ?>" id="bx_down_<?= $arItem['ID'] ?>"><i class="fa"></i></a>
                                                        <input onkeyup="this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" type="text" class="js-quantity text-center" name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>" value="<?= $arItem['CATALOG_MEASURE'] == 4 && $arItem['SHOW_NEW_RATIO'] ? $arItem['START_MEASURE_RATIO'] : $arItem['CATALOG_MEASURE_RATIO'] ?>" data-ratio="<?= $arItem['CATALOG_MEASURE_RATIO'] ?>" id="bx_quantity_<?= $arItem['ID'] ?>">

                                                        <a class="plus <?= $arItem['CATALOG_MEASURE'] == 4 && $arItem['SHOW_NEW_RATIO'] ? '' : 'js-plus' ?>" id="bx_up_<?= $arItem['ID'] ?>"><i class="fa"></i></a>
                                                        <span class="js-measurename"><?= $arItem['CATALOG_MEASURE_NAME'] ?></span>
                                                    </span>
                                                    <?
                                                }
                                                // LEEFT
                                                ?>


                                                <input type="hidden" name="action" value="ADD2BASKET">
                                                <input
                                                    type="hidden" 
                                                    name="<?= $arParams['PRODUCT_ID_VARIABLE'] ?>" 
                                                    class="js-add2basketpid" 
                                                    value="<?= $product['ID'] ?>"
                                                    >
                                                <button type="submit" rel="nofollow" class="submit js-add2basketlink" value="">
                                                    <?= Loc::getMessage('RS.MONOPOLY.BTN_BUY') ?>
                                                </button>
                                                <a class="inbasket" href="<?= $arParams['BASKET_URL'] ?>">
                                                    <?= Loc::getMessage('RS.MONOPOLY.BTN_GO2BASKET') ?>
                                                </a>
                                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="btn btn-primary js-morebtn buybtn">
                                                    <?= Loc::getMessage('RS.MONOPOLY.BTN_MORE') ?>
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
                                      <?=Loc::getMessage('RS.MONOPOLY.COMPARE')?>
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
            </div>
        </div>
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
