<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;


include $_SERVER["DOCUMENT_ROOT"].$templateFolder.'/functions.php';


if(!is_array($arResult['ITEMS']) && count($arResult['ITEMS']) < 1) {
    return;
}

?>

<div class="row">
    <div class="section-cart col-md-12">
		<h2 class="coolHeading">
			<span class="secondLine"><?=Loc::getMessage("RS.MONOPOLY.COLLECTION_ITEMS")?></span>
		</h2>
	</div>	
    <div class="col col-md-12">
        <?php include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/templates_ext/catalog.section/mshop/showcase.php'); ?>
        <p class="visible-xs visible-sm">
    </div>
</div>

<?php $this->SetViewTarget('collection_groups'); ?>
<div class="row mt">
    <div class="col col-md-12">    
        <ul class="nav nav-tabs" role="tablist">
            <?php $activeSection = null; ?>
            <?php foreach($arResult['SECTIONS'] as $id => $arSection): ?>
                <li class="<? if(!$activeSection) { echo 'active'; $activeSection=$id;}?>">
                    <a href="#section_<?=$id?>" aria-controls="section_<?=$id?>" data-toggle="tab">
                        <?=$arSection['NAME']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col col-md-12 section-cart">
        <div class="tab-content">
            <?php foreach($arResult['SECTIONS'] as $id => $arSection): ?>
                <?php
                    if(count($arSection) < 1) {
                        continue;
                    }
                ?>
                <div
                    role="tabpanel" 
                    class="tab-pane <?=$activeSection == $id ? 'active' : ''?>" 
                    id="section_<?=$id?>"
                >
                    <div class="row">
                        <div class="col col-md-12">
                            <div 
                                class = "products owlslider owl"
                                data-margin = "35"
                                data-items = "6"
                                data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"4"}, "956":{"items":"6"}}'
                            >
                                <? showItems($arSection['ITEMS'], $arParams); ?>
                            </div>
                        </div>
                    </div>
                
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<? $this->EndViewTarget(); ?>