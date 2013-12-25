<?php
/*
	Section: PinFooter
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: PinsPro stylized footer area. Columnized with navigation.
	Class Name: PinFooter
	
*/


class PinFooter extends PageLinesSection {

	

	/**
	* Section template.
	*/
   function section_template() {
	?>
	
	<div class="pinfooter-container row">
		<div class="span4">
			
			<div class="logo">
				<a href="<?php echo home_url();?>"><img src="<?php echo PL_THEME_URL.'/logo.png'?>" /></a>
			</div>
			<div class="tagline-text">
				<p>Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetuer adipiscing.</p>
			</div>
			<div class="copyright-text">
				<p>&copy; Your Company 2020</p>
			</div>
		</div>
		<div class="span2 offset2">
			<?php echo pl_media_list('Pages', pl_list_pages()); ?>
			
		</div>
		<div class="span2">
			<?php echo pl_media_list('Categories', pl_popular_taxonomy()); ?>
			
		</div>
		<div class="span2">
			<?php echo pl_media_list('Tags', pl_popular_taxonomy( 6, 'post_tag')); ?>
			
		</div>
	</div>
	
	
	<?php
	}
	
	
	
}