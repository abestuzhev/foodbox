<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if( $arResult["SECTIONS_COUNT"]>0 ) {
	?>
	<div class="text-center">
	
		<?/*<a class="name<?=($arParams["PAGE_URL"] == $arResult["SECTION"]["SECTION_PAGE_URL"]) ? ' active' : ''?>" href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" ><?
			?>Все<?
			?></a>
		<?*/
		$cell = 0;
		foreach ($arResult['SECTIONS'] as $arSection) {
			if ($arSection["UF_VIEW_CATALOG"]) continue;
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			?>
			<?if ($cell%9 == 0) :?>
			<div class="catalogHeaderCategories">
			<?endif;?>
			
			<a class="wrapImg<?=($arParams["PAGE_URL"] == $arSection['SECTION_PAGE_URL']) ? ' active' : ''?>" href="<?=$arSection['SECTION_PAGE_URL']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?
			?><span class="wrapName">
				<span class="hiddenText">
				<span class="img"><img src="<?=($arSection["UF_SECTION_ICON"] && !is_null($arSection["UF_SECTION_ICON"])) ? $arSection["UF_SECTION_ICON"]["SRC"] : $templateFolder . '/img/no_photo_nobg.png'?>" alt="<?=$arSection['NAME']?>" /></span>
				<span class="name"><?=$arSection['NAME']?></span>
				</span>
			</span><?
			?></a>
			
			<?
			$cell++;
			if ($cell%9 == 0) :?>
			</div>
			<?endif;?>
			<?
		}
	
		if ($cell%9 > 0) :?>
		</div>
		<?endif;?>
	
	</div><?
}