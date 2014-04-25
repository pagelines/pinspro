<?php
/*
	Section: NavBoard
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A stylized navigation bar with multiple modes and styles. 
	Class Name: PLNavBoard
	Filter: nav, full-width
*/


class PLNavBoard extends PageLinesSection {

	function section_opts(){

		$opts = array(
			array(
				'type'	=> 'multi',
				'key'	=> 'navboard_config', 
				'title'	=> 'Navboard Format',
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'select',
						'key'	=> 'navboard_format', 
						'label'	=> 'Navboard Format',
						'opts'	=> array(
							'search_logo_nav'	=> array('name' => 'SEARCH left, LOGO center, NAV right'),
							'nav_logo_search'	=> array('name' => 'NAV left, LOGO center, SEARCH right'),
							'logo_nav'			=> array('name' => 'LOGO left, NAV right'),
							'nav_logo_nav'		=> array('name' => 'NAV left, LOGO center, NAV2 right'),
						), 
					),
					array(
						'key'	=> 'navboard_search', 
						'type'	=> 'check',
						'label'	=> 'Hide Search?',
					)
				)
				
			),
			array(
				'type'	=> 'multi',
				'key'	=> 'navboard_content', 
				'title'	=> 'Navboard Content',
				'col'	=> 2,
				'opts'	=> array(
					array(
						'type'	=> 'image_upload',
						'key'	=> 'navboard_logo', 
						'label'	=> 'Navboard Logo',
					),
					array(
						'key'	=> 'navboard_menu', 
						'type'	=> 'select_menu',
						'label'	=> 'Select Menu',
					),
					array(
						'key'	=> 'navboard_menu_2', 
						'type'	=> 'select_menu',
						'label'	=> 'Select Menu (Two Nav Mode Only!)',
					),
				)
				
			)
			

		);

		return $opts;

	}

	/**
	* Section template.
	*/
   function section_template( $location = false ) {

		$format = ( $this->opt('navboard_format') ) ? $this->opt('navboard_format') : 'search_logo_nav'; 
		$logo = ( $this->opt('navboard_logo') ) ? $this->opt('navboard_logo') : PL_THEME_URL.'/logo.png'; 
		
		$menu = ( $this->opt('navboard_menu') ) ? $this->opt('navboard_menu') : false;
		
		
		$hide_search = ( $this->opt('navboard_search') ) ? 'hide-search' : false; 

		$logo_markup = sprintf('<div class="navboard-container"><a href="%s"><img src="%s" alt="%s" /></a></div>', home_url(), $logo, get_bloginfo('name') ); 

		$search = sprintf('<div class="navboard-container">%s</div>', pagelines_search_form( false, 'navboard-searchform') ); 
		
		
		$menu_args = array(
			'theme_location' => 'navboard_nav',
			'menu' => $menu,
			'menu_class'	=> 'inline-list pl-nav sf-menu',
		);
		$nav = pl_navigation( $menu_args );
		
		
	
		
		if( $format == 'nav_logo_search' ){
			$left = $nav;
			$right = $search;
			$center = $logo_markup;
		} else if( $format == 'logo_nav' ){
			$left = $logo_markup;
			$right = $nav;
			$center = '';
		} else if( $format == 'nav_logo_nav' ){
			
			$menu_2 = ( $this->opt('navboard_menu_2') ) ? $this->opt('navboard_menu_2') : false;
			
			if( $menu_2 ){
				
				
				$menu_args = array(
					'theme_location' => 'navboard_nav_2',
					'menu' => $menu,
					'menu_class'	=> 'inline-list pl-nav sf-menu',
				);

				$nav2 = pl_navigation( $menu_args );
			} else 
				$nav2 = '';
			
			$left = $nav;
			$right = $nav2;
			$center = $logo_markup;
		} else {
			$left = $search;
			$right = $nav;
			$center = $logo_markup; 
		}
			
		
	?>
	<div class="navboard-wrap <?php echo $hide_search; ?> fix">
		<div class="navboard-center">
			<?php echo $center; ?>
		</div>
		<div class="navboard-right">
			<?php echo $right; ?>
		</div>
		<div class="navboard-left ">
			<?php echo $left; ?>
		</div>
	
	</div>
<?php }

}
