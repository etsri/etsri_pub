<div class="container rsrc-container" role="main">
	<?php
	if ( is_front_page() || is_home() || is_404() ) {
		$heading = 'h1';
		$desc	 = 'h2';
	} else {
		$heading = 'h2';
		$desc	 = 'h3';
	}
	?> 
	<?php if ( get_theme_mod( 'infobox-text-right', '' ) != '' || get_theme_mod( 'infobox-text-left', '' ) != '' ) : ?>
		<div class="top-section row"> 
			<div class="top-infobox text-left col-xs-6">
				<?php if ( get_theme_mod( 'infobox-text-left', '' ) != '' ) {
					echo get_theme_mod( 'infobox-text-left' );
				} ?> 
			</div> 
			<div class="top-infobox text-right col-xs-6">
			<?php if ( get_theme_mod( 'infobox-text-right', '' ) != '' ) {
				echo get_theme_mod( 'infobox-text-right' );
			} ?> 
			</div>               
		</div>
	<?php endif; ?>
	<div class="header-section row" >
		<?php if ( is_active_sidebar( 'maxstore-topbar-area' ) ) { ?>
			<div id="content-top-section" class="co-md-12">
				<?php dynamic_sidebar( 'maxstore-topbar-area' ) ?>
			</div>
		<?php } ?>
		<?php // Site title/logo ?>
		<header id="site-header" class="col-md-12 text-center <?php if ( !function_exists('max_mega_menu_is_enabled') && has_nav_menu( 'main_menu' ) ) { echo 'hidden-xs'; }  ?> rsrc-header text-center" itemscope itemtype="http://schema.org/WPHeader" role="banner"> 
			<?php if ( get_theme_mod( 'header-logo', '' ) != '' ) : ?>
	            <div class="rsrc-header-img" itemprop="headline">
	                <a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-logo' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
	            </div>
			<?php else : ?>
	            <div class="rsrc-header-text">
	                <<?php echo $heading ?> class="site-title" itemprop="headline"><a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a></<?php echo $heading ?>>
	                <<?php echo $desc ?> class="site-desc" itemprop="description"><?php esc_attr( bloginfo( 'description' ) ); ?></<?php echo $desc ?>>
	            </div>
			<?php endif; ?>   
		</header> 
	</div>
	<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('main_menu') && has_nav_menu( 'main_menu' ) ) : ?>
		<?php wp_nav_menu( array( 'theme_location' => 'main_menu') ); ?>
	<?php else : ?>
	    <?php get_template_part('templates/template-part', 'mainmenu'); ?>
	<?php endif; ?> 
<?php if ( get_theme_mod( 'search-bar-check', 1 ) == 1 && class_exists( 'WooCommerce' ) ) : ?> 
	<?php get_template_part( 'templates/template-part', 'searchbar' ); ?>
<?php endif; ?>
<?php if ( get_theme_mod( 'services-check', 0 ) == 1 && get_theme_mod( 'services-everywhere', 'home' ) == 'home' && ( is_home() || is_front_page() ) || get_theme_mod( 'services-check', 0 ) == 1 && get_theme_mod( 'services-everywhere', 'home' ) == 'everywhere'  ) : ?> 
	<?php get_template_part( 'templates/template-part', 'services' ); ?>
<?php endif; ?>
