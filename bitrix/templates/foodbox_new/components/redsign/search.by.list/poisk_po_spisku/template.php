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
$this->setFrameMode(false);
?>
<?BXClearCache(true,"/search-by-list/");?>

<div class="search-content clearfix col-sm-12 col-md-3 col-lg-3">
<form id="search-list-form" method="post" action="">
	<input type="hidden" name="ajax_search_list" value="Y" />
	<div class="goods-box">
		<div class="goods-header clearfix">
			<div class="heading">
				 Товары
			</div>
			<div class="btn-container">
				<button class="btn-reset" type="reset" form="search-list-form" id="resetSearchByListForm" onclick="resetForm()">убрать</button>
			</div>
		</div>
		<ul class="goods-list">
		<?for ($i = 0; $i < $arResult["COUTN_INPUT"]; $i++) :?>
			<li><input value="<?=$arResult["RESULT_LIST_SEARCH"][$i]?>" class="input-search" name="QUERY[]" autocomplete="off" type="text"></li>
		<?endfor;?>
		</ul>
		<?//<a class="btn btn-primary btn-wide" onClick="obSearchList.submitForm();" href="javascript:void(0);">Поиск</a>?>
		<button class="btn btn-primary btn-wide" type="submit">Поиск</button>
	</div>
</form>
</div>

<?$templateData["RESULT_LIST_SEARCH"] = $arResult["RESULT_LIST_SEARCH"];
?>

