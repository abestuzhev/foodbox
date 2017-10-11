<?php

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::includeModule('main');
global $USER_FIELD_MANAGER, $USER;
$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getPostList()->toArray();
$salt = 'mshop_foodbox_';
if ($request['check_code'] === 'Y') {
    $sms_confirm_code_crypt_cookies = $APPLICATION->get_cookie('SMS_CONFIRM_CODE');
    if ($sms_confirm_code_crypt_cookies == md5($salt . $request['code'])) {
        $USER_FIELD_MANAGER->Update("USER", $USER->GetID(), array('UF_SMS_CHECK' => 1));

        if (isset($request['phone'])) {
            $user = new CUser;
            $user->Update($USER->GetID(), array('PERSONAL_PHONE' => $request['phone']));
        }
        $APPLICATION->set_cookie('SMS_CONFIRM_CODE', "", time() - 60, '/');
        header('Content-Type: application/json');
        echo Bitrix\Main\Web\Json::encode(array('phone' => $request['phone'], 'error' => 0, 'code' => 'Телефон подтвержден'));
        die();
    } else {
        if (isset($request['phone'])) {
            header('Content-Type: application/json');
            echo Bitrix\Main\Web\Json::encode(array('code' => 'Проверочный код не верный', 'error' => 3));
            die();
        } else
            echo false;
    }
} else {
    $phone = $request['tel'];
    $code = randString(5, "0123456789");
    $arUser = CUser::GetByID($USER->GetID())->Fetch();
    $isPhone = CUser::GetList(($by = "ID"), ($order = "DESC"), array('PERSONAL_PHONE' => $phone))->SelectedRowsCount() > 0;
    $sendCode = md5($salt . $code);
    $values = $USER_FIELD_MANAGER->GetUserFields("USER", $USER->GetID());

    if (strlen($phone) < 16) {
        header('Content-Type: application/json');
        echo Bitrix\Main\Web\Json::encode(array('code' => 'Не указан номер телефона', 'error' => 2));
        die();
    }
    if ($isPhone) {
        header('Content-Type: application/json');
        echo Bitrix\Main\Web\Json::encode(array('code' => 'Этот номер уже привязан к другой учётной записи.', 'error' => 1));
        die();
    } else if (!$values['UF_SMS_CHECK']['VALUE'] || $phone != $arUser['PERSONAL_PHONE']) {
        if (CModule::IncludeModule("imaginweb.sms")) {
          
            $sms = new CIWebSMS();
            $sms->Send($phone, 'Код для подтверждения телефона ' . $code);
            $APPLICATION->set_cookie('SMS_CONFIRM_CODE', $sendCode, time() + 60 * 60, '/');
        }
    }
}

