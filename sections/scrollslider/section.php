<?php
/*
	Section: Scroll Slider
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Stylized image slider. Control direction, transition. 
	Class Name: PLScrollSlider
	Filter: full-width
	
*/


class PLScrollSlider extends PageLinesSection {

	function section_styles(){
		
	
		wp_enqueue_script('scrollstop', $this->base_url.'/jquery.scrollstop.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('scrollsnap', $this->base_url.'/jquery.scrollsnap.js', array( 'jquery' ), PL_CORE_VERSION, true);
		wp_enqueue_script('pl-scrollslider', $this->base_url.'/pl.scrollslider.js', array( 'jquery' ), PL_CORE_VERSION, true);
		
	}
	
	function section_opts(){
		
		$options = array();

		$options[] = array(

			'title' => __( 'Slider Configuration', 'pagelines' ),
			'key'	=> 'sfs_config',
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'sfs_transition',
					'type' 			=> 'text_small',
					'default'		=> '500',
					'label' 	=> __( 'Transition Time in Milliseconds', 'pagelines' ),
				),
				array(
					'key'			=> 'sfs_timer',
					'type' 			=> 'check',
					'default'		=> '1',
					'label' 	=> __( 'Disable Auto Slide Transition', 'pagelines' ),
				),
				array(
					'key'			=> 'sfs_duration',
					'type' 			=> 'text_small',
					'default'		=> '8000',
					'label' 	=> __( 'Slide Time in Milliseconds (Timer Required)', 'pagelines' ),
				),
			)

		);

		$options[] = array(
			'key'		=> 'sfs_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('Slider Setup', 'pagelines'), 
			'post_type'	=> __('Slide', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'bg',
					'label'		=> __( 'Background Image', 'pagelines' ),
					'type'		=> 'image_upload',
					'sizelimit'	=> 2097152,
				),
				array(
					'key'		=> 'title',
					'label'		=> __( 'Title', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'sub',
					'label'	=> __( 'Sub Text', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'key'		=> 'link',
					'label'		=> __( 'Button Link (Required for Button)', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'btn_text',
					'label'		=> __( 'Button Text (Optional)', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'overlay',
					'label'		=> __( 'Add Overlay (Optional)', 'pagelines' ),
					'type'		=> 'check'
				),
				array(
					'key'		=> 'class',
					'label'		=> __( 'Slide Class (Optional)', 'pagelines' ),
					'type'		=> 'text'
				),
				
				

			)
	    );

		return $options;
		
	}
	
	
   function section_template() {
	
		$slide_array = $this->opt('sfs_array');
		
		$slides = '';
	
		if( ! is_array($slide_array) ){
			
			$slide_array = array(
				array(
					'bg'	=> $this->base_url . '/image-3.jpg',
					'title'	=> 'New York City, New York',
					'sub'	=> 'The Big Apple',
					'link'		=> 'http://en.wikipedia.org/wiki/New_York_City',
					'btn_text'	=> 'Read More'
				),
				array(
					'bg'		=> $this->base_url . '/image-1.jpg',
					'title'		=> 'San Francisco, California',
					'sub'		=> 'The beautiful city by the bay',
					'link'		=> 'http://en.wikipedia.org/wiki/California_Street_(San_Francisco)',
					'btn_text'	=> 'Read More'
				),
				array(
					'bg'	=> $this->base_url . '/image-2.jpg',
					'title'	=> 'Paris, France',
					'sub'	=> 'The city of love and lights.',
					'link'		=> 'http://en.wikipedia.org/wiki/Paris',
					'btn_text'	=> 'Read More'
				),
				
			);
			
		}
		
		
		$count = 1;
		foreach( $slide_array as $slide ){

			$the_bg = pl_array_get( 'bg', $slide ); 
			
			if( $the_bg ){
				
				$the_sub = pl_array_get( 'sub', $slide ); 
				$the_title = pl_array_get( 'title', $slide ); 
				$the_link = pl_array_get( 'link', $slide );
				$btn_text = pl_array_get( 'btn_text', $slide );
				$the_class = pl_array_get( 'class', $slide );

				$the_class .= ( pl_array_get( 'overlay', $slide ) && pl_array_get( 'overlay', $slide ) != 0 ) ? ' slide-overlay' : '';

				
				$the_button = ($the_link) ? sprintf('<a href="%s" class="btn btn-large btn-flat">%s</a>', $the_link, $btn_text) : '';

				$the_text = sprintf('<div class="the-text"><h2 class="header">%s</h2><div class="sub">%s</div></div>', $the_title, $the_sub);

				$content = sprintf('<div class="the-content">%s %s</div>', $the_text, $the_button);

				$slides .= sprintf(
					'<div class="slide %s" id="slide-%s" style="background-image: url(%s)">%s</div>', 
					$the_class, 
					$count, 
					$the_bg, 
					$content
				);
			}
		
			
			$count++;
		}
	
		
		$duration = ( $this->opt('sfs_duration') ) ? $this->opt('sfs_duration') : '10000';
		$transition = ( $this->opt('sfs_transition') ) ? $this->opt('sfs_transition') : '600';
		$sfs_timer = ( $this->opt('sfs_timer') ) ? $this->opt('sfs_timer') : '1';
	
	?>
	<div class="the-scrollslider"  >
		<div class="scrollslider-holder" data-transition="<?php echo $transition;?>" data-duration="<?php echo $duration;?>" data-timer="<?php echo $sfs_timer;?>">
			<div class="scrollslider-slider fix">
				<?php echo $slides; ?>
			</div>
		</div>
		
	</div>
	<?php
	}
	
	
	
}