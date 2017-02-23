<?php

if ( get_option( 'show_on_front' ) == 'page' ) { // Display static front page if is set.

	include( get_page_template() );

} elseif ( class_exists( 'WooCommerce' ) && get_theme_mod( 'demo_front_page', 1 ) == 1 && !is_child_theme() ) { // Display demo homepage only if WooCommerce plugin is activated, not a child theme and demo enabled via customizer.

	get_header();

	get_template_part( 'templates/template-part', get_theme_mod( 'header-style', 'head' ) ); 

	?>

	<!-- start content container --> 
	<div class="row rsrc-content">
		<?php if ( ! is_active_sidebar( 'maxstore-home-sidebar' ) && get_theme_mod( 'front_page_demo_sidebars', 'none' ) == 'left' ) : ?>
			<aside id="sidebar-secondary" class="col-md-3 rsrc-left" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
				<?php
					the_widget( 'WC_Widget_Product_Search', 'title=Search', 'before_title=<h3 class="widget-title">&after_title=</h3>' );
					the_widget( 'WC_Widget_Product_Categories', 'title=Categories', 'before_title=<h3 class="widget-title">&after_title=</h3>' );
				?>
			</aside>
		<?php else : ?>
			<?php if ( get_theme_mod( 'front_page_demo_sidebars', 'none' ) == 'left' ) : ?>
				<aside id="sidebar-secondary" class="col-md-3 rsrc-left" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
					<?php dynamic_sidebar( 'maxstore-home-sidebar' ); ?>
				</aside>
			<?php endif; ?>
		<?php endif; ?>
		<div class="col-md-<?php if ( get_theme_mod( 'front_page_demo_sidebars', 'none' ) == 'none' ) { echo '12'; } else { echo '9'; } ?>  rsrc-main">                                  
			<div <?php post_class( 'rsrc-post-content' ); ?>>                                                      
				<div class="entry-content">
					<?php if ( get_theme_mod( 'front_page_demo_banner', 1 ) == 1 ) {
						get_template_part( 'template-parts/demo-home', 'cats' );
					} ?>
					<?php
					$loop = new WP_Query( array(
						'post_type'	 => 'product',
					) );
					if ( $loop->have_posts() ) :
						if ( get_theme_mod( 'front_page_demo_style', 'style-one' ) == 'style-one' ) {
							get_template_part( 'template-parts/demo-layout', 'one' );
						} elseif ( get_theme_mod( 'front_page_demo_style', 'style-one' ) == 'style-two' ) { 
							get_template_part( 'template-parts/demo-layout', 'two' );	
						} elseif ( get_theme_mod( 'front_page_demo_style', 'style-one' ) == 'style-three' ) { 
							get_template_part( 'template-parts/demo-layout', 'three' );	
						} elseif ( get_theme_mod( 'front_page_demo_style', 'style-one' ) == 'style-four' ) { 
							get_template_part( 'template-parts/demo-layout', 'four' );	
						} else { 
							get_template_part( 'template-parts/demo-layout', 'five' );	
						}
					else : ?>
						<p class="text-center">	
							<?php esc_html_e( 'No products found', 'maxstore' ); ?>
						</p>
					<?php endif; ?>
				</div>                                                       
			</div>        
		</div>
		<?php if ( get_theme_mod( 'front_page_demo_sidebars', 'none' ) == 'right' ) : ?>
			<aside id="sidebar" class="col-md-3 rsrc-right" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
				<?php dynamic_sidebar( 'maxstore-home-sidebar' ); ?>
			</aside>
		<?php endif; ?>
	</div>
	<!-- end content container -->
	<?php get_footer(); ?>

	<?php
} else { // Display blog posts.
	include( get_home_template() );
}
