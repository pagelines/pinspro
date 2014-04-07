!function ($) {

	// --> Initialize
	$(document).ready(function() {
		
		
		$.plPins.start()
		
	})
	
	$.plPins = {

		start: function( opts ){
		
			var theContainers = $('.postpin-list')
			

			theContainers.each( function(){
				
				var theList = $(this)
				,	theListID = theList.parent().data('id')
				,	colWidth = theList.data('pin-width')
				,	gtrWidth = theList.data('gutter-width')
				,	loadStyle = theList.data('loading')
				,	pinsUrl = theList.data('url')
				
				theList.imagesLoaded(function(){

					theList
						.masonry({
							itemSelector : '.postpin-wrap'
							, columnWidth: colWidth
							, gutterWidth: gtrWidth
							, isFitWidth: true
						})
						.addClass('done-loading')

				
				});

			

				if( loadStyle == 'infinite' ){
					
					theList.infinitescroll({
						navSelector : '.iscroll',
						nextSelector : '.iscroll a',
						itemSelector : '.postpin-list .postpin-wrap',
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
								.find('.postpin-wrap').width( colWidth - 18 )
								.end()
								.masonry('appended', $( arrayOfNewElems ) )
							
							
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
								, 	result = newContainer.find( '.postpin-wrap' )
								,	nextlink = newContainer.find( '.fetchpins a' ).attr('href')
								
								
								
								result
									.find('.postpin-wrap').width( colWidth - 18 )
								
								theList.append( result )

								theList.imagesLoaded(function(){
									
									theList
										.masonry('appended', result)
										
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