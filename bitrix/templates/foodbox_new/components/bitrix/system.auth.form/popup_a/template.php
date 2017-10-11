<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? /* if($arResult["FORM_TYPE"] == "login"):?>
  <?
  $arParams2['arParams'] = $arParams; */ ?>
<script type="text/javascript">
    function ajaxAuthUser(dataSerialize) {
        $.post('<?= $templateFolder ?>/ajax.php?<?= http_build_query($arParams2, 'flags_') ?>', dataSerialize, function (data) {
                    $('#bx-auth-login').html(data);
                });
                return false;
            }
            $(window).resize(function () {
                setTimeout(function () {
                    //RSMONOPOLY_hideLis(true);
                    $.fancybox.update();
                }, 100);
            });
</script>
<div class="c-popup_container">
    <table class="c-popup_container-2">
        <tr>
            <td class="c-popup_container-3">
                <div class="c-popup c-popup_entry c_auth">
                    <div class="c-popup_close"><div></div><div></div></div> <!--закрыть окно-->
                    <div class="c-popup_header">
                            <a  style="cursor: pointer;" id="linkReg" class="c-popup_header-link">Регистрация</a>
                        </div><!--end c-popup_header-->
                    <div class="c-popup_row">
                        <div class="c-popup_col-6">
                            <div class="c-popup_body">
                                <form class="c-form" name="system_auth_form<?= $arResult["RND"] ?>" id="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">

                                    <? if ($arResult["BACKURL"] <> ''): ?>
                                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
                                    <? endif ?>
                                    <? foreach ($arResult["POST"] as $key => $value): ?>
                                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
                                    <? endforeach ?>
                                    <input type="hidden" name="AUTH_FORM" value="Y" />
                                    <input type="hidden" name="TYPE" value="AUTH" />
                                    <input type="hidden" name="templateName" value="<?= $templateName ?>" />
                                    <input type="hidden" name="is_ajax_post" value="Y" />

                                    <div class="c-popup_body-title">Вход для зарегистрированных пользователей</div>
                                    <div class="c-form_item">
                                        <label for="entry_login">Телефон, email или логин</label>
                                        <input type="text" id="entry_login" autofocus="" required="" name="USER_LOGIN" value="<?= $arResult["USER_LOGIN"] ?>">
                                        <div class="c-popup_note">Например: +7(900)1234567, yourname@example.com</div>
                                    </div>
                                    <div class="c-form_item">
                                        <label for="entry_password">Пароль:</label>
                                        <input type="password" name="USER_PASSWORD" id="entry_password" autofocus="" required="">
                                        <a style="cursor: pointer;
                                           float:right;
                                           text-decoration: none;" class="c-popup_note" onclick="Show_HidePassword('entry_password')" class="c-popup_link">Показать пароль</a>
                                    </div>
                                    <div class="c-popup_row" style="margin-top: 35px;">
                                        <div class="c-popup_col-4" style="float: left;">
                                            <button id="butAuth" type="button" class="c-form_button" name="Login">Войти</button>
                                        </div>
                                        <div class="c-popup_col-8" style="float: right; margin-top: 8px;"><a style="cursor: pointer;  color: green;" id="getpassauth" class="c-popup_link">Получить пароль</a></div>
                                    </div>
                                    <p id="mesAuth" style="margin-top: 75px;">&nbsp;</p>
                                </form><!--end form-->
                            </div><!--end c-popup_body-->
                        </div>
                        <div class="c-popup_col-6">
                            <div class="c-popup_body">
                                <div class="c-popup_body-title">Я новый покупатель</div>
                                <div class="c-form">
                                    <div class="c-form_item">
                                        <a style="cursor: pointer;" id="btn_reg_in" class="c-popup_btn-reg bg-grey">
                                            <div class="c-popup_btn-reg-title">Зарегистрироваться</div>
                                            <div class="c-popup_btn-reg-subtitle">и получать бонусы</div>
                                        </a>
                                    </div>
                                    <div class="c-form_item">
                                        <a style="cursor: pointer;" id="btnnoreg" class="c-popup_btn-reg bg-orange">
                                            <div class="c-popup_btn-reg-title">Купить без регистрации</div>
                                            <div class="c-popup_btn-reg-subtitle">быстрый заказ</div>
                                        </a>
                                    </div>
                                </div>


                                <? //echo "<pre>"; echo print_r($arResult); echo "</pre>";?>
                                <? if ($arResult["AUTH_SERVICES"] && !isset($_POST['popup'])): ?>
                                    <div class="c-popup_footer-title">Начать покупку, используя соцсеть:</div>
                                    <?
                                    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "social", array(
                                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                                        "AUTH_URL" => $arResult["AUTH_URL"],
                                        "POST" => $arResult["POST"],
                                        "POPUP" => "N",
                                        "SUFFIX" => "form",
                                            ), $component, array("HIDE_ICONS" => "Y")
                                    );
                                    ?>
                                <? endif; ?>




                                <!--<div class="c-popup_social">
                                    <a class="c-popup_social-item" href=""><img src="include/footer/images/icon_03.jpg" alt=""></a>
                                    <a class="c-popup_social-item" href=""><img src="include/footer/images/icon_11.jpg" alt=""></a>
                                    <a class="c-popup_social-item" href=""><img src="include/footer/images/icon_09.jpg" alt=""></a>
                                </div>-->
                            </div><!--end c-popup_body-->
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    function Show_HidePassword(id) {
        element = document.getElementById(id);
        if (element.type == 'password') {
            var inp = document.createElement("input");
            inp.id = id;
            inp.type = "text";
            inp.value = element.value;
            element.parentNode.replaceChild(inp, element);
        } else {
            var inp = document.createElement("input");
            inp.id = id;
            inp.type = "password";
            inp.value = element.value;
            element.parentNode.replaceChild(inp, element);
        }
    }

    $(document).ready(function () {

        $('#butAuth').click(function () {
            $.ajax({
                type: 'POST',
                url: "<?= SITE_TEMPLATE_PATH ?>/include/getlogin.php",
                data: {
                    login: $("#entry_login").val(),
                    password: $("#entry_password").val(),

                },
                success: function (data)
                {
                    if (data)
                    {
                        $("#mesAuth").html(data);
                    } else
                    {
                        ajaxAuthUser($('#system_auth_form<?= $arResult["RND"] ?>').serialize());
                        location.reload();
                    }
                }
            });

        });





    });
</script>

<?/*<div class="c-popup_bg" style="opacity:.4;z-index: 999;"></div>