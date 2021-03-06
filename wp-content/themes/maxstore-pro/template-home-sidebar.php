<?php
/**
 *
 * Template name: Homepage with sidebar
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
		<?php if ( $sidebar == 'left' ) get_sidebar( 'home' ); ?>   
    <div class="col-md-<?php if ( $sidebar != 'none' ) { echo $columns;	} else { echo '12';	}; ?> rsrc-main">        
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php $section_on = get_post_meta( get_the_ID(), 'maxstore_first_image_on', true ); ?>                                 
			<div <?php post_class( 'rsrc-post-content' ); ?>>                                                      
				<div class="entry-content"> 
					<?php if ( $section_on == 'on' && class_exists( 'WooCommerce' ) ) { ?>
						<?php get_template_part( 'templates/template-part', 'home-cats' ); ?>
					<?php } ?>                           
					<?php the_content(); ?>                            
				</div>                                                       
			</div>        
		<?php endwhile; ?>        
		<?php else: ?>            
			<?php get_404_template(); ?>        
		<?php endif; ?>    
	</div>
<?php //get the right sidebar  ?>    
<?php if ( $sidebar == 'right' ) get_sidebar( 'home-right' ); ?>  
</div>
<!-- end content container -->
<?php get_footer(); ?>