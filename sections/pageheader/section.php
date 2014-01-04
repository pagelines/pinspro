<?php
/*
	Section: PageHeader
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Adds an editable header to the page. If unset on archive pages, will show appropriate description for the page. 
	Class Name: PLPageHeader
	Filter: component, full-width
*/


class PLPageHeader extends PageLinesSection {



	function section_opts(){
		$opts = array(
			
			array(
				'type' 			=> 'multi',
				'col'			=> 1,
				'title' 		=> __( 'PageHeader Text', 'pagelines' ),
				'opts'	=> array(
					array(
						'key'			=> 'pl_pageheader_head',
						'type' 			=> 'text',
						'label' 		=> __( 'Header Text (Optional)', 'pagelines' ),
					),
					array(
						'key'			=> 'pl_pageheader_subhead',
						'type' 			=> 'text',
						'label' 		=> __( 'Sub Head Text (Optional)', 'pagelines' ),
					)

				), 
				'help'	=> 'Optionally adjust the text for the header. On archive pages this will default to showing information about the archive.'
			),
		

		);

		return $opts;

	}
	
	function section_template() {

		$head = $this->opt('pl_pageheader_head', $this->tset);
		$subhead = $this->opt('pl_pageheader_subhead', $this->tset);

		if( ! $head && ! $subhead ){
			$head = $this->get_header();
			$subhead = $this->get_subhead();
		}
		
		if( ! $head && ! $subhead )
			$head = 'Hello.';

		?>
		<div class="page-header-wrap">
			<?php
			if( $head )
				printf('<h2 class="page-header-head" data-sync="pl_pageheader_head">%s</h2>', $head );

			if( $subhead )
				printf('<div class="page-header-subhead" data-sync="pl_pageheader_subhead">%s</div>', $subhead );
			?>
		</div>
	<?php

	}
	
	function get_subhead(){
		
		if( is_home() ){
			
			return __('The latest news, thoughts, and insights.', 'pagelines');
			
		} elseif( is_category() ){
			
			return sprintf( '%s "%s"', __( 'Currently viewing the category:', 'pagelines' ), single_cat_title( false, false ) );
		
		} elseif( is_search() ){
			
			return '';
			
		} elseif( is_tag() ){
			
			return sprintf( '%s "%s"', __( 'Currently viewing the tag:', 'pagelines' ), single_tag_title( false, false ) );
		
		} elseif( is_archive() ){
			
			if (is_author()) {
				global $author;
				global $author_name;
				$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
				$out = sprintf( '%s <strong>"%s"</strong>', __( 'Posts by:', 'pagelines' ), $curauth->display_name );
			} elseif ( is_day() ) {
				$out = sprintf( '%s <strong>"%s"</strong>', __( 'From the daily archives:', 'pagelines' ), get_the_time('l, F j, Y') );
			} elseif ( is_month() ) {
				$out = sprintf( '%s <strong>"%s"</strong>', __( 'From the monthly archives:', 'pagelines' ), get_the_time('F Y') );
			} elseif ( is_year() ) {
				$out = sprintf( '%s <strong>"%s"</strong>', __( 'From the yearly archives:', 'pagelines' ), get_the_time('Y') );
			} else {
				
				if ( is_post_type_archive() )
					$title =  post_type_archive_title( null,false );
					
				if ( ! isset( $title ) ) {
					$o = get_queried_object();
					if ( isset( $o->name ) )
						$title = $o->name;
				}
				
				if ( ! isset( $title ) )
					$title = the_date();
					
				$out = sprintf( '%s <strong>"%s"</strong>', __( 'Viewing archives for ', 'pagelines'), $title );
			}
			
			return $out;
			
		} else
			return false;
	}
	
	function get_header(){
		
		
		if( is_home() )
		 	return __('Blog', 'pagelines');
		
		elseif( is_category() )
		 	return __('Category', 'pagelines');
		
		elseif( is_search() )
		 	return sprintf( '%s "%s"', __( 'Search results for', 'pagelines' ), get_search_query() );
		
		elseif( is_tag() )
		 	return __('Tag', 'pagelines');
		
		elseif( is_author() )
		 	return __('Author', 'pagelines');
		
		elseif( is_archive() )
		 	return __('Archive', 'pagelines');
		
		else
			return false;

	}

}
