<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (!empty($arResult)) {
    ?>
    <ul class="navigation__list" aria-labelledby="ddTopLineMenu">
        <?
        foreach ($arResult as $arItem) {
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <li class="navigation__item"><a href="<?= $arItem["LINK"] ?>" class="navigation__link <?= $arItem["SELECTED"] ? 'selected' : '' ?>"><?= $arItem["TEXT"] ?></a></li> <?
            }
            ?>
    </ul><?
}