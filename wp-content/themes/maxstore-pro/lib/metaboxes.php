<?php

/**
 *
 * Metaboxes
 *
 */
if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) && strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== FALSE ) {

	require_once( trailingslashit( get_template_directory() ) . 'lib/cmb2-fontawesome-picker.php' ); // enable font awesome icons select

	add_action( 'cmb2_init', 'maxstore_pro_homepage_template_metaboxes' );

	function maxstore_pro_homepage_template_metaboxes() {

		if ( class_exists( 'WooCommerce' ) ) {
			$prefix = 'maxstore';


			$cmb			 = new_cmb2_box( array(
				'id'			 => 'homepage_metabox',
				'title'			 => __( 'Homepage Options', 'maxstore' ),
				'object_types'	 => array( 'page', ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home.php', 'template-home-sidebar.php' ) ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb->add_field( array(
				'name'		 => __( 'Top section', 'maxstore' ),
				'desc'		 => __( 'Enable or disable top section', 'maxstore' ),
				'id'		 => $prefix . '_first_image_on',
				'default'	 => 'off',
				'type'		 => 'radio_inline',
				'options'	 => array(
					'on'	 => __( 'On', 'maxstore' ),
					'off'	 => __( 'Off', 'maxstore' ),
				),
			) );
			$cmb->add_field( array(
				'name'	 => __( 'Upload first image', 'maxstore' ),
				'desc'	 => __( 'Upload first image. 600x600px', 'maxstore' ),
				'id'	 => $prefix . '_first_image',
				'type'	 => 'file',
			) );
			$cmb->add_field( array(
				'name'	 => __( 'Title', 'maxstore' ),
				'desc'	 => __( 'Title', 'maxstore' ),
				'id'	 => $prefix . '_first_img_title',
				'type'	 => 'text',
			) );
			$cmb->add_field( array(
				'name'	 => __( 'Description', 'maxstore' ),
				'desc'	 => __( 'Description', 'maxstore' ),
				'id'	 => $prefix . '_first_img_desc',
				'type'	 => 'text',
			) );
			$cmb->add_field( array(
				'name'	 => __( 'Button text', 'maxstore' ),
				'id'	 => $prefix . '_first_img_button',
				'type'	 => 'text',
			) );
			$cmb->add_field( array(
				'name'		 => __( 'Button URL', 'maxstore' ),
				'id'		 => $prefix . '_first_img_button_url',
				'type'		 => 'text_url',
				'protocols'	 => array( 'http', 'https', 'mailto' ), // Array of allowed protocols
			) );
			$cmb->add_field( array(
				'name'				 => __( 'Secondary category', 'maxstore' ),
				'desc'				 => __( 'Select an option', 'maxstore' ),
				'id'				 => $prefix . '_second_cat',
				'type'				 => 'select',
				'show_option_none'	 => true,
				'default'			 => '',
				'options'			 => maxstore_pro_get_cats(),
			) );
			/**
			 * Carousel
			 */
			$cmb_carousel	 = new_cmb2_box( array(
				'id'			 => 'homepage_metabox_carousel',
				'title'			 => __( 'Homepage Options', 'maxstore' ),
				'object_types'	 => array( 'page' ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home-carousel.php' ) ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb_carousel->add_field( array(
				'name'				 => __( 'Carousel category', 'maxstore' ),
				'desc'				 => __( 'Select an option', 'maxstore' ),
				'id'				 => $prefix . '_carousel_cat',
				'type'				 => 'select',
				'show_option_none'	 => true,
				'default'			 => '',
				'options'			 => maxstore_pro_get_cats(),
			) );
			/**
			 * Category
			 */
			$cmb_category	 = new_cmb2_box( array(
				'id'			 => 'homepage_metabox_category',
				'title'			 => __( 'Homepage Options', 'maxstore' ),
				'object_types'	 => array( 'page' ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home-category.php' ) ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb_category->add_field( array(
				'name'				 => __( 'Category', 'maxstore' ),
				'desc'				 => __( 'Select category', 'maxstore' ),
				'id'				 => $prefix . '_category_cat',
				'type'				 => 'select',
				'show_option_none'	 => true,
				'default'			 => '',
				'options'			 => maxstore_pro_get_cats(),
			) );
			/**
			 * Masonry
			 */
			$cmb_masonry	 = new_cmb2_box( array(
				'id'			 => 'homepage_metabox_masonry',
				'title'			 => __( 'Homepage Options', 'maxstore' ),
				'object_types'	 => array( 'page' ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home-masonry.php' ) ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb_masonry->add_field( array(
				'name'		 => __( 'Category', 'maxstore' ),
				'desc'		 => __( 'Select 6 categories', 'maxstore' ),
				'id'		 => $prefix . '_masonry_cat',
				'type'		 => 'multicheck_inline',
				'options'	 => maxstore_pro_get_cats(),
			) );
			/**
			 * Slider
			 */
			$cmb_slider		 = new_cmb2_box( array(
				'id'			 => 'homepage_metabox_slider',
				'title'			 => __( 'Homepage Options', 'maxstore' ),
				'object_types'	 => array( 'page' ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home-slider.php' ) ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb_slider->add_field( array(
				'name'		 => __( 'Slider position', 'maxstore' ),
				'desc'		 => __( 'Enable or disable slider and select the sidebar position (only if selected).', 'maxstore' ),
				'id'		 => $prefix . '_slider_on',
				'default'	 => 'off',
				'type'		 => 'radio_inline',
				'options'	 => array(
					'off'			 => __( 'Off', 'maxstore' ),
					'with-sidebar'	 => __( 'Slider with sidebar', 'maxstore' ),
					'fullwidth'		 => __( 'Fullwidth', 'maxstore' ),
				),
			) );
			$group_field_id	 = $cmb_slider->add_field( array(
				'id'			 => $prefix . '_home_slider',
				'type'			 => 'group',
				'description'	 => __( 'Generate slider', 'maxstore' ),
				'options'		 => array(
					'group_title'	 => __( 'Slide {#}', 'maxstore' ), // {#} gets replaced by row number
					'add_button'	 => __( 'Add another slide', 'maxstore' ),
					'remove_button'	 => __( 'Remove slide', 'maxstore' ),
					'sortable'		 => true,
				),
			) );
			$cmb_slider->add_group_field( $group_field_id, array(
				'name'			 => __( 'Image', 'maxstore' ),
				'id'			 => $prefix . '_image',
				'description'	 => __( 'Ideal image size: 1140x488px', 'maxstore' ),
				'type'			 => 'file',
				'preview_size'	 => array( 100, 100 ), // Default: array( 50, 50 )
			) );
			$cmb_slider->add_group_field( $group_field_id, array(
				'name'	 => __( 'Slider Title', 'maxstore' ),
				'id'	 => $prefix . '_title',
				'type'	 => 'text',
			) );
			$cmb_slider->add_group_field( $group_field_id, array(
				'name'	 => __( 'Slider Description', 'maxstore' ),
				'id'	 => $prefix . '_desc',
				'type'	 => 'textarea_code',
			) );
			$cmb_slider->add_group_field( $group_field_id, array(
				'name'	 => __( 'Button Text', 'maxstore' ),
				'id'	 => $prefix . '_button_text',
				'type'	 => 'text',
			) );
			$cmb_slider->add_group_field( $group_field_id, array(
				'name'	 => __( 'Button URL', 'maxstore' ),
				'id'	 => $prefix . '_url',
				'type'	 => 'text_url',
			) );

			/**
			 * Repeatable Field Groups for custom tabs
			 */
			$cmb_group		 = new_cmb2_box( array(
				'id'			 => $prefix . '_tabs',
				'title'			 => __( 'Tabs', 'maxstore' ),
				'object_types'	 => array( 'product', ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true,
				'closed'		 => true,
			) );
			$group_field_id	 = $cmb_group->add_field( array(
				'id'		 => $prefix . '_custom_tabs',
				'type'		 => 'group',
				'options'	 => array(
					'group_title'	 => __( 'Tab {#}', 'maxstore' ), // {#} gets replaced by row number
					'add_button'	 => __( 'Add Another Tab', 'maxstore' ),
					'remove_button'	 => __( 'Remove Tab', 'maxstore' ),
					'sortable'		 => true,
				),
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'	 => __( 'Tab Title', 'maxstore' ),
				'id'	 => $prefix . '_title',
				'type'	 => 'text',
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'	 => __( 'Tab Content', 'maxstore' ),
				'id'	 => $prefix . '_desc',
				'type'	 => 'textarea',
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'		 => __( 'Tab Priority', 'maxstore' ),
				'desc'		 => __( 'Define tab priority (0 = highest priority)', 'maxstore' ),
				'id'		 => $prefix . '_priority',
				'default'	 => 21,
				'type'		 => 'text_small',
				'attributes' => array(
					'type'		 => 'number',
					'required'	 => 'required',
				),
			) );

			/**
			 * Repeatable Field Groups for custom boxes
			 */
			$cmb_group		 = new_cmb2_box( array(
				'id'			 => $prefix . '_boxes',
				'title'			 => __( 'Help boxes', 'maxstore' ),
				'object_types'	 => array( 'product', ),
				'context'		 => 'normal',
				'priority'		 => 'high',
				'show_names'	 => true,
				'closed'		 => true,
			) );
			$group_field_id	 = $cmb_group->add_field( array(
				'id'		 => $prefix . '_custom_boxes',
				'type'		 => 'group',
				'options'	 => array(
					'group_title'	 => __( 'Box {#}', 'maxstore' ), // {#} gets replaced by row number
					'add_button'	 => __( 'Add Another Box', 'maxstore' ),
					'remove_button'	 => __( 'Remove box', 'maxstore' ),
					'sortable'		 => true,
				),
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'	 => __( 'Box Icon', 'maxstore' ),
				'id'	 => $prefix . '_boxes_icon',
				'type'	 => 'fontawesome_icon',
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'	 => __( 'Box Title', 'maxstore' ),
				'id'	 => $prefix . '_boxes_title',
				'type'	 => 'text',
			) );
			$cmb_group->add_group_field( $group_field_id, array(
				'name'	 => __( 'Box Content', 'maxstore' ),
				'id'	 => $prefix . '_boxes_desc',
				'type'	 => 'textarea',
			) );
		}
	}

	add_action( 'cmb2_init', 'maxstore_pro_homepage_sidebar_template_metaboxes' );

	function maxstore_pro_homepage_sidebar_template_metaboxes() {

		if ( class_exists( 'WooCommerce' ) ) {
			$prefix = 'maxstore';


			$cmb = new_cmb2_box( array(
				'id'			 => 'homepage_metabox_sidebar',
				'title'			 => __( 'Sidebars', 'maxstore' ),
				'object_types'	 => array( 'page', ), // Post type 
				'show_on'		 => array( 'key' => 'page-template', 'value' => array( 'template-home-carousel.php', 'template-home-sidebar.php', 'template-home-slider.php', 'template-home-category.php', 'template-home-masonry.php', 'template-home-search-image.php' ) ),
				'context'		 => 'side',
				'priority'		 => 'high',
				'show_names'	 => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
			) );
			$cmb->add_field( array(
				'name'		 => __( 'Sidebar position', 'maxstore' ),
				'id'		 => $prefix . '_sidebar_position',
				'default'	 => 'left',
				'type'		 => 'select',
				'options'	 => array(
					'left'	 => __( 'Left', 'maxstore' ),
					'right'	 => __( 'Right', 'maxstore' ),
					'none'	 => __( 'None', 'maxstore' ),
				),
			) );
		}
	}

	function maxstore_pro_get_cats() {
		/* GET LIST OF CATEGORIES */
		$args		 = array(
			'taxonomy'	 => 'product_cat',
			'orderby'	 => 'name',
			'show_count' => 1,
		);
		$layercats	 = get_categories( $args );
		$newList	 = array();
		foreach ( $layercats as $category ) {
			$newList[ $category->term_id ] = $category->cat_name;
		}
		return $newList;
	}

}