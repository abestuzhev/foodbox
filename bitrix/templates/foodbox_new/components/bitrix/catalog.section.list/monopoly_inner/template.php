<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if( $arResult["SECTIONS_COUNT"]>0 ) {
	?><div class="row catalogHeaderCategories text-center">
		<a class="name<?=($arParams["PAGE_URL"] == $arResult["SECTION"]["SECTION_PAGE_URL"]) ? ' active' : ''?>" href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" ><?
			?>Все<?
			?></a>
		<?
		$cell = 1;
		foreach ($arResult['SECTIONS'] as $arSection) {
			if ($arSection["UF_VIEW_CATALOG"]) continue;
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			?><a class="name<?=($arParams["PAGE_URL"] == $arSection['SECTION_PAGE_URL']) ? ' active' : ''?>" href="<?=$arSection['SECTION_PAGE_URL']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?
			?><?=$arSection['NAME']?><?
			?></a><?
		}
	?></div><?
}