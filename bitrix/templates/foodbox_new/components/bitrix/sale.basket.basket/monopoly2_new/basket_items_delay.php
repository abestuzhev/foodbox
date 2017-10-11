<? 
showTableWithItems(array(
	'ITEMS' => $arResult["ITEMS"]["DelDelCanBuy"],
	'HEADERS' => $arResult["GRID"]["HEADERS"],
	'SKIP_PROP' => array('WEIGHT', 'PROPS', 'PROPERTY_CML2_ARTICLE_VALUE', 'TYPE', 'DELAY', 'SUM'),
	'URLS' => $arUrls,
	'ID_TABLE' => 'delayed_items',
	'NO_PHOTO' => $arResult['NO_PHOTO']
));
?>