<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult['SECTIONS'] as &$arSection) {
	if ($arSection["UF_SECTION_ICON"] && !is_null($arSection["UF_SECTION_ICON"])) {
		$arSection["UF_SECTION_ICON"] = CFile::GetFileArray($arSection["UF_SECTION_ICON"]);
	}
}