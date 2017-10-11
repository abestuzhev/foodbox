<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
	"redsign:example.search.list",
	"",
	Array(
		"BLOCK_ID" => "1",
		"DETAIL_URL" => ""
	)
);