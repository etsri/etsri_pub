<?php
$repeater_value	 = get_theme_mod( 'repeater_services', array(
	array(
		'service_text' => 'WORLDWIDE NEXT-DAY DELIVERY<br />ONLY<strong> $ 9.95</strong> A YEAR ›',
	),
	array(
		'service_text' => '<strong>STUDENTS:</strong> 10% OFF 24/7 + MORE GOOD STUFF ›',
	),
	array(
		'service_text' => '<strong>FREE DELIVERY WORLDWIDE</strong><br /><a href="#">MORE INFO HERE ›</a>',
	),
) );
?>
<div class="services-section row">
	<?php
	$i				 = 1;
	$columns		 = ( 12 / count( $repeater_value ) );
	foreach ( $repeater_value as $row ) :
		if ( isset( $row[ 'service_text' ] ) && !empty( $row[ 'service_text' ] ) ) :
			?>
			<div class="services-box text-center service-<?php echo $i; ?> col-sm-<?php echo $columns; ?>">
				<div class="services-inner">
					<?php echo wp_kses_post( $row[ 'service_text' ] ); ?>
				</div>
			</div>
			<?php
		endif;
		$i++;
	endforeach;
	?>
</div>
