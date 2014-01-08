<?php
/*
	Section: NavBoard
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A stylized navigation bar with multiple modes and styles. 
	Class Name: PLNavBoard
	Filter: nav, dual-width
*/


class PLNavBoard extends PageLinesSection {

	function section_opts(){

		$opts = array(
			array(
				'type'	=> 'multi',
				'key'	=> 'navboard_format', 
				'title'	=> 'Navboard Format and Formatting',
				'opts'	=> array(
					array(
						'type'	=> 'select',
						'key'	=> 'navboard_format', 
						'label'	=> 'Select Format',
						'opts'	=> array(
							'center_logo'	=> array( 'name' => 'Logo Center, Pop out menu' ),
							'left_logo'		=> array( 'name' => 'Logo Left, standard menu' ),
						), 

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
						'label'	=> 'Select Format',
						'opts'	=> array(
							'center_logo'	=> 'Center: Logo | Right: Pop Menu | Left: Site Search',
							'left_logo'		=> 'Left: Logo | Right: Standard Menu',
						), 
					),
					array(
						'key'	=> 'navboard_menu', 
						'type'	=> 'select_menu',
						'key'	=> 'navboard_menu', 
						'label'	=> 'Select Menu',
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
		$format = ( $this->opt('navboard_format') ) ? $this->opt('navboard_format') : false; 

	?>
	<div class="navboard-wrap fix">
		
		<div class="navboard-left navboard-container">
			<?php pagelines_search_form( true, 'navboard-searchform'); ?>
		</div>
		
		<div class="navboard-right">
			<?php echo pl_navigation( $menu ); ?>
			
		</div>
		<div class="navboard-center navboard-container">
			<a href="<?php echo home_url();?>"><img src="<?php echo $logo; ?>" /></a>
		</div>
	</div>
<?php }

}
