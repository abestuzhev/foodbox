<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

require_once $_SERVER["DOCUMENT_ROOT"] . $templateFolder . '/functions.php';

if ($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y") {
    if ($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
        if (strlen($arResult["REDIRECT_URL"]) > 0) {
            $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                window.top.location.href = '<?= CUtil::JSEscape($arResult["REDIRECT_URL"]) ?>';
            </script>
            <?
            die();
        }
    }
}
?>

<?
if (!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N") {

    if (!empty($arResult["ERROR"])) {

        foreach ($arResult["ERROR"] as $v) {
            echo ShowError($v);
        }
    } elseif (!empty($arResult["OK_MESSAGE"])) {

        foreach ($arResult["OK_MESSAGE"] as $v) {
            echo ShowNote($v);
        }
    }
    include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/auth.php");
} else {
    if ($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
        if (strlen($arResult["REDIRECT_URL"]) == 0) {
            include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/confirm.php";
        }
    } else {
        ?>
        <script type="text/javascript">

        <? if (CSaleLocation::isLocationProEnabled()): ?>

            <?
            // spike: for children of cities we place this prompt
            $city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
            ?>

                BX.saleOrderAjax.init(<?=
            CUtil::PhpToJSObject(array(
                'source' => $this->__component->getPath() . '/get.php',
                'cityTypeId' => intval($city['ID']),
                'messages' => array(
                    'otherLocation' => '--- ' . GetMessage('SOA_OTHER_LOCATION'),
                    'moreInfoLocation' => '--- ' . GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
                    'notFoundPrompt' => '<div class="-bx-popup-special-prompt">' . GetMessage('SOA_LOCATION_NOT_FOUND') . '.<br />' . GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
                        '#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
                        '#ANCHOR_END#' => '</a>'
                    )) . '</div>'
                )
            ))
            ?>);

        <? endif ?>

            var BXFormPosting = false;
            function submitForm(val)
            {
                if (BXFormPosting === true)
                    return true;

                BXFormPosting = true;
                if (val != 'Y')
                    BX('confirmorder').value = 'N';

                var orderForm = BX('ORDER_FORM');
                BX.showWait();

        <? if (CSaleLocation::isLocationProEnabled()): ?>
                    BX.saleOrderAjax.cleanUp();
        <? endif ?>

                BX.ajax.submit(orderForm, ajaxResult);

                return true;
            }

            function ajaxResult(res)
            {
                var orderForm = BX('ORDER_FORM');
                try
                {
                    // if json came, it obviously a successfull order submit

                    var json = JSON.parse(res);
                    BX.closeWait();

                    if (json.error)
                    {
                        BXFormPosting = false;
                        return;
                    } else if (json.redirect)
                    {
                        SendAnalyticsGoal('produkt-zakaz');

                        window.top.location.href = json.redirect;
                    }
                } catch (e)
                {
                    // json parse failed, so it is a simple chunk of html

                    BXFormPosting = false;
                    BX('order_form_content').innerHTML = res;

        <? if (CSaleLocation::isLocationProEnabled()): ?>
                        BX.saleOrderAjax.initDeferredControl();
        <? endif ?>
                }

                BX.closeWait();
                BX.onCustomEvent(orderForm, 'onAjaxSuccess');
            }

            function SetContact(profileId)
            {
                BX("profile_change").value = "Y";
                submitForm();
            }

            //Маска ввода телефона


        </script>
        <?
        if ($_POST["is_ajax_post"] != "Y") {
            ?><div id="formOrderDiv"><form action="<?= $APPLICATION->GetCurPage(); ?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
            <?= bitrix_sessid_post() ?><?
            ?><div id="order_form_content"><?
        } else {
            $APPLICATION->RestartBuffer();
        }

        if ($_REQUEST['PERMANENT_MODE_STEPS'] == 1) {
            ?><input type="hidden" name="PERMANENT_MODE_STEPS" value="1"><?
                }

                if (!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y") {

                    foreach ($arResult["ERROR"] as $v) {
                        echo ShowError($v);
                    }
                    ?>
                        <script type="text/javascript">
                            top.BX.scrollToNode(top.BX.findParent(top.BX('ORDER_FORM')));
                        </script>
                        <?
                    }
                    ?>


                    <div id="popupOrderDiv">
                        <h2>Оформить заказ</h2>
                        <div id="customerInfo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCustomerInfo">
                            <div class="panel-body">
                                <div class = "row">
        <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/person_type.php"; ?>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-sm-4 col-md-4 col-lg-4 order_props">
                                    <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/props.php"; ?>						
                                <div class="col col-md-11 prop_ADDRESS" data-property-id-row="7">
                                    <label for = "ORDER_DESCRIPTION"><?= Loc::getMessage('SOA_TEMPL_SUM_COMMENTS_TEXT'); ?></label>
                                    <textarea class = "form-control" name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?= $arResult["USER_VALS"]["ORDER_DESCRIPTION"] ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 delivery_payment">						
                                <h2>Оплата</h2>
        <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/paysystem.php"; ?>
                                <h2>Доставка</h2>
        <? include $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/delivery.php"; ?>

                            </div>
                        </div>
                        <hr>
                        <div class = "row">
                            <div class="col col-xs-10 col-md-10 col-md-push-10  buttons">
                                <input type="button" class="btn btn-primary btn-order" onclick="submitForm('Y'); return false" value="<?= Loc::getMessage("SOA_TEMPL_BUTTON") ?>">
                            </div>
                        </div>					
                    </div>




        <?
        if ($_POST["is_ajax_post"] != "Y") {
            ?></div><? ?><input type="hidden" name="confirmorder" id="confirmorder" value="Y"><? ?><input type="hidden" name="profile_change" id="profile_change" value="N"><? ?><input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y"><? ?><input type="hidden" name="json" value="Y"><? ?></form></div><?
        } else {
            ?>
            <script type="text/javascript">
                top.BX('confirmorder').value = 'Y';
                top.BX('profile_change').value = 'N';
            </script>
                        <?
                    die();
                }
            }
        }
        ?>


<? if (CSaleLocation::isLocationProEnabled()): ?>

    <div style="display: none">
    <? // we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it ?>
    <?
    $APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.steps", ".default", array(
            ), false
    );
    ?>
    <?
    $APPLICATION->IncludeComponent(
            "bitrix:sale.location.selector.search", ".default", array(
            ), false
    );
    ?>
    </div>

        <?
    endif;