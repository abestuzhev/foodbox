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
            col-lg-2 
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
                <div class="<?= (strtolower($arItem["PROPERTIES"]["SHILDIK"]["VALUE"]) == 'акция') ? 'act_icon' : 'new_icon' ?> hidden-xs"><?= $arItem["PROPERTIES"]["SHILDIK"]["VALUE"] ?></div>
                        <? endif; ?>
            <div class="row">
                <div class="col col-md-12">
                    <div class="in">
    <?php if ($arParams['RSMONOPOLY_USE_FAVORITE'] == "Y"): ?>
                            <div 
                                class="favorite favorite-heart"
                                data-elementid = "<?= $arItem['ID'] ?>"
                                data-detailpageurl="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                ></div>
                                <?php endif; ?>
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
                                </a>
                            </div>
                            <div class="row buy">
                                <div class="col col-xs-6 prices">
                                        <?php if ((int) $product['MIN_PRICE']['DISCOUNT_DIFF'] > 0): ?>
                                        <div class="price old">
                                        <?= $product['MIN_PRICE']['PRINT_VALUE'] ?>
                                        </div>
                                        <div class="price cool new">
                                            <?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="price cool">
        <?= $product['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?> / <?= $product["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] ?>
                                        </div>
    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
