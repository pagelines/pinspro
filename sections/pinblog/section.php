<?php
/*
	Section: PinBlog
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A pinterest style blog.
	Class Name: PinBlog
	Filter: format
*/


class PinBlog extends PageLinesSection {

	
	function before_section_template( $location = '' ) {

		global $wp_query;

		if(isset($wp_query) && is_object($wp_query))
			$this->wrapper_classes[] = ( $wp_query->post_count > 1 ) ? 'multi-post' : 'single-post';

	}

	/**
	* Section template.
	*/
   function section_template() {
	
		if( have_posts() )
			while ( have_posts() ) : the_post();  $this->get_article(); endwhile;
		else
			$this->posts_404();
	
	}
	
	function get_article(){
		$format = get_post_format();
		$linkbox = ($format == 'quote' || $format == 'link') ? true : false;
		
		$gallery_format = get_post_meta( get_the_ID(), '_pagelines_gallery_slider', true);

		$class[ ] = ( ! empty( $gallery_format ) ) ? 'use-flex-gallery' : '';
		
		$classes = apply_filters( 'pagelines_get_article_post_classes', join( " ", $class) );
		
		?>
		<div class="row fix">
			<div class="span9">
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
					<?php  if( is_single() ): ?>
						<div class="the-nav fix">
							<span class="previous"><?php previous_post_link('%link', '<i class="icon icon-angle-left"></i> %title') ?></span>
							<span class="next"><?php next_post_link('%link', '%title <i class="icon icon-angle-right"></i>') ?></span>
						</div>
					<?php endif; ?>
					<?php
						$media = pagelines_media( array( 'thumb-size' => 'aspect-thumb' ) ); 
						
						if( ! empty( $media ) )
							printf( '<div class="metamedia">%s</div>', $media );
					
					?>
				
					<?php if( ! $linkbox || is_single() ): ?>
					<div class="the-text">
						<?php if( ! $linkbox  ): ?>
							<h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
						<?php endif; ?>
							<div class="content">
								<?php 
									if( ! is_single() ) 
										echo get_the_excerpt();
									else{
										the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'pagelines' ) );

										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'pagelines' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									}
										
								?>
								
							</div>
					</div>
					<?php endif; ?>
					<div class="the-footer fix">
						<?php  if( ! is_single() ): ?>
							<a href="<?php the_permalink(); ?>">Read More <i class="icon icon-angle-right"></i></a>
						<?php else: ?>
							<?php previous_post_link('%link', 'Next article: %title') ?>
						<?php endif; ?>
						<?php echo do_shortcode('[post_edit before="" after=""]');?>
						<div class="social-shares">
							<?php echo do_shortcode('[like_button] [pinterest] [twitter_button]');?>
						</div>
					</div>
				</article>
			</div>
			<div class="span3">
				<div class="meta">
					<div class="the-text">
						<div class="media fix">
							<div class="avatar img">
								<?php echo get_avatar( get_the_author_meta('email'), 50 ); ?>
							</div>
							<div class="bd">
								<div class="author-name"><?php echo get_the_author(); ?></div>
								<div class="post-date"><?php echo do_shortcode( '[post_date]' ); ?></div>
							</div>
						</div>
						
					</div>
					<div class="the-footer">
						<?php if( comments_open( get_the_ID() ) ): ?>
						<a href="<?php the_permalink(); ?>#comments">
							<i class="icon icon-comments"></i> <?php comments_number( '0', '1', '%s' ); ?>
						</a>
						<?php endif; ?>
						<?php echo do_shortcode( '[pl_karma]' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
	
	function posts_404(){
		echo '404';
	}
	
}