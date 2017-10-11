<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if( !function_exists('RSMONOPOLY_GetResult') ) {
	function RSMONOPOLY_GetResult($amount,$arParams) {
		$return = 0;
		if($arParams['MONOPOLY_USE_MIN_AMOUNT']=='Y') {
			if( $amount<1 ) {
				$return = '<span class="genamount empty">'.GetMessage('RS.MONOPOLY.QUANTITY_EMPTY').'</span>';
			} elseif( $amount<$arParams['MIN_AMOUNT'] ) {
				$return = '<span class="genamount">'.GetMessage('RS.MONOPOLY.QUANTITY_LOW').'</span>';
			} else {
				$return = '<span class="genamount isset">'.GetMessage('RS.MONOPOLY.QUANTITY_ISSET').'</span>';
			}
		} else {
			$return = $amount;
		}
		return $return;
	}
}

?><span class="js-stores stores dropdown" data-firstElement="<?=$arParams['FIRST_ELEMENT_ID']?>"><?
	?><span><?
		if(count($arResult['STORES'])<1 || $arParams['SHOW_GENERAL_STORE_INFORMATION']=='Y'){
			?><?=$arParams['MAIN_TITLE']?>: <?
		} else {
			?><a class="dropdown-toggle" id="ddmStores_<?=$arParams['~ELEMENT_ID']?>" href="#" data-toggle="dropdown" title="<?=$arParams['MAIN_TITLE']?>" aria-expanded="true"><?
				?><?=$arParams['MAIN_TITLE']?><?
			?></a>: <?
		}
		if( is_array($arResult['JS']['SKU']) && count($arResult['JS']['SKU'])>1 ) {
			echo RSMONOPOLY_GetResult($arParams['DATA_QUANTITY'][$arParams['FIRST_ELEMENT_ID']],$arParams);
			if($arParams['SHOW_GENERAL_STORE_INFORMATION']!='Y') {
				?><div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="ddmStores_<?=$arParams['~ELEMENT_ID']?>"><?
					?><table><?
						foreach($arResult['STORES'] as $key1 => $arStore) {
							?><tr class="store_<?=$arStore['ID']?>" <?=($arParams['SHOW_EMPTY_STORE'] == 'N' && $arResult['JS']['SKU'][$arParams['FIRST_ELEMENT_ID']][$arStore['ID']] <= 0 ? 'style="display:none;"' : '')?>><?
								if( in_array('TITLE',$arParams['FIELDS'])) {
									?><td class="title"><?=$arStore['TITLE']?></td><?
								}
								if( in_array('PHONE',$arParams['FIELDS'])) {
									?><td><?=$arStore['PHONE']?></td><?
								}
								if( in_array('SCHEDULE',$arParams['FIELDS'])) {
									?><td><?=$arStore['SCHEDULE']?></td><?
								}
								if( in_array('EMAIL',$arParams['FIELDS'])) {
									?><td><?=$arStore['EMAIL']?></td><?
								}
								if( in_array('COORDINATES',$arParams['FIELDS'])) {
									?><td><?=$arStore['COORDINATES']?></td><?
								}
								if( in_array('DESCRIPTION',$arParams['FIELDS'])) {
									?><td><?=$arStore['DESCRIPTION']?></td><?
								}
								?><td class="amount"><?=RSMONOPOLY_GetResult($arResult['JS']['SKU'][$arParams['FIRST_ELEMENT_ID']][$arStore['ID']],$arParams)?></td><?
							?></tr><?
						}
					?></table><?
				?></div><?
			}
		} else {
			echo RSMONOPOLY_GetResult($arParams['DATA_QUANTITY'][$arParams['FIRST_ELEMENT_ID']],$arParams);
			if($arParams['SHOW_GENERAL_STORE_INFORMATION']!='Y') {
				?><div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="ddmStores_<?=$arParams['~ELEMENT_ID']?>"><?
					?><table><?
						foreach($arResult['STORES'] as $key1 => $arStore) {
							?><tr class="store_<?=$arStore['ID']?>" <?=($arParams['SHOW_EMPTY_STORE'] == 'N' && $arStore['AMOUNT'] <= 0 ? 'style="display:none;"' : '')?>><?
								if( in_array('TITLE',$arParams['FIELDS'])) {
									?><td class="title"><?=$arStore['TITLE']?></td><?
								}
								if( in_array('PHONE',$arParams['FIELDS'])) {
									?><td><?=$arStore['PHONE']?></td><?
								}
								if( in_array('SCHEDULE',$arParams['FIELDS'])) {
									?><td><?=$arStore['SCHEDULE']?></td><?
								}
								if( in_array('EMAIL',$arParams['FIELDS'])) {
									?><td><?=$arStore['EMAIL']?></td><?
								}
								if( in_array('COORDINATES',$arParams['FIELDS'])) {
									?><td><?=$arStore['COORDINATES']?></td><?
								}
								if( in_array('DESCRIPTION',$arParams['FIELDS'])) {
									?><td><?=$arStore['DESCRIPTION']?></td><?
								}
								?><td class="amount"><?=RSMONOPOLY_GetResult($arStore['AMOUNT'],$arParams)?></td><?
							?></tr><?
						}
					?></table><?
				?></div><?
			}
		}
	?></span><?
?></span><?

?><script>
	RSMONOPOLY_STOCK = {
	'<?=$arParams['~ELEMENT_ID']?>' : {
		'QUANTITY' : <?=json_encode($arParams['DATA_QUANTITY'])?>,
		'JS' : <?=CUtil::PhpToJSObject( $arResult['JS'] )?>,
		'USE_MIN_AMOUNT' : <?=( $arParams['MONOPOLY_USE_MIN_AMOUNT']=='Y' ? 'true' : 'false' )?>,
		'MIN_AMOUNT' : <?=(IntVal($arParams['MIN_AMOUNT'])>0 ? $arParams['MIN_AMOUNT'] : 0 )?>,
		'MESSAGE_ISSET' : <?=CUtil::PhpToJSObject( GetMessage('RS.MONOPOLY.QUANTITY_ISSET') )?>,
		'MESSAGE_LOW' : <?=CUtil::PhpToJSObject( GetMessage('RS.MONOPOLY.QUANTITY_LOW') )?>,
		'MESSAGE_EMPTY' : <?=CUtil::PhpToJSObject( GetMessage('RS.MONOPOLY.QUANTITY_EMPTY') )?>,
		'SHOW_EMPTY_STORE' : <?=( $arParams['SHOW_EMPTY_STORE']=='Y' ? 'true' : 'false' )?>
	}
};
</script>