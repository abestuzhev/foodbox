<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}?>
<div class="list-search-results col-sm-12 col-md-9 col-lg-9" id="ajax-list-search-results">
<?
include($_SERVER['DOCUMENT_ROOT'].
        '/bitrix/components/redsign/search.by.list/ajax.php');
?>



</div>

<?
$arJSParams["RESULT_LIST_SEARCH"] = $templateData["RESULT_LIST_SEARCH"];
?>

<script type="text/javascript">
var obSearchList = new JCSearchList(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>