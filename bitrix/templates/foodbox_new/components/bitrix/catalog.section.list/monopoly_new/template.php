<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if( $arResult["SECTIONS_COUNT"]>0 ) {
	?><div class="clearfix sectionsList"><?
		?><?
			$cell = 0;
			foreach ($arResult['SECTIONS'] as $arSection) {
				if ($arSection["UF_VIEW_CATALOG"]) continue;
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
				if ($cell%4 == 0) :?>
				<div class="row">
				<?endif;?>
				<div class="bg<?=$arSection['ID']?> col col-sm-6 col-xs-6 col-md-3<?=($arSection['PICTURE']['SRC'] == '' ) ? ' noImg' : ''?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><?
					?><div class="item"<?//=($arSection['PICTURE']['SRC']!='') ? 'style="background-image: url('.$arSection['PICTURE']['SRC'].')"' : 'style="background-image: url('.$templateFolder.'/img/no_photo_nobg.png); background-repeat: no-repeat; background-size: 70% auto;"'?>><?
						?><a href="<?=$arSection['SECTION_PAGE_URL']?>">
						<?if ($arSection['PICTURE']['SRC']!='') :?>
							<img class="img" src="<?=$arSection['PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>" />
						<?else : ?>
							<img class="img" src="<?=$templateFolder?>/img/no_photo_nobg.png" alt="<?=$arSection['NAME']?>" />
						<?endif;?>
						<?
							?><span class="name"><?=$arSection['NAME']?></span><?
						?></a><?
					?></div><?
				?></div><?
				$cell++;
				if ($cell%4 == 0) :?>
				</div>
				<?endif;
			}
			
			if ($cell%4 > 0) {
				echo "</div>";
			}
	?></div><?
}