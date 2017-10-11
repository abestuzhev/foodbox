<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$count = count($arResult['CATEGORIES']['READY']);
if (count($arResult['CATEGORIES']['READY']) > 0) {
    ?><table class="p_basket"><?
    ?><tbody><?
            for ($i = 0; $i < $count; $i++) {
                $arItem = &$arResult['CATEGORIES']['READY'][$i];

                if (!$arItem) {
                    break;
                }
                $isNewRatio = $arItem['MEASURE_NAME'] == 'кг' && $arItem['RATIO_DATA']['SHOW_NEW_RATIO'];
                ?><tr class="js-product" data-product-id="<?= $arItem["ID"] ?>"><?
                ?><td class="picture hidden-xs"><?
                    if (strlen($arItem["PICTURE_SRC"]) > 0):
                        $url = $arItem["PICTURE_SRC"];
                    elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
                        $url = $arItem["DETAIL_PICTURE_SRC"];
                    elseif ($arResult['NO_PHOTO']):
                        $url = $arResult['NO_PHOTO']['src'];
                    endif;

                    if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {
                        echo "<a href=" . $arItem["DETAIL_PAGE_URL"] . " class='outline'>";
                    }
                    ?><img alt="<?= $arItem["NAME"] ?>" src="<?= $url ?>"><?
                        if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {
                            echo '</a>';
                        }
                        ?></td><?
                        ?><td class="name"><?
                        ?><a class="aprimary" href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?
                        echo $arItem['NAME'];
                        ?></a><?
                        ?></td><?
                        ?><td class="quantity"><?
                        ?><span class = "fa minus <?= $isNewRatio ? '' : 'js-minus' ?>" id="bx_down_<?= $arItem['ID'] ?>"></span><?
                        $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                        ?><input <?
                        ?>onkeyup = "this.value = this.value.replace(/[^\d,.]*/g, '').replace(/,/g, '.').replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');" <?
                        ?>type = "text" <?
                        ?>class = "quantity_number js-quantity form-control" <?
                        ?>size = "2" <?
                        ?>value="<?= $arItem["QUANTITY"] ?>" <?
                        ?>name="QUANTITY_INPUT_<?= $arItem['ID'] ?>" <?
                        ?>id="QUANTITY_INPUT_<?= $arItem['ID'] ?>" <?
                        ?>data-ratio="<?= $ratio ?>"<?
                        ?>><?
                        ?><span class = "fa plus <?= $isNewRatio ? '' : 'js-plus' ?>" id="bx_up_<?= $arItem['ID'] ?>"></span><?
                        if ($arItem['MEASURE_NAME']) {
                            echo ' ' . $arItem['MEASURE_NAME'];
                        }
                        ?></td><? ?><td class="price"><?
                        echo $arItem['SUM'];
                        ?></td>
                    <td>
                        <? //print_r($arItem); ?>
                        <a onclick="deleteFromSmallBasket(<?= $arItem['ID'] ?>);" href="javascript:void(0);">Удалить</a>
                    </td>
                    <?
                    ?>
                    <?
                    if ($isNewRatio) {
                        $arJSParams = array(
                            'ID' => $arItem['ID'],
                            'START_RATIO' => $arItem['RATIO_DATA']['START_MEASURE_RATIO'],
                            'MIDDLE_RATIO' => $arItem['RATIO_DATA']['MIDDLE_MEASURE_RATIO'],
                            'RATIO' => $arItem['RATIO_DATA']['NEXT_MEASURE_RATIO'],
                            'RATIO_INPUT' => $ratio,
                            'CURRENT_STEP' => $arItem['RATIO_DATA']['CURRENT_STEP'],
                        );
                        $strObName = 'ob' . $arItem['ID'];
                        ?>
                <script type="text/javascript">
                    var <? echo $strObName; ?> = new JCCatalogBasket(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                </script>
            <? } ?>
        </tr>


        <?
        unset($arItem);
    }
    ?></tbody><?
    ?></table><?
} else {
    ?><p></p><p><?= GetMessage('SALE_NO_ITEMS') ?></p><?
}
