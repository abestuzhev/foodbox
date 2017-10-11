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
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
<div class="bx-searchtitle">
<div id="<?echo $CONTAINER_ID?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>">
		<div class="bx-input-group">
			<input id="<?echo $INPUT_ID?>" type="text" name="q" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off" class="bx-form-control" placeholder="Поиск по товарам. Введите название товара..."/>
			<span class="bx-input-group-btn">
				<button class="btn btn-default" type="submit" name="s"><i class="fa fa-search"></i></button>
			</span>
                        <span class="bx-input-group-btn" style="padding-left:20px;">
				<button type="button" onclick="yaCounter38959340.reachGoal('poisk-spiskom'); location.href='/search-by-list/'" class="btn btn-warning" style="background:#99998b;">Подбор по списку</button>
			</span>
		</div>
	</form>
</div>
	<div class="searchExample" id="searchExample">Например, <a href="<?echo $arResult["FORM_ACTION"]?>?q=молоко">молоко</a></div>
</div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
		BX.ajax.insertToNode(
		 '<?=$templateFolder?>/ajaxExampleSearch.php',
		 BX('searchExample')
		);
        BX.ajax.insertToNode(
		 '<?=$templateFolder?>/ajaxExampleSearch.php',
		 BX('searchExample-2')
		);
	});
</script>

