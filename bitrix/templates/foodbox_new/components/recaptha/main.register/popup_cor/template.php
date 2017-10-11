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
<? if($_REQUEST["AJAX_CALL"]!="Y"): ?>
<div class="c-popup_container">
    <table class="c-popup_container-2">
        <tr>
            <td class="c-popup_container-3">
                <? //echo "<pre>"; echo print_r($arResult); echo "</pre>"; ?>
                <div class="c-popup c-popup_entity cor_user">
                    <div class="c-popup_close"><div></div><div></div></div> <!--закрыть окно-->
                    <div class="c-popup_header">
                        <a style="cursor: pointer;" id="btn_entity_in" class="c-popup_header-link">Вход</a>
                        <a style="cursor: pointer;" id="btn_entity_reg" class="c-popup_header-link">Регистрация покупателя</a>
                    </div><!--end c-popup_header-->
                    <form class="c-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regcorform" enctype="multipart/form-data">
                        <?
                        if ($arResult["BACKURL"] <> ''):
                            ?>
                            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
                            <?
                        endif;
                        ?>
                        <input type="hidden" name="REGISTER[LOGIN]" value="login" />
                        <input type="hidden" name="REGISTER[PASSWORD]" value="password" />
                        <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="password" />
                        <div class="c-popup_body">
                            <div class="c-popup_body-title">Регистрация юридических лиц</div>
                            <div class="c-form_item">
                                <label for="entity_name">Ф.И.О.:<span>*</span></label>
                                <input type="text" id="entity_name" name="FIO" value="<?= $_REQUEST['FIO'] ?>" placeholder="Введите ваше Имя и Фамилию" autofocus="" required="">
                            </div>
                            <div class="c-form_item">
                                <label for="entity_company">Название компании (как в уставных документах):<span>*</span></label>
                                <input type="text" id="entity_company" name="COMPANY_NAME" value="<?= $_REQUEST["COMPANY_NAME"] ?>" placeholder="ООО Название компании" autofocus="" required="">
                            </div>
                            <div class="c-popup_row">
                                <div class="c-popup_col c-popup_col-6">
                                    <div class="c-form_item">
                                        <label for="entity_email">Эл. почта:<span>*</span></label>
                                        <input type="text" id="entity_email" name="REGISTER[EMAIL]" value="<?= $arResult['VALUES']['EMAIL'] ?>" autofocus="" required="">
                                    </div>
                                </div>
                                <div class="c-popup_col c-popup_col-6">
                                    <div class="c-form_item">
                                        <label for="entity_phone">Телефон:<span>*</span></label>
                                        <input type="text" id="entity_phone" name="REGISTER[PERSONAL_PHONE]" value="<?= $arResult['VALUES']["PERSONAL_PHONE"] ?>" placeholder="Тел: +7(___)___-__-__" class="phone-mask" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="c-form_item">
                                <input type="checkbox" id="entity_confirmation-stock" name="check" value="1" checked>
                                <label for="entity_confirmation-stock">Подтверждаю свое согласие на получение выгодных предложений на покупки
                                    продуктов.</label>
                            </div>
                            <div class="c-form_item">
                                <input type="checkbox" id="entity_confirmation-data" checked>
                                <label for="entity_confirmation-data">Подтверждаю свое согласие на обработку и хранение моих персональных данных всоответствии с
                                    <a href="#">пользовательским соглашением</a></label>
                            </div>
                            <div class="c-form_item">
                                <input type="checkbox" id="entity_confirmation-pact" checked>
                                <label for="entity_confirmation-pact">Я подтверждаю, что ознакомился с <a href="#">договором оферты</a> и принимаю условия, описанные в нем.</label>
                            </div>
                        </div><!--end c-popup_body-->
                        <div class="c-popup_footer">
                            <div class="c-popup_questionnaire">
                                <div class="c-popup_questionnaire-title">Как вам удобно заполнить информацию о вашей компании?</div>
                                <div class="c-form_item">
                                    <input type="radio" name="entity-info" id="entity_callback" value="1" >
                                    <label for="entity_callback">Заказать обратный звонок</label>
                                </div>
                                <div class="c-form_item">
                                    <input type="radio" name="entity-info" value="3" id="entity_file" >
                                    <label for="entity_file">Отправить реквизиты в файле (doc, pdf)</label>
                                    <input class="is-hidden" type="file" name="UF_FILE_REQUISITES" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                </div>
                                <div class="c-form_item">
                                    <input type="radio" name="entity-info" id="entity_yourself" value="2" checked>
                                    <label for="entity_yourself">Заполнить самостоятельно на сайте</label>
                                </div>
                                <div class="c-form_item">
                                    <div id="recaptcha2"></div>
                                </div>
                                <button class="c-form_button" id="butcorreg_" type="button" disabled="">Загрузить и зарегистрироваться</button>
                                <input class="btn btn-primary" type="submit" name="register_submit_button" id="butcorreg" value="<?= GetMessage("AUTH_REGISTER") ?>" style="display: none;" />
                            </div>
                        </div>
                    </form><!--end form-->
                </div>

            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#butcorreg_').click(function () {
            $("#butcorreg").click();
        });
    });
</script>

<?else:?>
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

                              <p style="line-height: 1.38462; font-family: 'Helvetica','Arial,sans-serif'; font-size: 15px;">На адрес <strong><?=$_SESSION["fdmail"]?></strong>  было отправлено письмо с кодом подтверждения регистрации.</p>
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
    <script type="text/javascript">
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