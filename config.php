<?php


class PageLinesInstallTheme extends PageLinesInstall{


	/*
	 * This sets up the default configuration for differing page types
	 * This filter will be used when no 'map' is set on a specific page. 
	 */ 
	function default_template_handling( $t ){
	

		// 404 Page
		if( is_404() ){

				$content = array(
					array(
						'object'	=> 'PageLinesNoPosts',
						'span' 		=> 10,
						'offset'	=> 1
					)
				);

		} 

		// Overall Default 
		else {
			$content = array(
				array(
					'object'	=> 'PageLinesPostLoop',
	
				)
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
			'bodybg'						=> '#e3e6e2',
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
	 * 
	 */ 
	function map_templates_to_pages( ){
		
		$map = array(
			//'is_404'	=> 'pp-archive',
			'tag'		=> 'pp-archive',
			'search'	=> 'pp-archive',
			'category'	=> 'pp-archive',
			'author'	=> 'pp-archive',
			'archive'	=> 'pp-archive',
			'blog'		=> 'pp-blog',
			'post'		=> 'pp-post',
		);
		
		return $map;
		
		
	}
	
	
	/* 
	 * This adds or updates templates defined by a map on theme activation
	 * Note that the user is redirected to 'welcome' template on activation by default (unless otherwise specified)
	 */
	function page_templates(){
		
		$templates = array(
			'welcome' 		=> $this->template_welcome(),
			'pp-pins' 		=> $this->template_pins(),
			'pp-blog' 		=> $this->template_blog(),
			'pp-post' 		=> $this->template_post(),
			'pp-archive'	=> $this->template_archive()
		);
				
		return $templates;
		
	}
	
	// Template Map
	function template_archive(){
		
		$template['key'] = 'pp-archive';
		
		$template['name'] = 'PinsPro | Archive Page';
		
		$template['desc'] = 'Template for archives and other listings.';
		
		$template['map'] = array(
			array(
				'object'	=> 'PLPageHeader',
				'settings'	=> array(),

			),
			array(
				'object'	=> 'PLSectionArea',

				'content'	=> array(
					array(
						'object'	=> 'PLPostPins',
					),
				)
			),
		); 
		
		return $template;
	}
	
	// Template Map
	function template_blog(){
		
		$template['key'] = 'pp-blog';
		
		$template['name'] = 'PinsPro | Blog Page';
		
		$template['desc'] = 'Used on blog pages.';
		
		$template['map'] = array(
			array(
				'object'	=> 'PLPageHeader',
				'settings'	=> array(),

			),
			array(
				'object'	=> 'PLSectionArea',

				'content'	=> array(
					array(
						'object'	=> 'PinBlog',
					),
					array(
						'object'	=> 'PageLinesPagination',
					),
				)
			),
		); 
		
		return $template;
	}
	
	// Template Map
	function template_post(){
		
		$template['key'] = 'pp-post';
		
		$template['name'] = 'PinsPro | Single Post';
		
		$template['desc'] = 'Used on single post pages.';
		
		$template['map'] = array(
			array(
				'object'	=> 'PLSectionArea',

				'content'	=> array(
					array(
						'object'	=> 'PinBlog',
					),
					array(
						'object'	=> 'PageLinesComments',
						'span'		=> 8,
					),
				)
			),
		); 
		
		return $template;
	}
	
	// Template Map
	function template_pins(){
		
		$template['key'] = 'pp-pins';
		
		$template['name'] = 'PinsPro | Pins List';
		
		$template['desc'] = 'A page with pins style posts and scrollable feature slider.';
		
		$template['map'] = array(
			
			array(
				'object'	=> 'PLScrollSlider',
				'settings'	=> array(),
				
			),
			array(
				'object'	=> 'PLPostPins',
				'settings'	=> array(),
				
			),
		); 
		
		return $template;
	}
	
	// Template Map
	function template_welcome(){
		
		$template['key'] = 'welcome';
		
		$template['name'] = 'PinsPro | Welcome';
		
		$template['desc'] = 'Getting started guide &amp; template.';
		
		$template['map'] = array(
			
			array(
				'object'	=> 'PLSectionArea',
				'settings'	=> array(
					'pl_area_theme' 		=> 'pl-dark-img',
					'pl_area_background'		=> '[pl_theme_url]/images/stock-1.jpg',
					'pl_area_pad'		=> '80px',
					'pl_area_parallax'	=> 'pl-parallax'
				),
				
				'content'	=> array(
					array(
						'object'	=> 'PLMasthead',
						'settings'	=> array(
							'pagelines_masthead_title'		=> 'Welcome to PinsPro',
							'pagelines_masthead_tagline'	=> 'A tidy pin-board style theme for the PageLines DMS framework. 
It\'s responsive too so it looks great everywhere.',
							'pagelines_masthead_img'		=> '[pl_parent_url]/images/getting-started-pl-logo.png',
							'masthead_button_link_1'		=> home_url(),
							'masthead_button_text_1'		=> 'View Your Blog <i class="icon icon-angle-right"></i>',
							'masthead_button_theme_1'		=> 'btn-flat',
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
									'title'	=> 'User Guide',
									'text'	=> 'New to PageLines? Get started fast with PageLines DMS Quick Start guide...',
									'icon'	=> 'rocket',
									'link'	=> 'http://www.pagelines.com/user-guide/'
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
