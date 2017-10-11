<?php

if (!empty($arParams["TEMPLATE_AJAX_ID"])) {
    echo '<div id="' . $arParams['TEMPLATE_AJAX_ID'] . '">';
}

$isAjaxShowMore = false;
if (isset($_REQUEST['show_more']) && $_REQUEST['show_more'] === 'Y') {
    $isAjaxShowMore = true;
}

if ($arResult['TEMPLATE_DEFAULT']['TEMPLATE'] == 'showcase') {

    if ($arParams['SEARCH_PAGE'])
        include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .
                '/templates_ext/catalog.section/mshop/showcase_search.php');
    else
        include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .
                '/templates_ext/catalog.section/mshop/showcase.php');
} elseif ($arResult['TEMPLATE_DEFAULT']['TEMPLATE'] == 'list') {
    include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .
            '/templates_ext/catalog.section/mshop/list.php');
} elseif ($arResult['TEMPLATE_DEFAULT']['TEMPLATE'] == 'showcase_little') {
    include($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .
            '/templates_ext/catalog.section/mshop/showcase_little.php');
}

if (!empty($arParams["TEMPLATE_AJAX_ID"])) {
    echo '</div>';
}