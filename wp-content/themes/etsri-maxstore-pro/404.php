<?php get_header(); ?>

<?php get_template_part( 'templates/template-part', get_theme_mod( 'header-style', 'head' ) ); ?>

<!-- start content container -->
<div class="row rsrc-content">

	<?php //left sidebar ?>
	<?php get_sidebar( 'left' ); ?>

	<div class="col-md-<?php maxstore_pro_main_content_width(); ?> rsrc-main">
		<div class="error-template text-center">
			<h1><?php _e( 'Oops!   404!!', 'maxstore' ); ?></h1>
			<div class="error-details">
				<p> 
					<img class="alignnone size-medium wp-image-500" src="http://localhost/etsri/wp-content/uploads/2016/12/thinking.png" alt="" width="300" height="200" />
					<h4><?php _e( 'hmmmm... something did not go well this time. Requested page was not found!', 'maxstore' ); ?></h4>
				</p> 
			</div>
			<p>                                      
				<a class="btn btn-primary btn-md outline" href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                    <span class="fa fa-home"></span><?php _e( ' Take Me Home', 'maxstore' ); ?> 
				</a>                                  
			</p> 
		</div>
	</div>

	<?php //get the right sidebar ?>
	<?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>