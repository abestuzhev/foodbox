<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if( $arResult["SECTIONS_COUNT"]>0 ) {
	?><div class="row gallery sections"><?
		$cell = 1;
		foreach ($arResult['SECTIONS'] as $arSection) {
			if ($arSection["UF_VIEW_CATALOG"]) continue;
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			?><div class="bg<?=$arSection['ID']?> col col-sm-6 col-md-4<?=($arSection['PICTURE']['SRC'] == '' ) ? ' noImg' : ''?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?
				?><div class="item"><?
					?><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?
						?><span class="image"<?=($arSection['PICTURE']['SRC']!='') ? 'style="background-image: url('.$arSection['PICTURE']['SRC'].')"' : 'style="background-image: url('.$templateFolder.'/img/no_photo_nobg.png)"'?>><?
						?></span><?
						?><span class="name">
							<span class="box">
								<span class="in"><?=$arSection['NAME']?></span>
							</span><?
						?></span><?
					?></a><?
				?></div><?
			?></div><?
		}
	?></div><?
}