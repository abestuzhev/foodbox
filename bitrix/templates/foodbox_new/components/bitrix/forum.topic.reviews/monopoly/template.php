<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);
?>

<div class = "row">
	<div class = "col col-md-12 section-cart">
		<h2 class="coolHeading">
			<span class="secondLine"><?=GetMessage('RS.MONOPOLY.REVIEW_TITLE')?></span>
		</h2>
	</div>
	<div class = "col col-md-12">
		<div class="panel panel-default">
		  <div class="panel-body reviews-header">
			<div class = "row">
				<div class = "col col-md-6 col-xs-4 rating"><?/*
					<span class = "hidden-xs"><?=GetMessage('RS.MONOPOLY.REVIEW_RATING')?></span>
					<div class = "stars-rating rating-<?=$arResult['COMMON_RATING'];?>">
						<span class = "star"></span>
						<span class = "star"></span>
						<span class = "star"></span>
						<span class = "star"></span>
						<span class = "star"></span>
					</div>
				*/?></div>
				<div class = "col col-md-6 col-xs-8 text-right">
					<a href = "#form_review" title = "<?=GetMessage('RS.MONOPOLY.REVIEW_NEW')?>" class = "fancywithoutajax btn btn-default"><?=GetMessage('RS.MONOPOLY.REVIEW_NEW')?></a>
				</div>
			</div>
		  </div>
		</div>
	</div>
	
	<? if($arResult['ERROR_MESSAGE']): ?>
		<div class = "col col-md-12">
			<div class="alert alert-danger" role="alert"><?=$arResult["ERROR_MESSAGE"]?></div>
		</div>
	<?php endif; ?>
	<? if($arResult['OK_MESSAGE']): ?>
		<div class = "col col-md-12">
			<div class="alert alert-success" role="alert"><?=$arResult["OK_MESSAGE"]?></div>
		</div>
	<?php endif; ?>
	
	<div class = "customerreviews col col-md-12">
		<? if( !is_array($arResult['MESSAGES']) || count($arResult['MESSAGES']) < 1 ):?>
			<div class="alert alert-warning" role="alert"><?=GetMessage('RS.MONOPOLY.NO_REVIEWS')?></div>
		<? endif; ?>
		<? foreach ($arResult['MESSAGES'] as $arMessage): ?>
			<div class = "item">
				<div class = "row">
					<div class = "col col-md-12"> 
						<div class = "review">
							<div class="in">
								<? // PLUS ?>
                                <? if(!empty($arMessage['POST_MESSAGE_TEXT_EXT']['PLUS'])): ?>                                
                                    <div class = "review-section">
                                        <span class = "review-title"><?=GetMessage('RS.MONOPOLY.REVIEW_PLUS')?></span>
                                        <?=$arMessage['POST_MESSAGE_TEXT_EXT']['PLUS'];?>
                                    </div>
                                <? endif; ?>
								<? // MINUS ?>
                                <? if(!empty($arMessage['POST_MESSAGE_TEXT_EXT']['MINUS'])): ?>
                                    <div class = "review-section">
                                        <span class = "review-title"><?=GetMessage('RS.MONOPOLY.REVIEW_MINUS')?></span>
                                        <?=$arMessage['POST_MESSAGE_TEXT_EXT']['MINUS'];?>
                                    </div>
                                <? endif; ?>
								<? // COMMENT ?>
								<div class = "review-section">
									<span class = "review-title"><?=GetMessage('RS.MONOPOLY.REVIEW_COMMENT')?> </span>
									<?=$arMessage['POST_MESSAGE_TEXT_EXT']['COMMENT'];?>
								</div>
								<? if($arResult['SHOW_POST_FORM']=='Y'): ?>
									<div class = "review-section">
										<?if($arResult['PANELS']['MODERATE'] == 'Y'):?>
											<a rel="nofollow" href="<?=$arMessage['URL']['MODERATE']?>"><?=GetMessage((($arMessage['APPROVED'] == 'Y') ? 'F_HIDE' : 'F_SHOW'))?></a>
											<? if ($arResult['PANELS']['DELETE']=='Y') { ?> &nbsp; | &nbsp; <? } ?>
										<? endif; ?>
										<?if($arResult['PANELS']['DELETE'] == 'Y'):?>
											<a rel="nofollow" href="<?=$arMessage['URL']['DELETE']?>"><?=GetMessage('F_DELETE')?></a>
										<? endif; ?>
									</div>
								<? endif; ?>
							</div>
							<div class="arrow"><span></span></div>
						</div>
						<div class = "author">
							<div class = "image">			
								<?//echo '<pre>'; var_dump($arMessage[]); echo '</pre>';?>
								<? if(is_array ($arMessage['AVATAR']) && array_key_exists ("HTML", $arMessage['AVATAR']) ): ?>
									<?=$arMessage['AVATAR']['HTML']?>
								<? else: ?>
									<img src = "<?=$arResult['NO_AVATAR']?>" alt = "<?=$arMessage['AUTHOR_NAME']?>">
								<? endif; ?>
							</div>
							<div class = "text">
								<div class = "pull-left">
									<div class="name aprimary robotolight">
										<?=$arMessage['AUTHOR_NAME']?>
										<div class = "stars-rating rating-<?=$arMessage['POST_MESSAGE_TEXT_EXT']['RATING'];?>">
											<? for ($i = 1; $i <= 5; $i++): ?>
												<span class = "star" data-index=<?=$i?>></span>
											<? endfor; ?>
										</div>
									</div>
									<? if(isset($arMessage['EMAIL'])): ?>
										<div class="job">
											<?=$arMessage['EMAIL']?>
										</div>									
									<?php endif; ?>
								</div>
								<div class = "pull-right">
									<?=$arMessage['POST_DATE']?>
								</div>
							</div>
							<div class = "clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		<? endforeach; ?>
		<?=$arResult["NAV_STRING"]?>
	</div>
