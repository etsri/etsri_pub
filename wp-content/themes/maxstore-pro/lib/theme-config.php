<?php

/**
 * Kirki Advanced Customizer
 *
 * @package maxstore
 */
// Early exit if Kirki is not installed
if ( !class_exists( 'Kirki' ) ) {
	return;
}
/* Register Kirki config */
Kirki::add_config( 'maxstore_pro_settings', array(
	'capability'	 => 'edit_theme_options',
	'option_type'	 => 'theme_mod',
) );

load_theme_textdomain( 'maxstore', get_template_directory() . '/languages' );

/**
 * Add sections
 */
if ( class_exists( 'WooCommerce' ) && get_option( 'show_on_front' ) != 'page' && !is_child_theme() ) {
	Kirki::add_section( 'maxstore_woo_demo_section', array(
		'title'		 => __( 'WooCommerce Homepage Demo', 'maxstore' ),
		'priority'	 => 10,
	) );
}
Kirki::add_section( 'sidebar_section', array(
	'title'			 => __( 'Sidebars', 'maxstore' ),
	'priority'		 => 10,
	'description'	 => __( 'Sidebar layouts.', 'maxstore' ),
) );

Kirki::add_section( 'layout_section', array(
	'title'			 => __( 'Main styling', 'maxstore' ),
	'priority'		 => 10,
	'description'	 => __( 'Define theme layout', 'maxstore' ),
) );

Kirki::add_section( 'top_bar_section', array(
	'title'			 => __( 'Top Bar', 'maxstore' ),
	'priority'		 => 10,
	'description'	 => __( 'Top bar text', 'maxstore' ),
) );

Kirki::add_section( 'search_bar_section', array(
	'title'			 => __( 'Search Bar & Social', 'maxstore' ),
	'priority'		 => 10,
	'description'	 => __( 'Search and social icons', 'maxstore' ),
) );

Kirki::add_section( 'site_bg_section', array(
	'title'		 => __( 'Site Background', 'maxstore' ),
	'priority'	 => 10,
) );

Kirki::add_section( 'colors_section', array(
	'title'		 => __( 'Colors & Typography', 'maxstore' ),
	'priority'	 => 10,
) );

if ( class_exists( 'WooCommerce' ) ) {
	Kirki::add_section( 'woo_section', array(
		'title'		 => __( 'WooCommerce', 'maxstore' ),
		'priority'	 => 10,
	) );
}
Kirki::add_section( 'services_section', array(
	'title'		 => __( 'Services', 'maxstore' ),
	'priority'	 => 10,
) );

