/*
* jquery.fotoexpose.js v2.0, July 09, 2011
* Copyright (c) 2011 Mark Tank (www.husbandman.org)
* License GLPv2 or later
*/

(function(jQuery) {
	jQuery.fn.fotoexpose = function(options) {
		var defaults = {
			increment: "", // how far the slider moves
			fade: 1000, // how fast the photo fade in and out
			sliderSpeed: 800, //how fast the thumbnail slide
			locationSpeed: 600, // how fast the location bar moves
			viewer: '#fe-viewer', // what tag is the viewer
			largePath: "gallery/largePhotos/", // the path of the large images
			mobileWidth: 768,
			modwidth: true,  //set whether the indicator changes size
			loaderClass: 'fe-loader', // the class for the load image
			loadedClass: 'fe-loaded',
			thumbWidth: '', // how wide the thumbnail bar is
			slideshow: 4000, // how fast the slide show moves
			effects: '', // class for the large image
		};
		var options = jQuery.extend(defaults, options);
		
		this.each(function() {
			var currentInd = jQuery("#fe-current");
			var photoBox = jQuery(this);
			var slider = photoBox.find('div:first-child');
			var currentThumb = slider.find("img:first-child");
			var firstThumb = slider.find("img:first-child");
			var interval;
			var largePhoto = jQuery("#largePhoto");
			var lastThumb = slider.find("img:last-child");
			var loaderClassImg = jQuery("."+options.loaderClass).css('background-image');
			var locationBar = jQuery("#fe-location");
			var more = jQuery('#fe-more');
			var playclass = jQuery('.fe-playing');
			var playing = false;
			var playtext = jQuery('#fe-playtext');
			var previous = jQuery('#fe-previous');
			var screenWidth = screen.width;
			var thumbWidth = (options.thumbWidth < 1) ? fitToScreen(currentThumb.width()) : options.thumbWidth;
			var thumbs = jQuery("#fe-thumbs");
			var viewer = jQuery("#fe-viewer");
			options.increment = (options.increment > 0 ) ? options.increment : thumbWidth ;
					
			var thumbNailWidth = slider.find('img:first-child').width();
			currentInd.css({"position":"relative","left":currentThumb.offset().left - thumbs.offset().left,"width":thumbNailWidth+"px"});
			thumbs.css({"height": currentThumb.height()+4+"px"});
			//currentThumb.css({"position: absolute;"});
			sliderWidth = getTotalWidth(slider);
			slider.css({"position":"absolute","left":"0",'width':sliderWidth});
			previous.hide();
			largePhoto.hide();
			if(slider.width() < photoBox.width()) {
				more.hide();
			}
			loadImage(currentThumb);
			
			//finding the left stop position
			var num = Math.floor(slider.width() / photoBox.width());
			var leftStop = (num * photoBox.width()) * -1;
			more.click(showMore);
			
			previous.click(showPrev);
			
			function showMore() {
				var sliderLeft = slider.css("left").replace(/\D/g,"");
				if(sliderLeft > leftStop) {
					slider.animate({ "left" : "-="+options.increment+"px"}, options.sliderSpeed, function() {
						if(slider.css("left").replace("px","") <= leftStop) more.fadeOut('fast');
						if(currentThumb) moveIndecator(currentThumb);
					});	
					previous.fadeIn('fast');
				}
			}
			
			function showPrev() {
				if( slider.css("left").replace("px","") < 0 ) {
					backto = slider.css("left").replace("px","") * -1
					backto = backto - options.increment;
					//slider.css({"left":backto+"px"});	
					slider.animate({"left": "+="+options.increment+"px"}, options.sliderSpeed, function(){
						//if the slider is back to 0 then previous get hid
						if( slider.css("left").replace("px","") >= 0 )  previous.fadeOut('fast'); more.fadeIn('fast');
						if(currentThumb) moveIndecator(currentThumb);
					});
				}
			}
			
			jQuery("img",thumbs).click(function() {
				if(playing) {
					return false;
				}
				// set the variable of images clicked
				currentThumb = jQuery(this);
				//move indicator to selected image
				moveIndecator(this);
				loadImage(jQuery(this));
			});
			
			jQuery('#fe-play').click(function() {
				if(playing) {
					playtext.addClass('shutdown');
					playing = false;
					stopSS();
				}
				else {
					startSS();
					playing = true;
				}
			});
			
			function startSS() {
				playtext.text('Stop');
				playclass.show();
				interval = self.setTimeout(function() {
					currentThumb = (currentThumb.next().length) ? currentThumb.next() : false;
					if(!currentThumb) {
						playtext.text('Play');
						playclass.hide();
						slider.css({ "left" : 0});
						currentThumb = firstThumb;
						moveIndecator(currentThumb);
						if(screenWidth > mobileWidth) {
							more.show();
						}
						previous.hide();
						playing = false;
						loadImage(currentThumb);
						return false;
						
					}
					loadImage(currentThumb);
					idc = moveIndecator(currentThumb);
					if(idc > (thumbWidth - thumbNailWidth)) {
						showMore();
					}
				},options.slideshow);
			}
			
			function stopSS() {
				self.clearTimeout(interval);
				playtext.removeClass('shutdown');	
				playtext.text('Play');
				playclass.hide();
			}
			
			jQuery(window).keydown(function(e) {
				if(playing) {
					return false;
				}
				
				if(e.which == 37 && playing !== true) {
					currentThumb = (currentThumb.prev().length) ? currentThumb.prev() : currentThumb;
					keyMove();
				}
				if(e.which == 39 && playing !== true) {
					currentThumb = (currentThumb.next().length) ? currentThumb.next() : currentThumb;
					keyMove();
				}
			});
			
			jQuery("#fe-previous-image").click(function() {
				if(playing !== true) {
					currentThumb = (currentThumb.prev().length) ? currentThumb.prev() : currentThumb;
					keyMove();
				}
			});
			
			jQuery("#fe-next-image").click(function() {
				if(playing !== true) {
					currentThumb = (currentThumb.next().length) ? currentThumb.next() : currentThumb;
					keyMove();
				}
			});
						
			function keyMove() {
					loadImage(currentThumb);
					moveIndecator(currentThumb);
					idc = moveIndecator(currentThumb);
					if(idc > (thumbWidth - thumbNailWidth)) {
						showMore();
					}
					else if (idc < 1) {
						showPrev();
					}
			}
			
			function moveIndecator(el) {
				var thumbLeft = jQuery(el).offset().left - thumbs.offset().left;
				if(options.modwidth == true) { 
					currentInd.animate({"left": thumbLeft+"px","width":jQuery(el).width()+"px"},options.locationSpeed);
				}
				else {
					currentInd.animate({"left": thumbLeft+"px"},options.locationSpeed);
				}
				return thumbLeft;
			};
			
			function getTotalWidth(el) {
				var total = 0;
				el.find('img').each(function() {
					total += jQuery(this).outerWidth(true);
				});
				return total;
			};
			
			function fitToScreen(thumb) {
				var ww = jQuery('#fe-fotobox').width();
				var div = Math.floor(ww / thumb);
				return div * thumb;
			};
			
			function scaleLarge(img) {
				var ratio = (viewer.width() < img.width()) ? viewer.width() / img.width() : 1;
				var dimensions = {
					width: img.width() * ratio,
					height: img.height() * ratio
				}
				return dimensions;
			}
			
			function loadImage(el) {
				var src = el.attr("fe-full");
				jQuery(options.viewer).find('img').remove('img');
				jQuery(options.viewer).addClass(options.loaderClass);
				img = new Image();
				jQuery(img).load(function() {			 
					jQuery(img).hide();
					jQuery(options.viewer).removeClass(options.loaderClass).addClass(options.loadedClass).append(img);
					var dimension = scaleLarge(jQuery(img)) 
					jQuery(img).css({'width': dimension.width,'height':dimension.height,'margin-right':'auto','margin-left':'auto'});
					jQuery(options.viewer).css({'height':dimension.height+24});
					jQuery(img).stop(true,true).fadeIn(options.fade);
					if(playing) {
						startSS();
					}
					else {
						stopSS();
					}
				}).attr('src',src).stop(true,true).fadeIn(options.fade).addClass(options.effects);
			}
			
		});
		return this;
	
	} // end plugin
	
})(jQuery);