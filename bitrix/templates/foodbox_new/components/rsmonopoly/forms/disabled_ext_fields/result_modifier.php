<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

if (!empty($_GET['get_form'])) {
	foreach ($arResult['FIELDS'] as &$arField) {
		$cntrlName = $arField['CONTROL_NAME'];
		if($_REQUEST[$cntrlName]) {		
			if(SITE_CHARSET != 'utf-8') {
				$arField['HTML_VALUE'] = $APPLICATION->ConvertCharset($_REQUEST[$cntrlName], 'utf-8', SITE_CHARSET);
			} else {
				$arField['HTML_VALUE'] = $_REQUEST[$cntrlName];
			}
			$arField['HTML_VALUE'] = htmlspecialcharsbx($arField['HTML_VALUE']);
		}
	}
	unset($arField);
}