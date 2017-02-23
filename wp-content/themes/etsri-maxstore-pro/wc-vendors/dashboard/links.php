<center>
<hr style="border: 1px outset;">
<h5>
<strong>


<p> 
        <a href="<?php echo $shop_page; ?>" class="button"><?php echo _e( 'VIEW YOUR STORE  |  ', 'wcvendors' ); ?></a>
        <a href="<?php echo $settings_page; ?>" class="button"><?php echo _e( 'STORE SETTINGS  |  ', 'wcvendors' ); ?></a>

<?php if ( $can_submit ) { ?>
                <a target="_TOP" href="<?php echo $submit_link; ?>" class="button"><?php echo _e( 'ADD NEW PRODUCT  |  ', 'wcvendors' ); ?></a>
                <a target="_TOP" href="<?php echo $edit_link; ?>" class="button"><?php echo _e( 'EDIT PRODUCTS', 'wcvendors' ); ?></a>
<?php } 
do_action( 'wcvendors_after_links' );
?>
</strong>
</h5>
</center>

<hr style="border: 1px outset;">