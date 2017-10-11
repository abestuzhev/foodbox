<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

$this->setFrameMode(true);

include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.
        '/templates_ext/catalog.section/mshop/template.php');