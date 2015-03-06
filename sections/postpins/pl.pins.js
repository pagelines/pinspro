!function ($) {

	// --> Initialize
	$(document).ready(function() {


		$.plPins.start()

	})

	$.plPins = {

		setMasonry: function(  ){

				var that = this
				,	theContainers = $('.postpin-list')


				theContainers.each( function(){
					var theList = $(this)

						theList.imagesLoaded(function(){

							var windowWidth = window.innerWidth
							,	galWidth = theList.width()
							,	masonrySetup = { }
							,	numCols

							if( windowWidth >= 1620 ){
								numCols = 5
							} else if ( windowWidth >= 1300 ){
								numCols = 4
							} else if ( windowWidth >= 990 ){
								numCols = 3
							} else if ( windowWidth >= 470 ){
								numCols = 2
							} else {
								numCols = 1
							}
console.log(numCols)
console.log(windowWidth)
console.log(galWidth)
							masonrySetup = {
								columnWidth: parseInt( galWidth / numCols )
							}
console.log(masonrySetup)

							theList.isotope({
								resizable: false,
								itemSelector : '.isotope-item',
								filter: '*',
								layoutMode: 'masonry',
								masonry: masonrySetup
							})
								.isotope( 'reLayout' )
								.addClass('done-loading')



						})
				})

		}

		, start: function( opts ){

			var that = this
			,	theContainers = $('.postpin-list')

			$(window).resize( that.setMasonry )
			that.setMasonry( )

			theContainers.each( function(){

				var theList = $(this)
				,	theListID = theList.parent().data('id')
				,	colWidth = theList.data('pin-width')
				,	gtrWidth = theList.data('gutter-width')
				,	loadStyle = theList.data('loading')
				,	pinsUrl = theList.data('url')

				if( loadStyle == 'infinite' ){

					theList.infinitescroll({
						navSelector : '.iscroll',
						nextSelector : '.iscroll a',
						itemSelector : '.postpin-list .isotope-item',
						loadingText : 'Loading...',
						loadingImg :  pinsUrl+'/load.gif',
						donetext : 'No more pages to load.',
						debug : true,
						loading: {
							finishedMsg: 'No more pages to load.'
						}

					}, function( arrayOfNewElems ) {

						theList.imagesLoaded(function(){


							theList
								.isotope('appended', $( arrayOfNewElems ) )


						})

					})

				} else {

					var theLoadLink = theList.parent().find('.fetchpins a')

					theLoadLink.on('click', function(e) {

						e.preventDefault();

						theLoadLink
							.addClass('loading')
							.html('<i class="icon icon-refresh icon-spin spin-fast"></i> &nbsp;  Loading...');

						$.ajax({
							type: "GET",
							url: theLoadLink.attr('href') + '#pinboard',
							dataType: "html",
							success: function(out) {

								var newContainer = $( out ).find( sprintf('[data-id="%s"]', theListID ) )
								, 	result = newContainer.find( '.isotope-item' )
								,	nextlink = newContainer.find( '.fetchpins a' ).attr('href')



								theList.append( result )

								theList.imagesLoaded(function(){

									theList
										.isotope('appended', result)

								});

								theLoadLink
									.removeClass('loading')
									.text('Load More Posts');



								if (nextlink != undefined)
									theLoadLink.attr('href', nextlink);
								else
									theLoadLink.parent().remove();

							}
						});
					});
				}

			})





		}


	}



}(window.jQuery);
