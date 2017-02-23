<?php if ( is_active_sidebar( 'maxstore-footer-area' ) ) { ?>
	<div id="content-footer-section" class="row clearfix">
		<?php dynamic_sidebar( 'maxstore-footer-area' ) ?>
	</div>
<?php } ?>    
<footer id="colophon" class="rsrc-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
	<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
	    <div class="rsrc-footer-menu row" >
	        <nav id="footer-navigation" class="navbar navbar-inverse" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">

				<div class="navbar-footer">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-2-collapse">
						<span class="sr-only"><?php _e( 'Toggle navigation', 'maxstore' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<?php
				wp_nav_menu( array(
					'theme_location'	 => 'footer_menu',
					'depth'				 => 1,
					'container'			 => 'div',
					'container_class'	 => 'collapse navbar-collapse navbar-2-collapse',
					'menu_class'		 => 'nav navbar-nav menu-center',
					'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
					'walker'			 => new wp_bootstrap_navwalker() )
				);
				?>
	        </nav>
	    </div>
	<?php endif; ?>
	
	<?php if ( get_theme_mod( 'footer-credits', '' ) != '' ) : ?>
		<div class="row rsrc-author-credits">
			<p class="text-center"><?php echo get_theme_mod( 'footer-credits' ); ?> </p>
		</div>
	<?php else : ?>
		<div class="row rsrc-author-credits">
			<p>
				<div class="text-center"><?php printf( __( 'Copyright &copy; %1$s | MaxStore by %2$s', 'maxstore' ), date( "Y" ), '<a href="' . esc_url( 'http://themes4wp.com' ) . '">Themes4WP</a>' ); ?></div>
			</p>
		</div>
	<?php endif; ?>
</footer>
<div id="back-top">
	<a href="#top"><span></span></a>
</div>
<?php if ( function_exists( 'maxstore_pro_header_cart' ) && get_theme_mod( 'header-style' ) == 'head-alt-3' && class_exists( 'WooCommerce' ) ) { ?> 
	<div class="float-cart header-cart text-center">
		<?php maxstore_pro_header_cart(); ?>
		<?php if ( get_theme_mod( 'my-account-link', 1 ) == 1 ) { ?>
			<a class="float-account" href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" title="<?php _e( 'My Account', 'maxstore' ); ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-user" aria-hidden="true"></i></a>
		<?php } ?>
	</div>
<?php } ?>
</div>
<!-- end main container -->
<?php wp_footer(); ?>
</body>
</html>