Kirki::add_section( 'code_section', array(
	'title'		 => __( 'Custom Codes', 'maxstore' ),
	'priority'	 => 10,
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'demo_front_page',
	'label'			 => __( 'Enable Demo Homepage?', 'maxstore' ),
	'description'	 => sprintf( __( 'When the theme is first installed and WooCommerce plugin activated, the demo mode would be turned on. This will display some sample/example content to show you how the website can be possibly set up. When you are comfortable with the theme options, you should turn this off. You can create your own unique homepage - Check the %s page for more informations.', 'maxstore' ), '<a href="' . admin_url( 'themes.php?page=maxstore-welcome' ) . '"><strong>' . __( 'Theme info', 'maxstore' ) . '</strong></a>' ),
	'section'		 => 'maxstore_woo_demo_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'radio-buttonset',
	'settings'			 => 'front_page_demo_style',
	'label'				 => esc_html__( 'Homepage Demo Styles', 'maxstore' ),
	'description'		 => sprintf( __( 'The demo homepage is enabled. You can choose from some predefined layouts or make your own %s.', 'maxstore' ), '<a href="' . admin_url( 'themes.php?page=maxstore-welcome' ) . '"><strong>' . __( 'custom homepage template', 'maxstore' ) . '</strong></a>' ),
	'section'			 => 'maxstore_woo_demo_section',
	'default'			 => 'style-one',
	'priority'			 => 10,
	'choices'			 => array(
		'style-one'		 => __( 'Layout one', 'maxstore' ),
		'style-two'		 => __( 'Layout two', 'maxstore' ),
		'style-three'	 => __( 'Layout three', 'maxstore' ),
		'style-four'	 => __( 'Layout four', 'maxstore' ),
		'style-five'	 => __( 'Layout five', 'maxstore' ),
	),
	'active_callback'	 => array(
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'switch',
	'settings'			 => 'front_page_demo_banner',
	'label'				 => __( 'Homepage top section', 'maxstore' ),
	'description'		 => esc_html__( 'Enable or disable demo homepage top section with custom image and random category products.', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'default'			 => 1,
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'image',
	'settings'			 => 'front_page_demo_banner_img',
	'label'				 => __( 'Banner image', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'default'			 => get_template_directory_uri() . '/template-parts/demo-img/demo-image-top.jpg',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'front_page_demo_banner',
			'operator'	 => '==',
			'value'		 => 1,
		),
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'text',
	'settings'			 => 'front_page_demo_banner_title',
	'label'				 => __( 'Banner title', 'maxstore' ),
	'default'			 => __( 'MaxStore', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'front_page_demo_banner',
			'operator'	 => '==',
			'value'		 => 1,
		),
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'text',
	'settings'			 => 'front_page_demo_banner_desc',
	'label'				 => __( 'Banner description', 'maxstore' ),
	'default'			 => __( 'Edit this section in customizer', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'front_page_demo_banner',
			'operator'	 => '==',
			'value'		 => 1,
		),
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'text',
	'settings'			 => 'front_page_demo_banner_url',
	'label'				 => __( 'Banner url', 'maxstore' ),
	'default'			 => '#',
	'section'			 => 'maxstore_woo_demo_section',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'front_page_demo_banner',
			'operator'	 => '==',
			'value'		 => 1,
		),
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'select',
	'settings'			 => 'front_page_demo_sidebars',
	'label'				 => esc_html__( 'Homepage Demo Sidebar Position', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'default'			 => 'none',
	'priority'			 => 10,
	'choices'			 => array(
		'left'	 => __( 'Left', 'maxstore' ),
		'right'	 => __( 'Right', 'maxstore' ),
		'none'	 => __( 'None', 'maxstore' ),
	),
	'active_callback'	 => array(
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'custom',
	'settings'			 => 'demo_page_intro',
	'label'				 => __( 'Products', 'maxstore' ),
	'section'			 => 'maxstore_woo_demo_section',
	'description'		 => esc_html__( 'If you dont see any products or categories on your homepage, you dont have any products probably. Create some products and categories first.', 'maxstore' ),
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'demo_front_page',
			'operator'	 => '==',
			'value'		 => 1,
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'custom',
	'settings'		 => 'demo_dummy_content',
	'label'			 => __( 'Need Dummy Products?', 'maxstore' ),
	'section'		 => 'maxstore_woo_demo_section',
	'description'	 => sprintf( esc_html__( 'When the theme is first installed, you dont have any products probably. You can easily import dummy products with only few clicks. Check %s tutorial.', 'maxstore' ), '<a href="' . esc_url( 'https://docs.woocommerce.com/document/importing-woocommerce-dummy-data/' ) . '" target="_blank"><strong>' . __( 'THIS', 'maxstore' ) . '</strong></a>' ),
	'priority'		 => 10,
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'rigth-sidebar-check',
	'label'			 => __( 'Right Sidebar', 'maxstore' ),
	'description'	 => __( 'Enable the Right Sidebar', 'maxstore' ),
	'section'		 => 'sidebar_section',
	'default'		 => 1,
	'priority'		 => 10,
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'right-sidebar-size',
	'label'		 => __( 'Right Sidebar Size', 'maxstore' ),
	'section'	 => 'sidebar_section',
	'default'	 => '3',
	'priority'	 => 10,
	'choices'	 => array(
		'1'	 => '1',
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'left-sidebar-check',
	'label'			 => __( 'Left Sidebar', 'maxstore' ),
	'description'	 => __( 'Enable the Left Sidebar', 'maxstore' ),
	'section'		 => 'sidebar_section',
	'default'		 => 0,
	'priority'		 => 10,
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'left-sidebar-size',
	'label'		 => __( 'Left Sidebar Size', 'maxstore' ),
	'section'	 => 'sidebar_section',
	'default'	 => '3',
	'priority'	 => 10,
	'choices'	 => array(
		'1'	 => '1',
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'footer-sidebar-size',
	'label'		 => __( 'Footer Widget Area Columns', 'maxstore' ),
	'section'	 => 'sidebar_section',
	'default'	 => '3',
	'priority'	 => 10,
	'choices'	 => array(
		'12' => '1',
		'6'	 => '2',
		'4'	 => '3',
		'3'	 => '4',
	),
) );


Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'image',
	'settings'		 => 'header-logo',
	'label'			 => __( 'Logo', 'maxstore' ),
	'description'	 => __( 'Upload your logo', 'maxstore' ),
	'section'		 => 'layout_section',
	'default'		 => '',
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'spacing',
	'settings'	 => 'logo_spacing',
	'label'		 => __( 'Logo/Title Spacing', 'maxstore' ),
	'section'	 => 'layout_section',
	'default'	 => array(
		'top'	 => '0px',
		'right'	 => '15px',
		'bottom' => '0px',
		'left'	 => '15px',
	),
	'output'	 => array(
		array(
			'element'	 => '.rsrc-header',
			'property'	 => 'padding',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'radio-image',
	'settings'	 => 'header-style',
	'label'		 => __( 'Header Style', 'maxstore' ),
	'section'	 => 'layout_section',
	'default'	 => 'head',
	'priority'	 => 10,
	'choices'	 => array(
		'head'		 => get_template_directory_uri() . '/img/default-header.jpg',
		'head-alt'	 => get_template_directory_uri() . '/img/alternative-header.jpg',
		'head-alt-2' => get_template_directory_uri() . '/img/alternative-header-2.jpg',
		'head-alt-3' => get_template_directory_uri() . '/img/alternative-header-3.jpg',
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'code',
	'settings'			 => 'header-banner',
	'label'				 => __( 'Header Banner', 'maxstore' ),
	'help'				 => __( 'Add your HTML code with your banner.', 'maxstore' ),
	'section'			 => 'layout_section',
	'choices'			 => array(
		'label'		 => __( 'HTML code', 'maxstore' ),
		'language'	 => 'html',
		'theme'		 => 'monokai',
		'height'	 => 100,
	),
	'default'			 => '',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'header-style',
			'operator'	 => '==',
			'value'		 => 'head-alt',
		),
	)
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'menu-sticky',
	'label'			 => __( 'Sticky menu', 'maxstore' ),
	'description'	 => __( 'Enable or disable sticky menu', 'maxstore' ),
	'section'		 => 'layout_section',
	'default'		 => 0,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'menu-position',
	'label'			 => __( 'Menu alignment', 'maxstore' ),
	'description'	 => __( 'Define menu alignment', 'maxstore' ),
	'section'		 => 'layout_section',
	'default'		 => 'menu-left',
	'priority'		 => 10,
	'choices'		 => array(
		'menu-left'		 => __( 'Left', 'maxstore' ),
		'menu-center'	 => __( 'Center', 'maxstore' ),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'menu-style',
	'label'		 => __( 'Menu style', 'maxstore' ),
	'section'	 => 'layout_section',
	'default'	 => 'default',
	'priority'	 => 10,
	'choices'	 => array(
		'default'	 => __( 'Default', 'maxstore' ),
		'boxed'		 => __( 'Boxed', 'maxstore' ),
		'clean'		 => __( 'Clean', 'maxstore' ),
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'textarea',
	'settings'			 => 'footer-credits',
	'label'				 => __( 'Footer credits', 'maxstore' ),
	'help'				 => __( 'You can add custom text or HTML code.', 'maxstore' ),
	'section'			 => 'layout_section',
	'sanitize_callback'	 => 'wp_kses_post',
	'default'			 => '',
	'priority'			 => 10,
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'textarea',
	'settings'			 => 'infobox-text-left',
	'label'				 => __( 'Top bar left', 'maxstore' ),
	'description'		 => __( 'Top bar left text area', 'maxstore' ),
	'help'				 => __( 'You can add custom text. Only text allowed!', 'maxstore' ),
	'section'			 => 'top_bar_section',
	'sanitize_callback'	 => 'wp_kses_post',
	'default'			 => '',
	'priority'			 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'textarea',
	'settings'			 => 'infobox-text-right',
	'label'				 => __( 'Top bar right', 'maxstore' ),
	'description'		 => __( 'Top bar right text area', 'maxstore' ),
	'help'				 => __( 'You can add custom text. Only text allowed!', 'maxstore' ),
	'section'			 => 'top_bar_section',
	'sanitize_callback'	 => 'wp_kses_post',
	'default'			 => '',
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			array(
				'setting'	 => 'header-style',
				'operator'	 => '==',
				'value'		 => 'head',
			),
			array(
				'setting'	 => 'header-style',
				'operator'	 => '==',
				'value'		 => 'head-alt-3',
			),
		),
	)
) );


Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'search-bar-check',
	'label'			 => __( 'Search bar', 'maxstore' ),
	'description'	 => __( 'Enable search bar with social icons', 'maxstore' ),
	'section'		 => 'search_bar_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'select',
	'settings'		 => 'search-bar-cat-select',
	'label'			 => __( 'Shop by category', 'maxstore' ),
	'description'	 => __( 'Select categories for Shop by category section. Leave blank for all.', 'maxstore' ),
	'section'		 => 'search_bar_section',
	'default'		 => '',
	'choices'		 => maxstore_pro_category_select(),
	'multiple'		 => '99',
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'radio-buttonset',
	'settings'			 => 'searchbar-mobile',
	'label'				 => __( 'Search bar on mobile devices', 'maxstore' ),
	'description'		 => __( 'Enable or disable Search bar on mobile devices', 'maxstore' ),
	'section'			 => 'search_bar_section',
	'default'			 => 'hidden-xs',
	'priority'			 => 10,
	'choices'			 => array(
		'visible'	 => __( 'Visible', 'maxstore' ),
		'hidden-xs'	 => __( 'Hidden', 'maxstore' ),
	),
	'active_callback'	 => array(
		array(
			'setting'	 => 'search-bar-check',
			'operator'	 => '==',
			'value'		 => 1,
		),
	)
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'switch',
	'settings'			 => 'maxstore_socials',
	'label'				 => __( 'Social Icons', 'maxstore' ),
	'description'		 => __( 'Enable or Disable the social icons', 'maxstore' ),
	'section'			 => 'search_bar_section',
	'default'			 => 0,
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'search-bar-check',
			'operator'	 => '==',
			'value'		 => 1,
		),
	)
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'text',
	'settings'			 => 'maxstore_socials_text',
	'label'				 => __( 'Follow Us Text', 'maxstore' ),
	'description'		 => __( 'Insert your text before social icons.', 'maxstore' ),
	'help'				 => __( 'Leave blank to hide text. Use max 6 icons.', 'maxstore' ),
	'section'			 => 'search_bar_section',
	'default'			 => __( 'Follow Us', 'maxstore' ),
	'priority'			 => 10,
	'active_callback'	 => array(
		array(
			'setting'	 => 'maxstore_socials',
			'operator'	 => '==',
			'value'		 => 1,
		),
	)
) );
$s_social_links = array(
	'twp_social_facebook'	 => __( 'Facebook', 'maxstore' ),
	'twp_social_twitter'	 => __( 'Twitter', 'maxstore' ),
	'twp_social_google'		 => __( 'Google-Plus', 'maxstore' ),
	'twp_social_instagram'	 => __( 'Instagram', 'maxstore' ),
	'twp_social_pin'		 => __( 'Pinterest', 'maxstore' ),
	'twp_social_youtube'	 => __( 'YouTube', 'maxstore' ),
	'twp_social_reddit'		 => __( 'Reddit', 'maxstore' ),
	'twp_social_linkedin'	 => __( 'LinkedIn', 'maxstore' ),
	'twp_social_skype'		 => __( 'Skype', 'maxstore' ),
	'twp_social_vimeo'		 => __( 'Vimeo', 'maxstore' ),
	'twp_social_flickr'		 => __( 'Flickr', 'maxstore' ),
	'twp_social_dribble'	 => __( 'Dribbble', 'maxstore' ),
	'twp_social_envelope-o'	 => __( 'Email', 'maxstore' ),
	'twp_social_rss'		 => __( 'Rss', 'maxstore' ),
);

