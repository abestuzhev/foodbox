<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION,$JSON;
$JSON = array(
    'TYPE' => 'OK',
    'HTMLBYID' => array(
        'basketinfo' => $arResult['NUM_PRODUCTS'].' '.GetMessage('RS.MONOPOLY.SMALLBASKET_TOVAR').$arResult['RIGHT_WORD'].' '.GetMessage('RS.MONOPOLY.SMALLBASKET_NA').'<br />'.$arResult['PRINT_FULL_PRICE'],
    ),
);
if($arResult['NUM_PRODUCTS']<1)
{
    $JSON['HTMLBYID']['basketinfo'] = GetMessage('RS.MONOPOLY.SMALLBASKET_PUSTO');
}