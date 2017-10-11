<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$this->setFrameMode(true);

if (!\Bitrix\Main\Loader::includeModule('redsign.mshop'))
    return;

//isset($_SERVER['HTTP_X_REQUESTED_WITH'])
if (1 == 1) {
    $ELEMENT_ID = IntVal($_REQUEST['element_id']);
    if ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST['action'] == 'get_element_json') {
        // +++++++++++++++++++++++++++++++ get element json +++++++++++++++++++++++++++++++ //
        global $APPLICATION, $JSON;
        $APPLICATION->RestartBuffer();
        if ($ELEMENT_ID < 1) {
            $arJson = array('TYPE' => 'ERROR', 'MESSAGE' => 'Element id is empty');
            echo json_encode($arJson);
            die();
        }
        $ElementID = $APPLICATION->IncludeComponent(
                'bitrix:catalog.element', 'json', Array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
            'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
            'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
            'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
            'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
            'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
            'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
            'CACHE_TIME' => $arParams['CACHE_TIME'],
            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
            'SET_TITLE' => $arParams['SET_TITLE'],
            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
            'PRICE_CODE' => $arParams['PRICE_CODE'],
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
            'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
            'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
            'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
            'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
            'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
            'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
            'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
            'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
            'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],
            'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
            'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
            'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
            'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
            'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
            'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
            'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
            'ELEMENT_ID' => $ELEMENT_ID,
            'ELEMENT_CODE' => '',
            'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
            'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
            'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
            'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
            'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
            // monopoly params
            "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
            "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
            "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
            "RSMONOPOLY_PROPS_ATTRIBUTES" => $arParams["RSMONOPOLY_PROPS_ATTRIBUTES"],
            "RSMONOPOLY_PROPS_ATTRIBUTES_COLOR" => $arParams["RSMONOPOLY_PROPS_ATTRIBUTES_COLOR"],
            // store
            'USE_STORE' => $arParams['USE_STORE'],
            'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
            'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
            'MAIN_TITLE' => $arParams['MAIN_TITLE'],
                ), $component, array('HIDE_ICONS' => 'Y')
        );
        $APPLICATION->RestartBuffer();
        if (SITE_CHARSET != 'utf-8') {
            $data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
            $json_str_utf = json_encode($data);
            $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
            echo $json_str;
        } else {
            echo json_encode($JSON);
        }
        die();
    } elseif ($arParams['USE_COMPARE'] == 'Y' && $_REQUEST['AJAX_CALL'] == 'Y' && ($_REQUEST['action'] == 'ADD_TO_COMPARE_LIST' || $_REQUEST['action'] == 'DELETE_FROM_COMPARE_LIST')) {
        // +++++++++++++++++++++++++++++++ add2compare +++++++++++++++++++++++++++++++ //
        global $APPLICATION, $JSON;
        $APPLICATION->IncludeComponent(
                'bitrix:catalog.compare.list', 'json', array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'NAME' => $arParams['COMPARE_NAME'],
            'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
            'COMPARE_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
            'IS_AJAX_REQUEST' => 'Y',
                ), $component, array('HIDE_ICONS' => 'Y')
        );
        $APPLICATION->RestartBuffer();
        if (SITE_CHARSET != 'utf-8') {
            $data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
            $json_str_utf = json_encode($data);
            $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
            echo $json_str;
        } else {
            echo json_encode($JSON);
        }
        die();
    } elseif ($_REQUEST['AJAX_CALL'] == 'Y' && strtolower($_REQUEST['action']) == 'add2basket') {
        // +++++++++++++++++++++++++++++++ add2basket +++++++++++++++++++++++++++++++ //
        global $APPLICATION, $JSON;
        $ProductID = IntVal($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
        $QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);
        $params = Array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
            'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
            'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
            'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
            'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
        );
        $restat = RSDF_EasyAdd2Basket($ProductID, $QUANTITY, $params);
        $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "monopoly", array("PATH_TO_BASKET" => $arParams["BASKET_URL"], "JSON" => 'Y',));
        $APPLICATION->RestartBuffer();
        if (SITE_CHARSET != 'utf-8') {
            $data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
            $json_str_utf = json_encode($data);
            $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
            echo $json_str;
        } else {
            echo json_encode($JSON);
        }
        die();
    } elseif ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST['action'] == 'UPDATE_FAVORITE') {
        global $JSON;

        $res = RSFavoriteAddDel($ELEMENT_ID);

        $APPLICATION->IncludeComponent('redsign:favorite.list', 'json', array());
        $APPLICATION->RestartBuffer();

        if ($res == 2) {
            $arJson = array('TYPE' => 'OK', 'MESSAGE' => 'Element add2favorite', 'ACTION' => 'ADD', 'HTMLBYID' => $JSON['HTMLBYID']);
        } else if ($res == 1) {
            $arJson = array('TYPE' => 'OK', 'MESSAGE' => 'Element removed from favorite', 'ACTION' => 'REMOVE', 'HTMLBYID' => $JSON['HTMLBYID']);
        } else {
            $arJson = array('TYPE' => 'ERROR', 'MESSAGE' => 'Bad request');
        }

        if (SITE_CHARSET != 'utf-8') {
            $data = $APPLICATION->ConvertCharsetArray($arJson, SITE_CHARSET, 'utf-8');
            $json_str_utf = json_encode($data);
            $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
            echo $json_str;
        } else {
            echo json_encode($arJson);
        }
        die();
    } elseif ($_REQUEST['action'] == 'UPDATE_FAVORITE') {
        $res = RSFavoriteAddDel($ELEMENT_ID);
    }
}
// popup gallery
require_once($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . '/include/popupgallery_catalog.php');
global $IS_CATALOG, $IS_CATALOG_SECTION;
$IS_CATALOG_SECTION = true;
$arParams['HEAD_TYPE'] = RSMshop::getSettings('headType', 'type1');
?><?
$ElementID = $APPLICATION->IncludeComponent(
        "bitrix:catalog.element", "monopoly", array(
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
    "META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
    "META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
    "BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
    "CHECK_SECTION_ID_VARIABLE" => (isset($arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"]) ? $arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"] : ''),
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    "LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
    "LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
    "LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
    "LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
    "OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
    "OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
    'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
    'USE_REVIEW' => $arParams['USE_REVIEW'],
    'FORUM_ID' => $arParams['FORUM_ID'],
    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
    "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
    "DISPLAY_COMPARE" => $arParams['USE_COMPARE'],
    "SET_CANONICAL_URL" => $arParams['DETAIL_SET_CANONICAL_URL'],
    // monopoly
    "RSMONOPOLY_SHOW_CREDIT_BTN" => $arParams["RSMONOPOLY_SHOW_CREDIT_BTN"],
    "RSMONOPOLY_CREDIT_BTN_LINK" => $arParams["RSMONOPOLY_CREDIT_BTN_LINK"],
    "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
    "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
    "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
    "HEAD_TYPE" => $arParams["HEAD_TYPE"],
    "RSMONOPOLY_PROPS_ATTRIBUTES" => $arParams["RSMONOPOLY_PROPS_ATTRIBUTES"],
    "RSMONOPOLY_PROPS_ATTRIBUTES_COLOR" => $arParams["RSMONOPOLY_PROPS_ATTRIBUTES_COLOR"],
    "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
    "RSMONOPOLY_USE_CUSTOM_COLLECTION" => $arParams['RSMONOPOLY_USE_CUSTOM_COLLECTION'],
    'PROPS_TABS' => $arParams['PROPS_TABS'],
    // store
    'USE_STORE' => $arParams['USE_STORE'],
    'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
    'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
    'MAIN_TITLE' => $arParams['MAIN_TITLE'],
    'SHOW_GENERAL_STORE_INFORMATION' => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
    "STORES_FIELDS" => $arParams['FIELDS'],
        ), $component
);
?>
<? if ($ElementID): ?>

    <?
    global $collectionFilter;
    if (is_array($collectionFilter["ID"])) {
        ?>
        <?
        $APPLICATION->includeComponent(
                'bitrix:catalog.section', 'collection', array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
            'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
            'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
            'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
            'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
            'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
            'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
            'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
            'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
            'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
            'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
            'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'FILTER_NAME' => 'collectionFilter',
            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
            'CACHE_TIME' => $arParams['CACHE_TIME'],
            'CACHE_FILTER' => $arParams['CACHE_FILTER'],
            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
            'SET_TITLE' => $arParams['SET_TITLE'],
            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
            'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
            'PAGE_ELEMENT_COUNT' => $arParams['PAGE_ELEMENT_COUNT'],
            'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
            'PRICE_CODE' => $arParams['PRICE_CODE'],
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
            'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
            'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
            'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
            'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
            'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
            'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
            'PAGER_TITLE' => $arParams['PAGER_TITLE'],
            'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
            'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
            'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
            'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
            'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
            'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
            'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
            'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
            'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
            'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
            'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
            'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
            'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
            'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
            'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
            "SHOW_ALL_WO_SECTION" => "Y",
            "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
            // store
            'USE_STORE' => $arParams['USE_STORE'],
            'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
            'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
            'MAIN_TITLE' => $arParams['MAIN_TITLE'],
            'SHOW_GENERAL_STORE_INFORMATION' => 'Y',
            //"STORES_FIELDS" => $arParams['FIELDS'],
            // monopoly
            "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
            "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
            "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
            "SIDEBAR" => $arParams['HEAD_TYPE'] == 'type3' ? 'Y' : 'N',
            "RSMONOPOLY_TEMPLATE" => 'showcase',
            "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
                ), $component
        );
        ?>
        <?
    }
    ?>

    <? $APPLICATION->ShowViewContent('collection_groups'); ?>

    <? if ($arParams['RSMONOPOLY_SHOW_SETS'] == "Y"): ?>
        <?
        $APPLICATION->IncludeComponent(
                'bitrix:catalog.set.constructor', 'monopoly', array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ELEMENT_ID' => $ElementID,
            'PRICE_CODE' => $arParams['PRICE_CODE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
            'CACHE_TIME' => $arParams['CACHE_TIME'],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams["CURRENCY_ID"],
                )
        );
        ?>
    <? endif; ?>

    <? if ($arParams['USE_BIG_DATA'] == 'Y'): ?>
        <?
        $APPLICATION->IncludeComponent(
                "bitrix:catalog.bigdata.products", "mshop", array(
            "RCM_TYPE" => "any",
            "ID" => $ElementID,
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SHOW_FROM_SECTION" => "N",
            "SECTION_ELEMENT_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_ELEMENT_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "SHOW_NAME" => "Y",
            "SHOW_IMAGE" => "Y",
            "MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
            "MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
            "MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
            "PAGE_ELEMENT_COUNT" => 100,
            "LINE_ELEMENT_COUNT" => 100,
            "DETAIL_URL" => "",
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SHOW_OLD_PRICE" => "Y",
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
            "SHOW_PRODUCTS_" . $arParams["IBLOCK_ID"] => "Y",
            "PROPERTY_CODE_" . $arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
            "ADDITIONAL_PICT_PROP_" . $arParams["IBLOCK_ID"] => '', // TODO
            // Stores
            'USE_STORE' => $arParams['USE_STORE'],
            'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
            'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
            'MAIN_TITLE' => $arParams['MAIN_TITLE'],
            'SHOW_GENERAL_STORE_INFORMATION' => "Y",
            "STORES_FIELDS" => $arParams['FIELDS'],
            "SIDEBAR" => $arParams['HEAD_TYPE'] == 'type3' ? 'Y' : 'N',
            "DISPLAY_COMPARE" => $arParams['USE_COMPARE'],
            'RSMONOPOLY_USE_FAVORITE' => $arParams['RSMONOPOLY_USE_FAVORITE'],
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ACTION_VARIABLE" => "action_cbdp",
            "BASKET_URL" => "/personal/basket.php",
            "CART_PROPERTIES_" . $arParams["IBLOCK_ID"] => array("", ""),
            "DEPTH" => "",
            "HIDE_NOT_AVAILABLE" => "N",
            "LABEL_PROP_" . $arParams["IBLOCK_ID"] => "-",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "",
            "SECTION_CODE" => "",
            "SECTION_ID" => "",
            "USE_PRODUCT_QUANTITY" => "Y",
                //"PRODUCT_SUBSCRIPTION" => "N",
                //"SECTION_ELEMENT_CODE" => "",
                //"SECTION_ELEMENT_ID" => "",
                )
        );
        ?>
    <? endif; ?>

    <? if ($arParams['RSMONOPOLY_SHOW_RECOMMENDED_PRODUCTS'] == 'Y'): ?>
        <?
        // Sale recommended products
        $APPLICATION->IncludeComponent(
                "bitrix:sale.recommended.products", "monopoly", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ID" => $ElementID,
            "MIN_BUYES" => "0.1",
            "SHOW_OLD_PRICE" => "N",
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "CACHE_TYPE" => "A",
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
            "RSMONOPOLY_USE_FAVORITE" => $arParams["RSMONOPOLY_USE_FAVORITE"],
            "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
            "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
            "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
            "COMPONENT_TEMPLATE" => "monopoly",
            "CODE" => $_REQUEST["PRODUCT_CODE"],
            "HIDE_NOT_AVAILABLE" => "N",
            "SHOW_DISCOUNT_PERCENT" => "N",
            "PRODUCT_SUBSCRIPTION" => "N",
            "SHOW_NAME" => "Y",
            "SHOW_IMAGE" => "Y",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "PAGE_ELEMENT_COUNT" => "30",
            "DETAIL_URL" => "",
            "CACHE_TIME" => "86400",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "CONVERT_CURRENCY" => "N",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "USE_PRODUCT_QUANTITY" => "Y",
            "PROPERTY_CODE_34" => array(
                0 => "",
                1 => "",
            ),
            "CART_PROPERTIES_34" => array(
                0 => "",
                1 => "",
            ),
            "ADDITIONAL_PICT_PROP_34" => "MORE_PHOTO",
            "LABEL_PROP_34" => "-"
                ), false
        );
        ?>
    <? endif; ?> 
    <? if ($arParams['RSMONOPOLY_SHOW_VIEWED_PRODUCTS'] == 'Y'): ?>
        <?
        // Viewed products
        $APPLICATION->IncludeComponent(
                "bitrix:catalog.viewed.products", "monopoly", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SHOW_FROM_SECTION" => "Y",
            "SECTION_ID" => $arResult["ROOT_SECTION_ID"],
            "={\"SHOW_PRODUCTS_\".\$arParams[\"IBLOCK_ID\"]}" => "Y",
            "DEPTH" => "100",
            "SHOW_OLD_PRICE" => "N",
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "CACHE_TYPE" => "A",
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
            "={\"PROPERTY_CODE_\".\$arParams[\"IBLOCK_ID\"]}" => $arParams["PRODUCT_PROPERTIES"],
            "RSMONOPOLY_USE_FAVORITE" => $arParams["RSMONOPOLY_USE_FAVORITE"],
            "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
            "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
            "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
            "COMPONENT_TEMPLATE" => "monopoly",
            "SECTION_CODE" => "",
            "SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
            "SECTION_ELEMENT_CODE" => "",
            "HIDE_NOT_AVAILABLE" => "N",
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "PRODUCT_SUBSCRIPTION" => "N",
            "SHOW_NAME" => "Y",
            "SHOW_IMAGE" => "Y",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "PAGE_ELEMENT_COUNT" => "5",
            "DETAIL_URL" => "",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "CONVERT_CURRENCY" => "N",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action_cvp",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_QUANTITY_VARIABLE" => "",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "USE_PRODUCT_QUANTITY" => "Y",
            "SHOW_PRODUCTS_34" => "N",
            "PROPERTY_CODE_34" => array(
            ),
            "CART_PROPERTIES_34" => array(
            ),
            "ADDITIONAL_PICT_PROP_34" => "",
            "LABEL_PROP_34" => ""
                ), false
        );
        ?>
    <? endif; ?> 

    <!-------------------------------->
    <div class="row" style="display: none;">
        <div class="col col-md-12 section-cart">
            <h2 class="coolHeading">
                <span class="secondLine">Рецепты с этим ингредиентом</span>
            </h2>
            <div 
                class = "products showcase owlslider owl"
                data-margin = "35"
                data-items = "5"
                data-responsive = '{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"4"}, "956":{"items":"5"}}'
                >
    <?
    $arFilter = Array(
        "IBLOCK_ID" => 35,
        "ACTIVE" => "Y",
        "PROPERTY_TOVARY.ID" => $ElementID
    );
    $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter);
    while ($ar_fields = $res->GetNext()) {
        ?>
                    <div class = "item js-element" style="min-height:250px;">
                        <div class="in">						
                            <div class = "pic">
                                <a class="js-detail_page_url" href="<?= $ar_fields['DETAIL_PAGE_URL'] ?>">
        <?= ShowImage($ar_fields['PREVIEW_PICTURE'], 150, 180) ?>
                                </a>
                            </div>
                            <div class = "data">
                                <div class = "name">
                                    <a class="aprimary" href="<?= $ar_fields['DETAIL_PAGE_URL'] ?>" title="<?= $ar_fields['NAME'] ?>"><?= $ar_fields['NAME'] ?></a><br />
                                </div>
                            </div>
                        </div>
                    </div>
        <?
    }
    ?>


            </div>
        </div>
    </div>
    <!-------------------------------->

                    <? if ($arParams['USE_REVIEW'] == "Y"): ?>
                        <?
                        $APPLICATION->IncludeComponent(
                                "bitrix:forum.topic.reviews", "monopoly", array(
                            'FORUM_ID' => $arParams['FORUM_ID'],
                            'ELEMENT_ID' => $ElementID,
                            'CACHE_TYPE' => $arParams["CACHE_TYPE"],
                            'CACHE_TIME' => $arParams["CACHE_TIME"],
                            'AJAX_POST' => 'N',
                            'AJAX_MODE' => 'N',
                            'USE_CAPTCHA' => $arParams["USE_CAPTCHA"],
                            'MESSAGES_PER_PAGE' => $arParams["MESSAGES_PER_PAGE"],
                            'PAGE_NAVIGATION_TEMPLATE' => 'monopoly',
                            'PREORDER' => 'N',
                            'DATE_TIME_FORMAT' => 'd.m.Y'
                                )
                        );
                        ?>
    <? endif; ?>

<? endif; ?>
