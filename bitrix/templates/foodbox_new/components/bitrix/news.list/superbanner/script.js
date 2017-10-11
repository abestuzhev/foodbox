$(document).ready(function() {
    "use strict";
    
    if($( window ).width() > 1200) {    
    
        setTimeout(function() {
            initBanner();
        }, 3000);
        
    } else {
        $(".js-superbanner_text").removeClass("hidden-lg");
    }
    
    function initBanner() {
		
		var $jsSuperbanner = $(".js-superbanner");
		console.log($jsSuperbanner);
		
		
        $jsSuperbanner.superBanner({
            isSwitch: true,
            $switchSelector: $(".js-superbanner_moved-area"),
            images: $(".js-superbanner_images"),
            width: $jsSuperbanner.data('width'),
            height: $jsSuperbanner.data('height')
        });  
    }
    
    $( window ).resize(function() {
        if($( window ).width() > 1200) {    
            initBanner();
        } 
    });
    
    $(".js-superbanner").on("superbanner.images:loaded", function() {
        $(".js-superbanner_text").removeClass("hidden-lg");
    });
});