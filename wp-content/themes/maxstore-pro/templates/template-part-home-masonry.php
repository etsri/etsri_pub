<?php
$cats = get_post_meta( get_the_ID(), 'maxstore_masonry_cat', true );
if ( $cats ) {
	$count	 = count( $cats );
	?>
	<div class="masonry-section">
		<?php
		$i		 = 0;
		foreach ( $cats as $key => $value ) {
			if ( ++$i > 6 )	break;
			$term			 = get_term_by( 'id', $value, 'product_cat' );
			if ( $term ) {
				$term_name		 = $term->name;
				$term_id		 = $term->term_id;
				$term_slug		 = $term->slug;
				$desc			 = $term->description;
				$category_link	 = get_term_link( $term );
				$thumb_id		 = get_term_meta( $term_id, 'thumbnail_id', true );
				$term_img		 = wp_get_attachment_image( $thumb_id, 'maxstore-category' );
				?>
					<?php if ( $count >= 6 ) { ?>
						<div class="topfirst-img <?php if ( $i == 1 ) {	echo 'col-sm-6'; } elseif ( $i == 4 ) {	echo 'col-sm-6 position-right'; } elseif ( $i >= 2 && $i != 4 ) { echo 'col-sm-3 col-xs-6';	} ?>"> 
					<?php } else { ?>
						<div class="topfirst-img <?php if ( $i == 1 ) {	echo 'col-sm-6'; } elseif ( $i >= 2 ) {	echo 'col-sm-3 col-xs-6'; } ?>">
					<?php } ?>
						<a href="<?php echo esc_url( $category_link ); ?>"> 
							<div class="top-grid-img">
								<?php
								if ( $term_img ) {
									echo $term_img;
								} else {
									echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="600px" height="600px" />';
								}
								?>
							</div>
							<div class="top-grid-heading">
								<h2>
									<?php if ( $term_name ) { echo esc_html( $term_name ); } ?>
								</h2>
								<p>
									<?php if ( $desc ) { echo substr( $desc, 0, 50 ), '&hellip;'; } ?>
								</p>
							</div>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
<?php
}
