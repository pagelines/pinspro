!function ($) {

	// --> Initialize
	$(document).ready(function() {
		
		
		$.plScrollSlider.init()
		
		
		
	})
	
	$.plScrollSlider = {

		init: function( ){
			var that = this
			
			$('.scrollslider-holder').each(function(){
				
				var pinSlideHeight = 0

				that.container = $(this).parent()
				that.slider = $(this)

				that.allSlides = that.slider.find('.slide')
				
				

				that.numSlides = that.allSlides.length

				that.duration = (that.slider.data('duration')) ? that.slider.data('duration') : 10000
				that.transition = (that.slider.data('transition')) ? that.slider.data('transition') : 800

				that.timer = (that.slider.data('timer')) ? that.slider.data('timer') : 1

				// Setup Slide Dimensions
				var sliderTotalWidth = that.numSlides * 100
				,	slideIndWidth = 100 / that.numSlides

				$('.scrollslider-slider').width( sliderTotalWidth + '%')
				
				that.allSlides.width( slideIndWidth + '%' )

				that.allSlides.each( function(){

					if( $(this).height() > pinSlideHeight ){
						pinSlideHeight = $(this).height()
						that.allSlides.height( pinSlideHeight )
					}

				})

				// Allow scrolling
				that.setupScroll()

				// Allow nav
				if( that.numSlides > 1 )
					that.setupNav()

				// Allow timer
				if( that.timer == 1 && that.numSlides > 1 )
					that.setupTimer()
					
				that.navElements = that.container.find('.scrollslider-nav a')

				that.slider.on('scroll', function() {
				  	that.slider.find('.the-content').each(function(){

						var theOff = ($(this).parent().position().left) / .6 

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
				
				
			})
			
			
			
		}
		
		, setupTimer: function(){
			
			var that = this
			,	theTimer = '<div class="scrollslider-loader"></div>'
			
			$(theTimer).insertBefore( that.slider )
			
		}
		
		, setupNav: function(){
			
			var that = this
			,	theNav = ''
			
			that.allSlides.each(function( index ){
				
				theClass = (index == 0) ? 'current' : ''
				
				theNav += sprintf('<a class="%s"><i class="icon icon-circle"></i></a>', theClass)
				
			})
			
			$(sprintf('<div class="scrollslider-nav">%s</div>', theNav)).insertAfter( that.slider )
			
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
					that.newSlideActive()
				else 
					that.noScrollEvent = false
			})
			
		}
		
		, newSlideActive: function( whatever ){
			
			var that = this
			,	activeSlide = that.getCurrentSlide()
			,	theLoader = $('.scrollslider-loader')
			
			that.changeActiveNav( that.navElements.eq( activeSlide - 1 ) )

			if( theLoader.length ){
				
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

			
		}
		
		, timerAnim: function(){
			
			var that = this
			,	theLoader = $('.scrollslider-loader')
			
			if( theLoader.length ){
			
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
