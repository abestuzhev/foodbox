<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

if(is_array($arResult["GROUPED_ITEMS"]) && count($arResult["GROUPED_ITEMS"])>0) {
	$j = 0;
	foreach($arResult["GROUPED_ITEMS"] as $index => $arrValue) {
		if(!is_array($arrValue["PROPERTIES"]) && count($arrValue["PROPERTIES"]) < 1) {
			continue;
		}
		if($j % 2 == 0) {
			?><div class="row proptable"><?
		}
		$j++;
		?><div class="col col-md-12"><?
			?><div class="prop_title aprimary"><?=$arrValue['GROUP']['NAME'];?></div><?
			?><table><?
				?><tbody><?
					foreach ($arrValue['PROPERTIES'] as $arProp) {
						?><tr class="prop_<?=$arProp['CODE']?>"><?
							?><td class="name"><span><?=$arProp['NAME']?></span><div class="border"></div></td><?
							?><td class="val"><span><?
								if(is_array($arProp['DISPLAY_VALUE'])) {
									echo implode(' <br> ', $arProp['DISPLAY_VALUE']);
								} else {
									echo $arProp['DISPLAY_VALUE'];
								}
							?></span></td><?
						?></tr><?
					}
				?></tbody><?
			?></table><?
		?></div><?
		if($j % 2 == 0) {
			?></div><?
		}
	}
	if($j % 2 == 1) {
		?></div><?
	}
}

if(is_array($arResult["NOT_GROUPED_ITEMS"]) && count($arResult["NOT_GROUPED_ITEMS"])>0) {
	?><div class="proptable"><?
		?><div class="col col-md-12"><?
			?><div class="prop_title aprimary"><?=GetMessage('RS.MSHOP.NOT_GRUPPED_TITLE')?></div><?
			?><table><?
				?><tbody><?
					foreach($arResult["NOT_GROUPED_ITEMS"] as $arProp) {
						if ($arProp['NAME'] == "Характеристики") :
						//Debug($arProp);
							foreach ($arProp['VALUE'] as $keyValue => $arValue) :?>
							<tr class="prop_<?=$arProp['CODE']?>"><?
								?><td class="name"><span><?=$arValue?></span><div class="border"></div></td><?
								?><td class="val"><span><?=$arProp['DESCRIPTION'][$keyValue]?></span></td><?
							?></tr><?
							endforeach;
							
							continue;
						endif;
						?><tr class="prop_<?=$arProp['CODE']?>"><?
							?><td class="name"><span><?=$arProp['NAME']?></span><div class="border"></div></td><?
							?><td class="val"><span><?
								if(is_array($arProp['DISPLAY_VALUE'])) {
									echo implode(' <br> ', $arProp['DISPLAY_VALUE']);
								} else {
									echo $arProp['DISPLAY_VALUE'];
								}
							?></span></td><?
						?></tr><?
					}
				?></tbody><?
			?></table><?
		?></div><?
	?></div><?
}