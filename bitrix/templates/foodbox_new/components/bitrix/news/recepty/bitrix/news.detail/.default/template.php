<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

CModule::IncludeModule("iblock");
?>

<style type="text/css">
.submit{
	border: 1px solid #a54345;
    background: none;
    color: #fff;
    font-size: 16px;
    line-height: 17px;
    padding: 3px 10px 3px 10px;
    text-decoration: none;
    position: relative;
    display: inline-block;
    min-width: 112px;
    background-color: #a54345;
	margin:2px;
}
.submit:hover{
	background:#c26365;
}
.inbasket{
	background-color: #ffffff;
    color: #a54345;
}
.inbasket:hover{
	color: #fff;
}

ul.bxslider  > li:before, ol > li:before
{
	display:none;
}
ul.bxslider{
	padding-left:0px;
}

 .videoWrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        padding-top: 25px;
        height: 0;
}
.videoWrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
}
</style>
<script>
$(document).ready(function(){
	$(".submit").click(function()
	{
		var btn = $(this);
		$.ajax({
		  url: $(this).val(),
		  success: function(){
			btn.toggleClass('inbasket').text('В корзине');
		  }
		});
	});
	
	$('.bxslider').bxSlider({
	  mode: 'fade',
	  captions: false,
	  responsive:true,
	  auto:true
	});
});
</script>

<h3><?=$arResult["NAME"]?></h3>
<div class="news-detail row">

<div class="col-sm-12 col-md-12 col-lg-12">
<?
if($arResult["PROPERTIES"]['VIDEO']['VALUE'])
{
	echo '<div class="videoWrapper">';
	echo htmlspecialcharsBack($arResult["PROPERTIES"]['VIDEO']['VALUE']);
	echo '</div>';
}
else
{
	echo '<ul class="bxslider">';
	
	foreach($arResult["PROPERTIES"]['PHOTOS']['VALUE'] as $imgID)
	{
		$img = CFile::GetFileArray($imgID); 
		echo '<li><img src="'.$img['SRC'].'" /></li>';
	}
	
	echo '</ul>';
}
?>

</div>

<div class="col-sm-12 col-md-12 col-lg-12">
	
	
	<h4>Вам понадобится:</h4>
	<?
	foreach($arResult["PROPERTIES"]['TOVARY']['VALUE'] as $pid=>$arTovar){
		$res = CIBlockElement::GetByID($arTovar);
		$tovar = $res->GetNext();
		
		$dbBasketItems = CSaleBasket::GetList(
			array(
					"NAME" => "ASC",
					"ID" => "ASC"
				),
			array(
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
					"PRODUCT_ID" => $tovar['ID']
				),
			false,
			false,
			array("ID", "MODULE", "PRODUCT_ID", "QUANTITY",  "CAN_BUY", "PRICE",)
		);
		$inbasket = false;
		while ($arItems = $dbBasketItems->Fetch())
		{
			$inbasket = !empty(arItems) ? true : false;
		}
		
		echo "<br><div class='col-sm-9 col-md-9 col-lg-9'>&bull; <i>".$tovar['NAME']."</i></div>".
		"<div class='col-sm-3 col-md-3 col-lg-3'><button type='submit' rel='nofollow' class='submit ".($inbasket ? 'inbasket' : '')."' value='/?quantity=1&action=ADD2BASKET&id=".$tovar['ID']."'>".($inbasket ? 'В корзине' : 'Купить')."</button></div>";
	}
	?>

	
	
	
</div>
</div>
<br clear=all>
<h4>Способ приготовления:</h4>
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<?echo $arResult["DETAIL_TEXT"];?>
	</div>

</div>