foreach ( $s_social_links as $keys => $values ) {
	Kirki::add_field( 'maxstore_pro_settings', array(
		'type'				 => 'text',
		'settings'			 => $keys,
		'label'				 => $values,
		'description'		 => sprintf( __( 'Insert your custom link to show the %s icon.', 'maxstore' ), $values ),
		'help'				 => __( 'Leave blank to hide icon.', 'maxstore' ),
		'section'			 => 'search_bar_section',
		'default'			 => '',
		'priority'			 => 10,
		'active_callback'	 => array(
			array(
				'setting'	 => 'search-bar-check',
				'operator'	 => '==',
				'value'		 => 1,
			),
		)
	) );
}

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'custom',
	'settings'	 => 'main_color_title',
	'label'		 => __( 'Main colors', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '<div style="border-bottom: 1px solid #fff;"></div>',
	'priority'	 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'main_site_color',
	'label'		 => __( 'Main color', 'maxstore' ),
	'help'		 => __( 'Main site color (links, buttons, carts...)', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#F4C700',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '.product-slider .star-rating span:before, a, .top-wishlist a, .btn-primary.outline, .pagination > li > a, .pagination > li > span, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus, .woocommerce .star-rating span, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .top-wishlist .fa',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.searchbar-template .header-search-form button, li.woocommerce-MyAccount-navigation-link.is-active, .top-category-products-line:nth-of-type(2n), .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled[disabled], .widget_wysija_cont .wysija-submit, .twp-countdown, .single-meta-date, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-product-search input[type="submit"], .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .top-area .onsale, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce ul.products li.product .button, .add-to-wishlist-custom:hover, .woocommerce ul.products li.product .onsale, .woocommerce span.onsale, .top-carousel-inner span.onsale, .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus, #back-top span, .navigation.pagination, .comment-reply-link, .comment-respond #submit, #searchform #searchsubmit, #yith-searchsubmit, #wp-calendar #prev a, #wp-calendar #next a',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '#home-carousel .top-grid-heading, blockquote, .btn-primary.outline, .comment-reply-link, .comment-respond #submit, #searchform #searchsubmit, #yith-searchsubmit, #wp-calendar #prev a, #wp-calendar #next a, .related-header',
			'property'	 => 'border-color',
		),
		array(
			'element'	 => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active',
			'property'	 => 'border-bottom-color',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'hover_site_color',
	'label'		 => __( 'Hover color', 'maxstore' ),
	'help'		 => __( 'Hover color for links, buttons, carts...', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#F48C00',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => 'a:hover',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.nav > li > a:hover, .nav > li > a:focus, .woocommerce a.added_to_cart:hover, .woocommerce-product-search input[type="submit"]:hover, #searchform #searchsubmit:hover, #yith-searchsubmit:hover, .topfirst-img:hover .btn-primary.outline, .btn-primary.outline:hover, .btn-primary.outline:focus, .btn-primary.outline:active, .btn-primary.outline.active, .open > .dropdown-toggle.btn-primary, #wp-calendar #prev a:hover, #wp-calendar #next a:hover, .comment-reply-link:hover, .comment-respond #submit:hover',
			'property'	 => 'background-color',
		),
		array(
			'element'	 => '#searchform #searchsubmit:hover, .topfirst-img:hover .btn-primary.outline, .btn-primary.outline:hover, .btn-primary.outline:focus, .btn-primary.outline:active, .btn-primary.outline.active, .open > .dropdown-toggle.btn-primary, #wp-calendar #prev a:hover, #wp-calendar #next a:hover, .comment-reply-link:hover, .comment-respond #submit:hover',
			'property'	 => 'border-color',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'body_color',
	'label'		 => __( 'Body color', 'maxstore' ),
	'help'		 => __( 'Background color for pages and posts.', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#fff',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '.rsrc-container, .rsrc-header, .panel, .site-header-cart, .navbar, .dropdown-menu',
			'property'	 => 'background-color',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'footer_color',
	'label'		 => __( 'Footer widgets color', 'maxstore' ),
	'help'		 => __( 'Background color for footer widgets.', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#F1F1F1',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '#content-footer-section',
			'property'	 => 'background-color',
		),
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'custom',
	'settings'	 => 'typo_title',
	'label'		 => __( 'Typography and font colors', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '<div style="border-bottom: 1px solid #fff;"></div>',
	'priority'	 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'color_site_title',
	'label'		 => __( 'Site title color', 'maxstore' ),
	'help'		 => __( 'Site title text color, if not defined logo.', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#222',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '.rsrc-header-text .site-title a',
			'property'	 => 'color',
			'units'		 => ' !important',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'typography',
	'settings'	 => 'site_title_typography_font',
	'label'		 => __( 'Site title font', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => array(
		'font-style'	 => array( 'bold', 'italic' ),
		'font-family'	 => 'Open Sans',
		'font-size'		 => '36px',
		'variant'		 => '400',
		'line-height'	 => '1.1',
		'letter-spacing' => '0',
	),
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element' => '.rsrc-header-text h1.site-title, .rsrc-header-text h2.site-title',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'color_site_desc',
	'label'		 => __( 'Site description color', 'maxstore' ),
	'help'		 => __( 'Site description text color, if not defined logo.', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#5D5D5D',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '.rsrc-header-text h3, .rsrc-header-text h2',
			'property'	 => 'color',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'typography',
	'settings'	 => 'description_typography_font',
	'label'		 => __( 'Site description font', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => array(
		'font-style'	 => array( 'bold', 'italic' ),
		'font-family'	 => 'Open Sans',
		'font-size'		 => '14px',
		'variant'		 => '400',
		'line-height'	 => '1.5',
		'letter-spacing' => '0',
	),
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element' => '.rsrc-header-text h3, .rsrc-header-text h2',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'color',
	'settings'	 => 'color_content_text',
	'label'		 => __( 'Text color', 'maxstore' ),
	'help'		 => __( 'Select the general text color used in the theme.', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => '#939393',
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element'	 => '.navbar-inverse .navbar-nav > li > a:after, .amount-cart, .top-infobox, .dropdown-menu > li > a, .widget-menu a, body, .btn-primary.outline, .single-article h2.page-header a, .home-header .page-header a, .page-header, .header-cart a, .header-login a, .entry-summary, .btn-primary.outline, .navbar-inverse .navbar-nav > li > a, .widget h3, .header-cart, .header-login, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .social-links i.fa, .woocommerce ul.products li.product h3, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price, legend',
			'property'	 => 'color',
		),
		array(
			'element'	 => '.social-links i.fa, .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a',
			'property'	 => 'border-color',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'typography',
	'settings'	 => 'content_typography_font',
	'label'		 => __( 'Site content font', 'maxstore' ),
	'section'	 => 'colors_section',
	'default'	 => array(
		'font-style'	 => array( 'bold', 'italic' ),
		'font-family'	 => 'Open Sans',
		'font-size'		 => '14px',
		'variant'		 => '300',
		'line-height'	 => '1.8',
		'letter-spacing' => '0',
	),
	'priority'	 => 10,
	'output'	 => array(
		array(
			'element' => 'body, .btn-primary.outline, .home-header .page-header a, .page-header, .header-cart a, .header-login a, .entry-summary, .btn-primary.outline, .navbar-inverse .navbar-nav > li > a, .widget h3, .header-cart, .header-login, .woocommerce div.product .woocommerce-tabs ul.tabs li a',
		),
	),
) );

if ( function_exists( 'YITH_WCWL' ) ) {
	Kirki::add_field( 'maxstore_pro_settings', array(
		'type'			 => 'toggle',
		'settings'		 => 'wishlist-top-icon',
		'label'			 => __( 'Header Wishlist icon', 'maxstore' ),
		'description'	 => __( 'Enable or disable heart icon with counter in header', 'maxstore' ),
		'section'		 => 'woo_section',
		'default'		 => 0,
		'priority'		 => 10,
	) );
}
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'cart-top-icon',
	'label'			 => __( 'Header Cart', 'maxstore' ),
	'description'	 => __( 'Enable or disable header cart', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'my-account-link',
	'label'			 => __( 'My Account/Login link', 'maxstore' ),
	'description'	 => __( 'Enable or disable header My Account/Login/Register link', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'woo-breadcrumbs',
	'label'			 => __( 'Breadcrumbs', 'maxstore' ),
	'description'	 => __( 'Enable or disable breadcrumbs on WooCommerce pages', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 0,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'buttons-styling',
	'label'			 => __( 'Buttons Styling', 'maxstore' ),
	'description'	 => __( 'Select the products button styling', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 'default',
	'priority'		 => 10,
	'choices'		 => array(
		'default'	 => __( 'Default', 'maxstore' ),
		'boxed'		 => __( 'Boxed', 'maxstore' ),
		'rounded'	 => __( 'Rounded', 'maxstore' ),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'product-hover',
	'label'			 => __( 'Hover Effect', 'maxstore' ),
	'description'	 => __( 'Select the product hover effect.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 'none',
	'priority'		 => 10,
	'choices'		 => array(
		'none'						 => __( 'None', 'maxstore' ),
		'0 0 3px rgba(0,0,0,0.5)'	 => __( 'Shadow', 'maxstore' ),
	),
	'output'		 => array(
		array(
			'element'	 => '.woocommerce ul.products li.product:hover, .slider-products:hover, .single-article-inner:hover, .custom-category .img-thumbnail:hover',
			'property'	 => 'box-shadow',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'product-shadow',
	'label'			 => __( 'Shadow', 'maxstore' ),
	'description'	 => __( 'Select the product shadow effect.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 'none',
	'priority'		 => 10,
	'choices'		 => array(
		'none'						 => __( 'None', 'maxstore' ),
		'0 0 5px rgba(0,0,0,0.5)'	 => __( 'Small', 'maxstore' ),
		'0 0 10px rgba(0,0,0,0.5)'	 => __( 'Medium', 'maxstore' ),
		'0 0 15px rgba(0,0,0,0.5)'	 => __( 'Large', 'maxstore' ),
	),
	'output'		 => array(
		array(
			'element'	 => '.woocommerce ul.products li.product, .slider-products, .single-article-inner, .searchbar-template, .custom-category .img-thumbnail',
			'property'	 => 'box-shadow',
		),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'product-style',
	'label'			 => __( 'Product style', 'maxstore' ),
	'description'	 => __( 'Select homepage/archive product style.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 'default-style',
	'priority'		 => 10,
	'choices'		 => array(
		'default-style'	 => __( 'Default', 'maxstore' ),
		'style-one'		 => __( 'Style #1', 'maxstore' ),
		'style-two'		 => __( 'Style #2', 'maxstore' ),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'woo_second_img',
	'label'			 => __( 'WooCommerce Product Image Flipper', 'maxstore' ),
	'description'	 => __( 'Adds a secondary image on product archives that is revealed on hover. Perfect for displaying front/back shots of clothing and other products.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 0,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'slider',
	'settings'		 => 'archive_number_products',
	'label'			 => __( 'Number of products', 'maxstore' ),
	'description'	 => __( 'Change number of products displayed per page in archive(shop) page.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 24,
	'priority'		 => 10,
	'choices'		 => array(
		'min'	 => 2,
		'max'	 => 60,
		'step'	 => 1
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'slider',
	'settings'		 => 'archive_number_columns',
	'label'			 => __( 'Number of products per row', 'maxstore' ),
	'description'	 => __( 'Change the number of product columns per row in archive(shop) page.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 4,
	'priority'		 => 10,
	'choices'		 => array(
		'min'	 => 2,
		'max'	 => 5,
		'step'	 => 1
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'woo_sale_deal',
	'label'			 => __( 'Sale offer countdown', 'maxstore' ),
	'description'	 => __( 'Enable or disable countdown for sale offer - globally.', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'product-meta-styling',
	'label'			 => __( 'Product Meta', 'maxstore' ),
	'description'	 => __( 'Select the products meta (SKU, Category, Tags) styling', 'maxstore' ),
	'section'		 => 'woo_section',
	'default'		 => 'inline',
	'priority'		 => 10,
	'choices'		 => array(
		'inline' => __( 'Inline', 'maxstore' ),
		'block'	 => __( 'Block', 'maxstore' ),
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'switch',
	'settings'	 => 'services-check',
	'label'		 => __( 'Enable Services', 'maxstore' ),
	'section'	 => 'services_section',
	'default'	 => 0,
	'priority'	 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'			 => 'radio-buttonset',
	'settings'		 => 'services-everywhere',
	'label'			 => __( 'Services placing', 'maxstore' ),
	'description'	 => __( 'Enable services everywhere or only on homepage', 'maxstore' ),
	'section'		 => 'services_section',
	'default'		 => 'home',
	'priority'		 => 10,
	'choices'		 => array(
		'home'		 => __( 'Homepage', 'maxstore' ),
		'everywhere' => __( 'Everywhere', 'maxstore' ),
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'				 => 'repeater',
	'label'				 => __( 'Services', 'maxstore' ),
	'section'			 => 'services_section',
	'priority'			 => 10,
	'settings'			 => 'repeater_services',
	'sanitize_callback'	 => 'wp_kses_post',
	'default'			 => array(
		array(
			'service_text' => 'WORLDWIDE NEXT-DAY DELIVERY<br />ONLY<strong> $ 9.95</strong> A YEAR ›',
		),
		array(
			'service_text' => '<strong>STUDENTS:</strong> 10% OFF 24/7 + MORE GOOD STUFF ›',
		),
		array(
			'service_text' => '<strong>FREE DELIVERY WORLDWIDE</strong><br /><a href="#">MORE INFO HERE ›</a>',
		),
	),
	'fields'			 => array(
		'service_text' => array(
			'type'		 => 'text',
			'label'		 => __( 'Service text (HTML allowed)', 'maxstore' ),
			'default'	 => '',
		),
	),
	'row_label'			 => array(
		'type'	 => 'text',
		'value'	 => __( 'Service', 'maxstore' ),
	),
	'choices'			 => array(
		'limit' => 4,
	),
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'multicolor',
	'settings'	 => 'services-colors',
	'label'		 => esc_attr__( 'Services Colors', 'maxstore' ),
	'section'	 => 'services_section',
	'priority'	 => 10,
	'choices'	 => array(
		'text'		 => esc_attr__( 'Text', 'maxstore' ),
		'background' => esc_attr__( 'Background', 'maxstore' ),
		'link'		 => esc_attr__( 'Link', 'maxstore' ),
		'link-hover' => esc_attr__( 'Link hover', 'maxstore' ),
	),
	'default'	 => array(
		'text'		 => '#FFFFFF',
		'background' => '#2b2b2b',
		'link'		 => '#F4C700',
		'link-hover' => '#F46A00',
	),
	'output'	 => array(
		array(
			'choice'	 => 'text',
			'element'	 => '.services-box',
			'property'	 => 'color',
		),
		array(
			'choice'	 => 'background',
			'element'	 => '.services-box:after',
			'property'	 => 'background-color',
		),
		array(
			'choice'	 => 'link',
			'element'	 => '.services-inner a',
			'property'	 => 'color',
		),
		array(
			'choice'	 => 'link-hover',
			'element'	 => '.services-inner a:hover',
			'property'	 => 'color',
		),
	),
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'background',
	'settings'	 => 'background_site',
	'label'		 => __( 'Background', 'maxstore' ),
	'section'	 => 'site_bg_section',
	'default'	 => array(
		'color'		 => '#fff',
		'image'		 => '',
		'repeat'	 => 'no-repeat',
		'size'		 => 'cover',
		'attach'	 => 'fixed',
		'position'	 => 'center-top',
		'opacity'	 => 100,
	),
	'priority'	 => 10,
	'output'	 => 'body',
) );

Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'code',
	'settings'	 => 'google-analytics',
	'label'		 => __( 'Tracking Code', 'maxstore' ),
	'help'		 => __( 'Paste your Google Analytics (or other) tracking code here.', 'maxstore' ),
	'section'	 => 'code_section',
	'choices'	 => array(
		'label'		 => __( 'Tracking Code', 'maxstore' ),
		'language'	 => 'html',
		'theme'		 => 'monokai',
		'height'	 => 200,
	),
	'default'	 => '',
	'priority'	 => 10,
) );
Kirki::add_field( 'maxstore_pro_settings', array(
	'type'		 => 'code',
	'settings'	 => 'custom-css',
	'label'		 => __( 'Custom CSS', 'maxstore' ),
	'help'		 => __( 'Write your custom css.', 'maxstore' ),
	'section'	 => 'code_section',
	'default'	 => '',
	'priority'	 => 10,
	'choices'	 => array(
		'label'		 => __( 'Custom CSS Code', 'maxstore' ),
		'language'	 => 'css',
		'theme'		 => 'monokai',
		'height'	 => 250,
	),
) );

function maxstore_pro_configuration() {

	$config[ 'logo_image' ]		 = get_template_directory_uri() . '/img/site-logo.png';
	$config[ 'color_back' ]		 = '#192429';
	$config[ 'color_accent' ]	 = '#0085ba';
	$config[ 'width' ]			 = '25%';

	return $config;
}

add_filter( 'kirki/config', 'maxstore_pro_configuration' );

/**
 * Add custom CSS styles
 */
function maxstore_pro_enqueue_header_css() {

	$columns = get_theme_mod( 'archive_number_columns', 4 );

	if ( $columns == '2' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 48.05%}}';
	} elseif ( $columns == '3' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 30.75%;}}';
	} elseif ( $columns == '5' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 16.95%;}}';
	} else {
		$css = '';
	}
	$button = get_theme_mod( 'buttons-styling', 'default' );
	if ( $button == 'boxed' ) {
		$button_css = '.woocommerce ul.products li.product .button, .add-to-wishlist-custom {width: initial;} .woocommerce ul.products li.product:hover .button {left: 50%; transform: translate(-50%, 0);} .woocommerce ul.products li.product:hover .add-to-wishlist-custom {right: 50%; transform: translate(50%, 0);}';
	} elseif ( $button == 'rounded' ) {
		$button_css = '.woocommerce ul.products li.product .button, .add-to-wishlist-custom {width: initial; border-radius: 25px;} .woocommerce ul.products li.product:hover .button {left: 50%; transform: translate(-50%, 0);} .woocommerce ul.products li.product:hover .add-to-wishlist-custom {right: 50%; transform: translate(50%, 0);}';
	} else {
		$button_css = '';
	}
	$prod_meta = get_theme_mod( 'product-meta-styling', 'inline' );
	if ( $prod_meta == 'block' ) {
		$prod_css = '.woocommerce .product_meta .sku_wrapper, .woocommerce .product_meta .posted_in, .woocommerce .product_meta .tagged_as {
						display: block;
						font-weight: bold;
						padding-bottom: 5px;
						border-bottom: 1px solid #D3D3D3;
					}
					.woocommerce .product_meta .sku_wrapper .sku, .woocommerce .product_meta .posted_in a, .woocommerce .product_meta .tagged_as a {
						font-weight: normal;
						margin-left: 5px;
					}';
	} else {
		$prod_css = '';
	}
	$hover = get_theme_mod( 'product-hover', 'none' );
	if ( $hover == 'shadow' ) {
		$hover = '.woocommerce ul.products li.product:hover {
					-moz-box-shadow: 0 0 3px rgba(0,0,0,0.5);
					-webkit-box-shadow: 0 0 3px rgba(0,0,0,0.5);
					box-shadow: 0 0 3px rgba(0,0,0,0.5);
				}';
	} else {
		$hover = '';
	}
	$menu_style = get_theme_mod( 'menu-style', 'default' );
	if ( $menu_style == 'boxed' ) {
		$menu_style_css = '
			@media (min-width: 768px) {
				.navbar-nav > li > a {
					padding: 15px;
					border-left: 1px solid #D3D3D3 !important;
					margin-left: -1px;
				}
				.navbar-nav > li:last-of-type {
					border-right: 1px solid #D3D3D3 !important;	
				}
				.navbar-inverse .navbar-nav > li > a:after {
					content: "";
					margin-left: 0;
				}
				.navbar {
					border-left: 1px solid #D3D3D3;
					border-right: 1px solid #D3D3D3;
					border-top: 1px solid #D3D3D3;
					margin-top: -1px;
				}
			}
		';
	} elseif ( $menu_style == 'clean' ) {
		$menu_style_css = '
			@media (min-width: 768px) {
				.navbar-nav > li {
					padding: 15px 0;
				}
				.navbar-nav > li > a {
					padding: 0 15px;
					border-right: 1px solid;
				}
				.navbar-inverse .navbar-nav > li > a:after {
					content: "";
					margin-left: 0;
				}
				.navbar {
					border-top: 1px solid #D3D3D3;
					margin-top: -1px;
				}
			}
		';
	} else {
		$menu_style_css = '';
	}
	$custom_css = "
		{$css}
		{$prod_css}
		{$button_css}
		{$hover}
		{$menu_style_css}
	";
	wp_add_inline_style( 'kirki-styles-maxstore_pro_settings', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'maxstore_pro_enqueue_header_css', 9999 );

function maxstore_pro_product_style() {
	if ( get_theme_mod( 'product-style', 'default-style' ) == 'style-one' ) {
		wp_enqueue_style( 'maxstore-product-one', get_template_directory_uri() . '/css/product-style1.css' );
	} elseif ( get_theme_mod( 'product-style', 'default-style' ) == 'style-two' ) {
		wp_enqueue_style( 'maxstore-product-one', get_template_directory_uri() . '/css/product-style2.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'maxstore_pro_product_style', 99999 );

function maxstore_pro_category_select() {
	global $wpdb;
	$all_categories	 = $wpdb->get_results( 'SELECT name, ' . $wpdb->prefix . 'terms.term_id FROM ' . $wpdb->prefix . 'terms, ' . $wpdb->prefix . 'term_taxonomy WHERE ' . $wpdb->prefix . 'terms.term_id = ' . $wpdb->prefix . 'term_taxonomy.term_id AND taxonomy = "product_cat" ORDER BY name ASC;' );
	$categories		 = array();
	if ( $all_categories && !is_wp_error( $all_categories ) ) {
		foreach ( $all_categories as $cat ) {
			$categories[ $cat->term_id ] = $cat->name;
		}
		return $categories;
	}
}
