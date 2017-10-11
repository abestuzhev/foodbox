<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arResult
 * @var array $arParam
 * @var CBitrixComponentTemplate $this
 */
/** @var PageNavigationComponent $component */
$component = $this->getComponent();

$this->setFrameMode(true);
?>
<nav>
    <ul class="pagination list-unstyled">
        <?
        $first = true;

        //if ($arResult["CURRENT_PAGE"] > 1):
            if ($arResult["CURRENT_PAGE"] >= 2):
                ?>
                <li><a href="<?= htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"] - 1)) ?>">&laquo;</a></li>
                <?
            else:
                ?>
                <li class="disabled"><a href="#">&laquo;</a></li>
            <?
            endif;

            if ($arResult["START_PAGE"] > 1):
                $first = false;
                ?>
                <li><a href="<?= htmlspecialcharsbx($arResult["URL"]) ?>">1</a></li>
                <?
                if ($arResult["START_PAGE"] > 2):
                    ?>
                    <li><a class="modern-page-dots" href="<?= htmlspecialcharsbx($component->replaceUrlTemplate(round($arResult["START_PAGE"] / 2))) ?>">...</a></li>
                    <?
                endif;
            endif;
        //endif;

        $page = $arResult["START_PAGE"];
        do {
            if ($page == $arResult["CURRENT_PAGE"]):
                ?>
                <li class="active"><a href="#"><?= $page ?></a></li>
                <?
            elseif ($page == 1):
                ?>
                <li class=""><a href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a></li>
                <?
            else:
                ?>
                <li><a href="<?= htmlspecialcharsbx($component->replaceUrlTemplate($page)) ?>" class="<?= ($first ? "modern-page-first" : "") ?>"><?= $page ?></a></li>
            <?
            endif;

            $page++;
            $first = false;
        }
        while ($page <= $arResult["END_PAGE"]);

        if ($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):
            if ($arResult["END_PAGE"] < $arResult["PAGE_COUNT"]):
                if ($arResult["END_PAGE"] < ($arResult["PAGE_COUNT"] - 1)):
                    ?>
                    <li><a class="modern-page-dots" href="<?= htmlspecialcharsbx($component->replaceUrlTemplate(round($arResult["END_PAGE"] + ($arResult["PAGE_COUNT"] - $arResult["END_PAGE"]) / 2))) ?>">...</a></li>
                    <?
                endif;
                ?>
                <li><a href="<?= htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"])) ?>"><?= $arResult["PAGE_COUNT"] ?></a></li>
                <?
            endif;
            ?>
            <li><a class="modern-page-next" href="<?= htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"] + 1)) ?>">&raquo;</a></li>
            <?
        else:
            ?>
            <li class="disabled"><a href="#">&raquo;</a></li>
            <?
            endif;
            ?>
    </ul>
</nav>