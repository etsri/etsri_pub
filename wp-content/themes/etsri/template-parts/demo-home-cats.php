<?php 
$entries = array(
	array(
		'maxstore_image_id'	 => get_stylesheet_directory_uri() . '/img/demo/slider421.jpg',
	),
	array(
		'maxstore_image_id'	 => get_stylesheet_directory_uri() . '/img/demo/slider41.jpg',
	),
	array(
		'maxstore_image_id'	 => get_stylesheet_directory_uri() . '/img/demo/slider51.jpg',
	),
	array(
		'maxstore_image_id'	 => get_stylesheet_directory_uri() . '/img/demo/slider2.jpg',
	),
	array(
		'maxstore_image_id'	 => get_stylesheet_directory_uri() . '/img/demo/slider3.jpg',
	),

)

?>
<div class="top-area row">      
  <div class="carousel slide" id="maxstore-slider">
    <ol class="carousel-indicators">                                
      <?php $j=0; foreach ( $entries as $key => $entry ) : ?>                                                                      
         <li data-target="#maxstore-slider" data-slide-to="<?php echo $j; ?>" class="<?php if ($j == 0) echo 'active '; ?>"></li>                                  
         <?php $j++; ?>                                
      <?php endforeach; ?>                            
    </ol>
	<div class="displayStyle">
    <div class="carousel-inner">
      <?php $i=0; 
        foreach ( (array) $entries as $key => $entry ) {
          $img = '';    
          if ( isset( $entry['maxstore_image_id'] ) ) {
            $img =  esc_url( $entry['maxstore_image_id'] );
          } ?>
          <div class="item <?php if( $i == 0 ) echo 'active'; ?>">
            <div class="top-slider-inner">   
                <?php echo '<img src="' . esc_url ( $entry['maxstore_image_id'] ) . '" alt="">'; ?>                        
                </div>
              </div>

          <?php $i++;?>
        <?php } ?>
      </div>
	  </div>
    <a class="left carousel-control" href="#maxstore-slider" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
    <a class="right carousel-control" href="#maxstore-slider" data-slide="next"><i class="fa fa-chevron-right"></i></a>
  </div> 
</div>
