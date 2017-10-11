<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;

require_once $_SERVER["DOCUMENT_ROOT"].$templateFolder.'/functions.php';

if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}

?>

<? 
if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N") { 

	if(!empty($arResult["ERROR"])) {
		
		foreach($arResult["ERROR"] as $v) {			
			echo ShowError($v);
		}
		
	} elseif(!empty($arResult["OK_MESSAGE"])) {
		
		foreach($arResult["OK_MESSAGE"] as $v) {
			echo ShowNote($v);
		}
		
	}

	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
} else {
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
		if(strlen($arResult["REDIRECT_URL"]) == 0) {
			include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php";
		}
	} else {
		
		?>
			<script type="text/javascript">

				<?if(CSaleLocation::isLocationProEnabled()):?>

					<?
					// spike: for children of cities we place this prompt
					$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
					?>

					BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
						'source' => $this->__component->getPath().'/get.php',
						'cityTypeId' => intval($city['ID']),
						'messages' => array(
							'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
							'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
							'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
								'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
								'#ANCHOR_END#' => '</a>'
							)).'</div>'
						)
					))?>);

				<?endif?>

				var BXFormPosting = false;
				function submitForm(val)
				{
					if (BXFormPosting === true)
						return true;

					BXFormPosting = true;
					if(val != 'Y')
						BX('confirmorder').value = 'N';

					var orderForm = BX('ORDER_FORM');
					BX.showWait();

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.cleanUp();
					<?endif?>

					BX.ajax.submit(orderForm, ajaxResult);

					return true;
				}

				function ajaxResult(res)
				{
					var orderForm = BX('ORDER_FORM');
					try
					{
						// if json came, it obviously a successfull order submit

						var json = JSON.parse(res);
						BX.closeWait();
						
						if (json.error)
						{
							BXFormPosting = false;
							return;
						}
						else if (json.redirect)
						{
							SendAnalyticsGoal('produkt-zakaz');
							
							window.top.location.href = json.redirect;
						}
					}
					catch (e)
					{
						// json parse failed, so it is a simple chunk of html

						BXFormPosting = false;
						BX('order_form_content').innerHTML = res;

						<?if(CSaleLocation::isLocationProEnabled()):?>
							BX.saleOrderAjax.initDeferredControl();
						<?endif?>
					}

					BX.closeWait();
					BX.onCustomEvent(orderForm, 'onAjaxSuccess');
				}

				function SetContact(profileId)
				{
					BX("profile_change").value = "Y";
					submitForm();
				}
			</script>
		<?
		
		if($_POST["is_ajax_post"] != "Y") {			
			?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
			<?=bitrix_sessid_post()?><?
				?><div id="order_form_content"><?
		} else {
			$APPLICATION->RestartBuffer();
		}
		
		if($_REQUEST['PERMANENT_MODE_STEPS'] == 1) {
			?><input type="hidden" name="PERMANENT_MODE_STEPS" value="1"><?
		}
		
		if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y") {
			
			foreach($arResult["ERROR"] as $v) {
				echo ShowError($v);
			}
			?>
			<script type="text/javascript">
				top.BX.scrollToNode(top.BX.findParent(top.BX('ORDER_FORM')));
			</script>
			<?
		}
		
		
		?>
			<div class="panel-group" data-toggle = "accordion" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingCustomerInfo">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" href="#customerInfo" aria-expanded="true" aria-controls="customerInfo">
								<?=Loc::getMessage('SOA_TEMPL_BUYER_INFO'); ?>
							</a>
						</h4>
					</div>
					<div id="customerInfo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCustomerInfo">
						<div class="panel-body">
							<div class = "row">
								<?include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php";?>
								<?include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php";?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingComment">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" href="#comment" aria-expanded="true" aria-controls="comment">
								<?=Loc::getMessage('SOA_TEMPL_SUM_COMMENTS'); ?>
							</a>
						</h4>
					</div>
					<div id="comment" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingComment">
						<div class="panel-body">
							<div class = "row">
								<div class = "form-group">
									<label for = "ORDER_DESCRIPTION"><?=Loc::getMessage('SOA_TEMPL_SUM_COMMENTS_TEXT');?></label>
									<textarea class = "form-control" name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<? if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d"): ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingPaySystem">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#paySystem" aria-expanded="true" aria-controls="paySystem">
									<?=Loc::getMessage('SOA_TEMPL_PAY_SYSTEM'); ?>
								</a>
							</h4>
						</div>
						<div id="paySystem" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPaySystem">
							<div class="panel-body">
								<div class = "row">
										<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php"; ?>
								</div>
							</div>
						</div>
					</div>
				
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingDelivery">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#delivery" aria-expanded="true" aria-controls="delivery">
									<?=Loc::getMessage('SOA_TEMPL_DELIVERY'); ?>
								</a>
							</h4>
						</div>
						<div id="delivery" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingDelivery">
							<div class="panel-body">
								<div class = "row">
										<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php"; ?>
								</div>
							</div>
						</div>
					</div>
				<? else: ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingDelivery">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#delivery" aria-expanded="true" aria-controls="delivery">
									<?=Loc::getMessage('SOA_TEMPL_DELIVERY'); ?>
								</a>
							</h4>
						</div>
						<div id="delivery" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingDelivery">
							<div class="panel-body">
								<div class = "row">
										<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php"; ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingPaySystem">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#paySystem" aria-expanded="true" aria-controls="paySystem">
									<?=Loc::getMessage('SOA_TEMPL_PAY_SYSTEM'); ?>
								</a>
							</h4>
						</div>
						<div id="paySystem" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPaySystem">
							<div class="panel-body">
								<div class = "row">
										<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php"; ?>
								</div>
							</div>
						</div>
					</div>
				<? endif; ?>
				
				<? if(is_array($arResult["ORDER_PROP"]["RELATED"]) && count($arResult["ORDER_PROP"]["RELATED"])): ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingRelatedProps">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" href="#relatedProps" aria-expanded="true" aria-controls="relatedProps">
									<?=Loc::getMessage('SOA_TEMPL_RELATED_PROPS'); ?>
								</a>
							</h4>
						</div>
						<div id="relatedProps" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingRelatedProps">
							<div class="panel-body">
								<div class = "row">
										<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php"; ?>
								</div>
							</div>
						</div>
					</div>
				<? endif; ?>
				
			</div>
			
			<? include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php"; ?>
			
			<? //include $_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php"; ?>
			
		<?
		if($_POST["is_ajax_post"] != "Y") {
			?></div><?
				?><input type="hidden" name="confirmorder" id="confirmorder" value="Y"><?
				?><input type="hidden" name="profile_change" id="profile_change" value="N"><?
				?><input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y"><?
				?><input type="hidden" name="json" value="Y"><?
			?></form><?
		} else {
			?>
			<script type="text/javascript">
				top.BX('confirmorder').value = 'Y';
				top.BX('profile_change').value = 'N';
			</script>
			<?
			die();
		}
	}
}
?>


<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps", 
			".default", 
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.search", 
			".default", 
			array(
			),
			false
		);?>
	</div>

<?endif;