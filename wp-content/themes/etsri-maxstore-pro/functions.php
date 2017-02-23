<?php
/**
 * Function describe for Alpha Store PRO child
 *
 * @package alpha-store-pro-child
 */

add_action( 'wp_enqueue_scripts', 'alpha_store_child_enqueue_styles', 999 );
function alpha_store_child_enqueue_styles() {
 $parent_style = 'alpha-store-parent-style';

 wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
 wp_enqueue_style( 'alpha-store-child-style',
 get_stylesheet_directory_uri() . '/style.css',
 array( $parent_style )
 );
}


add_action( 'woocommerce_account_dashboard', 'testfx', 999 );
function testfx() {
 echo '';	
}

?>