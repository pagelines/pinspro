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
					'label'		=> __( 'Background Image (Required)', 'pagelines' ),
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
					'key'			=> 'link',
					'type' 			=> 'button_link',
					'label' 		=> __( 'Button Link 1', 'pagelines' ),
				),
				array(
					'key'			=> 'link2',
					'type' 			=> 'button_link',
					'label' 		=> __( 'Button Link 2', 'pagelines' ),
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
	
	function slides_output( $array ){
		$out = '';
		
		$count = 1;
		
		if( is_array( $array ) ){
			foreach( $array as $slide ){

				$the_bg = pl_array_get( 'bg', $slide ); 

				if( $the_bg ){

					$the_sub = pl_array_get( 'sub', $slide ); 
					$the_title = pl_array_get( 'title', $slide ); 
					$the_class = pl_array_get( 'class', $slide );

					$the_class .= ( pl_array_get( 'overlay', $slide ) && pl_array_get( 'overlay', $slide ) != 0 ) ? ' slide-overlay' : '';

					$the_text = sprintf('<div class="the-text"><h2 class="header">%s</h2><div class="sub">%s</div></div>', $the_title, $the_sub);

					$link = pl_array_get( 'link', $slide ); 
					$link_text = pl_array_get( 'link_text', $slide, __('More', 'pagelines') ); 
					$link_style = pl_array_get( 'link_style', $slide, 'btn-ol-white' ); 

					$link_2 = pl_array_get( 'link_2', $slide ); 
					$link_2_text = pl_array_get( 'link_2_text', $slide, __('Check it out', 'pagelines') ); 
					$link_2_style = pl_array_get( 'link_2_style', $slide, 'btn-info' );

					$link = ( $link ) ? sprintf('<a href="%s" class="btn btn-large slider-btn %s">%s</a>', $link, $link_style, $link_text) : false;
					$link_2 = ( $link_2 ) ? sprintf('<a href="%s" class="btn btn-large slider-btn %s">%s</a>', $link_2, $link_2_style, $link_2_text) : false;

					$buttons = ($link || $link_2) ? sprintf( '<div class="slider-buttons">%s %s</div>', $link, $link_2 ) : '';

					$content = sprintf('<div class="the-content">%s %s</div>', $the_text, $buttons);

					$out .= sprintf(
						'<div class="slide %s" id="slide-%s" style="background-image: url(%s)">%s</div>', 
						$the_class, 
						$count, 
						$the_bg, 
						$content
					);
				}


				$count++;
			}
		}
		
	
		return $out;
	}
	
   function section_template() {
	
		$slide_array = $this->opt('sfs_array');
		
		$slides = $this->slides_output( $slide_array );
	
		if( $slides == '' ){
			
			$slide_array = array(
				array(
					'bg'	=> $this->base_url . '/image-1.jpg',
					'title'	=> 'ScrollSlider',
					'sub'	=> 'Congrats! You have successfully installed this slider. Now just set it up.',
					'link'		=> 'http://www.pagelines.com/',
					'btn_text'	=> 'Visit PageLines.com'
				),
				
			);
			
			$slides = $this->slides_output( $slide_array );
			
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