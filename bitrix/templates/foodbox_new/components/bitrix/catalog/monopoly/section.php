<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$this->setFrameMode(true);
if (!\Bitrix\Main\Loader::includeModule('redsign.mshop'))
    return;

$useSorter = false;
if ($arParams['RSMONOPOLY_SHOW_SORTER'] == 'Y' && \Bitrix\Main\Loader::includeModule("redsign.devcom")) {
    $useSorter = true;
}

global $IS_CATALOG, $IS_CATALOG_SECTION;
$IS_CATALOG = true;

if (\Bitrix\Main\Loader::includeModule("iblock")) {
    // take data about curent section
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (IntVal($arResult["VARIABLES"]["SECTION_ID"]) > 0) {
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    } elseif ($arResult["VARIABLES"]["SECTION_CODE"] != "") {
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
    }
    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        $arCurSection = array();
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "LEFT_MARGIN", "RIGHT_MARGIN", "DESCRIPTION", "IBLOCK_SECTION_ID"));
        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");
            if ($arCurSection = $dbRes->GetNext()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$arCurSection = $dbRes->GetNext()) {
                $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    // /take data about curent section
}
?>


<div class="bx-sidebar-block">
    <?
    $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter", "monopoly", array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arCurSection['ID'],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SAVE_IN_SESSION" => "N",
        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
        "XML_EXPORT" => "N",
        "SECTION_TITLE" => "NAME",
        "SECTION_DESCRIPTION" => "DESCRIPTION",
        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        "SEF_MODE" => $arParams["SEF_MODE"],
        "SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
            ), $component, array('HIDE_ICONS' => 'Y')
    );
    ?>
</div>


