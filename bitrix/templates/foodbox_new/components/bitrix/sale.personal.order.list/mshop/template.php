<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

if (!empty($arResult['ERRORS']['FATAL'])) {

    foreach ($arResult['ERRORS']['FATAL'] as $error) {
        echo ShowError($error);
    }
} else {

    if (!empty($arResult['ERRORS']['NONFATAL'])) {
        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
            echo ShowError($error);
        }
    }
    ?><div class="row orders_btns"><?
    ?><div class="col-md-12"><?
        $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
        ?><a href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=N" class = "btn btn <?= $nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y' ? ' btn-primary' : 'btn-primary--grey' ?>"><?= Loc::getMessage('SPOL_CUR_ORDERS'); ?></a> <?
        ?><a href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=Y" class = "btn btn <?= $_REQUEST["filter_history"] == 'Y' ? ' btn-primary' : 'btn-primary--grey' ?>"><?= Loc::getMessage('SPOL_ORDERS_HISTORY'); ?></a><?
        ?></div><?
        ?></div><?
        ?>
    <br>


    <div class="orders_title">Информация о заказах:</div>
    <div class="history-orders"></div>
    <div class="active-orders">

        <? foreach ($arResult['ORDERS'] as $index => $order): ?>

            <?
            $orderStatusId = $order['ORDER']['CANCELED'] == 'Y' ?
                    'PSEUDO_CANCELLED' : $order["ORDER"]["STATUS_ID"];
            ?>

            <div class="c-card-order">
                <div class="c-card-order_header">
                    <div class="row">
                        <div class="col col-xs-6">
                            <div class="c-card-order_title">Заказ от 
                                <? if (strlen($order["ORDER"]["DATE_INSERT_FORMATED"])) {
                                    ?><?=
                                    // $order["ORDER"]["DATE_INSERT_FORMATED"];
                                    $date = new DateTime($order["ORDER"]["DATE_INSERT_FORMATED"]);
                                    echo $date->format('d');
                                    echo " " . FormatDate("F", MakeTimeStamp($order["ORDER"]["DATE_INSERT_FORMATED"]));
                                }
                                ?>

                                <a href="<?= $order["ORDER"]["URL_TO_DETAIL"] ?>" class="c-card-order_number">№<?= $order["ORDER"]["ACCOUNT_NUMBER"] ?></a></div>
                        </div>
                        <div class="col col-xs-6 btn-right">
                            <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>" class="c-card-order_link c-card-order_link--icon color-orange">Повторить заказ</a>
                            <a href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>" class="c-card-order_link">Отменить</a>
                        </div>
                    </div>
                </div>
                <div class="c-card-order_body">
                    <div class="c-card-order_address">Адрес доставки: 
                        <?
                        $dbOrderProps = CSaleOrderPropsValue::GetList(
                                        array("SORT" => "ASC"), array("ORDER_ID" => $order['ORDER']["ID"], "CODE" => array("ADDRESS"))
                        );
                        $arOrderProps = $dbOrderProps->GetNext();
                        echo $arOrderProps['VALUE_ORIG'];
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="c-card-order_item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/images/icon-star.png" alt="" class="c-card-order_icon">
                                <div class="c-card-order_item-title color-orange"><?
                                    // Label
                                    echo $arResult["INFO"]["STATUS"][$orderStatusId]['NAME']
                                    ?>
                                </div>
                                <div class="c-card-order_item-subtitle">Состояние заказа</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="c-card-order_item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/images/icon-calendare.png" alt="" class="c-card-order_icon">
                                <div class="c-card-order_item-title">
                                    <?
                                    if (strlen($order["ORDER"]["DATE_INSERT_FORMATED"])) {
                                        ?><?
                                        //=$order["ORDER"]["DATE_INSERT_FORMATED"];
                                        $date = new DateTime($order["ORDER"]["DATE_INSERT_FORMATED"]);
                                        echo $date->format('d.m.y');
                                    }
                                    ?>
                                </div>
                                <div class="c-card-order_item-subtitle">Дата заказа</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="c-card-order_item">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/images/icon-purse.png" alt="" class="c-card-order_icon">
                                <div class="c-card-order_item-title"><?=
                                    //$order["ORDER"]["PRICE"]
                                    number_format($order["ORDER"]["PRICE"], 2, ',', " ");
                                    ?><span>&nbsp;₽</span></div>
                                <div class="c-card-order_item-subtitle"><span class="color-orange"><?= trim(Loc::getMessage('SPOL_' . ($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))) ?></span><? if ($order["ORDER"]["PAYED"] != "Y"): ?>(<?= mb_strtolower($arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]); ?>)
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--END c-card-order-->
        <? endforeach; ?>
    </div>
    <?
    if (strlen($arResult['NAV_STRING'])) {
        echo $arResult['NAV_STRING'];
    }

    if (empty($arResult['ORDERS'])) {
        ?><div class="alert alert-info" role="alert"><?= GetMessage('SPOL_NO_ORDERS') ?></div><?
    }
}

