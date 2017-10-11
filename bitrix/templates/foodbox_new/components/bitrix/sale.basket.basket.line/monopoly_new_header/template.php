<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?><div class = "dropdown-basketinhead js-basketline <?= $_REQUEST['open'] == 'Y' ? 'open' : '' ?>">
<?
if (isset($_REQUEST['AJAX']) && $_REQUEST['AJAX'] == 'Y' && isset($_REQUEST['REFRESH_BASKET_LINE']) && $_REQUEST['REFRESH_BASKET_LINE'] == 'Y') {
    $APPLICATION->EndBufferContent();
    $APPLICATION->RestartBuffer();
}
if ($arParams['JSON'] == 'Y') {
    $this->SetViewTarget("ddbasketinhead");
}
?>
    <a href="<?= $arParams['PATH_TO_BASKET'] ?>" id="ddbasketinhead" aria-expanded="false" class="cart__link">
        <div class="descr" id="basketinfo">
            <?
            if ($arParams['JSON'] != 'Y') {
                $frame = $this->createFrame('basketinfo', false)->begin();
            }
            ?>
            <div class="descr__number"><?= $arResult["NUM_PRODUCTS"] ?></div>
            <?
            if ($arParams['JSON'] != 'Y') {
                $frame->beginStub();
                echo GetMessage('RS.MONOPOLY.SMALLBASKET_PUSTO');
                $frame->end();
            }
            ?>
        </div>
        <img src="<?= SITE_TEMPLATE_PATH ?>/styles/img/cart.png" alt="">
        <div class="cart__wrap">
            <span class="cart__text">товаров на сумму:</span>
            <div class="cart__issue">
                <span class="cart__price"><?= $arResult["TOTAL_PRICE"] ?></span>
                <button class="cart__submit" type="submit" onclick="showPopupOformlenie();">Оформить</button>
            </div>
        </div>
    </a>
    <div class="dropdown-smallbasket" aria-labelledby="ddbasketinhead">
        <div class="section items"><?
            include($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/items.php');
            ?>
        </div>
        <div class="section text-right">
            <div class="smallbasketAllSum">Сумма заказа: <b><?= $arResult["TOTAL_PRICE"] ?></b></div><?
            ?><a onClick="SendAnalyticsGoal('perehod-korzina');" class="btn btn-default gotoorder" href="<?= $arParams['PATH_TO_BASKET'] ?>"><?= GetMessage('RS.MONOPOLY.GOTO_BASKET') ?></a>
            <? if (intVal($arResult['NUM_PRODUCTS']) > 0): ?><a onclick="showPopupOformlenie();"  class="btn  btn-primary">Оформить заказ</a> &nbsp; <? endif; ?>
        </div>
    </div>
    <script type="text/javascript">RSMONOPOLY_DropFancy();</script>
    <?
    if (isset($_REQUEST['AJAX']) && $_REQUEST['AJAX'] == 'Y' && isset($_REQUEST['REFRESH_BASKET_LINE']) && $_REQUEST['REFRESH_BASKET_LINE'] == 'Y') {
        die();
    }
    if ($arParams['JSON'] == 'Y') {
        $this->EndViewTarget();
        $templateData['ddbasketinhead'] = $APPLICATION->GetViewContent('ddbasketinhead');
    }
    ?>
</div>
    <?