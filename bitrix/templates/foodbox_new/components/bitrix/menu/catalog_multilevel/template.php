<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$sectionStatus = true;
foreach($arResult as $arItem){
	if ($arItem["PARAMS"]["FROM_IBLOCK"]) {
		continue;
	}
	$sectionStatus = false;
}

$statusCatalog = true;
if (!empty($arResult) && !$sectionStatus):?>
<ul class="vertical-multilevel-menu">
<?
$cell = 0;
$previousLevel = 0;
foreach($arResult as $arItem):
	if ($arItem["PARAMS"]["FROM_IBLOCK"]) {
		continue;
	}
	$statusCatalog = false;
?>
	<?if (!$cell) :?>
	<li class="title">
		<?$APPLICATION->IncludeComponent(
			"bitrix:search.title", 
			"foodbox_catalog", 
			array(
				"COMPONENT_TEMPLATE" => "foodbox",
				"NUM_CATEGORIES" => "1",
				"TOP_COUNT" => "5",
				"ORDER" => "rank",
				"USE_LANGUAGE_GUESS" => "N",
				"CHECK_DATES" => "N",
				"SHOW_OTHERS" => "N",
				"PAGE" => "#SITE_DIR#catalog/",
				"SHOW_INPUT" => "Y",
				"INPUT_ID" => "title-search-input-catalog",
				"CONTAINER_ID" => "title-search-catalog",
				"CATEGORY_OTHERS_TITLE" => "",
				"CATEGORY_0_TITLE" => "",
				"CATEGORY_0" => array(
					0 => "iblock_catalog",
				),
				"CATEGORY_0_iblock_catalog" => array(
					0 => "34",
				),
				"PRICE_CODE" => array(
					0 => "Опт 5",
				),
				"PRICE_VAT_INCLUDE" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"SHOW_PREVIEW" => "Y",
				"PREVIEW_WIDTH" => "75",
				"PREVIEW_HEIGHT" => "75",
				"CONVERT_CURRENCY" => "Y",
				"CURRENCY_ID" => "RUB"
			),
			false
		);?>
		<?/*<div class="wrapSearch" id="<?echo $CONTAINER_ID?>">
			<form action="/catalog/" method="GET">
				<input placeholder="Введите название товара..." id="<?echo $INPUT_ID?>" autocomplete="off" class="input_text" value="" name="q" type="text">
				<input name="s" class="input_submit" value=" " type="submit">
			</form>
		</div>*/?>
	</li>
	<?endif?>
	
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li><a <?=($arItem["PARAMS"]["SECTION_ICON"]) ? 'style="background-image: url('.$arItem["PARAMS"]["SECTION_ICON"]["SRC"].')"' : ''?> href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?> <i class="fa arrowright"></i></a>
				<ul class="root-item">
		<?else:?>
			<li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?> <i class="fa arrowright"></i></a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a <?=($arItem["PARAMS"]["SECTION_ICON"]) ? 'style="background-image: url('.$arItem["PARAMS"]["SECTION_ICON"]["SRC"].')"' : ''?> href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?
	$cell++;
endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>

<?if (!empty($arResult)):?>
<ul class="vertical-multilevel-menu">
<?
$cell = 0;
$previousLevel = 0;
foreach($arResult as $arItem):
	if (!$arItem["PARAMS"]["FROM_IBLOCK"] || $arItem["PARAMS"]["VIEW_CATALOG"]) {
		continue;
	}
?>
	<?if (!$cell) :?>
	<li class="title">
		<?if ($statusCatalog) :?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:search.title", 
			"foodbox_catalog", 
			array(
				"COMPONENT_TEMPLATE" => "foodbox",
				"NUM_CATEGORIES" => "1",
				"TOP_COUNT" => "5",
				"ORDER" => "rank",
				"USE_LANGUAGE_GUESS" => "N",
				"CHECK_DATES" => "N",
				"SHOW_OTHERS" => "N",
				"PAGE" => "#SITE_DIR#catalog/",
				"SHOW_INPUT" => "Y",
				"INPUT_ID" => "title-search-input-catalog",
				"CONTAINER_ID" => "title-search-catalog",
				"CATEGORY_OTHERS_TITLE" => "",
				"CATEGORY_0_TITLE" => "",
				"CATEGORY_0" => array(
					0 => "iblock_catalog",
				),
				"CATEGORY_0_iblock_catalog" => array(
					0 => "34",
				),
				"PRICE_CODE" => array(
					0 => "Опт 5",
				),
				"PRICE_VAT_INCLUDE" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"SHOW_PREVIEW" => "Y",
				"PREVIEW_WIDTH" => "75",
				"PREVIEW_HEIGHT" => "75",
				"CONVERT_CURRENCY" => "Y",
				"CURRENCY_ID" => "RUB"
			),
			false
		);?>
		
		<?endif?>
	</li>
	<?endif?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li><a <?=($arItem["PARAMS"]["SECTION_ICON"]) ? 'style="background-image: url('.$arItem["PARAMS"]["SECTION_ICON"]["SRC"].')"' : ''?> href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?> <i class="fa arrowright"></i></a>
				<ul class="root-item">
		<?else:?>
			<li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?> <i class="fa arrowright"></i></a>
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a <?=($arItem["PARAMS"]["SECTION_ICON"]) ? 'style="background-image: url('.$arItem["PARAMS"]["SECTION_ICON"]["SRC"].')"' : ''?> href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?
	$cell++;
endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>