<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$phone = "";
$mail = "";
$filter = Array
(
    "PERSONAL_PHONE" => $_POST["phone"],
    
);
$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter);
if($rsUsers->Fetch())
{
	$phone = "Номер";
}

$filter = Array
(
    "EMAIL" => $_POST["mail"],
    
);
$rsUsers1 = CUser::GetList(($by="personal_country"), ($order="desc"), $filter);
if($rsUsers1->Fetch())
{
	$mail = "Email";
}

if($mail && $phone)
{
	echo "<p style='color:red'>Email и Телефон занят</p>";
}
else
if($mail)
{
	echo "<p style='color:red'>Email занят</p>";
}
else
if($phone)
{
	echo "<p style='color:red'>Телефон занят</p>";
}
