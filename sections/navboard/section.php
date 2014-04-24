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
				'key'	=> 'navboard_content', 
				'title'	=> 'Navboard Content',
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'image_upload',
						'key'	=> 'navboard_logo', 
						'label'	=> 'Navboard Logo',
						'opts'	=> array(
							'center_logo'	=> 'Center: Logo | Right: Pop Menu | Left: Site Search',
							'left_logo'		=> 'Left: Logo | Right: Standard Menu',
						), 
					),
					array(
						'key'	=> 'navboard_menu', 
						'type'	=> 'select_menu',
						'label'	=> 'Select Menu',
					),
					array(
						'key'	=> 'navboard_search', 
						'type'	=> 'check',
						'label'	=> 'Hide Search?',
					)
				)
				
			)
			

		);

		return $opts;

	}

	/**
	* Section template.
	*/
   function section_template( $location = false ) {


		$logo = ( $this->opt('navboard_logo') ) ? $this->opt('navboard_logo') : PL_THEME_URL.'/logo.png'; 
		$menu = ( $this->opt('navboard_menu') ) ? $this->opt('navboard_menu') : false;
		$hide_search = ( $this->opt('navboard_search') ) ? 'hide-search' : false; 

	?>
	<div class="navboard-wrap <?php echo $hide_search; ?> fix">
		<div class="navboard-center navboard-container">
			<a href="<?php echo home_url();?>"><img src="<?php echo $logo; ?>" /></a>
		</div>
		<div class="navboard-right">
			<?php 

					$menu_args = array(
						'theme_location' => 'navboard_nav',
						'menu' => $menu,
						'menu_class'	=> 'inline-list pl-nav sf-menu',
					);
					echo pl_navigation( $menu_args );
 			?>
			
			
		</div>
		<div class="navboard-left navboard-container">
			<?php pagelines_search_form( true, 'navboard-searchform'); ?>
		</div>
	
	</div>
<?php }

}
