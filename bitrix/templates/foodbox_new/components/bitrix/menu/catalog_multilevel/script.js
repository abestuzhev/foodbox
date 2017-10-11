var jsvhover = function()
{
	var menuDiv = document.getElementById("vertical-multilevel-menu");
	if (!menuDiv)
		return;

  var nodes = menuDiv.getElementsByTagName("li");
  for (var i=0; i<nodes.length; i++) 
  {
    nodes[i].onmouseover = function()
    {
      this.className += " jsvhover";
    }
    
    nodes[i].onmouseout = function()
    {
      this.className = this.className.replace(new RegExp(" jsvhover\\b"), "");
    }
  }
}

if (window.attachEvent) 
	window.attachEvent("onload", jsvhover); 


jQuery(document).ready(function($){
	var tmp_menu_height = $('.fixedMenu').innerHeight();
	$('.fixedMenu').css('margin-top', '0px');

    
    scrollMenu("Y");
    
});
$(window).resize(function() {
    scrollMenu("Y");
    //$('.ss_menu_private_banking ul').offset().top
    //console.log($(".bottomBlock").offset().top);
});
$(document).scroll(function() {
    scrollMenu("N");
    //$('.ss_menu_private_banking ul').offset().top
    //console.log($(".bottomBlock").offset().top);
});

function scrollMenu(statusSetWidth){
	if ($('.myContent > .container > .row > .col').height() <= $('#sidebar').height()) {
		return false;
	}
	if ($(window).height() < $('.fixedMenu').height()) {
		defaultWidthMenu ();
		return false;
	}
	
	if (statusSetWidth == "Y") {
		defaultWidthMenu();
	}
	
	if (parseInt($("footer").offset().top) <= parseInt($('.fixedMenu').height() + $(document).scrollTop() + $('header').height() + 20)) {
		$('.fixedMenu').css({'position':'absolute', 'top':($('header').height() + ($('.myContent > .container').height() - ($('header').height() - 40)) - $('.fixedMenu').outerHeight(true)), 'margin-top': '0', 'bottom':'auto'});
	} else if ($(document).scrollTop() <= 25) {
		$('.fixedMenu').css({'position':'relative', 'top':'auto', 'margin-top': '0', 'bottom':'auto'});
	} else {
		$('.fixedMenu').css({'position':'fixed','top':$('header').height() + 20, 'bottom':'auto', 'margin-top': '0'});
	}
	
}

function defaultWidthMenu () {
	$('.fixedMenu').css({'position':'relative', 'top':"auto", 'margin-top': '0', 'bottom':'auto', 'width':'auto'});
	var widthMenu = $('.fixedMenu').width();
	$('.fixedMenu').width(widthMenu);
}