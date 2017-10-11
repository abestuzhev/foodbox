/**
 * @fileOverview SuperBanner plugin for JQuery
 * @author ALFA Systems
 * @version: 0.1
 */
;(function ($, window ) {
    "use strict";
    
    var pluginName = "superBanner",
        namespace = "superbanner",
        defaultOptions = {
            isSwitch: false,
            width: 1200,
            height: 440
        };
        
    function SuperBanner($element, options) {
        this.$element = $element;
        
        if(this.$element.length == 0) {
            console.warn("Selector " + this.$element.selector + " don`t find");
            return;
        }
        
        this.options = $.extend( {}, defaultOptions, options );
        this.isLoadImages = false;
        this.currentIndex = this.options.startIndex || 
                            parseInt( this.options.images.length / 2 );
        this.elements = {};
        this.images = [];
                            
        this.init();
    }
    
    $.extend(SuperBanner.prototype, {
        init: function() {
            
            var _this = this;
            callFunction( this.options.onBeforeInit, this );
            
            this.initDom();
            this.canvasCtx = $(".js-superbanner-layer")[0].getContext("2d");
            
            this.loadImages()
                .then(function() {
                    
                    _this.showImages();
                    callFunction( _this.options.onLoadImages, _this );
                    _this.$element.trigger( namespace + ".images:loaded" );
                    _this.setImage( _this.currentIndex );
                    
                }, function() {
                    console.warn("Don't load images");
                });
            
            startEvents();
            
            
            callFunction(this.options.onAfterInit, this);
            
            function startEvents() {
                
                _this.$element.on(namespace + ".image:prev", function(event) {
                    _this.$element.trigger(namespace + ".image:to", _this.currentIndex - 1);
                });
                
                _this.$element.on(namespace + ".image:next", function(event) {
                    _this.$element.trigger(namespace + ".image:to", _this.currentIndex + 1);
                });
                
                _this.$element.on(namespace + ".image:to", function(event, index) {    
                    
                    if(
                        !$.isNumeric( index ) ||
                        (index > _this.options.images.length || index < 0) ||
                        _this.currentIndex == index
                    ) {
                            
                        return false;
                    }
                    
                    _this.toImage(index);
                    _this.$element.trigger(namespace + ".image:changed", index);
                });
                
                var $switchSelector = _this.options.$switchSelector || _this.$element;
                $switchSelector.on("mousemove", function(event) {
                    
                    if(_this.options.isSwitch) {
                        
                        var mousePositionX = event.pageX - $switchSelector.offset().left,
                            switchAreaWidth = $switchSelector.innerWidth();
                        
                        var index = Math.floor(
                            mousePositionX * (_this.options.images.length) / switchAreaWidth
                        );
                        
                        _this.$element.trigger( namespace + ".image:to", index);
                    }
                    
                });
            }
        },
        
        loadImages: function() {
            if(this.isLoadImages) {
                return true;
            }
            
            var _this = this,
                promises = [];
                
            var images = [];
            if(this.options.images instanceof $) {            
                var $imgsSelector = this.options.images;
                
                $imgsSelector.find("img").each(function(k, img) {
                    images.push($(img).data("src"));
                });
                
                this.options.images = images;
                
            } else if($.isArray(this.options.images)) {
                images = this.options.images;
            }
            
            images.forEach(function(image, i) {
                promises.push(
                    $.Deferred(function(promise) {
                        $( "<img>" )
                            .attr( "src", image )
                            .appendTo( _this.elements.$hidden )
                            .load(function() {
                                
                                _this.images[i] = new Image();
                                _this.images[i].src = image;
                                
                                promise.resolve();
                            });                    
                    })
                )
            });
            
            return $.when.apply( $, promises );
        },
        
        initDom: function() {
            var preloadHtml = this.options.preload || this.$element.html();
                              
            this.$element.html('');
            
            this.elements.$preload = $( "<div>" )
                .addClass( "js-superbanner-preload" )
                .html( preloadHtml )
                .appendTo(this.$element);
            
            this.elements.$hidden = $( "<div>" )
                .addClass( "js-superbanner-hidden" )
                .hide()
                .appendTo( this.$element );
                
            this.elements.$image = $( "<div>" )
                .addClass( "js-superbanner-image" )
                .hide()
                .html( 
                    $("<canvas>")
                        .addClass("js-superbanner-layer")
                        .attr("width", this.options.width)
                        .attr("height", this.options.height) 
                )
                .appendTo( this.$element );
        },
        
        showPreload: function() {
            this.elements.$preload.show();
        },
        
        toImage: function(index) {    
            var _this = this;
            index = parseInt( index );    
            
            if(this.isMoving) {
                return;
            }
            
            this.lastIndex = this.currentIndex;
            this.currentIndex = index;
            
            var indexesDiff = this.currentIndex - this.lastIndex;
            
            if(indexesDiff > 1 || indexesDiff < -1) {
                this.isMoving = true;
                clearInterval( _this.interval );
                if(indexesDiff > 1) {
                    
                    _this.interval = setInterval(function() {
                        if(_this.lastIndex >= _this.currentIndex) {
                            clearInterval(_this.interval);
                            _this.isMoving = false;
                        }
                        _this.setImage( ++_this.lastIndex );
                    }, 15);
                    
                } else {
                    
                    _this.interval = setInterval(function() {
                        if(_this.lastIndex <= _this.currentIndex) {
                            clearInterval(_this.interval);
                            _this.isMoving = false;
                        }
                        _this.setImage( --_this.lastIndex );
                    }, 15);
                    
                }
                
            } else {
                this.setImage( this.currentIndex );
            }
            
        },
        
        showImages: function() {
            this.elements.$preload.hide();
            this.elements.$image.show();
        },
        
        setImage: function(index) {        
        
            index = index || this.currentIndex;
			
			if(!this.images[index]) {
				return;
			}
        
            this.canvasCtx.drawImage(
                this.images[index], 
                0,
                0,
                this.options.width, 
                this.options.height
            );
            
        }
        
    });
    
    function callFunction(f, context, args) {
        
        args = $.isArray(args) ? args : [];
        
        if(f && $.isFunction(f)) {
            f.apply( context, args );
        }
    }
    
    $.fn[pluginName] = function(options) {
        return this.each(function() {
			if (!$.data( this, "plugin_" + pluginName )) {
				$.data(
					this, "plugin_" + pluginName, 
					new SuperBanner( $(this), options )
				);
			}
		});;
    };
    
})( $, window );