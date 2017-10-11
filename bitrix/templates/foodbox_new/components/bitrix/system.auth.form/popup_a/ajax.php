<?php

//define('STOP_STATISTICS', true);
//define('NOT_CHECK_PERMISSIONS', true);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

//header('Content-Type: text/html; charset='.LANG_CHARSET);
$_POST['arParams']['AUTH_RESULT'] = $APPLICATION->arAuthResult;
$APPLICATION->IncludeComponent('bitrix:system.auth.form', $_POST['templateName'], $_REQUEST['arParams']);
?>
