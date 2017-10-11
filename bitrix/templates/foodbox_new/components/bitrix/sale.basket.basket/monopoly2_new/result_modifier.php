<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (!CModule::IncludeModule('redsign.devfunc'))
    return;

// get no photo
$arResult['NO_PHOTO'] = RSDevFunc::GetNoPhoto(array('MAX_WIDTH' => 110, 'MAX_HEIGHT' => 110));
// /get no photo

foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $k => $item):
    $res = CIBlockElement::GetByID($item['PRODUCT_ID'])->Fetch();
    $section = CIBlockSection::GetByID($res['IBLOCK_SECTION_ID'])->Fetch();

    $ratioRes = CNewRation::getNewRationInBasket($section['IBLOCK_ID'], $section['ID'], $section['DEPTH_LEVEL'], $item['QUANTITY']);

    $arResult["ITEMS"]["AnDelCanBuy"][$k]['RATIO_DATA'] = $ratioRes;
endforeach;

/*
  if (strlen($_COOKIE['BITRIX_SM_F_SALE_CODE']) > 0) {

  $coupon = Marketing::getFreeCoupon();
  if ($coupon !== false) {
  if ($arResult['COUPON'] != $coupon) {
  CCatalogDiscountCoupon::ClearCoupon();
  CCatalogDiscountCoupon::SetCoupon($coupon);
  }
  if ($arResult['COUPON'] != $coupon) {
  LocalRedirect('/personal/cart/');
  }
  }
  }
 * */

if (strlen($_COOKIE['BITRIX_SM_SALE_CODE']) > 0) {
    $coupon = Marketing::getDiscountCoupon();
    if ($coupon !== false) {
        if ($arResult['COUPON'] != $coupon) {
            CCatalogDiscountCoupon::ClearCoupon();
            CCatalogDiscountCoupon::SetCoupon($coupon);
        }
        if ($arResult['COUPON'] != $coupon) {
            LocalRedirect('/personal/cart/');
        }
    }
}
