<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<? if ($_REQUEST["AJAX_CALL"] != "Y"): ?>

    <? //echo "<pre>"; echo print_r($arResult); echo "</pre>";  ?>
    <div class="c-popup_container">
        <table class="c-popup_container-2">
            <tr>
                <td class="c-popup_container-3">
                    <div class="c-popup c-popup_reg-user c-popup_entity">
                        <div class="c-popup_close"><div></div><div></div></div>	<!--закрыть окно-->
                        <div class="c-popup_header">
                            <a style="cursor: pointer;" id="linkIn" class="c-popup_header-link">Вход</a>
                            <a  style="cursor: pointer;" id="linkCor" class="c-popup_header-link">Регистрация юридических лиц</a>
                        </div><!--end c-popup_header-->
                        <div class="c-popup_body">
                            <div class="c-popup_body-title">Регистрация покупателя</div>

                            <form class="c-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data">
                                <? if ($arResult["BACKURL"] <> ''): ?>
                                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
                                    <?
                                endif;
                                ?>
                                <input type="hidden" name="REGISTER[LOGIN]" value="login" />
                                <input type="hidden" name="REGISTER[PASSWORD]" value="password" />
                                <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="password" />

                                <div class="c-form_item">
                                    <label for="reg-user_name">Ф.И.О.:<span>*</span></label>
                                    <input type="text" name="FIO" id="reg-user_name" placeholder="Введите ваше Имя и Фамилию" autofocus required
                                           value="<?= $_REQUEST['FIO'] ?>">
                                </div>
                                <div class="c-form_item">
                                    <label for="reg-user_email">Электронная почта:<span>*</span></label>
                                    <input type="text" name="REGISTER[EMAIL]" value="<?= $arResult["VALUES"]["EMAIL"] ?>" id="reg-user_email" placeholder="Введите свой E-mail" autofocus required>
                                </div>
                                <div class="c-form_item">
                                    <label for="reg-user_phone">Мобильный телефон для звонка курьера:</label>
                                    <input type="text" id="reg-user_phone" name="REGISTER[PERSONAL_PHONE]" value="<?= $arResult["VALUES"]["PERSONAL_PHONE"] ?>" placeholder="Тел: +7(___)___-__-__" class="phone-mask" autofocus required>
                                </div>
                                <div class="c-form_item">
                                    <input type="checkbox" id="confirmation-stock" name="check" value="1" checked >
                                    <label for="confirmation-stock" >Подтверждаю свое согласие на получение выгодных предложений на покупки
                                        продуктов.</label>
                                </div>
                                <div class="c-form_item">
                                    <input type="checkbox" id="confirmation-data" required checked>
                                    <label for="confirmation-data">Подтверждаю свое согласие на обработку и хранение моих персональных данных всоответствии с пользовательским соглашением</label>
                                </div>
                                <!--<div class="c-form_item">-->
                                <!--<textarea name="" id="c-popup_mail-text" rows="7" placeholder="Здесь вы можете указать желаемое время звонка или задать вопрос."></textarea>-->
                                <!--</div>-->
                                <div class="c-form_item">
                                    <div id="recaptcha1"></div>
                                </div>
                                <div class="c-popup_row">
                                    <div class="c-popup_col-5">
                                        <button class="c-form_button" type="button" id="but_reg">Регистрация</button>
                                        <input class="btn btn-primary" type="submit" name="register_submit_button" id="butreg" value="<?= GetMessage("AUTH_REGISTER") ?>" style="display: none;" />
                                    </div>
                                    <div class="c-popup_col-7"><div class="c-popup_reference"><span>*</span> - поля обязательные для заполнения</div></div>
                                </div>
                                <p id="mesReg" style="margin-top: 15px;">&nbsp;</p>
                            </form>
                        </div><!--end c-popup_body-->

                        <div class="c-popup_footer">
                            <div class="c-popup_footer-title">Приступите к покупкам, используя свой логин в сети:</div>
                            <div class="c-popup_social">
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('https://www.facebook.com/dialog/oauth?client_id=221928201614533&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2Fauth%2F%3Fauth_service_id%3DFacebook%26check_key%3D6d1d951df5ac1df611b2b4f01e61971b%26backurl%3D%252Fauth%252F&scope=email,publish_actions,user_friends&display=popup', 580, 400)"><img src="/include/footer/images/icon_03.jpg" alt=""></a>
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('http://www.odnoklassniki.ru/oauth/authorize?client_id=1249221120&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2Fbitrix%2Ftools%2Foauth%2Fodnoklassniki.php&response_type=code&state=site_id%3Ds1%26backurl%3D%252F%253Fcheck_key%253D6d1d951df5ac1df611b2b4f01e61971b%26redirect_url%3D%252F%26mode%3Dopener', 580, 400)"><img src="/include/footer/images/icon_11.jpg" alt=""></a>
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('https://oauth.vk.com/authorize?client_id=5764799&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2F%3Fauth_service_id%3DVKontakte&scope=friends,notify,offline,email&response_type=code&state=site_id%3Ds1%26backurl%3D%252F%253Fcheck_key%253D6d1d951df5ac1df611b2b4f01e61971b%26redirect_url%3D%252F', 660, 425)"><img src="/include/footer/images/icon_09.jpg" alt=""></a>
                            </div>
                        </div>
                    </div><!--end popup-->
                </td>
            </tr>
        </table>
    </div>
