<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?><div class="bx-auth-profile"><?
if ($arResult['strProfileError'] != '') {
    ?><div class="alert alert-danger" role="alert"><?= $arResult['strProfileError'] ?></div><?
    }

    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?><? /* <script type="text/javascript">
      <!--
      var opened_sections = [<?
      $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"] . "_user_profile_open"];
      $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
      if (strlen($arResult["opened"]) > 0) {
      echo "'" . implode("', '", explode(",", $arResult["opened"])) . "'";
      } else {
      $arResult["opened"] = "reg";
      echo "'reg'";
      }
      ?>];
      //-->
      var cookie_prefix = '<?= $arResult["COOKIE_PREFIX"] ?>';
      </script> */ ?><? ?><?
    ?></div><? ?>

<?php
//print_var($arResult, true);
$arUser = $arResult['arUser'];

//echo $arResult['strProfileError'];
?>
<? if (strlen($arResult['strProfileError']) > 0): ?>
    <div class="alert alert-danger" role="alert"><?= $arResult['strProfileError'] ?></div>
<? endif; ?>

<div class="profile">
    <form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data" class="c-form">
        <? echo $arResult["BX_SESSION_CHECK"]; ?>
        <input type="hidden" name="lang" value="<?= LANG ?>" />
        <input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />
        <input type="hidden" name="LOGIN" value="<?= $arUser['LOGIN'] ?>">
        <div class="row">
            <div class="col col-sm-7 col-md-7">
                <div class="c-card-profile">
                    <div class="c-card-profile_title">Личная информация</div>
                    <div class="c-form_item">
                        <label for="profile_name">Ф.И.О:</label>
                        <input type="text" id="profile_name" placeholder="Иванов Иван Иванович" value="<?= $USER->GetFullName() ?>">
                        <input type="hidden" id="name" name="NAME" value="<?= $arUser['NAME'] ?>">
                        <input type="hidden" id="l_name" name="LAST_NAME" value="<?= $arUser['LAST_NAME'] ?>">
                        <input type="hidden" id="s_name" name="SECOND_NAME" value="<?= $arUser['SECOND_NAME'] ?>">
                    </div>
                    <div class="row">
                        <div class="col col-md-8">
                            <label for="possible-answer-4">Ваш пол:</label>
                            <div class="c-form_item c-form_item--inline">
                                <input type="radio" name="PERSONAL_GENDER" id="profile_gender-man" value="M" <?= $arUser['PERSONAL_GENDER'] == 'M' ? 'checked' : '' ?>>
                                <label for="profile_gender-man">Мужской</label>
                            </div>
                            <div class="c-form_item c-form_item--inline">
                                <input type="radio" name="PERSONAL_GENDER" id="profile_gender-woman" value="F" <?= $arUser['PERSONAL_GENDER'] == 'F' ? 'checked' : '' ?>>
                                <label for="profile_gender-woman">Женский</label>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="c-form_item">
                                <label for="profile_date">Дата рождения:</label>
                                <input type="text" id="profile_date" class="js-profile_date" placeholder="__.__._____" name="PERSONAL_BIRTHDAY" value="<?= $arUser['PERSONAL_BIRTHDAY'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-sm-5 col-md-5">
                <div class="c-card-profile">
                    <div class="c-card-profile_title">Аватарка</div>
                    <label>Будет видна в отзывах к товарам</label>
                    <div class="avatar-upload">
                        <?
                        if ((int) $arUser['PERSONAL_PHOTO'] > 0) {
                            $file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_EXACT, true);
                            //$file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 200, 'height' => 200), BX_RESIZE_IMAGE_EXACT, true);
                        }
                        ?>
                        <img src="<?= (int) $arUser['PERSONAL_PHOTO'] > 0 ? $file['src'] : SITE_TEMPLATE_PATH . '/images/avatar-default.jpg' ?>">
                        <div class="avatar-upload_title">загрузить</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-sm-7 col-md-7">
                <div class="c-card-profile">
                    <div class="c-card-profile_title">Контактная информация</div>

                    <div class="c-form_item">
                        <label for="profile_phone">Телефон:</label>
                        <div class="input-group">
                            <input type="text" id="profile_phone" placeholder="Тел: +7(___)___-__-__" class="phone-mask"  value="<?= $arUser['PERSONAL_PHONE'] ?>" name="PERSONAL_PHONE">
                            <? if (!$arUser['UF_SMS_CHECK']): ?>
                                <div class="input-group-btn"><button class="c-form_button" id="sendCode">Получить код</button></div>
                            <? else: ?>
                                <div class="input-group-btn"><button class="c-form_button checked">Номер проверен</button></div>
                            <? endif; ?>
                        </div>
                    </div>
                    <? if (!$arUser['UF_SMS_CHECK'] && false): ?>
                        <div class="c-form_item">
                            <label for="profile_code">Полученный код активации: <span class="c-form_note-example">Пример: 65609</span>
                                <a href="#" class="c-form_link">Не пришло СМС-сообщение?</a></label>
                            <div class="input-group">
                                <input type="password" id="profile_code" placeholder="Введите код">
                                <div class="input-group-btn"><button class="c-form_button bg-grey" id="check">Подтвердить</button></div>
                            </div>
                        </div>
                    <? endif; ?>
                    <div class="c-form_item">
                        <label for="profile_newPass">Дополнительный номер:</label>
                        <? if (strlen($arUser['PERSONAL_MOBILE'] <= 0)): ?>
                            <div class="l-form_button"><a class="c-form_button js-add-additional_phone">Добавить</a></div>
                        <? endif; ?>
                        <input style="display:<?= strlen($arUser['PERSONAL_MOBILE'] > 0) ? 'block' : 'none' ?>;" type="text" id="additional_phone" placeholder="Тел: +7(___)___-__-__" class="phone-mask"  name="PERSONAL_MOBILE"  value="<?= $arUser['PERSONAL_MOBILE'] ?>">
                    </div>
                    <div class="c-form_item">
                        <label for="profile_adress">Адрес доставки</label>
                        <div class="input-group">
                            <input type="text" id="profile_adress" placeholder="" value="<?= $arUser['PERSONAL_CITY'] ?>" name="PERSONAL_CITY">
                            <div class="input-group-btn"><button class="c-form_button js-click-adress">Сохранить</button></div>
                        </div>
                    </div>

                    <div class="c-form_item">
                        <label for="profile_email">Электронная почта:</label>
                        <div class="input-group">
                            <input type="text" id="profile_email" placeholder="yourname@example.com" value="<?= $arUser['EMAIL'] ?>" name="EMAIL">
                            <div class="input-group-btn"><button class="c-form_button">Подтвердить</button></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col col-sm-5 col-md-5">
                <div class="c-card-profile">
                    <div class="c-card-profile_title">Изменение пароля</div>

                    <!--                    <div class="c-form_item">
                                            <label for="profile_oldPass">Старый пароль</label>
                                            <input type="password" id="profile_oldPass">
                                        </div>-->
                    <div class="c-form_item">
                        <label for="profile_newPass">Новый пароль:</label>
                        <input type="password" id="profile_newPass" name="NEW_PASSWORD">
                    </div>
                    <div class="c-form_item">
                        <label for="profile_newPass-confirmation">Новый пароль еще раз:</label>
                        <input type="password" id="profile_newPass-confirmation" name="NEW_PASSWORD_CONFIRM">
                        <div class="c-popup_note">Придумайте сложный пароль, который нельзя подобрать: от 6 до 20 символов -
                            цифры, английские буквы и спецсимволы.</div>
                    </div>
                    <div class="l-form_button btn-right"><button class="c-form_button" name="save" type="submit" value="save">Изменить</button></div>

                </div>
            </div>
        </div>
        <hr>
        <div class="l-form_button btn-right"><button class="c-form_button js-button" name="save" type="submit" value="save">Сохранить изменения</button></div>
        <div class="social-profile">
            <div class="social-profile_title">Авторизация через социальные сети</div>
            <div class="social-profile_text">Подключите свой профиль в социальной сети, чтобы авторизоваться без ввода пароля в дальнейшем.</div>
            <?
            $oAuthManager = new CSocServAuthManager();
            $arServices = $oAuthManager->GetActiveAuthServices($arResult);
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "social", array(
                "AUTH_SERVICES" => $arServices,
                "AUTH_URL" => $arResult["AUTH_URL"],
                "POST" => $arResult["POST"],
                "POPUP" => "Y",
                "SUFFIX" => "form",
                    ), $component, array("HIDE_ICONS" => "N")
            );
            ?>
        </div>
    </form>
