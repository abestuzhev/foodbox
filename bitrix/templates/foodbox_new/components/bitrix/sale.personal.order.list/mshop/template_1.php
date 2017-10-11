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

    // Links
    /* ?><div class="row buttonPersonalOrderList"><?
      ?><div class="col-md-12"><?
      $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
      ?><a href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y" class = "btn btn-default <?=$nothing || isset($_REQUEST["filter_history"])?'':'btn-primary'?>"><?=Loc::getMessage('SPOL_ORDERS_ALL');?></a> <?
      ?><a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N" class = "btn btn-default <?=$_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'?'':'btn-primary'?>"><?=Loc::getMessage('SPOL_CUR_ORDERS');?></a> <?
      ?><a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y" class = "btn btn-default <?=$nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'?'':'btn-primary'?>"><?=Loc::getMessage('SPOL_ORDERS_HISTORY');?></a><?
      ?></div><?
      ?></div><? */
    ?><br><?
    // Orders
    ?><div class="personalOrderList"><?
    ?><div class="col col-md-12"><?
        /*
          if($_GET['show_all']=='Y'):
          $APPLICATION->SetTitle("История заказов");
          else:
          $APPLICATION->SetTitle("Активные заказы");
          endif; */
//echo "<pre>"; echo print_r($order['ORDER']); echo "</pre>";
        ?>
            <!--<div class="col col-md-9 col-md-push-3 maincontent">-->
            <? /* 	<div class="js-ttl">
              <div class="page-header"><h1>История заказов</h1></div>
              </div>
              <div class="js-brcrtitle"><ul id="breadcrumbs" class="list-unstyled clearfix" itemscope="" itemtype="http://schema.org/BreadcrumbList"><li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" href="/" title="Главная"><span itemprop="name">Главная</span></a></li><li class="arrow"></li><li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><span itemprop="name">Персональный раздел</span></li></ul></div> */ ?>

            <? /* if($_GET['show_all']=='Y'):?>
              <div class="row orders_btns">
              <div class="col-md-12">
              <a href="" class="btn btn-primary--grey">История заказов</a>
              <a href="" class="btn btn-primary">Активные заказы</a>
              </div>
              </div>
              <?endif; */ ?>


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

            <!--</div>-->
            <?
            /* ?><table class="table table-striped"><?
              foreach ($arResult['ORDERS'] as $index => $order){

              $orderStatusId = $order['ORDER']['CANCELED'] == 'Y' ?
              'PSEUDO_CANCELLED' : $order["ORDER"]["STATUS_ID"];
              ?><tr><?
              ?><td class="hidden-xs"><?=$index+1;?></td><?
              ?><td style="width: 100%;"><?
              // Detail link
              ?><a class="aprimary nameOrder" href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?
              ?><?=Loc::getMessage('SPOL_ORDER')?> <?
              ?><?=Loc::getMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?><?
              // ORDER DATE
              if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])) {
              ?> <?= GetMessage('SPOL_FROM') ?> <?= $order["ORDER"]["DATE_INSERT_FORMATED"]; ?><?
              }
              ?></a><?
              // Label
              $CSSClass = 'label label-success';
              if($arResult["INFO"]["STATUS"][$orderStatusId]['COLOR']=='yellow'){
              $CSSClass = 'label label-warning';
              } elseif($arResult["INFO"]["STATUS"][$orderStatusId]['COLOR']=='red'){
              $CSSClass = 'label label-danger';
              } elseif($arResult["INFO"]["STATUS"][$orderStatusId]['COLOR']=='gray'){
              $CSSClass = 'label label-info';
              }
              ?>&nbsp;&nbsp;<span class="<?=$CSSClass;?>"><?
              ?><?=$arResult["INFO"]["STATUS"][$orderStatusId]['NAME']?><?
              ?></span><?
              ?><br><?

              // IS PAYED
              ?><?=Loc::getMessage('SPOL_PAYED')?>: <?
              ?><?=Loc::getMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?><br><?

              // PAY SYSTEM
              if(intval($order["ORDER"]["PAY_SYSTEM_ID"])) {
              ?><?= Loc::getMessage('SPOL_PAYSYSTEM') ?>: <?
              ?><?= $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"] ?><br><?
              }

              // DELIVERY SYSTEM
              if(intval($order["ORDER"]["DELIVERY_ID"]) ||
              strpos($order["ORDER"]["DELIVERY_ID"], ':') !== "false") {
              ?><?= Loc::getMessage('SPOL_DELIVERY') ?>: <?
              if (intval($order["ORDER"]["DELIVERY_ID"])) {
              ?><?= $arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"] ?><br><?
              } elseif (strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false) {
              $arId = explode(":", $order["ORDER"]["DELIVERY_ID"]);
              ?><?= $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"] ?><?
              ?>(<?= $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"] ?>)<br><?
              }
              }

              // Basket
              ?><br><?
              ?><ul class="list-unstyled"><?
              foreach ($order["BASKET_ITEMS"] as $item) {
              ?><li><?
              ?><?= $item['NAME'] ?> - <?
              ?><?= $item['QUANTITY'] ?><?
              ?><?= (isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : Loc::getMessage('SPOL_SHT')) ?><?
              ?></li><?
              }
              ?></ul><?

              ?><?=Loc::getMessage('SPOL_PAY_SUM')?>: <?=$order["ORDER"]["FORMATED_PRICE"]?><?

              /* Show on mobile device */
            /* 	?><div class="visible-xs"><?
              ?><a class="aprimary" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><?
              ?><?=Loc::getMessage('SPOL_CANCEL_ORDER');?><?
              ?></a><br><?
              ?><a class="aprimary" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?
              ?><?=Loc::getMessage('SPOL_REPEAT_ORDER');?><?
              ?></a><?
              ?></div><?
              /* /Show on mobile device */

            /* ?></td><?

              /* Hidden on mobile device */
            /* ?><td class="hidden-xs"><?
              ?><a class="aprimary" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><?
              ?><?=Loc::getMessage('SPOL_CANCEL_ORDER');?><?
              ?></a><?
              ?></td><?
              ?><td class="hidden-xs"><?
              ?><a class="aprimary" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><?
              ?><?=Loc::getMessage('SPOL_REPEAT_ORDER');?><?
              ?></a><?
              ?></td><?
              /* /Hidden on mobile device */

            /* 	?></tr><?
              }
              ?></table><? */
            ?></div><?
            ?></div><?
    if (strlen($arResult['NAV_STRING'])) {
        echo $arResult['NAV_STRING'];
    }

    if (empty($arResult['ORDERS'])) {
        ?><div class="alert alert-info" role="alert"><?= GetMessage('SPOL_NO_ORDERS') ?></div><?
    }
}

