<?php
/**
 *
 * Template name: Sitemap Page
 * The template for displaying Sitemap Page.
 *
 * @package maxstore
 */

get_header(); ?>

<?php get_template_part('templates/template-part', get_theme_mod( 'header-style', 'head' )); ?>

<!-- start content container -->
<div class="row rsrc-content">      
	<article class="col-md-12 rsrc-main" itemscope itemtype="http://schema.org/BlogPosting">        
		<div id="row">
            <?php if (have_posts()) {
                while (have_posts()){ the_post(); ?>
                  <?php maxstore_pro_breadcrumb(); ?>
                    <header>                              
                      <h1 class="entry-title page-header" itemprop="headline">
                        <?php the_title() ;?>
                      </h1>                                                        
                    </header>                            
                    <div class="entry-content" itemprop="articleBody">                              
                      <?php the_content(); ?>                            
                    </div>

                <?php }//while ?>
            <?php }//if ?>

            <?php wp_reset_query(); ?> 
            <div class="col-md-3">
                <h2><?php _e('Latest Posts', 'maxstore'); ?></h2>
                <ul>
                    <?php query_posts('post_type="post"&post_status="publish"&showposts=10'); ?>
                    <?php if ( have_posts() ) {
                        while ( have_posts() ){ the_post(); ?>
                            <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                        <?php }//while ?>
                    <?php }//fin ?>
                    <?php wp_reset_query(); ?> 
                </ul>
	          </div>
	          <div class="col-md-3">
                <h2><?php _e('Pages', 'maxstore'); ?></h2>
                <ul>
                    <?php wp_list_pages('title_li='); ?>
                </ul>
            </div>
            <div class="col-md-3">        
                <h2><?php _e('Categories', 'maxstore'); ?></h2>
                <ul>
                    <?php wp_list_categories('title_li=&show_count=1'); ?>
                </ul>
            </div>
            <div class="col-md-3">    
                <h2><?php _e('Archives', 'maxstore'); ?></h2>
                <ul>
                    <?php wp_get_archives('show_post_count=true'); ?>
                </ul>
            </div>
            <div class="clear"></div>
            <hr />
            <div class="col-md-6"> 
                <h2><?php _e('Posts by Category', 'maxstore'); ?></h2>
                <?php $categories = get_categories( ); ?>
                <?php foreach($categories as $cat){ ?>
                	<h3><a href="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo $cat->name; ?></a></h3>
                    <ul>
                    	<?php query_posts('post_type="post"&post_status="publish"&cat='. $cat->term_id); ?>
	                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                        	<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
	                        <?php endwhile; ?>
	                        <?php endif; ?>
	                    <?php wp_reset_query(); ?> 
                    </ul>
            	<?php } ?>
            </div>
            <?php if ( class_exists( 'WooCommerce' ) ) { ?>
              <div class="col-md-6"> 
                  <h2><?php _e('Products by Category', 'maxstore'); ?></h2>
                  <?php $args = array(
                         'taxonomy'     => 'product_cat',
                  );
                  $categories = get_categories( $args ); ?>
                  <?php foreach($categories as $cat){ ?>
                    <h3><a href="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo $cat->name; ?></a></h3>
                      <ul>
                      	<?php 
                        $args = array(
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'ID',
                                    'terms' => $cat->term_id
                                ),
                            ),
                            'post_type' => 'product',
                            'orderby' => 'title',
                        );
                        $the_query = new WP_Query( $args ); ?>
  	                        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  	                        	<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
  	                        <?php endwhile; ?>
  	                        <?php endif; ?>
  	                    <?php wp_reset_query(); ?> 
                      </ul>
              	<?php } ?>
              </div>
            <?php } ?>            
         </div><!-- entry -->					
	</article>    
</div>
<!-- end content container -->

<?php get_footer(); ?>