</div><!--END profile-->

<script>
    new window.AvatarUpload({
        el: document.querySelector('.avatar-upload'),
        uploadUrl: '<?= $templateFolder ?>/upload.php',
        uploadData: {
            foo: 'bar',
            bar: 'baz'
        },
        pretendUpload: false
    })
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#profile_name').keyup(function () {
            var name = $(this).val().split(' ');
            $('#name').val(name[1]);
            $('#l_name').val(name[0]);
            $('#s_name').val(name[2]);
        });
    });

    var url = '<?= $templateFolder ?>';
</script>
<?
$this->SetViewTarget("phone_modal");
?>
<div class="c-popup_container">
    <table class="c-popup_container-2">
        <tr>
            <td class="c-popup_container-3">
                <div class="c-popup c-popup_entry change_phone">
                    <div class="c-popup_close"><div></div><div></div></div> <!--закрыть окно-->
                    <div class="c-popup_row">
                        <div class="c-popup_col-12">
                            <div class="c-popup_body">
                                <div class="c-form">

                                    <div class="c-popup_body-title personal">Подтверждение телефона</div>
                                    <p class="messages_alert hidden"></p>
                                    <div id="enter-phone">
                                        <div>Для совершения заказа необходимо подтвердить номер вашего мобильного телефона.</div><br>
                                        <div class="c-form_item">
                                            <label for="entry_login">Телефон</label>
                                            <input type="text" id="entry_phone" placeholder="Тел: +7(___)___-__-__" class="phone-mask">
                                            <div class="c-popup_note">Например, телефон: +7(900)1234567</div>
                                        </div>
                                        <div class="c-popup_row">
                                            <div class="c-popup_col-4">
                                                <button onclick="sendSms(); return false" class="c-form_button" id="send-code" name="">Отправить</button>
                                            </div>
                                            <div class="c-popup_col-8"><a style="cursor: pointer;" id="getpassauth" class="c-popup_link no-thanks">Нет, спасибо</a></div>
                                        </div>
                                    </div>
                                    <div id="send-phone-code">
                                        <div>Для подтверждения номера телефона вам отправлено SMS с проверочным кодом.</div><br>
                                        <div class="c-form_item">
                                            <h3><span class="confirm_phone_container"></span><a style="cursor: pointer;" class="c-popup_link another-phone">Другой телефон</a></h3>
                                        </div>
                                        <div class="c-form_item">
                                            <label for="entry_login">Введите проверочный код</label>
                                            <input type="text" id="entry_code" >
                                        </div>
                                        <div class="c-popup_row">
                                            <div class="c-popup_col-4">
                                                <button onclick="checkCode();return false" class="c-form_button" name="">Отправить</button>
                                            </div>
                                            <div class="c-popup_col-8"><a style="cursor: pointer;" id="getpassauth" class="c-popup_link no-thanks">Нет, спасибо</a></div>
                                        </div>
                                    </div>

                                </div>
                            </div><!--end c-popup_body-->
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<? $this->EndViewTarget(); ?> 