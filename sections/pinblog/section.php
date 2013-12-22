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
		
		?>
		<div class="row fix">
			<div class="span9">
				
				<article class="article <?php echo join(' ', get_post_class()); ?>">
					<?php  if( is_single() ): ?>
						<div class="the-nav fix">
							<span class="previous"><?php previous_post_link('%link', '<i class="icon-angle-left"></i> %title') ?></span>
							<span class="next"><?php next_post_link('%link', '%title <i class="icon-angle-right"></i>') ?></span>
						</div>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'aspect-thumb' ); ?></a>
					<div class="the-text">
						<h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
						<div class="content">
							<?php 
								if( is_single() )
									echo the_content(); 
								else 
									echo get_the_excerpt(); 
								?>
						</div>
					</div>
					<div class="the-footer fix">
						<?php  if( ! is_single() ): ?>
							<a href="<?php the_permalink(); ?>">Read More <i class="icon-angle-right"></i></a>
						<?php else: ?>
							<?php previous_post_link('%link', 'Next article: %title') ?>
						<?php endif; ?>
						
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
						<a href=""><i class="icon-comments"></i> 10</a>
						<?php echo pl_love(); ?>
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