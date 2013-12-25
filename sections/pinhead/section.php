<?php
/*
	Section: PinHead
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: PinsPro stylized feature header. Variable height, drag and drop area.
	Class Name: PLPinHead
	Filter: full-width
	
*/


class PLPinHead extends PageLinesSection {

	function section_styles(){
		
	
		wp_enqueue_script('scrollstop', $this->base_url.'/jquery.scrollstop.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('scrollsnap', $this->base_url.'/jquery.scrollsnap.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('pl-pinhead', $this->base_url.'/pl.pinhead.js', array( 'jquery' ), PL_CORE_VERSION, true);
		
	}
   function section_template() {
	?>
	<div class="the-pinhead">
		<div class="pinhead-loader"></div>
		<div class="pinhead-holder">
		  <div class="pinhead-slider fix">
		    <div class="slide" id="slide-1">
				<div class="the-content">
					<div class="the-text">
						<h2 class="header">This is a header1</h2>
						<div class="sub">this is a sub</div>
					</div>
					<a href="#" class="btn btn-large btn-flat">Go With It!</a>
				</div>
			</div>
		    <div class="slide" id="slide-2">
				<div class="the-content">
					<div class="the-text">
						<h2 class="header">This is a header2</h2>
						<div class="sub">this is a sub</div>
					</div>
					<a href="#" class="btn btn-large btn-flat">Go With It!</a>
				</div>
			</div>
		    <div class="slide" id="slide-3">
				<div class="the-content">
					<div class="the-text">
						<h2 class="header">This is a header3</h2>
						<div class="sub">this is a sub</div>
					</div>
					<a href="#" class="btn btn-large btn-flat">Go With It!</a>
				</div>
			</div>
			<div class="slide" id="slide-4">
				
				<video id="bg-video" autoplay loop class="the-background">
					<source src="http://getflywheel.com/wp-content/themes/flywheel2013/videos/agency.mp4 ">
					<source src="http://getflywheel.com/wp-content/themes/flywheel2013/videos/agency.ogg">
					<source src="http://getflywheel.com/wp-content/themes/flywheel2013/videos/agency.webm">
				</video>
				<div class="the-content">
					<div class="the-text">
						<h2 class="header">This is a header3</h2>
						<div class="sub">this is a sub</div>
					</div>
					<a href="#" class="btn btn-large btn-flat">Go With It!</a>
				</div>
			</div>
		
		  </div>
		
		</div>
		<div class="pinhead-nav">
			<a class="current"><i class="icon-circle"></i></a>
			<a><i class="icon-circle"></i></a>
			<a><i class="icon-circle"></i></a>
			<a><i class="icon-circle"></i></a>
		</div>
	</div>
	<?php
	}
	
	
	
}