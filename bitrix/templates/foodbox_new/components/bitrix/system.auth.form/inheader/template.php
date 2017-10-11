<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?><div class="authinhead dropdown" id="authinhead"><?
$frame = $this->createFrame('authinhead', false)->begin();
$frame->setBrowserStorage(true);
if ($arResult["FORM_TYPE"] == "login") {
    ?><a id="ddPersonalMenu" href="<?= SITE_DIR ?>auth/" class="js-reg">Регистрация</a><?
    ?><a id="ddEntry" href="<?= SITE_DIR ?>personal/" class="js-entry">Вход</a><?
    } else {
        ?>
        <?php
        $arUser = CUser::GetByID($USER->GetID())->Fetch();
        $style = '';
        if ((int) $arUser['PERSONAL_PHOTO'] > 0) {
            $file = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 23, 'height' => 21), BX_RESIZE_IMAGE_EXACT, true);
            echo '<style>header .auth #ddPersonalMenu:before{background: url(' . $file['src'] . ') no-repeat}</style>';
        }
        ?>
        <a class="dropdown-toggle" id="ddPersonalMenu" data-toggle="dropdown" href="<?= SITE_DIR ?>personal/"><?= $USER->GetFirstName() ?><!--<i class="fa hidden-xs"></i>--></a><?
        /* if($USER->isAdmin()):
          ?>
          <script type="text/javascript">
          $(document).ready(function(){
          //console.log('1');
          //$('#authtest').load('/authtest/');
          $(".qwe").click(function(event){
          $('#authtest').load('/authtest/');
          });
          });
          </script>
          <a class="qwe" style="cursor: pointer;">Регистрация</a>

          <?
          endif; */
        /* ?><a class = "hidden-xs" href="?logout=yes"><?=GetMessage('RS.MONOPOLY.EXIT')?></a><? */
        ?><ul class="dropdown-menu dropdown-menu-right list-unstyled" style="background-color: white;" aria-labelledby="ddPersonalMenu"><?
            /* ?><li><a href="<?=SITE_DIR?>personal/"><?=GetMessage('RS.MONOPOLY.MENU_PERSONAL')?></a></li><? */
            ?><li><a href="<?= SITE_DIR ?>personal/profile/"><?= GetMessage('RS.MONOPOLY.MENU_PROFILE') ?></a></li><?
            ?><li><a href="<?= SITE_DIR ?>personal/cart/"><?= GetMessage('RS.MONOPOLY.MENU_BASKET') ?></a></li><?
            /* ?><li><a href="<?=SITE_DIR?>personal/delivery/"><?=GetMessage('RS.MONOPOLY.MENU_DELIVERY_PROFIL')?></a></li><? */
            ?><li><a href="<?= SITE_DIR ?>personal/order/?show_all=Y"><?= GetMessage('RS.MONOPOLY.MENU_ORDERS') ?></a></li><?
            ?><li><a href="<?= SITE_DIR ?>personal/favorite/"><?= GetMessage('RS.MONOPOLY.MENU_FAVORITE') ?></a></li><?
            ?><li><a href="<?= SITE_DIR ?>personal/viewed/"><?= GetMessage('RS.MONOPOLY.MENU_VIEWED') ?></a></li><?
            if ($USER->IsAuthorized()):
                ?><li><a href="?logout=yes"><?= GetMessage('RS.MONOPOLY.EXIT') ?></a></li><?
                endif;
                ?></ul><?
        }
        $frame->beginStub();
        ?><a href="<?= SITE_DIR ?>auth/"><?= GetMessage('RS.MONOPOLY.PERSONAL_PAGE') ?></a><?
        $frame->end();
        ?></div>