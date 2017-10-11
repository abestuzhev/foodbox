<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (htmlspecialchars($_POST["login"]) != "") {
    if (htmlspecialchars($_POST["login"]) == "fastreg") {
        $new_password = randString(7);
        $user = new CUser;
        $arFields = Array(
            "NAME" => "Новый покупатель",
            "LOGIN" => randString(7),
            "LID" => "ru",
            "ACTIVE" => "Y",
            "GROUP_ID" => array(5),
            "PASSWORD" => $new_password,
            "CONFIRM_PASSWORD" => $new_password,
        );

        $ID = $user->Add($arFields);
        if (intval($ID) > 0) {
            $USER->Authorize($ID);
        }
    } else {

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

        function hiddenMail($mail) {
            $em = explode("@", $mail);
            $name = $em[0];
            $len = strlen($name);
            $showLen = floor($len / 2);
            $str_arr = str_split($name);
            for ($ii = $showLen; $ii < $len; $ii++) {
                $str_arr[$ii] = '*';
            }
            $em[0] = implode('', $str_arr);
            $new_name = implode('@', $em);
            return $new_name;
        }

        function hiddenPhone($phone) {
            for ($i = 7; $i <= 13; $i++) {
                $phone[$i] = "*";
            }
            return $phone;
        }

        if ($_POST['mail'] == 1) {
            $filter = Array
                (
                "EMAIL" => $_POST['login'],
            );
            $rsUsers = CUser::GetList(($by = "personal_country"), ($order = "desc"), $filter);
            if ($rsUsers) {

                while ($rsUsers->NavNext(true, "f_")):

                    $rsUser1 = CUser::GetByID($f_ID);
                    $arUser = $rsUser1->Fetch();
                    $new_password = '';
                    if (strlen($arUser["UF_PASS"]) == 0) {
                        for ($i = 0; $i < 7; $i++)
                            $new_password .= rand(0, 9);
                        $user = new CUser;
                        $user->Update($f_ID, ['PASSWORD' => $new_password, 'CONFIRM_PASSWORD' => $new_password, 'UF_PASS' => $new_password]);
                    } else {
                        $new_password = $arUser["UF_PASS"];
                        $user->Update($f_ID, ['PASSWORD' => $new_password, 'CONFIRM_PASSWORD' => $new_password, 'UF_PASS' => $new_password]);
                    }
                    $headers = 'From: zakaz@foodbox.ru' . "\r\n";
                    mail($_POST["login"], "Ваш пароль", "Логин: " . $arUser["LOGIN"] . "\nПароль: " . $new_password . "\n" . $_SERVER["SERVER_NAME"], $headers);
                    echo "<p style='color:green'>Пароль выслан на Email: " . hiddenMail($arUser["EMAIL"]) . "</p>";
                    break;
                endwhile;
            }
        } else
        if ($_POST['phone'] == 1) {
            $tel = "";
            $tel = normPhone($_POST['login']);

            $filter = Array
                (
                "PERSONAL_PHONE" => $tel,
            );
            $rsUsers = CUser::GetList(($by = "personal_country"), ($order = "desc"), $filter);
            if ($rsUsers) {
                while ($rsUsers->NavNext(true, "f_")):
                    $rsUser1 = CUser::GetByID($f_ID);
                    $arUser = $rsUser1->Fetch();
                    //echo "<pre>"; echo print_r($arUser); echo "</pre>";
                    //mail("nikcfc@gmail.com","sms","Логин: ".$arUser["LOGIN"]." Пароль: ".$arUser["UF_PASS"]);
                    if ($arUser["UF_COUNT_SEND"] == 0) {
                        $_SESSION["timeout"] = date("H:i");
                        $_SESSION["timeout"] = date('H:i', strtotime($_SESSION["timeout"] . ' + 10 min'));
                        $arFields["UF_COUNT_SEND"] = 1;
                        $USER->Update($f_ID, $arFields);
                    } else {
                        $timeCurrent = date("H:i");
                        if ($_SESSION["timeout"] > $timeCurrent) {
                            $arFields["UF_COUNT_SEND"] = $arUser["UF_COUNT_SEND"] + 1;
                            $USER->Update($f_ID, $arFields);
                        } else {
                            $_SESSION["timeout"] = "";
                            $arFields["UF_COUNT_SEND"] = 0;
                            $USER->Update($f_ID, $arFields);
                        }
                    }
                    $rsUser2 = CUser::GetByID($f_ID);
                    $arUser3 = $rsUser2->Fetch();
                    $new_password = '';
                    if (strlen($arUser["UF_PASS"]) == 0) {
                        for ($i = 0; $i < 7; $i++)
                            $new_password .= rand(0, 9);
                        $user = new CUser;
                        $user->Update($f_ID, ['PASSWORD' => $new_password, 'CONFIRM_PASSWORD' => $new_password, 'UF_PASS' => $new_password]);
                    } else {
                        $new_password = $arUser["UF_PASS"];
                    }
                    if ($arUser3["UF_COUNT_SEND"] < 5) {
                        if (CModule::IncludeModule("imaginweb.sms")) {
                            $phone = $_POST['login'];
                            CIWebSMS::Send($phone, "Логин: " . $arUser["LOGIN"] . "\nПароль: " . $new_password . "\n" . $_SERVER["SERVER_NAME"]);
                        }
                        echo "<p style='color:green'>Пароль выслан на номер: " . hiddenPhone($arUser["PERSONAL_PHONE"]) . "</p>";
                    } else {
                        echo "<p style='color:red'>Превышен лимит запросов</p>";
                    }
                    break;
                endwhile;
            }
        } else {
            $filter = Array
                (
                "LOGIN" => $_POST['login'],
            );
            $rsUsers = CUser::GetList(($by = "personal_country"), ($order = "desc"), $filter);
            if ($rsUsers) {
                $sendTel = "";
                while ($rsUsers->NavNext(true, "f_")):
                    $rsUser1 = CUser::GetByID($f_ID);
                    $arUser = $rsUser1->Fetch();
                    $new_password = '';
                    if (strlen($arUser["UF_PASS"]) == 0) {
                        for ($i = 0; $i < 7; $i++)
                            $new_password .= rand(0, 9);
                        $user = new CUser;
                        $user->Update($f_ID, ['PASSWORD' => $new_password, 'CONFIRM_PASSWORD' => $new_password, 'UF_PASS' => $new_password]);
                    } else {
                        $new_password = $arUser["UF_PASS"];
                    }
                    $headers = 'From: zakaz@foodbox.ru' . "\r\n";
                    mail($arUser["EMAIL"], "Ваш пароль", "Логин: " . $arUser["LOGIN"] . " Пароль: " . $new_password, $headers);
                    if ($arUser["UF_COUNT_SEND"] < 5) {
                        if (CModule::IncludeModule("imaginweb.sms")) {
                            $phone = $arUser['PERSONAL_PHONE'];
                            CIWebSMS::Send($phone, "Логин: " . $arUser["LOGIN"] . "\nПароль: " . $new_password . "\n" . $_SERVER["SERVER_NAME"]);
                        }
                        $arFields["UF_COUNT_SEND"] = $arUser["UF_COUNT_SEND"] + 1;
                        $USER->Update($f_ID, $arFields);
                        $sendTel = " и на Телефон: " . hiddenPhone($arUser["PERSONAL_PHONE"]);
                    } else {
                        $sendTel = "";
                    }

                    echo "<p style='color:green'>Пароль  выслан на Email: " . hiddenMail($arUser["EMAIL"]) . $sendTel . "</p>";
                    break;
                endwhile;
            }
        }
    }
} else {
    echo "<p style='color:red'>Укажите свой номер, email или логин</p>";
}