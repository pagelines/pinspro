<?php


class PageLinesInstallTheme extends PageLinesInstall{

	

	/*
	 * This sets up the default configuration for differing page types
	 * This filter will be used when no 'map' is set on a specific page. 
	 */ 
	function default_template_handling( $t ){
	
		$sidebar = array(
			'object'	=> 'PLColumn',
			'span' 	=> 4,
			'content'	=> array(
				array(
					'object'	=> 'PLRapidTabs'
				),
				array(
					'object'	=> 'PrimarySidebar'
				),
			)
		);

		// 404 Page
		if( is_404() ){

				$content = array( 'object' => 'PageLinesNoPosts' );

		} 

		// Standard WP page default
		elseif( is_page() ){

			$content = array(
				array(
					'object'	=> 'PageLinesPostLoop',
					'span' 		=> 10,
					'offset'	=> 1
				)
			);

		} 

		// Post Page 
		elseif( is_single() ) {

			$content = array(
						array(
							'object'	=> 'PLColumn',
							'span' 		=> 8,
							'content'	=> array(
								array(
									'object'	=> 'PageLinesPostLoop'
								),
								array(
									'object'	=> 'PageLinesComments'
								)
							)
						),

						$sidebar 
					);

		} 


		// Overall Default 
		else {
			$content = array( 
						array(
							'object'	=> 'PLColumn',
							'span' 	=> 8,
							'content'	=> array(
								array(
									'object'	=> 'PageLinesPostLoop'
								),
							)
						),
						$sidebar
					);
		}


		$t = array( 'content' => $content );
	
		return $t;
		
	}
	
	
	
	/* 
	 * This sets the global areas of the site's sections on theme activation. 
	 */ 
	function global_region_map(){
		
		$map = array(
			'header'	=> array(), 
			'footer'	=> array(
				array(
					'object' => 'PinDivider'	
				),
				array(
					'content'	=> array(
						array( 'object'	=> 'PinFooter' ),
						array( 'object'	=> 'PLWatermark' )
					)
				)
			),
			'fixed'	=> array(
				array( 'object'	=> 'PLNavBoard' )
			)
		);
		
		return $map;
		
	}

	/* 
	 * This sets the global option values on theme activation. 
	 */
	function set_global_options(){
		
		$options_array = array(
			'page_background_image_url' 	=> '[pl_theme_url]/images/bg-repeat.png',
			'page_background_image_repeat'	=> 'repeat',
			'supersize_bg'					=> 0,
			'content_width_px'				=> '1100px',
			'linkcolor'						=> '#D30000',
			'text_primary'					=> '#000000',
			'bodybg'						=> '#E3E3E3',
			'layout_mode'					=> 'pixel',
			'layout_display_mode'			=> 'display-full',
			'font_primary'					=> 'helvetica',
			'base_font_size'				=> 14,
			'font_primary_weight'			=> 300,
			'font_headers'					=> 'helvetica',
			'header_base_size'				=> 16,
			'font_headers_weight'			=> 600,
		);
		
		return $options_array;
		
	}
	
	
	/* 
	 * Sets the info for the draft page that is created on install. This is the page users are redirected to after activation.
	 */
	function activation_page_data(){
		$data = array(
			'post_title'	=> 'PinsPro Getting Started',
			'post_name'		=> 'pinspro-getting-started',
			'template'		=> 'welcome',
		);
		
		return $data;
	}
	
	/*
	 * 
	 */ 
	function map_templates_to_pages( ){
		
		$map = array(
			'404_page'	=> 'Pins Blog',
			'tag'		=> 'Pins Blog',
			'search'	=> 'Pins Blog',
			'category'	=> 'Pins Blog',
			'author'	=> 'Pins Blog',
			'archive'	=> 'Pins Blog',
			'blog'		=> 'Pins Blog',
			'page'		=> 'Pins Blog',
			'post'		=> 'Pins Blog',
		);
		
		return $map;
		
		
	}
	
	
	/* 
	 * This adds or updates templates defined by a map on theme activation
	 * Note that the user is redirected to 'welcome' template on activation by default (unless otherwise specified)
	 */
	function page_templates(){
		
		$templates = array(
			'welcome' 	=> $this->template_welcome(),
			'pins' 		=> $this->template_pins(),
			'blog' 		=> $this->template_pins()
		);
				
		return $templates;
		
	}
	
