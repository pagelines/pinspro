<?php
/*
	Section: PostPins
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A continuous list of post 'pins'.
	Class Name: PLPostPins
	Filter: format, dual-width
*/


class PLPostPins extends PageLinesSection {

	
	function section_styles(){
		wp_enqueue_script('infinitescroll', $this->base_url.'/script.infinitescroll.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('masonry', $this->base_url.'/script.masonry.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('pl-pins', $this->base_url.'/pl.pins.js', array( 'masonry' ), PL_CORE_VERSION, true);
		
	}

	function old_section_head(){

		
		?>
		<style>.postpin-wrap{ width: <?php echo $width;?>px; }</style>
		<script>

		jQuery(document).ready(function () {

			var theContainer = jQuery('.postpin-list');
			var containerWidth = theContainer.width();


			theContainer.imagesLoaded(function(){

				theContainer.masonry({
					itemSelector : '.postpin-wrap',
					columnWidth: <?php echo $width;?>,
					gutterWidth: <?php echo $gutter_width;?>,
					isFitWidth: true
				});

			});

			<?php if($this->opt('pins_loading', $this->oset) == 'infinite'): ?>

				theContainer.infinitescroll({
					navSelector : '.iscroll',
					nextSelector : '.iscroll a',
					itemSelector : '.postpin-list .postpin-wrap',
					loadingText : 'Loading...',
					loadingImg :  '<?php echo $this->base_url."/load.gif";?>',
					donetext : 'No more pages to load.',
					debug : true,
					loading: {
						finishedMsg: 'No more pages to load.'
					}
				}, function(arrayOfNewElems) {
					theContainer.imagesLoaded(function(){
						theContainer.masonry('appended', jQuery(arrayOfNewElems));
					});
				});

			<?php endif;?>

		});

			<?php if($this->opt('pins_loading', $this->oset) != 'infinite'): ?>
			jQuery('.fetchpins a').live('click', function(e) {
				e.preventDefault();
				jQuery(this).addClass('loading').text('<?php _e('Loading...', 'pagelines');?>');
				jQuery.ajax({
					type: "GET",
					url: jQuery(this).attr('href') + '#pinboard',
					dataType: "html",
					success: function(out) {

						result = jQuery(out).find('.pinboard .postpin-wrap');
						nextlink = jQuery(out).find('.fetchpins a').attr('href');

						var theContainer = jQuery('.postpin-list');

						theContainer.append(result);

						theContainer.imagesLoaded(function(){
							theContainer.masonry('appended', result);
						});

						jQuery('.fetchpins a').removeClass('loading').text('<?php _e('Load More Posts', 'pagelines');?>');



						if (nextlink != undefined) {
							jQuery('.fetchpins a').attr('href', nextlink);
						} else {
							jQuery('.fetchpins').remove();
						}
					}
				});
			});
			<?php endif;?>


		</script>
	<?php }

	/* Section template.
	 ****************************/
	function pl_current_url(){


		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		return substr($url,0,strpos($url, '?'));
	}

	/**
	* Section template.
	*/
   function section_template() {


		global $wp_query;
		global $post;


		$category = ($this->opt('pins_category' )) ? $this->opt('pins_category') : null;

		$number_of_pins = ($this->opt('pins_number' )) ? $this->opt('pins_number') : 15;

		$special_meta = ($this->opt('pins_meta')) ? $this->opt('pins_meta') : '[post_date] / [post_comments]';

		// JAVASCRIPT VARIABLES
		$pin_width = ($this->opt('pins_width')) ? $this->opt('pins_width') : 255;
		$gutter_width = ($this->opt('pins_gutterwidth')) ? $this->opt('pins_gutterwidth') : 15;
		$loading = ( $this->opt('pins_loading') ) ? $this->opt('pins_loading') : 'ajax';

		$current_url = $this->pl_current_url();

		$image_size = ( $this->opt( 'pins_thumbsize', $this->oset ) ) ? $this->opt( 'pins_thumbsize', $this->oset ) : 'medium';

		$page = (isset($_GET['pins']) && $_GET['pins'] != 1) ? $_GET['pins'] : 1;

		$out = '';

		foreach( $this->load_posts($number_of_pins, $page, $category) as $key => $p ){

			if(has_post_thumbnail($p->ID) && get_the_post_thumbnail($p->ID) != ''){
				$thumb = get_the_post_thumbnail($p->ID, $image_size );

				$check = strpos( $thumb, 'data-lazy-src' );
				if( $check ) {
					// detected lazy-loader.
					$thumb = preg_replace( '#\ssrc="[^"]*"#', '', $thumb );
					$thumb = str_replace( 'data-lazy-', '', $thumb );
				}
				$image = sprintf('<div class="pin-img-wrap"><a class="pin-img" href="%s">%s</a></div>', get_permalink( $p->ID ), $thumb);
			} else
				$image = '';
				
		
			$author_name = get_the_author();
			$default_avatar = PL_IMAGES . '/avatar_default.gif';
			$author_desc = custom_trim_excerpt( get_the_author_meta('description', $p->post_author), 10);
			$author_email = get_the_author_meta('email', $p->post_author);
			$avatar = get_avatar( $author_email, '32' );


			$meta_bottom = sprintf(
				'<div class="media fix"><div class="img">%s</div><div class="bd pin-meta subtext"><strong>%s</strong> <br/> %s </div></div>',
				$avatar,
				ucwords	( $author_name ),
				do_shortcode( $special_meta )
				
			);

			$content = sprintf(
				'<div class="postpin-pad"><h4 class="headline pin-title"><a href="%s">%s</a></h4><div class="pin-excerpt summary">%s %s</div></div><div class="postpin-pad pin-bottom">%s</div>',
			
				get_permalink( $p->ID ),
				$p->post_title,
				custom_trim_excerpt($p->post_content, 25),
				pledit($p->ID),
				$meta_bottom
			);

			$out .= sprintf(
				'<div class="postpin-wrap" style="width: %spx;"><article class="postpin">%s%s</article></div>',
				$pin_width - 18,
				$image,
				$content
			);
		}
		
		$pg = $page+1;
		$u = $current_url.'?pins='.$pg;

		$next_posts = $this->load_posts($number_of_pins, $pg, $category);

		if( !empty($next_posts) ){

			$class = ( $this->opt('pins_loading', $this->oset) == 'infinite' ) ? 'iscroll' : 'fetchpins';

			$display = ($class == 'iscroll') ? 'style="display: none"' : '';

			$next_url = sprintf('<div class="%s fetchlink" %s><a class="btn" href="%s">%s</a></div>', $class, $display, $u, __('Load More Posts', 'pagelines'));

		} else
			$next_url = '';
		
		
		
		
		printf(	
			'<div class="pinboard fix"> <div class="postpin-list fix" data-id="%s" data-loading="%s" data-pin-width="%s" data-gutter-width="%s" data-url="%s">%s</div> %s <div class="clear"></div></div>', 
			$this->meta['clone'],
			$loading,
			$pin_width,
			$gutter_width,
			$this->base_url,
			$out, 
			$next_url
		);
	}

	function pl_get_comments_link( $post_id ){

		$num_comments = get_comments_number($post_id);
		
		 if ( comments_open() ){
		 	  if($num_comments == 0){
		 	  	  $comments = __('Add', 'pagelines');
		 	  } elseif($num_comments > 1){
		 	  	  $comments = $num_comments;
		 	  } else{
		 	  	   $comments ='1';
		 	  }
		 $write_comments = '<a href="' . get_comments_link($post_id) .'">'. $comments.' <i class="icon-comments"></i></a>';
		 }
		else{ $write_comments =  false; }

		return $write_comments;

	}

	function load_posts( $number = 20, $page = 1, $category = null){
		$query = array();

		if( isset($category) && !empty($category) )
			$query['category_name'] = $category;

		$query['paged'] = $page;

		$query['showposts'] = $number;

		$q = new WP_Query($query);

		return $q->posts;
	}

	/**
	 *
	 * Page-by-page options for PostPins
	 *
	 */
	function section_opts(  ){

	

			$options = array(
			 	array(
					'type' 			=> 'multi',
					'title' 		=> __( 'Pins Configuration', 'pagelines' ),
					'opts'			=> array(
						array(
							'key'		=> 'pins_number',
							'type' 		=> 'text_small',
							'label' 	=> __( 'Number of Pins To Load', 'pagelines' ),
							'title' 	=> __( 'Number of Pins to Load', 'pagelines' ),
							'place'		=> 15,
						),
						
						array(
							'key'		=> 'pins_width',
							'place'		=> 237,
							'type' 		=> 'text_small',
							'label' 	=> __( 'Pin Width in Pixels', 'pagelines' ),
							'title' 	=> __( 'Pin Width', 'pagelines' ),
							'help' 		=> __( 'The width of post pins in pixels. Default is <strong>237px</strong>.', 'pagelines' )
						),

						
						array(
							'key'		=> 'pins_gutterwidth',
							'type' 		=> 'text_small',
							'place'		=> 15,
							'label' 	=> __( 'Pin Gutter Width in Pixels', 'pagelines' ),
							'title' 	=> __( 'Pin Gutter Width', 'pagelines' ),
							'help' 		=> __( 'The width of the spacing between post pins in pixels. Default is <strong>15px</strong>.', 'pagelines' )
						),

						array(
							'key'			=> 'pins_loading',
							'type' 			=> 'select',
							'default'		=> 'ajax',
							'opts' => array(
								'infinite' 		=> array('name' => __( 'Use Infinite Scrolling', 'pagelines' ) ),
								'ajax' 			=> array('name' => __( 'Use Load Posts Link (AJAX)', 'pagelines' ) ),
							),
							'label' 	=> __( 'Pin Loading Method', 'pagelines' ),
							'title' 		=> __( 'Post Pin Loading', 'pagelines' ),
							'help' 			=> __( "Use infinite scroll loading to automatically load new pins when users get to the bottom of the page. Alternatively, you can use a link that users can click to 'load new pins' into the page.", 'pagelines' ),
						),
					)
				),
				
				array(
					'type' 			=> 'multi',
					'col'			=> 2,
					'title' 		=> __( 'Pins Post Handling', 'pagelines' ),
					'opts'			=> array(
						array(
							'key'			=> 'pins_thumbsize',
							'type'			=> 'select',
							'default'		=>	'large',
							'opts'			=> $this->get_image_sizes(),
							'label'		 	=> __( 'Select attachment image source', 'pagelines' ),
							'title' 		=> __( 'Attachment source', 'pagelines' ),
						),
						array(
							'key'		=> 'pins_meta',
							'default'	=> '[post_date] / [post_comments]',
							'type' 		=> 'text',
							'label' 	=> __( 'Pin Meta Info', 'pagelines' ),
							'title' 	=> __( 'Pin Meta Info', 'pagelines' ),
							'help' 		=> __( 'Use shortcodes to customize the meta information for these pins.', 'pagelines' )
						),
						array(
							'key'			=> 'pins_post_type',
							'type' 			=> 'select',
							'opts'			=> pl_get_thumb_post_types(),
							'default'		=> 4,
							'label' 	=> __( 'Which post type?', 'pagelines' ),
							'help'		=> __( '<strong>Note</strong><br/> Defaults to standard WP posts. Post types for this section must have "featured images" enabled and be public.<br/><strong>Tip</strong><br/> Use a plugin to create custom post types.', 'pagelines' ),
						),
						
						array(
							'key'			=> 'pins_category',
							'taxonomy_id'	=> 'category',
							'type' 			=> 'select_taxonomy',
							'label'		 	=> __( 'Pin Post Category', 'pagelines' ),
							'title' 		=> __( 'Pins Category/Posts Mode', 'pagelines' ),
							'help' 			=> __( "You can select to use only posts from a specific category, leave blank to use all posts. Default is to show all posts.", 'pagelines' )
						)
					)
				),
				
				
			);

			return $options;

	}
	function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
				'thumbnail' => array( 'name' => 'Thumbnail' ),
				'medium'=> array( 'name' => 'Medium' ),
				'large'	=> array( 'name' => 'Large' ),
				'full'	=> array( 'name' => 'Full' )
				);
		if ( is_array( $_wp_additional_image_sizes ) && ! empty( $_wp_additional_image_sizes ) )
			foreach ( $_wp_additional_image_sizes as $size => $data )
				$sizes[] = array( 'name' => $size );

		return $sizes;
	}
}