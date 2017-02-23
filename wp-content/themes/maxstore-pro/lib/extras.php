<?php
/**
 *
 * Extra functions
 *
 */
add_filter( 'woocommerce_product_tabs', 'maxstore_pro_woo_extra_tabs' );

function maxstore_pro_woo_extra_tabs( $tabs ) {
	global $post;
	$custom_tabs = get_post_meta( get_the_ID(), 'maxstore_custom_tabs', true );
	$i			 = 0;
	if ( !empty( $custom_tabs ) ) {
		foreach ( $custom_tabs as $tab ) {
			if ( isset( $tab[ 'maxstore_title' ])) {
				$priority = $tab[ 'maxstore_priority' ];
				if ( $priority == '' ) {
					$priority = ( 21 + $i );
				};
				$tabs[ 'custom_tab_' . $i ] = array(
					'title'		 => esc_attr( $tab[ 'maxstore_title' ] ),
					'priority'	 => absint( $priority ),
					'callback'	 => 'maxstore_pro_add_custom_panel_content',
					'custom_tab' => $tab[ 'maxstore_desc' ]
				);
				$i++;
			}
		}
	}
	return $tabs;
}

function maxstore_pro_add_custom_panel_content( $key, $tab ) {
	echo apply_filters( 'the_content', $tab[ 'custom_tab' ] );
}

function maxstore_pro_custom_box_field() {
	$entries = get_post_meta( get_the_ID(), 'maxstore_custom_boxes', true );
	if ( !empty( $entries ) ) {
		foreach ( (array) $entries as $key => $entry ) {
			if ( isset( $entry[ 'maxstore_boxes_title' ] ) && !empty( $entry[ 'maxstore_boxes_title' ] ) && isset( $entry[ 'maxstore_boxes_desc' ] ) && !empty( $entry[ 'maxstore_boxes_desc' ] ) ) {
				?>    
			<div class="custom-box" data-toggle="popover" title='<?php echo esc_attr( $entry[ 'maxstore_boxes_title' ] ) ?>' data-content='<?php echo wp_kses_post( $entry[ 'maxstore_boxes_desc' ] ) ?>'>                              
					<?php if ( isset( $entry[ 'maxstore_boxes_icon' ] ) && !empty( $entry[ 'maxstore_boxes_icon' ] ) ) { ?>
						<i class="fa <?php echo esc_attr( $entry[ 'maxstore_boxes_icon' ] ) ?>"></i>
					<?php } ?>
					<?php echo esc_attr( $entry[ 'maxstore_boxes_title' ] ) ?>                           
				</div>
				<?php
			}
		}
	}
}

add_action( 'woocommerce_after_add_to_cart_button', 'maxstore_pro_custom_box_field', 9 );

////////////////////////////////////////////////////////////////////
// Google Analytics Tracking Code
////////////////////////////////////////////////////////////////////
if ( !function_exists( 'maxstore_pro_google' ) ) {

	function maxstore_pro_google() {

		if ( get_theme_mod( 'google-analytics', '' ) == '' ) {
			return false;
		}

		echo stripslashes( get_theme_mod( 'google-analytics' ) );
	}

}

add_action( 'wp_footer', 'maxstore_pro_google' );

////////////////////////////////////////////////////////////////////
// Custom CSS
////////////////////////////////////////////////////////////////////
if ( !function_exists( 'maxstore_pro_custom_css' ) ) {

	function maxstore_pro_custom_css() {

		$maxstore_pro_custom_css = get_theme_mod( 'custom-css', '' );
		if ( !empty( $maxstore_pro_custom_css ) ) {
			echo '<!-- ' . get_bloginfo( 'name' ) . ' Custom Styles -->';
			?><style type="text/css"><?php echo $maxstore_pro_custom_css; ?></style><?php
		}
	}

}
add_action( 'wp_head', 'maxstore_pro_custom_css' );

