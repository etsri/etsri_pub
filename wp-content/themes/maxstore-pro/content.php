<article class="archive-article" itemscope itemtype="http://schema.org/BlogPosting"> 
	<div <?php post_class(); ?>>                            
		<?php if ( has_post_thumbnail() ) : ?>                               
			<div class="featured-thumbnail col-md-12"><?php the_post_thumbnail( 'maxstore-single', array( 'itemprop' => 'image' ) ); ?>                                                          
			<?php else : ?>
				<div class="nothumbnail">                          
				<?php endif; ?>
				<header>
					<h2 class="page-header" itemprop="headline">                                
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'maxstore' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>                            
					</h2>
					<?php get_template_part( 'templates/template-part', 'postmeta' ); ?>
				</header> 
			</div> 
			<div class="home-header text-center col-md-12">                                                      
				<div class="entry-summary" itemprop="text">
					<?php $content = get_the_content();
					echo wp_trim_words( strip_shortcodes( $content ), '40', $more	 = '...' ); ?> 
				</div><!-- .entry-summary -->                                                                                                                       
				<div class="clear"></div>                                  
				<p>                                      
					<a class="btn btn-primary btn-md outline" href="<?php the_permalink(); ?>" itemprop="interactionCount">
						<?php _e( 'Read more', 'maxstore' ); ?> 
					</a>                                  
				</p>                            
			</div>                      
		</div>
		<div class="clear"></div>
</article>