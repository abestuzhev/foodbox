<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
?>
<script>
	function changePaySystem(param)
	{
		if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
		{
			if (param == 'account')
			{
				if (BX("PAY_CURRENT_ACCOUNT"))
				{
					BX("PAY_CURRENT_ACCOUNT").checked = true;
					BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
					BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

					// deselect all other
					var el = document.getElementsByName("PAY_SYSTEM_ID");
					for(var i=0; i<el.length; i++)
						el[i].checked = false;
				}
			}
			else
			{
				BX("PAY_CURRENT_ACCOUNT").checked = false;
				BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
				BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
			}
		}
		else if (BX("account_only") && BX("account_only").value == 'N')
		{
			if (param == 'account')
			{
				if (BX("PAY_CURRENT_ACCOUNT"))
				{
					BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

					if (BX("PAY_CURRENT_ACCOUNT").checked)
					{
						BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
					}
					else
					{
						BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
					}
				}
			}
		}

		submitForm();
	}
</script>
<? uasort($arResult["PAY_SYSTEM"], "cmpBySort"); ?>
<table class = "table-order">
	<tbody>
		<? if($arResult["PAY_FROM_ACCOUNT"] == "Y"): ?>
			<? $accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N"; ?>
			<tr >
				<td class = "rdbtn">
					<input type="hidden" id="account_only" value="<?=$accountOnly?>">
					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
					<div class = "checkbox">					
						<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
						<label for = "PAY_CURRENT_ACCOUNT"></label>
					</div>
				</td>
				<td colspan = "2">
					<b><?=Loc::getMessage("SOA_TEMPL_PAY_ACCOUNT")?></b>
					<p>
						<div><?=Loc::getMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
						<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
							<div><?=Loc::getMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
						<? else:?>
							<div><?=Loc::getMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
						<? endif;?>
					</p>
				</td>
			</tr>
		<? endif; ?>
		<? foreach($arResult["PAY_SYSTEM"] as $arPaySystem): ?>		
			<tr onclick = "BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;">
				<td class = "rdbtn">
					<div class = "radio">
						<input type="radio"
								id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
								name="PAY_SYSTEM_ID"
								value="<?=$arPaySystem["ID"]?>"
								<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
								
						>
						<label for = "ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"></label>
					</div>
				</td>
				<td class = "img hidden-xs">
					<?
					if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
						$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
					else:
						$imgUrl = $templateFolder."/images/logo-default-ps.gif";
					endif;
					?>
					<img src = "<?=$imgUrl?>" alt = "<?=$arPaySystem["PSA_NAME"];?>">
				</td>
				<td>
					<?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
						<b><?=$arPaySystem["PSA_NAME"];?></b>
					<?endif;?>
					<? str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), Loc::getMessage("SOA_TEMPL_PAYSYSTEM_PRICE")); ?>
					<p><?=$arPaySystem["DESCRIPTION"];?></p>
				</td>
			</tr>	
		<? endforeach; ?>
	</tbody>
</table>