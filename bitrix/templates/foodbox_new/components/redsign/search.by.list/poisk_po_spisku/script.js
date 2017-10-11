(function (window) {



if (!!window.JCSearchList)
{
	return;
}

window.JCSearchList = function (arParams)
{
	this.paramAjaxPost = {
		path: '/bitrix/components/redsign/search.by.list/ajax.php?asd=Y&_dc='+(new Date()).getTime(),
		params: {
			AJAX: 'Y',
			RESULT_LIST_SEARCH: false
		}
	};
	
	if (typeof arParams === 'object')
	{
		this.params = arParams;
		
		this.paramAjaxPost.params.RESULT_LIST_SEARCH = this.params.RESULT_LIST_SEARCH;
	}
	
	if (this.params.RESULT_LIST_SEARCH) {
		//BX.ready(BX.delegate(this.Init,this));
		
	}
	
}

window.JCSearchList.prototype.Init = function()
{
	console.log('Init');
	
	BX.ajax.post(
		this.paramAjaxPost.path,
		this.paramAjaxPost.params,
		BX.proxy(this.ajaxResult, this)
	);	
}

window.JCSearchList.prototype.ajaxResult = function(arResult)
{
	BX('ajax-list-search-results').innerHTML = arResult;
	
	$('.bx_catalog_top_home').bxSlider({
		slideWidth: 235,
		minSlides: 1,
		maxSlides: 4,
		slideMargin: 1,
		pager:false
	});
}

window.JCSearchList.prototype.submitForm = function()
{
	var orderForm = BX('search-list-form');
	BX.showWait();

	BX.ajax.submit(orderForm, BX.proxy(this.ajaxResultForm, this));

}

window.JCSearchList.prototype.ajaxResultForm = function(arResult)
{
	console.log('ajaxResultForm');
	
	var json = JSON.parse(arResult);
	
	this.paramAjaxPost.params.RESULT_LIST_SEARCH = json.RESULT_LIST_SEARCH;
	
	this.Init();
	
	BX.closeWait();
}



})(window);

function resetForm()
{	
	$('.goods-list').find('input').attr('value','');
}

function setSelectionRange(input, selectionStart, selectionEnd) {
  if (input.setSelectionRange) {
    input.focus();
    input.setSelectionRange(selectionStart, selectionEnd);
  }
  else if (input.createTextRange) {
    var range = input.createTextRange();
    range.collapse(true);
    range.moveEnd('character', selectionEnd);
    range.moveStart('character', selectionStart);
    range.select();
  }
}

function setCaretToPos (input, pos) {
  setSelectionRange(input, pos, pos);
}

$(document).ready(function() {
 $("#search-list-form").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
		  var curInput = event.target;		  
		  var next = $(curInput).parent().next('li').find('input')[0];
		  if(typeof next!="undefined")
		  {
		  setCaretToPos(next, $(next).val().length);
		  }		  
          return false;
		}
	});
});
