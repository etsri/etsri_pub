<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<p> <h5>
	<?php
		echo sprintf( esc_attr__( 'Hello %s%s%s (not %2$s? %sSign out%s)', 'woocommerce' ), '<strong>', esc_html( $current_user->display_name ), '</strong>', '<strong><a href="' . esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a></strong>' );
	?>
	<br>
	</h5>
</p>
<?php $user_info = get_userdata(1);
      echo 'Username: ' . $user_info->user_login . "\n";
      echo 'User roles: ' . implode(', ', $user_info->roles) . "\n";
      echo 'User ID: ' . $user_info->ID . "\n";
?>

<p>
	<img class="alignnone size-medium wp-image-500" src="http://localhost/etsri/wp-content/uploads/2016/12/Title-bar-300x8.jpg" alt="" width="300" height="8" />

	<strong> <br>
	<a href="vendor_dashboard/">VENDOR DASHBOARD </a> <br><br>
	<a href="orders/">VIEW RECENT ORDERS </a> <br><br>
	<a href="edit-address/">MANAGE SHIPPING AND BILLING ADDDRESS </a> <br><br>
	<a href="edit-account/">EDIT PASSWORD AND ACCOUNT DETAILS </a> <br><br>
	</strong>

	<img class="alignnone size-medium wp-image-500" src="http://localhost/etsri/wp-content/uploads/2016/12/Title-bar-300x8.jpg" alt="" width="300" height="8" />
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
?>
