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
		//wp_enqueue_script('masonry', $this->base_url.'/script.masonry.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script( 'isotope', PL_JS . '/utils.isotope.min.js', array('jquery'), pl_get_cache_key(), true);
		wp_enqueue_script('pl-pins', $this->base_url.'/pl.pins.js', array( 'masonry' ), PL_CORE_VERSION, true);
		
	}

	function section_opts(  ){

	

			$options = array(
			 	array(
					'type' 			=> 'multi',
					'title' 		=> __( 'Pins Configuration', 'pagelines' ),
					'opts'			=> array(
					
						
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
							'key'		=> 'pins_number',
							'default'	=> '12',
							'type'			=> 'count_select',
							'count_number'	=> '30',
							'label' 	=> __( 'Number of Pins', 'pagelines' ),
							'title' 	=> __( 'Number of Pins', 'pagelines' ),
						),
						array(
							'key'		=> 'pins_meta',
							'default'	=> '[post_date] <br/> [post_comments]',
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

		if( is_archive() )
			$category = $wp_query->query_vars['category_name'];
		else
			$category = ($this->opt('pins_category' )) ? $this->opt('pins_category') : null;
		
		$post_type = ($this->opt('pins_post_type' )) ? $this->opt('pins_post_type') : null;

		$number_of_pins = ($this->opt('pins_number' )) ? $this->opt('pins_number') : 15;

		$special_meta = ($this->opt('pins_meta')) ? $this->opt('pins_meta') : '[post_date] / [post_comments]';

		// JAVASCRIPT VARIABLES
	//	$pin_width = ($this->opt('pins_width')) ? $this->opt('pins_width') : 255;
	//	$gutter_width = ($this->opt('pins_gutterwidth')) ? $this->opt('pins_gutterwidth') : 15;
		$loading = ( $this->opt('pins_loading') ) ? $this->opt('pins_loading') : 'ajax';

		$current_url = $this->pl_current_url();

		$image_size = ( $this->opt( 'pins_thumbsize', $this->oset ) ) ? $this->opt( 'pins_thumbsize', $this->oset ) : 'medium';

		$page = (isset($_GET['pins']) && $_GET['pins'] != 1) ? $_GET['pins'] : 1;
		
		$out = '';
			// 	
			// if( (is_category() || is_archive() || is_search() || is_author() ) && empty( $category ) && $post_type == 'post')
			// 	$pins = $wp_query->posts;
			// else 
			// 	
			
			$pins = $this->load_posts($page, $category, $post_type, $number_of_pins);

		

		if( !empty( $pins) ){
		
			foreach( $pins as $key => $p ){
				$post = $p;
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
					'<div class="span3 isotope-item"><div class="span-wrap postpin-wrap" ><article class="postpin">%s%s</article></div></div>',
				
					$image,
					$content
				);
			}
			
			
		} else {
			echo pl_posts_404();
		}

		
		$u = add_query_arg('pins', $page + 1, pl_current_url());
		
		// just to see if we should show link
		$next_posts = $this->load_posts( $page + 1, $category, $post_type, $number_of_pins);
			
		
		

		if( !empty($next_posts) ){

			$class = ( $this->opt('pins_loading', $this->oset) == 'infinite' ) ? 'iscroll' : 'fetchpins';

			$display = ($class == 'iscroll') ? 'style="display: none"' : '';

			$next_url = sprintf('<div class="%s fetchlink" %s><a class="" href="%s">%s</a></div>', $class, $display, $u, __('Load More Posts', 'pagelines'));

		} else
			$next_url = '';
		
		
		
		
		printf(	
			'<div class="pinboard fix" data-id="%s"> 
				<div class="postpin-list row row-set with-gutter fix"  data-loading="%s" data-url="%s">%s</div> 
				%s 
				<div class="clear"></div>
			</div>', 
			$this->meta['clone'],
			$loading,
			$this->base_url,
			$out, 
			$next_url
		);
	}

	function load_posts( $page = 1, $category = null, $post_type = null, $number = null){
		
		$query = array();
		
		$query['paged'] = $page;

		if( isset($category) && !empty($category) )
			$query['category_name'] = $category;
			
		if( isset($post_type) && !empty($post_type) )
			$query['post_type'] = $post_type;

		// Search page
		if( isset( $_GET['s'] ) && $_GET['s'] != '' )
			$query['s'] = $_GET['s'];
		
		if( isset($number) )
			$query['posts_per_page'] = $number;
		

		$q = new WP_Query($query);

	
		return $q->posts;
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