<? else: ?>
    <div class="c-popup_container c-popup_show" >
        <table class="c-popup_container-2">
            <tr>
                <td class="c-popup_container-3">
                    <div class="c-popup c-popup_reg-user c-popup_entity c-popup_show">
                        <div class="c-popup_close" id="closeOt"><div></div><div></div></div> <!--закрыть окно-->
                        <div class="c-popup_header" style="height: 43px;">


                        </div><!--end c-popup_header-->
                        <div class="c-popup_body">
                            <div class="c-popup_body-title">Регистрация покупателя</div>

                            <p style="line-height: 1.38462; font-family: 'Helvetica','Arial,sans-serif'; font-size: 15px;">На адрес <strong><?= $_SESSION["fdmail"] ?></strong>  было отправлено письмо с кодом подтверждения регистрации.</p>

                        </div><!--end c-popup_body-->

                        <div class="c-popup_footer">
                            <div class="c-popup_footer-title">Приступите к покупкам, используя свой логин в сети:</div>
                            <div class="c-popup_social">
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('https://www.facebook.com/dialog/oauth?client_id=221928201614533&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2Fauth%2F%3Fauth_service_id%3DFacebook%26check_key%3D6d1d951df5ac1df611b2b4f01e61971b%26backurl%3D%252Fauth%252F&scope=email,publish_actions,user_friends&display=popup', 580, 400)"><img src="/include/footer/images/icon_03.jpg" alt=""></a>
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('http://www.odnoklassniki.ru/oauth/authorize?client_id=1249221120&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2Fbitrix%2Ftools%2Foauth%2Fodnoklassniki.php&response_type=code&state=site_id%3Ds1%26backurl%3D%252F%253Fcheck_key%253D6d1d951df5ac1df611b2b4f01e61971b%26redirect_url%3D%252F%26mode%3Dopener', 580, 400)"><img src="/include/footer/images/icon_11.jpg" alt=""></a>
                                <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('https://oauth.vk.com/authorize?client_id=5764799&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2F%3Fauth_service_id%3DVKontakte&scope=friends,notify,offline,email&response_type=code&state=site_id%3Ds1%26backurl%3D%252F%253Fcheck_key%253D6d1d951df5ac1df611b2b4f01e61971b%26redirect_url%3D%252F', 660, 425)"><img src="/include/footer/images/icon_09.jpg" alt=""></a>
                                <p style="text-align: right; margin-top: -30px;"><button class="c-form_button" id="continue" type="button">Продолжить</button></p>
                            </div>
                        </div>
                    </div><!--end popup-->
                </td>
            </tr>
        </table>
    </div>
    <script type="text/javascript">
        $("#continue").click(function () {
            event.preventDefault();
            $(this).parent('.c-popup').removeClass('c-popup_show');
            $(this).parents('.c-popup_container').removeClass('c-popup_show');
            $('.c-popup_bg').removeClass('is-visible');
            $('body').removeClass('body-popup');
            $('.c-popup').removeClass('body-popup');
    //Открыть откуда узнали
            if ($("div").is(".c-popup_question"))
            {
                $('.c-popup_question').toggleClass('c-popup_show');
                $('.c-popup_bg').toggleClass('is-visible');
                $(".c-popup_question").parents('.c-popup_container').toggleClass('c-popup_show');
                $('body').toggleClass('body-popup');
            }
        });
        $("#closeOt").click(function (event) {
            event.preventDefault();
            $(this).parent('.c-popup').removeClass('c-popup_show');
            $(this).parents('.c-popup_container').removeClass('c-popup_show');
            $('.c-popup_bg').removeClass('is-visible');
            $('body').removeClass('body-popup');
            $('.c-popup').removeClass('body-popup');
            //Открыть откуда узнали
            if ($("div").is(".c-popup_question"))
            {
                $('.c-popup_question').toggleClass('c-popup_show');
                $('.c-popup_bg').toggleClass('is-visible');
                $(".c-popup_question").parents('.c-popup_container').toggleClass('c-popup_show');
                $('body').toggleClass('body-popup');
            }
        });
    </script>
<? endif; ?>