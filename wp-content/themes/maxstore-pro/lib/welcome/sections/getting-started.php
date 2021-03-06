<?php
/**
 * Getting started template
 */

?>

<div id="getting_started" class="maxstore-tab-pane active">

	<div class="maxstore-tab-pane-center">

    <h1 class="maxstore-welcome-title"><?php printf( esc_html__( 'Welcome to %s!', 'maxstore' ), 'MaxStore PRO' ); ?></h1>

		<p><?php esc_html_e( 'Our elegant and professional WooCommerce theme, which turns your Wordpress to awesome eCommerce site.','maxstore'); ?></p>
		<p><?php printf( esc_html__( 'We want to make sure you have the best experience using %1s and that is why we gathered here all the necessary informations for you. We hope you will enjoy using %2s, as much as we enjoy creating great products.', 'maxstore' ), 'MaxStore PRO', 'MaxStore PRO' ); ?>

	</div>

	<hr />

	<div class="maxstore-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'maxstore' ); ?></h1>

		<h4><?php esc_html_e( 'Customize everything in a single place.' ,'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'maxstore' ); ?></p>
    <p><?php esc_html_e( 'This theme uses Kirki toolkit plugin to customize theme. This plugin adds advanced features to the WordPress customizer. Install the plugin before you go to the customizer.', 'maxstore' ); ?></p>
		<p>
      <?php if ( is_plugin_active( 'kirki/kirki.php' ) ) { ?>
				<span class="maxstore-w-activated button"><?php esc_html_e( 'Kirki is already activated', 'maxstore' ); ?></span>
			<?php	} else { ?>
				<a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=kirki' ), 'install-plugin_kirki' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Kirki Toolkit', 'maxstore' ); ?></a>
		  <?php	} ?>
      <a href="<?php echo esc_url( admin_url() . 'customize.php' ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'maxstore' ); ?></a>
    </p>

	</div>

	<hr />

	<div class="maxstore-tab-pane-center">

		<h1><?php esc_html_e( 'FAQ', 'maxstore' ); ?></h1>

	</div>
  <div class="maxstore-video-tutorial">
    <div class="maxstore-tab-pane-half maxstore-tab-pane-first-half">
  		<h4><?php esc_html_e( 'Theme Setup - step by step', 'maxstore' ); ?></h4>
      <p><?php esc_html_e( 'You can check our video tutorial how to setup the theme. This may help you to understand how the theme works and check if you miss something when you create your website.', 'maxstore' ); ?></p>
  	  <p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/homepage-setup-maxstore/' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>
    </div>
    <div class="maxstore-tab-pane-half video">
      <p class="youtube">
  			<iframe width="360" height="180" src="<?php echo esc_url( 'https://www.youtube.com/embed/GHMMKCbuUAM' ); ?>" frameborder="0" allowfullscreen></iframe>
  		</p>
    </div>
  </div>
  
	<div class="maxstore-tab-pane-half maxstore-tab-pane-first-half">

		<h4><?php esc_html_e( 'Create unique homepage', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'In the below documentation you will find an easy way to build an unique homepage design.', 'maxstore' ); ?></p>
		<p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/homepage-setup/#homepage-content' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>
		
		<hr />
		
		<h4><?php esc_html_e( 'One Click Demo Import', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'You can easily import our demo content, widgets and theme settings with one click.', 'maxstore' ); ?></p>
		<p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/maxstore-pro-one-click-demo-import/' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>

		<hr />
		
		<h4><?php esc_html_e( 'Dummy products', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'When the theme is first installed, you dont have any products probably. You can easily import dummy products with only few clicks.', 'maxstore' ); ?></p>
		<p><a href="<?php echo esc_url( 'https://docs.woocommerce.com/document/importing-woocommerce-dummy-data/' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>
    
	</div>

	<div class="maxstore-tab-pane-half">

		<h4><?php esc_html_e( 'Using Shortcodes', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Shortcodes allow you to create Buy Now buttons, insert products into pages, display related products or featured products, and more.', 'maxstore' ); ?></p>
		<p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/using-shortcodes/' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>

		<hr />
    
    <h4><?php esc_html_e( 'Create a child theme', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'If you want to make changes to the theme\'s files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.', 'maxstore' ); ?></p>
		<p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/how-to-create-a-child-theme/' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'maxstore' ); ?></a></p>
		
	</div>

	<div class="maxstore-clear"></div>

	<hr />

	<div class="maxstore-tab-pane-center">

		<h1><?php esc_html_e( 'View full documentation', 'maxstore' ); ?></h1>
		<p><?php printf( esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'maxstore' ), 'MaxStore PRO' ); ?></p>
		<p><a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/category/maxstore-pro/' ); ?>" class="button button-primary"><?php esc_html_e( 'Read full documentation', 'maxstore' ); ?></a></p>

	</div>

	<hr />

	<div class="maxstore-tab-pane-center">
		<h1><?php esc_html_e( 'Recommended plugins', 'maxstore' ); ?></h1>
	</div>

	<div class="maxstore-tab-pane-half maxstore-tab-pane-first-half">
		<!-- Kirki Toolkit -->
		<h4><?php esc_html_e( 'Kirki Toolkit', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'This theme uses Kirki toolkit plugin to customize theme. This plugin adds advanced features to the WordPress customizer. Install the plugin before you go to the customizer.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'kirki/kirki.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php }	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=kirki' ), 'install-plugin_kirki' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Kirki Toolkit', 'maxstore' ); ?></a></p>
		<?php }	?>
    
		<hr />
    
		<!-- WooCommerce -->
		<h4><?php esc_html_e( 'WooCommerce', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'WooCommerce is a free eCommerce plugin that allows you to sell anything, beautifully. ', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php }	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install WooCommerce', 'maxstore' ); ?></a></p>
		<?php } ?>
    
		<hr />
    
    <!-- CMB2 -->
		<h4><?php esc_html_e( 'CMB2', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Homepage template options.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'cmb2/init.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php }	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=cmb2' ), 'install-plugin_cmb2' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install CMB2', 'maxstore' ); ?></a></p>
		<?php } ?>
    
		<hr />
		
		<!-- MailPoet Newsletters -->
		<h4><?php esc_html_e( 'MailPoet Newsletters', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Send newsletters post notifications or autoresponders from WordPress easily.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'wysija-newsletters/index.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php	}	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=wysija-newsletters' ), 'install-plugin_wysija-newsletters' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install MailPoet Newsletters', 'maxstore' ); ?></a></p>
		<?php	} ?>	
    
	</div>

	<div class="maxstore-tab-pane-half">
  
		<!-- YITH WooCommerce Wishlist -->
		<h4><?php esc_html_e( 'YITH WooCommerce Wishlist', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Offer to your visitors a chance to add the products of your woocommerce store to a wishlist page', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php } else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=yith-woocommerce-wishlist' ), 'install-plugin_yith-woocommerce-wishlist' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install YITH WooCommerce Wishlist', 'maxstore' ); ?></a></p>
		<?php } ?>
		
		<hr />
		
		<!-- YITH WooCommerce Ajax Search -->
		<h4><?php esc_html_e( 'YITH WooCommerce Ajax Search', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Allows your users to search products in real time.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'yith-woocommerce-ajax-search/init.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php	}	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=yith-woocommerce-ajax-search' ), 'install-plugin_yith-woocommerce-ajax-search' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install YITH WooCommerce Ajax Search', 'maxstore' ); ?></a></p>
		<?php	} ?>
    
		<hr />
    
		<!-- WooCommerce Shortcodes -->
		<h4><?php esc_html_e( 'WooCommerce Shortcodes', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'This plugin provides a TinyMCE dropdown button for you use all WooCommerce shortcodes.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'woocommerce-shortcodes/woocommerce-shortcodes.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php	}	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce-shortcodes' ), 'install-plugin_woocommerce-shortcodes' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install WooCommerce Shortcodes', 'maxstore' ); ?></a></p>
		<?php	} ?>
    
		<hr />
		
		<!-- Contact form 7 -->
		<h4><?php esc_html_e( 'Contact Form 7', 'maxstore' ); ?></h4>
		<p><?php esc_html_e( 'Contact form plugin.', 'maxstore' ); ?></p>
		<?php if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { ?>
			<p><span class="maxstore-w-activated button"><?php esc_html_e( 'Already activated', 'maxstore' ); ?></span></p>
		<?php	}	else { ?>
			<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=contact-form-7' ), 'install-plugin_contact-form-7' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Contact Form 7', 'maxstore' ); ?></a></p>
		<?php	} ?>

	</div>

	<div class="maxstore-clear"></div>

</div>
