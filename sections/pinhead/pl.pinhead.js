!function ($) {

	// --> Initialize
	$(document).ready(function() {
		
		
		$.plPinHead.init()
		
		
		
	})
	
	$.plPinHead = {

		init: function( ){
			
			var that = this
			,	pinSlideHeight = 0
			,	allSlides = $('.pinhead-holder .slide')
			
			this.slider = $('.pinhead-holder')
			
			this.navElements = $('.pinhead-nav a')
			
			this.numSlides = allSlides.length
			
			this.duration = 10000
			this.transition = 7000
		
			
			allSlides.each( function(){
				
				if( $(this).height() > pinSlideHeight ){
					pinSlideHeight = $(this).height()
					allSlides.height( pinSlideHeight )
				}
				
			})
	
			// Allow scrolling
			that.setupScroll()
		
			
			that.slider.on('scroll', function() {
			  	that.slider.find('.the-content').each(function(){
				
					var theOff = ($(this).parent().position().left) / 3 
					
					$(this).css('margin-left', theOff)
				})
			})
			
			
			// Allow Navigation
			that.navElements.on( 'click', function(){
				
				event.preventDefault();

				// Get "1" from "#slide-1", for example
				var position = $(this).index() + 1;

				that.slider
					.clearQueue()
					.stop()

				that.slider.animate({
						scrollLeft: (position - 1) * that.slider.width()
					}
					, {
						duration: that.transition,
						complete: function(){

							that.newSlideActive()
						}
					} 
				)

				that.changeActiveNav( $(this) )
				
			})
			
	
			that.newSlideActive( 'start' )
			
		}
		
		, setupScroll: function(){
			var that = this
			
			that.slider.scrollsnap({
				direction: 'x',
				snaps: '.slide',
				proximity: 900
			})
			
			
			that.slider.on('scrollstop', function(){
				
				var ratio = ( (that.slider.scrollLeft() / that.slider.width()) % 1 === 0 ) ? true : false;
				
				if( ! that.noScrollEvent && ratio)
					that.newSlideActive( 'scrollstop' )
				else 
					that.noScrollEvent = false
			})
			
		}
		
		, newSlideActive: function( whatever ){
			
			var that = this
			,	activeSlide = that.getCurrentSlide()
			,	theLoader = $('.pinhead-loader')
			
			that.changeActiveNav( that.navElements.eq( activeSlide - 1 ) )

			// clear animations
			theLoader
				.clearQueue()
				.stop()
				.css({ width: "0%" })
			
			that.timerAnim()
			
			that.slider.hover(
				function(){
					theLoader.clearQueue();
				  	theLoader.stop();
				}, 
				function(){
					that.timerAnim()
				}
			)
		}
		
		, timerAnim: function(){
			
			var that = this
			,	theLoader = $('.pinhead-loader')
			
			// Allow Timer
			theLoader
				.animate({
						width: "100%"
					}
					, {
						duration: that.duration,
						queue: false,
						easing: "linear",
						complete: function(){
							
							if( theLoader.attr('style') == 'width: 100%;' ){
								theLoader.css('width', '0')
								that.nextSlide()
								that.noScrollEvent = true
							}
						}
					} 
				)
		}
		
		, nextSlide: function(){
			
			var that = this
			,	activeSlide = that.getCurrentSlide()
			,	nextSlide = ( activeSlide >= that.numSlides ) ? 0 : ( activeSlide + 1 )
		
			that.slider.animate({
					scrollLeft: (nextSlide - 1) * that.slider.width()
				}
				, that.transition
				, 'swing'
				, function(){
					that.newSlideActive(  'animatess' )
				}
			)
			
			
			
		}
		
		, getCurrentSlide: function(){
			
			var that = this
			
			return Math.round( that.slider.scrollLeft() / that.slider.width() ) + 1
		}

		, changeActiveNav: function(el) {
		
			el.parent().find('a').removeClass("current")
		
			el.addClass("current")
		}


	}



}(window.jQuery);
