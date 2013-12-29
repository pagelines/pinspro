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
			
		

		);

		return $opts;

	}

	/**
	* Section template.
	*/
   function section_template( $location = false ) {


	?>
	<div class="navboard-container fix">
		
		<div class="navboard-left">
			<?php pagelines_search_form( true, 'navboard-searchform'); ?>
			
		</div>
		
		<div class="navboard-right">
			<div class="menu-toggle btn mm-toggle">
				<i class="icon-reorder"></i>
			</div>
		</div>
		<div class="navboard-center">
			<a href="<?php echo home_url();?>"><img src="<?php echo PL_THEME_URL.'/logo.png'?>" /></a>
		</div>
	</div>
<?php }

}
