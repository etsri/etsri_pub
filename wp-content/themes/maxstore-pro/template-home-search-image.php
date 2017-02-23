<?php
/**
 *
 * Template name: Homepage with searchbar
 * The template for displaying homepage.
 *
 * @package maxstore
 */
get_header();
?>

<?php get_template_part( 'templates/template-part', get_theme_mod( 'header-style', 'head' ) ); ?>
 
<!-- start content container -->
<div class="row rsrc-content">
	<?php
	global $post;
	$sidebar = get_post_meta( $post->ID, 'maxstore_sidebar_position', true );
	if ( $sidebar == 'left' ) {
		$columns = (12 - get_theme_mod( 'left-sidebar-size', 3 ));
	} elseif ( $sidebar == 'right' ) {
		$columns = (12 - get_theme_mod( 'right-sidebar-size', 3 ));
	} else {
		$columns = '12';
	}
	?> 
	<?php if ( has_post_thumbnail() && class_exists( 'WooCommerce' ) ) { ?>
		<div class="top-area no-gutter searchbar-template" style="background-image: url(<?php the_post_thumbnail_url( 'maxstore-slider' ); ?>)">
				<h1 class="header-search-text col-xs-8 col-xs-push-2">
					<?php the_title(); ?>
				</h1>
			<div class="header-search-form col-xs-8 col-xs-push-2">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input class="col-xs-12" name="s" type="text" placeholder="<?php esc_attr_e( 'Search for products', 'maxstore' ); ?>"/>
					<button type="submit">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
				</form>
			</div>
		</div>
	<?php } ?>   
	<?php if ( $sidebar == 'left' ) get_sidebar( 'home' ); ?>    
	<div class="col-md-<?php if ( $sidebar != 'none' ) { echo $columns;	} else { echo '12';	}; ?> rsrc-main" >         
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>                                
				<div <?php post_class( 'rsrc-post-content' ); ?>>                                                      
					<div class="entry-content">                       
						<?php the_content(); ?>                            
					</div>                                                       
				</div>        
			<?php endwhile; ?>        
		<?php else: ?>            
			<?php get_404_template(); ?>        
		<?php endif; ?>    
	</div>
	<?php if ( $sidebar == 'right' ) get_sidebar( 'home-right' ); ?> 
</div>
<!-- end content container -->
<?php get_footer(); ?>