////////////////////////////////////////////////////////////////////
// Offer price
////////////////////////////////////////////////////////////////////
if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'woo_sale_deal', 1 ) == 1 ) {
	add_filter( 'woocommerce_get_price_html', 'maxstore_pro_custom_price_html', 100, 2 );

	function maxstore_pro_custom_price_html( $price, $product ) {
		global $post;
		$sales_price_to		 = get_post_meta( $post->ID, '_sale_price_dates_to', true );
		$sales_price_from	 = get_post_meta( $post->ID, '_sale_price_dates_from', true );
		$todaysDate			 = strtotime( date( 'Y-m-d' ) );
		if ( is_single() && $sales_price_to != "" && $sales_price_from <= $todaysDate ) {
			$sales_price_date_to = date( "j M y", $sales_price_to );
			$sale_offer			 = '<br/ >' . esc_html__( 'Offer till ', 'maxstore' ) . $sales_price_date_to;
			return $price . $sale_offer;
		} else {
			return apply_filters( 'woocommerce_get_price', $price );
		}
	}

	add_filter( 'woocommerce_after_shop_loop_item', 'maxstore_pro_custom_price_archive', 20 );

	function maxstore_pro_custom_price_archive() {
		global $post;
		$sales_price_to		 = get_post_meta( $post->ID, '_sale_price_dates_to', true );
		$sales_price_from	 = get_post_meta( $post->ID, '_sale_price_dates_from', true );
		$todaysDate			 = strtotime( date( 'Y-m-d' ) );
		if ( $sales_price_to != "" && $sales_price_from <= $todaysDate ) {
			$sales_price_date_to = date( 'M j Y', $sales_price_to );
			$counter			 = '<div class="twp-countdown" countdown data-date="' . $sales_price_date_to . '">';
			$counter .= '<span data-days>0</span>' . esc_html__( 'days', 'maxstore' ) . '';
			$counter .= '<span data-hours>0</span>' . esc_html__( 'hours', 'maxstore' ) . '';
			$counter .= '<span data-minutes>0</span>' . esc_html__( 'minutes', 'maxstore' ) . '';
			$counter .= '<span data-seconds>0</span>' . esc_html__( 'seconds', 'maxstore' ) . '';
			$counter .= '</div>';
			echo $counter;
		}
	}

}

////////////////////////////////////////////////////////////////////
// Shortcodes empty paragraph fix
////////////////////////////////////////////////////////////////////
function maxstore_pro_shortcode_empty_paragraph_fix( $content ) {
	$array = array(
		'<p>['		 => '[',
		']</p>'		 => ']',
		']<br />'	 => ']'
	);

	$content = strtr( $content, $array );
	return $content;
}

add_filter( 'the_content', 'maxstore_pro_shortcode_empty_paragraph_fix' );

////////////////////////////////////////////////////////////////////
// Demo import
////////////////////////////////////////////////////////////////////
if ( class_exists( 'WooCommerce' ) ) {
	function maxstore_pro_import_files() {
	  return array(
		array(
		  'import_file_name'           => 'MaxStore PRO',
		  'import_file_url'            => 'http://preview.themes4wp.com/demos/maxstore-pro/maxstore-pro-content.xml',
		  'import_widget_file_url'     => 'http://preview.themes4wp.com/demos/maxstore-pro/maxstore-pro-widgets.wie',
		  'import_customizer_file_url' => 'http://preview.themes4wp.com/demos/maxstore-pro/maxstore-pro-customizer.dat',
		  'import_preview_image_url'   => 'http://preview.themes4wp.com/demos/maxstore-pro/maxstore-pro-image.jpg',
		  'import_notice'              => __( 'The plugins settings (Mega Menu, Contact Form,...) are not included in this import.', 'maxstore' ),
		),
	  );
	}
	add_filter( 'pt-ocdi/import_files', 'maxstore_pro_import_files' );

	function maxstore_pro_after_import_setup() {
		// Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
		$footer = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
				'main_menu' => $main_menu->term_id,
				'footer_menu' => $footer->term_id,
			)
		);

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Homepage' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );

	}
	add_action( 'pt-ocdi/after_import', 'maxstore_pro_after_import_setup' );
}
