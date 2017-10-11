<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog.php");
\Bitrix\Main\Loader::includeModule('sale');
$rsUser=CUser::GetByID($_SESSION[\Bitrix\Sale\Fuser::getId()]["fdid"]);
$arUser = $rsUser->Fetch();

$arFields = array(
	'LAST_NAME' =>$arUser["LAST_NAME"],
	'NAME' =>$arUser["NAME"],
	'SECOND_NAME'=>$arUser["SECOND_NAME"],
	'UF_LEARNED'=>htmlspecialchars($_POST['quest']),
	);
$USER->Update($_SESSION[\Bitrix\Sale\Fuser::getId()]["fdid"],$arFields);





