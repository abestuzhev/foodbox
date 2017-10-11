<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;
use \Bitrix\Main\Localization\Loc;
?>

<?
//Еще в файле script.js(шаблоне) есть вызов этой же функии для события изменения состава корзины.
if(intVal($arResult['allSum'])<1500) echo "<script>showBuyMoreForFreeDelivery(".$arResult['allSum'].",1500);</script>";
?>

<?if(!$isNormal): ?>
	<div class="alert alert-info"><?=Loc::getMessage("SALE_NO_ITEMS");?></div>
<? else: ?>
<?
showTableWithItems(array(
	'ITEMS' => $arResult["ITEMS"]["AnDelCanBuy"],
	'HEADERS' => $arResult["GRID"]["HEADERS"],
	'SKIP_PROP' => array('WEIGHT', 'PROPS', 'PROPERTY_CML2_ARTICLE_VALUE', 'TYPE'),
	'URLS' => $arUrls,
	'NO_PHOTO' => $arResult['NO_PHOTO']
));
?>
<div class = "row">
    <div class="col col-xs-6 visible-xs">
        <a href="#" class="clearbasket aprimary"><?=Loc::getMessage("CLEAR_BASKET")?></a>
    </div>
	<div class = "col col-xs-6 col-md-12 text-right ws_formated">
		<span class = "count-items "> <?=Loc::getMessage("SALE_COUNT_ITEMS");?> <span id = ""><?=count($arResult["ITEMS"]["AnDelCanBuy"]);?></span> </span>
		
			<span class = "total-weight left-indent"><?=Loc::getMessage("SALE_TOTAL_WEIGHT");?>  <span id = "allWeight_FORMATED"><?=$arResult['allWeight_FORMATED']?></span> </span>
		
	</div>
</div>
<div class = "row">
	<div class = "col col-md-12">
		<div class="panel panel-basket">
			<div class="panel-body">
				<div class = "row">
					<div class = "col col-md-6"></div>
					<div class = "col col-md-6">
						<div class = "text-right">
							<?=Loc::getMessage("SALE_TOTAL")?>
							<span class = "price cool" id = "allSum_FORMATED"> <?=$arResult['allSum_FORMATED']?>  </span>
							<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
								<div class = "price vat">
									<?=Loc::getMessage('SALE_VAT_INCLUDED'); ?>
									<span class = "price vat" id = "allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></span>
								</div>
							<? endif; ?>
						</div>
					</div>
				</div>
				<div class = "row">
                    <div class = "col col-xs-12 col-md-6" id = "coupons_block">
						<p class="visible-xs visible-sm"></p>
						<div class="input-group">
							<input class="form-control" type="text" id="coupon" name="COUPON" value="" placeholder="<?=Loc::getMessage('STB_COUPON_PROMT')?>">
							<span class="input-group-btn">
								<input type = "button" onclick="enterCoupon();" class = "btn btn-primary" value = "<?=Loc::getMessage('CHECK_COUPON')?>">
							</span>
						</div>
						<p class="visible-xs visible-sm"></p>

						<?if($arResult['COUPON_LIST']):?>
							<? foreach ($arResult['COUPON_LIST'] as $i => $oneCoupon): ?>
								<? $couponClass = 'disabled'; ?>
								<?
								switch ($oneCoupon['STATUS'])
								{
									case DiscountCouponsManager::STATUS_NOT_FOUND:
									case DiscountCouponsManager::STATUS_FREEZE:
										$couponClass = 'bad has-error';
										break;
									case DiscountCouponsManager::STATUS_APPLYED:
										$couponClass = 'good has-success';
										break;
								}
								?>
								<div class="<?=$couponClass?> has-feedback" name="coup">
									<label class="control-label" for="coupon_<?=$i?>"><?=Loc::getMessage('COUPON')?></label>
									<input class="form-control" disabled readonly type="text" name="OLD_COUPON[]" id="coupon_<?=$i?>"  value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>">
									<span class="fa glyphicon-remove form-control-feedback"></span>
									<div class="help-block">
										<?if (isset($oneCoupon['CHECK_CODE_TEXT'])):?>
											<span class="note"><?echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);?>&nbsp;</span>
										<?endif;?>
										<span class="aprimary <?=$couponClass?>" data-coupon="<?=htmlspecialcharsbx($oneCoupon['COUPON'])?>" style="cursor:pointer;"><?=Loc::getMessage('SALE_DELETE')?></span>
									</div>
								</div>
							<? endforeach; ?>
							<? unset($couponClass, $oneCoupon); ?>
						<? endif ?>
					</div>
					<div class = "col col-xs-12 col-md-6">
						<div class = "text-right">

							<div class = "buttons">
                                <div class="btn_left">
                                
                                    <a href = "<?=SITE_DIR?>forms/buy1click/"
                                       class = "btn btn-default buy1click_basket fancyajax fancybox.ajax"
                                       title = "<?=Loc::getMessage('BUY1CLICK')?>"
									   onClick="SendAnalyticsGoal('buy-1');"
                                    >
                                        <?=Loc::getMessage('BUY1CLICK')?>
                                    </a>
                                </div>
                                <div class="btn_right">
                                    <input class="btn-order btn btn-primary" type="submit" value="<?=Loc::getMessage('SALE_ORDER')?>" onclick="location.href='<?=$arParams['PATH_TO_ORDER']?>';return false;">
                                </div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<? endif; ?>