	// Template Map
	function template_pins(){
		
		$template['name'] = 'Pins Page';
		
		$template['desc'] = 'A page with pins style posts and scrollable feature slider.';
		
		$template['map'] = array(
			
			array(
				'object'	=> 'PLSectionArea',
				'settings'	=> array(
					'pl_area_bg' 		=> 'pl-dark-img',
					'pl_area_image'		=> '[pl_theme_url]/images/sunrise.jpg',
					'pl_area_pad'		=> '80px',
					'pl_area_parallax'	=> 1
				),
				
				'content'	=> array(
					array(
						'object'	=> 'PLMasthead',
						'settings'	=> array(
							'pagelines_masthead_title'		=> 'Congratulations!',
							'pagelines_masthead_tagline'	=> 'You are up and running with PageLines PinsPro.',
							'pagelines_masthead_img'		=> '[pl_parent_url]/images/getting-started-pl-logo.png',
							'masthead_button_link_1'		=> home_url(),
							'masthead_button_text_1'		=> 'View Your Blog <i class="icon-angle-right"></i>',
						)
					),
				)
			),
			array(
				'content'	=> array(
					array(
						'object'	=> 'pliBox',
						'settings'	=> array(
							'ibox_array'	=> array(
								array(
									'title'	=> 'Quick Start',
									'text'	=> 'New to PageLines? Get started fast with PageLines DMS Quick Start guide...',
									'icon'	=> 'rocket',
									'link'	=> 'http://www.pagelines.com/quickstart/'
								),
								array(
									'title'	=> 'Forum',
									'text'	=> 'Have questions? We are happy to help, just search or post on PageLines Forum.',
									'icon'	=> 'comment',
									'link'	=> 'http://forum.pagelines.com/'
								),
								array(
									'title'	=> 'Docs',
									'text'	=> 'Time to dig in. Check out the Docs for specifics on creating your dream website.',
									'icon'	=> 'file-text',
									'link'	=> 'http://docs.pagelines.com/'
								),
							)
						)
					),
				)
			)
		); 
		
		return $template;
	}
	
	// Template Map
	function template_welcome(){
		
		$template['name'] = 'Welcome';
		
		$template['desc'] = 'Getting started guide &amp; template.';
		
		$template['map'] = array(
			
			array(
				'object'	=> 'PLSectionArea',
				'settings'	=> array(
					'pl_area_bg' 		=> 'pl-dark-img',
					'pl_area_image'		=> '[pl_parent_url]/images/getting-started-mast-bg.jpg',
					'pl_area_pad'		=> '80px',
					'pl_area_parallax'	=> 1
				),
				
				'content'	=> array(
					array(
						'object'	=> 'PLMasthead',
						'settings'	=> array(
							'pagelines_masthead_title'		=> 'Congratulations!',
							'pagelines_masthead_tagline'	=> 'You are up and running with PageLines DMS.',
							'pagelines_masthead_img'		=> '[pl_parent_url]/images/getting-started-pl-logo.png',
							'masthead_button_link_1'		=> home_url(),
							'masthead_button_text_1'		=> 'View Your Blog <i class="icon-angle-right"></i>',
						)
					),
				)
			),
			array(
				'content'	=> array(
					array(
						'object'	=> 'pliBox',
						'settings'	=> array(
							'ibox_array'	=> array(
								array(
									'title'	=> 'Quick Start',
									'text'	=> 'New to PageLines? Get started fast with PageLines DMS Quick Start guide...',
									'icon'	=> 'rocket',
									'link'	=> 'http://www.pagelines.com/quickstart/'
								),
								array(
									'title'	=> 'Forum',
									'text'	=> 'Have questions? We are happy to help, just search or post on PageLines Forum.',
									'icon'	=> 'comment',
									'link'	=> 'http://forum.pagelines.com/'
								),
								array(
									'title'	=> 'Docs',
									'text'	=> 'Time to dig in. Check out the Docs for specifics on creating your dream website.',
									'icon'	=> 'file-text',
									'link'	=> 'http://docs.pagelines.com/'
								),
							)
						)
					),
				)
			)
		); 
		
		return $template;
	}

}
