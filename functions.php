<?php
/*
 *	Tell DMS we are in a subfolder and start it
 */
define( 'DMS_CORE', true );
require_once( 'dms/functions.php' );

/**
 * Fix uploader issues with DMS2 and WP 4.3 jQuery temporary patch
 */
if( ! function_exists( 'fix_jquery_for_dms_theme' ) ) {
	add_action( 'wp_enqueue_scripts', 'fix_jquery_for_dms_theme' );
	function fix_jquery_for_dms_theme() {
		if( ! is_admin() && function_exists( 'pl_draft_mode' ) && pl_draft_mode() ){
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"), false, '1.11.2');
			wp_enqueue_script('jquery');
		}
	}
}
