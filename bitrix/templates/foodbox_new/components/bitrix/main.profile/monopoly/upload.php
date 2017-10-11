<?php

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('main');

$userId = $USER->GetID();
$arPERSONAL_PHOTO = $_FILES["upload"];
$arFields['PERSONAL_PHOTO'] = $arPERSONAL_PHOTO;
$obUser = new CUser;
$obUser->Update($userId, $arFields, true);
