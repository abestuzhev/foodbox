<? 
showTableWithItems(array(
	'ITEMS' => $arResult["ITEMS"]["ProdSubscribe"],
	'HEADERS' => $arResult["GRID"]["HEADERS"],
	'SKIP_PROP' => array('WEIGHT', 'PROPS', 'PROPERTY_CML2_ARTICLE_VALUE', 'TYPE', 'DELAY', 'SUM'),
	'URLS' => $arUrls,
	'NO_PHOTO' => $arResult['NO_PHOTO']
));