</div>
<div style = "display: none;" id = "form_review">
	<div class = "overflower">
		<div class = "row">
			<div class = "col col-md-12">
				<form action="<?=POST_FORM_ACTION_URI?>"  name="<?=$arParams['FORM_ID']?>" id="<?=$arParams['FORM_ID']?>" method="POST" class = "mainform preview_form">
					<input type="hidden" name="index" value="<?=htmlspecialcharsbx($arParams["form_index"])?>" />
					<input type="hidden" name="back_page" value="<?=$arResult["CURRENT_PAGE"]?>" />
					<input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
					<input type="hidden" name="SECTION_ID" value="<?=$arResult["ELEMENT_REAL"]["IBLOCK_SECTION_ID"]?>" />
					<input type="hidden" name="save_product_review" value="Y" />
					<input type="hidden" name="preview_comment" value="N" />
					<input type = "hidden" name = "REVIEW_TEXT" value = "Hello, world2asd!">
					<?=bitrix_sessid_post()?>
					<div class = "webform clearfix">
						<div class = "row">
							<div class = "col col-md-12">
									<?=GetMessage('RS.MONOPOLY.REVIEW_RATING')?> 
									<div class = "stars-rating js-stars">
										<? for ($i = 1; $i <= 5; $i++): ?>
											<span class = "star" data-index=<?=$i?>></span>
										<? endfor; ?>
									</div>
							</div>
							<? if(!$arResult['IS_AUTHORIZED']): ?>
								<div class = "col col-md-12 field-wrap">
									<span class = "label-wrap">
										<?=GetMessage('RS.MONOPOLY.REVIEW_NAME')?>
										<input name="REVIEW_AUTHOR" id="REVIEW_AUTHOR<?=$arParams["form_index"]?>" class = "form-control" type="text" value="<?=$arResult["REVIEW_AUTHOR"]?>">
									</span>
								</div>
								<? if ($arResult["FORUM"]["ASK_GUEST_EMAIL"]=="Y"): ?>
									<div class = "col col-md-12 field-wrap">
										<span class = "label-wrap">
											<?=GetMessage('RS.MONOPOLY.REVIEW_EMAIL')?>
											<input name="REVIEW_AUTHOR" id="REVIEW_EMAIL<?=$arParams["form_index"]?>" class = "form-control" type="text" value="<?=$arResult["REVIEW_EMAIL"]?>">
										</span>
									</div>
								<? endif; ?>
							<? endif; ?>
							<div class = "col col-md-12 field-wrap">
								<span class = "label-wrap">
									<?=GetMessage('RS.MONOPOLY.REVIEW_PLUS')?>
								</span>
								<textarea name="REVIEW_TEXT_plus" class="form-control"><?=(isset($arResult['REVIEW_TEXT_EXT']['PLUS']) ? $arResult['REVIEW_TEXT_EXT']['PLUS'] : '')?></textarea>
							</div>
							<div class = "col col-md-12 field-wrap">
								<span class = "label-wrap">
									<?=GetMessage('RS.MONOPOLY.REVIEW_MINUS')?>
								</span>
								<textarea name="REVIEW_TEXT_minus" class="form-control"><?=(isset($arResult['REVIEW_TEXT_EXT']['MINUS']) ? $arResult['REVIEW_TEXT_EXT']['MINUS'] : '')?></textarea>
							</div>
							<div class = "col col-md-12 field-wrap">
								<span class = "label-wrap">
									<?=GetMessage('RS.MONOPOLY.REVIEW_COMMENT')?>
									<span class="required"> *</span>
								</span>
								<textarea name="REVIEW_TEXT_comment" class="req-input must-be-filled almost-filled form-control"><?=(isset($arResult['REVIEW_TEXT_EXT']['COMMENT']) ? $arResult['REVIEW_TEXT_EXT']['COMMENT'] : '')?></textarea>
							</div>
						</div>
					</div>
					<div class = "row">
						<? if(strLen($arResult["CAPTCHA_CODE"]) > 0): ?>
							<div class="captcha_wrap col col-md-12 form-group field-wrap req">
								<label for="captcha_word" class="col col-md-12"><?=GetMessage("RS.MONOPOLY.REVIEW_CATPCHA")?>: <span class="required">*</span><br>
								<div class = "row">
									<div class="col col-md-6"><img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA"></div>
									<div class="col col-md-6"><input class="form-control" type="text" name="captcha_word" id="captcha_word" size="30" maxlength="50" value=""></div>
									<input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>">
									<a id="reloadCaptcha" class="reloadCaptcha"><?=GetMessage('RS.MONOPOLY.RELOAD_CAPTCHA')?></a>
								</div>
							</div>
						<? endif; ?>
						<div class = "col col-md-12 buttons">
							<span><?=GetMessage('RS.MONOPOLY.REVIEW_REQUIRED_FIELD')?></span>
							<input type="submit" class="btn btn-primary btn-group-lg" name="send_button" value="<?=GetMessage("RS.MONOPOLY.REVIEW_SUBMIT")?>" disabled>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>