<div class="row"><?
    $IS_CATALOG_SECTION = true;
    ?><div class="col col-md-12"><!-- =catalog= --><?
    if ($useSorter) {
        \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('catalog');
    }
    // catalog //
    ?><div class="row"><?
        if ($useSorter) {
            ?><div class="col col-md-12"><?
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.compare.list", "monopoly", array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "NAME" => $arParams["COMPARE_NAME"],
                    "COMPONENT_TEMPLATE" => "monopoly",
                    "AJAX_MODE" => $arParams["AJAX_MODE"],
                    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                    "COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"]
                        ), $component, array('HIDE_ICONS' => 'Y')
                );
                global $alfaCTemplate, $alfaCSortType, $alfaCSortToo, $alfaCOutput;
                ?><?
                $APPLICATION->IncludeComponent(
                        "redsign:catalog.sorter", "monopoly", array(
                    "COMPONENT_TEMPLATE" => "monopoly",
                    "ALFA_ACTION_PARAM_NAME" => "alfaction",
                    "ALFA_ACTION_PARAM_VALUE" => "alfavalue",
                    "ALFA_CHOSE_TEMPLATES_SHOW" => $arParams['RSMONOPOLY_SORTER_SHOW_TEMPLATE'],
                    "ALFA_SORT_BY_SHOW" => $arParams['RSMONOPOLY_SORTER_SHOW_SORTING'],
                    "ALFA_SHORT_SORTER" => "N",
                    "ALFA_OUTPUT_OF_SHOW" => $arParams['RSMONOPOLY_SORTER_SHOW_PAGE_COUNT'],
                    "ALFA_CNT_TEMPLATES" => "4",
                    "ALFA_DEFAULT_TEMPLATE" => $arParams['RSMONOPOLY_SORTER_TEMPLATE_DEFAULT'],
                    "ALFA_SORT_BY_NAME" => array("CATALOG_PRICE_1", "sort", "name"),
                    "ALFA_SORT_BY_DEFAULT" => "CATALOG_PRICE_1_asc",
                    "ALFA_OUTPUT_OF" => array("12", "48", "2000"),
                    "ALFA_OUTPUT_OF_DEFAULT" => "48",
                    "ALFA_OUTPUT_OF_SHOW_ALL" => "N",
                    "ALFA_CNT_TEMPLATES_0" => "",
                    "ALFA_CNT_TEMPLATES_NAME_0" => "showcase",
                    "ALFA_CNT_TEMPLATES_1" => "",
                    "ALFA_CNT_TEMPLATES_NAME_1" => "list_little",
                    "ALFA_CNT_TEMPLATES_2" => "",
                    "ALFA_CNT_TEMPLATES_NAME_2" => "list",
                    "ALFA_CNT_TEMPLATES_3" => "",
                    "ALFA_CNT_TEMPLATES_NAME_3" => "showcase_little",
                    "USE_FILTER" => $arParams['USE_FILTER'],
                    "USE_AJAX" => $arParams['SORTER_USE_AJAX'],
                    "TEMPLATE_AJAX_ID" => $arParams['TEMPLATE_AJAX_ID']
                        ), $component, array('HIDE_ICONS' => 'Y')
                );
                ?><?
                ?></div><?
            }
            ?><div class="col col-md-12"><?
                $idSection = $arCurSection["ID"];
                if ($arCurSection["IBLOCK_SECTION_ID"]) {
                    $idSection = $arCurSection["IBLOCK_SECTION_ID"];
                }
                ?><?
                $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list", "monopoly_inner_img", array(
                    "PAGE_URL" => $APPLICATION->GetCurDir(),
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $idSection,
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                    "TOP_DEPTH" => "1",
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ""),
                    "SECTION_USER_FIELDS" => array(
                        0 => "UF_VIEW_CATALOG",
                        1 => "UF_SECTION_ICON",
                        2 => "",
                    ),
                        ), $component, array('HIDE_ICONS' => 'Y')
                );
                ?>
                <div id="js-ajaxcatalog">
                    <?
                    $intSectionID = $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section", "monopoly", array(
                        "AJAX_MODE" => $arParams["AJAX_MODE"],
                        "AJAX_OPTION_ADDITIONAL" => $arParams["AJAX_OPTION_ADDITIONAL"],
                        "AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
                        "AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
                        "AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_SORT_FIELD" => ( $useSorter ? $alfaCSortType : $arParams["ELEMENT_SORT_FIELD"] ),
                        "ELEMENT_SORT_ORDER" => ( $useSorter ? $alfaCSortToo : $arParams["ELEMENT_SORT_ORDER"] ),
                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                        "PAGE_ELEMENT_COUNT" => ( $useSorter ? $alfaCOutput : $arParams["PAGE_ELEMENT_COUNT"] ),
                        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
                        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ""),
                        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ""),
                        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                        "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                        "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                        "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                        "LABEL_PROP" => $arParams["LABEL_PROP"],
                        "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
                        "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
                        "OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
                        "OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
                        "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
                        "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
                        "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
                        "MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
                        "MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
                        "MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
                        "MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
                        "MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"]) ? $arParams["TEMPLATE_THEME"] : ""),
                        "ADD_SECTIONS_CHAIN" => "N",
                        "ADD_TO_BASKET_ACTION" => $basketAction,
                        "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "",
                        "COMPARE_PATH" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                        // store
                        'USE_STORE' => $arParams['USE_STORE'],
                        'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
                        'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
                        'MAIN_TITLE' => $arParams['MAIN_TITLE'],
                        'SHOW_GENERAL_STORE_INFORMATION' => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                        "STORES_FIELDS" => $arParams['FIELDS'],
                        // monopoly
                        "RSMONOPOLY_PROP_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_MORE_PHOTO"],
                        "RSMONOPOLY_PROP_SKU_MORE_PHOTO" => $arParams["RSMONOPOLY_PROP_SKU_MORE_PHOTO"],
                        "RSMONOPOLY_PROP_ARTICLE" => $arParams["RSMONOPOLY_PROP_ARTICLE"],
                        "SIDEBAR" => $arResult["SIDEBAR"],
                        "RSMONOPOLY_TEMPLATE" => $alfaCTemplate,
                        "RSMONOPOLY_USE_FAVORITE" => $arParams['RSMONOPOLY_USE_FAVORITE'],
                        'TEMPLATE_AJAX_ID' => $arParams['TEMPLATE_AJAX_ID']
                            ), $component
                    );
                    ?></div><?
                    ?></div><?
                    ?><div class="col col-md-12 sectiondescription"><?= $arCurSection["DESCRIPTION"] ?></div><?
                    ?></div><?
            // /catalog //

            if ($useSorter) {
                \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('catalog', '<div class="preloader"></div>');
            }
            ?><!-- /=catalog= --></div><?
            ?></div><?