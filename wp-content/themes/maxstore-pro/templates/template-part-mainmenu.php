<?php
if ( is_front_page() || is_home() || is_404() ) {
	$heading = 'h1';
} else {
	$heading = 'h2';
}
?>
<?php if ( has_nav_menu( 'main_menu' ) ) : ?> 
	<div class = "rsrc-top-menu row" >
		<nav id = "site-navigation" class = "navbar navbar-inverse" role = "navigation" itemscope itemtype = "http://schema.org/SiteNavigationElement">
			<div class = "navbar-header">
				<button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = ".navbar-1-collapse">
					<span class = "sr-only"><?php esc_html_e( 'Toggle navigation', 'maxstore' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<header class="visible-xs-block responsive-title" itemscope itemtype="http://schema.org/WPHeader" role="banner"> 
					<?php if ( get_theme_mod( 'header-logo', '' ) != '' ) : ?>
						<div class="menu-img text-left" itemprop="headline">
							<a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-logo' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
						</div>
					<?php else : ?>
						<div class="rsrc-header-text menu-text">
							<<?php echo $heading ?> class="site-title" itemprop="headline"><a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a></<?php echo $heading ?>>
						</div>
					<?php endif; ?>   
				</header>
			</div>

			<?php
			wp_nav_menu( array(
				'theme_location'	 => 'main_menu',
				'depth'				 => 3,
				'container'			 => 'div',
				'container_class'	 => 'collapse navbar-collapse navbar-1-collapse',
				'menu_class'		 => 'nav navbar-nav ' . get_theme_mod( 'menu-position', 'menu-left' ),
				'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
				'walker'			 => new wp_bootstrap_navwalker() )
			);
			?>
		</nav>
	</div>
<?php endif; ?>
 