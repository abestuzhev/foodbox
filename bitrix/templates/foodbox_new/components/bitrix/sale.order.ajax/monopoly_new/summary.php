<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
?>
<div class = "row">

	

	<div class = "col col-md-12 text-right ws_formated">
		<span class = ""> <?=Loc::getMessage('SOA_TEMPL_ITEMS_COUNT')?> <?=count($arResult['BASKET_ITEMS'])?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_SUMMARY')?> <?=$arResult['ORDER_PRICE_FORMATED']?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_WEIGHT_SUM')?> <?=$arResult['ORDER_WEIGHT_FORMATED']?> </span>
		<span class = "left-indent"> <?=Loc::getMessage('SOA_TEMPL_SUM_DELIVERY')?> <?=$arResult['DELIVERY_PRICE_FORMATED']?> </span>
	</div>
	<div class = "col col-md-12">
		<div class = "panel panel-order">
			<div class = "panel-body">
                <div class="row orderline">
                
                    <div class="col col-xs-6 col-md-5 buttons">
						<div class="row">
							<div class="col col-xs-6 col-md-6 buttons">
								<a onClick="SendAnalyticsGoal('modify');" href="<?=$arParams['PATH_TO_BASKET']?>" class="btn btn-default">
									<?=Loc::getMessage("SOA_TEMPL_BUTTON_EDIT_BASKET")?>
								</a>
							</div>
							<div class="col col-xs-6 col-md-6">
								<a href="/catalog/" class="btn btn-default">
									<?=Loc::getMessage("SALE_RETURN_TO_CATALOG")?>
								</a>
							</div>
						</div>
                    </div>
                    <div class="col col-xs-6 col-md-3 col-md-push-4 text-right buttons">
                        <a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="checkout btn btn-primary btn-order">
                            <?=Loc::getMessage("SOA_TEMPL_BUTTON")?>
                        </a>
                    </div>
                    <div class="col col-xs-12 col-md-4 col-md-pull-3 col-lg-pull-2 text-right">
                        <?=Loc::getMessage('SOA_TEMPL_SUM_IT')?>
                        <span class = "price cool"> <?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></span>
                        
                        <div class = "price vat text-right">
                            <?=Loc::getMessage('SOA_TEMPL_SUM_VAT'); ?>
                            <?=$arResult['VAT_SUM_FORMATED']?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>