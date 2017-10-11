<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if(count($arResult['ITEMS'])>0 ):?>
<?$i=true;?>
<div class="c-popup_container">
        <table class="c-popup_container-2">
            <tr>
                <td class="c-popup_container-3">
<div class="c-popup c-popup_question">
    <div class="c-popup_close"><div></div><div></div></div> <!--закрыть окно-->
    <div class="c-popup_header">
        <div class="c-popup_header-title">Откуда вы узнали о нашем сайте?</div>
    </div><!--end c-popup_header-->
    <form action="/" class="c-form" method="post" name="questForm" enctype="multipart/form-data">
        <div class="c-popup_body">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="c-form_item">
                <input type="radio" name="c-popup_question" id="possible-answer-<?=$arItem["ID"]?>" <?if($i): $i=false;?> checked <?endif;?> >
                <label for="possible-answer-<?=$arItem["ID"]?>"><?=$arItem["NAME"]?></label>
            </div>
        <?endforeach;?>
            <div class="c-form_item">
                <input type="radio" name="c-popup_question" id="possible-answer-other">
                <label for="possible-answer-other">Другое</label>
                <input type="text" id="answer-text" name="other" value="<?=$_REQUEST['other']?>" placeholder="Ваш вариант">
            </div>
            <button class="c-form_button"  id="sendquest" type="button" name="send">Голосовать</button>
        </div><!--end c-popup_body-->
    </form><!--end form-->
</div>
       </div>
                </td>
            </tr>
        </table>
    </div>
<script type="text/javascript">

<?foreach($arResult["ITEMS"] as $arItem):?>
<?if(!$i): $i=true;?>var ques="<?=$arItem["NAME"]?>";<?endif;?>
$("#possible-answer-<?=$arItem["ID"]?>").click(function(){
    ques="<?=$arItem["NAME"]?>";
});
<?endforeach;?>
$("#possible-answer-other").click(function(){
    ques=$("#an").val();
});
</script>


<?endif;?>















<?/*
if( is_array($arResult['ITEMS']) && count($arResult['ITEMS'])>0 ) {
	if( $arParams['RSMONOPOLY_SHOW_BLOCK_NAME']=='Y' ) {
		?><h2 class="coolHeading"><span class="secondLine"><?
			if( $arParams['RSMONOPOLY_BLOCK_NAME_IS_LINK']=='Y' && $arResult['LIST_PAGE_URL']!='' ) {
				?><a href="<?=( str_replace('//','/', str_replace('#SITE_DIR#',SITE_DIR,$arResult['LIST_PAGE_URL']) ) )?>"><?=$arResult["NAME"]?></a><?
			} else {
				?><?=$arResult["NAME"]?><?
			}
		?></span></h2><?
	}
	?><div class="<?if($arParams['RSMONOPOLY_USE_OWL']=='Y'):?>owl<?else:?>row<?endif;?> about_us" <?
		?>data-changespeed="<?if(IntVal($arParams["RSMONOPOLY_OWL_CHANGE_SPEED"])<1):?>2000<?else:?><?=$arParams["RSMONOPOLY_OWL_CHANGE_SPEED"]?><?endif;?>" <?
		?>data-changedelay="<?if(IntVal($arParams["RSMONOPOLY_OWL_CHANGE_DELAY"])<1):?>8000<?else:?><?=$arParams["RSMONOPOLY_OWL_CHANGE_DELAY"]?><?endif;?>" <?
		?>data-margin="24" <?
		?>data-responsive='{"0":{"items":"<?=(IntVal($arParams['RSMONOPOLY_OWL_PHONE'])>0?$arParams['RSMONOPOLY_OWL_PHONE']:1)?>"},"768":{"items":"<?=(IntVal($arParams['RSMONOPOLY_OWL_TABLET'])>0?$arParams['RSMONOPOLY_OWL_TABLET']:1)?>"},"991":{"items":"<?=(IntVal($arParams['RSMONOPOLY_OWL_PC'])>0?$arParams['RSMONOPOLY_OWL_PC']:1)?>"}}'<?
		?>><?
		foreach($arResult["ITEMS"] as $arItem) {
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			?><div class="item<?if($arParams['RSMONOPOLY_USE_OWL']!='Y'):?> col col-md-<?=$arParams['RSMONOPOLY_COLS_IN_ROW']?><?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><?
				?><div class="row"><?
					?><div class="col col-md-12"><?
						?><div class="image"><?
							?><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?
								if( $arItem['PREVIEW_PICTURE']['SRC']!='' ) {
									?><img u="image" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" <?
										?>alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" <?
										?>title="<?=$arItem['PREVIEW_PICTURE']['TITLE']?>" <?
									?>/><?
								} else {
									?><img u="image" border="0" <?
										?>src="<?=$templateFolder."/img/nopic.jpg"?>" <?
										?>alt="<?=$arItem['NAME']?>" <?
										?>title="<?=$arItem['NAME']?>" <?
									?>/><?
								}
							?></a><?
						?></div><?
						?><div class="data"><?
							$publish = false;
							if( $arParams['RSMONOPOLY_PROP_PUBLISHER_NAME']!='' && $arItem['DISPLAY_PROPERTIES'][$arParams['RSMONOPOLY_PROP_PUBLISHER_NAME']]['DISPLAY_VALUE']!='' ) {
								$publish = true;
							}
							?><div class="info<?if($publish):?> smaller<?endif;?>"><?
								?><div class="name"><a class="aprimary robotolight" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a></div><?
								?><div class="descr"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["PREVIEW_TEXT"]?></a></div><?
							?></div><?
							?><div class="publish"><?
								if($publish) {
									?><span class="publisher">&laquo;<?=$arItem['DISPLAY_PROPERTIES'][$arParams['RSMONOPOLY_PROP_PUBLISHER_NAME']]['DISPLAY_VALUE']?>&raquo;</span><?
									if( $arParams['RSMONOPOLY_PROP_PUBLISHER_DESCR']!='' && $arItem['DISPLAY_PROPERTIES'][$arParams['RSMONOPOLY_PROP_PUBLISHER_DESCR']]['DISPLAY_VALUE']!='' ) {
										?><span class="publisher_descr"><?=$arItem['DISPLAY_PROPERTIES'][$arParams['RSMONOPOLY_PROP_PUBLISHER_DESCR']]['DISPLAY_VALUE']?></span><?
									}
								}
							?></div><?
						?></div><?
					?></div><?
				?></div><?
			?></div><?
		}
	?></div><?
	if($arParams["DISPLAY_BOTTOM_PAGER"]) {
		echo $arResult["NAV_STRING"];
	}
}