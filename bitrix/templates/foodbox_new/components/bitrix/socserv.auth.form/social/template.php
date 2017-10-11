<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$arAuthServices = $arPost = array();
if(is_array($arParams["~AUTH_SERVICES"]))
{
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if(is_array($arParams["~POST"]))
{
	$arPost = $arParams["~POST"];
}
?>
<?
if($arParams["POPUP"]):
	//only one float div per page
	if(defined("BX_SOCSERV_POPUP"))
		return;
	define("BX_SOCSERV_POPUP", true);
?>
<div style="display:block;">
<div id="bx_auth_float" class="bx-auth-float">
<?endif?>

<?if(($arParams["~CURRENT_SERVICE"] <> '') && $arParams["~FOR_SPLIT"] != 'Y'):?>
<script type="text/javascript">
BX.ready(function(){BxShowAuthService('<?=CUtil::JSEscape($arParams["~CURRENT_SERVICE"])?>', '<?=$arParams["~SUFFIX"]?>')});
</script>
<?endif?>
<?
if($arParams["~FOR_SPLIT"] == 'Y'):?>
<div class="bx-auth-serv-icons">
	<?foreach($arAuthServices as $service):?>
	<?
	if(($arParams["~FOR_SPLIT"] == 'Y') && (is_array($service["FORM_HTML"])))
		$onClickEvent = $service["FORM_HTML"]["ON_CLICK"];
	else
		$onClickEvent = "onclick=\"BxShowAuthService('".$service['ID']."', '".$arParams['SUFFIX']."')\"";
	?>
	<a title="<?=htmlspecialcharsbx($service["NAME"])?>" href="javascript:void(0)" <?=$onClickEvent?> id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>"><i class="bx-ss-icon <?=htmlspecialcharsbx($service["ICON"])?>"></i></a>
	<?endforeach?>
</div>
<?endif;?>

<!--
<div class="c-popup_footer">
    <div class="c-popup_footer-title">Приступите к покупкам, используя свой логин в сети:</div>-->
    <form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">
    <div class="c-popup_social">
        <a class="c-popup_social-item" href="javascript:void(0)" onclick="BX.util.popup('https://www.facebook.com/dialog/oauth?client_id=221928201614533&redirect_uri=http%3A%2F%2Ffoodbox.leeft.ru%2Fauth%2F%3Fauth_service_id%3DFacebook%26check_key%3D6d1d951df5ac1df611b2b4f01e61971b%26backurl%3D%252Fauth%252F&scope=email,publish_actions,user_friends&display=popup', 580, 400)"><img src="/include/footer/images/icon_03.jpg" alt=""></a>
        <a class="c-popup_social-item" href="javascript:void(0)" onclick="<?=$arAuthServices[Odnoklassniki][ONCLICK]?>"><img src="/include/footer/images/icon_11.jpg" alt=""></a>
        <a class="c-popup_social-item" href="javascript:void(0)" onclick="<?=$arAuthServices[VKontakte][ONCLICK]?>"><img src="/include/footer/images/icon_09.jpg" alt=""></a>
    </div>
    </form>
<!--</div>-->
<?//echo "<pre>"; echo print_r($arAuthServices); echo "</pre>";?>

<?if($arParams["POPUP"]):?>
</div>
</div>
<?endif?>