<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$arFields = htmlspecialcharsbx($_POST["login"]);

function normPhone($phone) {
    $resPhone = preg_replace("/[^0-9]/", "", $phone);

    if (strlen($resPhone) === 11) {
        $resPhone = preg_replace("/^7|8/", "+7", $resPhone);
    }
    if (strlen($resPhone) == 10) {
        $resPhone = "+7" . $resPhone;
    }
    $resPhone = substr_replace($resPhone, "(", 2, 0);
    $resPhone = substr_replace($resPhone, ")", 6, 0);
    $resPhone = substr_replace($resPhone, "-", 10, 0);
    $resPhone = substr_replace($resPhone, "-", 13, 0);
    return $resPhone;
}

$USER = new CUser();
if (!filter_var($_POST["login"], FILTER_VALIDATE_EMAIL)) {
    $filter = Array(
        "PERSONAL_PHONE" => htmlspecialcharsbx(normPhone($_POST["login"])),
    );
    $rsUsers = $USER->GetList(($by = "personal_country"), ($order = "desc"), $filter);
    $arUser = $rsUsers->Fetch();
    if ($arUser) {
        $arFields = $arUser["LOGIN"];
    }
    if (strlen($arFields) == 0) {
        $filter = Array(
            "=LOGIN" => htmlspecialcharsbx(normPhone($_POST["login"])),
        );
        $rsUsers = $USER->GetList(($by = "personal_country"), ($order = "desc"), $filter);
        $arUser = $rsUsers->Fetch();
        if ($arUser) {
            $arFields = $arUser["LOGIN"];
        }
    }
} else {
    $filter = Array
        (
        "=EMAIL" => htmlspecialcharsbx($_POST["login"]),
    );
    $rsUsers1 = $USER->GetList(($by = "personal_country"), ($order = "desc"), $filter);
    $arUser1 = $rsUsers1->Fetch();
    if ($arUser1) {
        $arFields = $arUser1["LOGIN"];
    }
}

if (($USER->login($arFields, $_POST["password"])) != 1) {
    echo"<p style='color:red'>Неверный логин или пароль</p>";
}
