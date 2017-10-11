<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog.php");

$rsUser=CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$arFields = array(
	'LAST_NAME' =>$arUser["LAST_NAME"],
	'NAME' =>$arUser["NAME"],
	'SECOND_NAME'=>$arUser["SECOND_NAME"],
	'EMAIL'=>htmlspecialchars($_POST['email']),
	);
$USER->Update($USER->GetID(),$arFields);
echo "Готово.";