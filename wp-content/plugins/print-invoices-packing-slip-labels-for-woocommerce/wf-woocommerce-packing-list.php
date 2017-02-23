<?php
/*
Plugin Name: Print Invoice, Packing Slip, Delivery Note & Label Plugin for WooCommerce (Basic)
Plugin URI: http://www.xadapter.com/product/print-invoices-packing-list-labels-for-woocommerce/
Description: Prints Packing List,Invoice,Delivery Note & Shipping Label.
Version: 2.0.9
Author: WooForce
Author URI: http://www.xadapter.com/vendor/wooforce/
*/

// to check wether accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// for Required functions
if (!function_exists('wf_is_woocommerce_active')) {
	require_once ('wf-includes/wf-functions.php');
}

// to check woocommerce is active
if (!(wf_is_woocommerce_active())) {
	return;
}

// to check if option is present
if(get_option(('woocommerce_wf_invoice_as_ordernumber'))=== false){
	update_option('woocommerce_wf_invoice_as_ordernumber','Yes');	
}

// to check if option is present
if(get_option('woocommerce_wf_generate_for_orderstatus')=== false){
	$data =  Array ("wc-completed");
	update_option('woocommerce_wf_generate_for_orderstatus',$data);
}

if(!class_exists('Wf_WooCommerce_Packing_List')){
	// class for Invoice and Packing List Printing
	class Wf_WooCommerce_Packing_List
	{
		// initializing the class
		function __construct()
		{
			add_action( 'init', array($this, 'load_plugin_textdomain'));
			add_action( 'init', array($this, 'init'));
			add_filter('woocommerce_admin_order_actions', array($this, 'wf_packinglist_alter_order_actions'),10,2); //to add print option at the end of each orders in orders page
			add_action('admin_init', array($this,'wf_packinglist_print_window')); //to print the invoice and packinglist
			add_action('admin_menu', array($this,'wf_packinglist_admin_menu')); //to add shipment label settings menu to main menu of woocommerce
			add_action('add_meta_boxes', array($this,'wf_packinglist_add_box')); //to add meta box in every single detailed order page
			add_action('admin_print_scripts-edit.php', array($this,'wf_packinglist_scripts')); //to load the js for label for client
			add_action('admin_print_scripts-post.php', array($this,'wf_packinglist_scripts')); //to load the js for label for client
			add_filter('plugin_action_links_' . plugin_basename(__FILE__) , array($this,'wf_packinglist_action_links')); //to add settings, doc, etc options to plugins base
			add_filter('woocommerce_subscriptions_renewal_order_meta_query', array($this,'wf_packinglist_remove_subscription_renewal_order_meta'), 10, 4);
			add_action('admin_enqueue_scripts', array($this,'wf_packinglist_admin_scripts')); //to load the js for admin
			add_action('admin_print_styles', array($this,'admin_scripts'));
			add_action( 'manage_shop_order_posts_custom_column', array($this,'wf_custom_column_value_invoice'));
			add_filter( 'manage_edit-shop_order_columns',array($this,'wf_custom_shop_order_column'));
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wf-woocommerce-packing-list', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		}
		
		public function init()
		{
			$this->wf_pklist_init_fields();//function to init values of the fields
		}
			
			//function for initializing fields included from packaging type
		public function wf_pklist_init_fields()
		{
			$this->wf_package_type_options = array(
				'single_packing' => __('Single Package Per Order','wf-woocommerce-packing-list')
			);
			$this->create_package_documents  = array(
				'print_packing_list',
				'print_shipment_label',
				'print_delivery_note',
				'download_shipment_label',
				'download_packinglist',
				'download_delivery_note'
			);
			$this->print_documents = array(
				'print_shipment_label' => 'Print Shipping Label',
				'print_invoice'        => 'Print Invoice',
				'print_packing_list'   => 'Print Packing List',
				'print_delivery_note'  => 'Print Delivery Note'
			);
			$this->download_documents = array(
				'download_shipment_label'     => 'Download Shipping Label',
				'download_invoice'            => 'Download Invoice',
				'download_packinglist'        => 'Download PackingList',
				'download_delivery_note'      => 'Download Delivery Note',
			);
			$this->font_size_options = array(
				'medium'       => 'Medium',
			);
			$this->wf_pklist_font_list = $this->wf_pklist_get_fonts();
			$this->wf_package_type = 'single_packing';
			$this->weight_unit = get_option('woocommerce_weight_unit');
			$this->dimension_unit = get_option('woocommerce_dimension_unit');
			$this->wf_enable_contact_number = get_option('woocommerce_wf_packinglist_contact_number') !=''  ? get_option('woocommerce_wf_packinglist_contact_number') : 'Yes';
			$this->wf_generate_invoice_for = get_option('woocommerce_wf_generate_for_orderstatus') ? get_option('woocommerce_wf_generate_for_orderstatus') : array();
			$this->wf_pklist_font_name = 'arial';
			$this->wf_pklist_font_size = 'medium';				
			$this->wf_packinglist_plugin_path = $this->wf_packinglist_get_plugin_path();
			$this->invoice_labels = apply_filters('wf_pklist_modify_invoice_labels',$this->get_invoice_labels());
				
		}

		// function to add column "Invoice" in orders settings page
		function wf_custom_shop_order_column($columns)
		{
			//add columns
			$columns['Invoice'] = __( 'Invoice','wf-woocommerce-packing-list');
			return $columns;
		}

		//function to generate invoice number
		function wf_generate_invoice_number($order)
		{
			$order_num = $order->id;
			$wf_invoice_id = get_post_meta($order_num,'wf_invoice_number', true);
			$wf_invoice_as_ordernumber = get_option('woocommerce_wf_invoice_as_ordernumber');
			if($wf_invoice_as_ordernumber=="Yes"){
				if(!empty($wf_invoice_id)){
					return $wf_invoice_id;
				}else{
					$invoice_number = $order_num;
					add_post_meta($order_num,'wf_invoice_number',$invoice_number);
					return $invoice_number;
				}
			}else{
				if(!empty($wf_invoice_id)){
					return $wf_invoice_id;
				}else{
					$Current_invoice_number= get_option('woocommerce_wf_Current_Invoice_number');
					update_option('woocommerce_wf_Current_Invoice_number',++$Current_invoice_number);
					$invoice_number = get_option('woocommerce_wf_Current_Invoice_number');
					add_post_meta($order_num,'wf_invoice_number', $invoice_number);
					return $invoice_number;	
				}
			}
		}
		
		// function to add value in "Invoice" column 
		function wf_custom_column_value_invoice($column)
		{		 
			global $post, $woocommerce, $the_order;
			if($column=="Invoice") {
				$generate_invoice_for=array();
				$order_num=$post->ID;
				if(get_option('woocommerce_wf_generate_for_orderstatus')){
					$generate_invoice_for=get_option('woocommerce_wf_generate_for_orderstatus');
				}
				$wf_invoice_id=get_post_meta($order_num,'wf_invoice_number',true);
				$wf_invoice_as_ordernumber=get_option('woocommerce_wf_invoice_as_ordernumber');
				if($wf_invoice_as_ordernumber=="Yes"){
					if(!empty($wf_invoice_id)){
						_e($wf_invoice_id, 'wf-woocommerce-packing-list');
					}else if(empty($wf_invoice_id) && in_array(get_post_status($post->ID),$generate_invoice_for)){
						$invoice_number = $order_num;
						add_post_meta($order_num,'wf_invoice_number',$invoice_number);
						_e($invoice_number, 'wf-woocommerce-packing-list');
					}else{
						_e("-",'wf-woocommerce-packing-list');
					}
				}else{
					if(!empty($wf_invoice_id)){
						_e($wf_invoice_id,'wf-woocommerce-packing-list');
					}else if(empty($wf_invoice_id) && in_array(get_post_status($post->ID),$generate_invoice_for)){
						$current_invoice_number=get_option('woocommerce_wf_Current_Invoice_number');
						update_option('woocommerce_wf_Current_Invoice_number',++$current_invoice_number);
						$invoice_number = get_option('woocommerce_wf_Current_Invoice_number');
						add_post_meta($order_num,'wf_invoice_number',$invoice_number);
						_e($invoice_number,'wf-woocommerce-packing-list');
					}else{
						_e("-",'wf-woocommerce-packing-list');
					}
				}
			}
			
			// Get the order
			$wc_order = wc_get_order( $post->ID );
			// Hidden content that will be injected as order button actions tooltip content in js
			if ( $wc_order && 'order_actions' === $column ) {

				?>
				<div id="wf-pklist-print-tooltip-order-actions-<?php echo $wc_order->id; ?>"class="wf-pklist-print-tooltip-order-actions wf-packing-list-link" style="display:none;">
					<div class="wf-pklist-print-tooltip-content">
						<ul>
							<?php foreach ($this->print_documents as $id => $value) { ?>
								<li>
									<a class="wf-pklist-print-document-tooltip-order-action wf-packing-list-link"
									   href="<?php echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $wc_order->id . '&type='.$id) , 'print-packinglist'); ?>"
									   target="_blank">
										<?php echo esc_html(_e($value, 'wf-woocommerce-packing-list')); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div id="wf-pklist-download-tooltip-order-actions-<?php echo $wc_order->id; ?>"class="wf-pklist-download-tooltip-order-actions wf-packing-list-link" style="display:none;">
					<div class="wf-pklist-download-tooltip-content">
						<ul>
							<?php foreach ($this->download_documents as $id => $value) { ?>
								<li>
									<a class="wf-pklist-download-document-tooltip-order-action wf-packing-list-link"
									   href="<?php echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $wc_order->id . '&type='.$id) , 'print-packinglist'); ?>"
									   target="_blank">
										<?php echo esc_html(_e($value, 'wf-woocommerce-packing-list')); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php
			}
		}
			
		// function to add print invoice packinglist button in admin orders page

		function wf_packinglist_alter_order_actions($actions,$order)
		{ 
				$wf_pklist_print_options = array(
					array(
						'name'   => '',
						'action' => 'wf_pklist_print_document',
						'url'    => sprintf( '#%s', $order->id )
					),
					array(
						'name'   => '',
						'action' => 'wf_pklist_download_document',
						'url'    => sprintf( '#%s', $order->id )
					)
				);
				 return array_merge( $actions, $wf_pklist_print_options);
		}

		// function to add settings link to invoice packing-list-print plugin view
		function wf_packinglist_action_links($links)
		{
			$plugin_links = array(
				'<a href="' . admin_url('admin.php?page=wf_woocommerce_packing_list') . '">' . __('Settings', 'wf-woocommerce-packing-list') . '</a>',
				'<a href="http://www.xadapter.com/product/print-invoices-packing-list-labels-for-woocommerce/" target="_blank">' . __( 'Premium Upgrade', 'wf-woocommerce-packing-list' ) . '</a>',
				'<a href="https://wordpress.org/support/plugin/print-invoices-packing-slip-labels-for-woocommerce" target="_blank">' . __( 'Support', 'wf-woocommerce-packing-list' ) . '</a>',
			);
			return array_merge($plugin_links, $links);
		}

		// function to get plugin url
		function wf_packinglist_get_plugin_url()
		{
			return untrailingslashit(plugins_url('/', __FILE__));
		}

		// functio to get pulgin directory
		function wf_packinglist_get_plugin_path()
		{
			return untrailingslashit(plugin_dir_path(__FILE__));
		}

		// function to start invoice and packinglist printing window
		function wf_packinglist_print_window()
		{
			if (isset($_GET['print_packinglist'])) {
				$client = false;
				//	to check current user has rights to get invoice and packing list
				$nonce = key_exists('_wpnonce',$_GET) ? $_GET['_wpnonce'] : '';
				if (!(wp_verify_nonce($nonce, 'print-packinglist')) || !(is_user_logged_in())) {
					die(_e('You are not allowed to view this page.', 'wf-woocommerce-packing-list'));
				}
				remove_action('wp_footer', 'wp_admin_bar_render', 1000);
				// to get the orders number
				$orders = explode(',', $_GET['post']);
				$action = $_GET['type'];
				$number_of_orders = count($orders);
				$order_loop = 0;
				$is_shipping_from_address_available = 0;
				// function to check that the shipping from address is added or not
				if ($this->wf_packinglist_check_from_address()) {
					$is_shipping_from_address_available = 1;
				}
				switch ($action) {
					case 'print_invoice':
						$this->print_invoice($orders, $action);
						break;
					case 'print_packing_list':
						$this->print_packinglist($orders, $action);
						break;
					case 'print_shipment_label':
						$this->print_shippinglabel($orders, $action, $is_shipping_from_address_available);
						break;
					case 'print_delivery_note':
						$this->print_deliverynote($orders, $action);
						break;
					case 'download_shipment_label':
						$this->download_shippinglabel($orders, $action, $is_shipping_from_address_available);
						break;
					case 'download_packinglist':
						return $this->download_packinglist($orders, $action);
						break;
					case 'download_invoice':
						$this->download_invoice($orders, $action);
						break;
					case 'download_delivery_note':
						$this->download_deliverynote($orders, $action);
						break;
				}
			}
		}
		
		private function download_invoice($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			include_once $this->wf_packinglist_template('dir', 'wf-invoice-pdf-template.php') . 'wf-invoice-pdf-template.php';
			$pdf_invoice = new Pdf_Invoice();
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$pdf_invoice->init($this->wf_pklist_font_name, $this->wf_pklist_font_size);
				if ($this->wf_packinglist_get_companyname() != '') {
					$pdf_invoice->add_Companyname($this->wf_packinglist_get_companyname());
				}
				$pdf_invoice->invoice_num($this->wf_generate_invoice_number($order), $this->get_document_name($action));
				$pdf_invoice->order_date(date("d-m-Y", strtotime($order->order_date)));
				$faddress=$this->wf_shipment_label_get_from_address(); 
				$pdf_invoice->from_address($faddress);
				$pdf_invoice->billing_address($order);
				$pdf_invoice->shipping_address($order);
				$pdf_invoice->OrderDetails_invoice($order, $this->get_table_column_sizes($order));
				if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
				} else {
					if(isset($_GET['attaching_pdf'])){
						$pdf_invoice->Output($this->wf_packinglist_plugin_path.'/'.$order->id ."-Invoice.pdf","F");
						unset($pdf_invoice);
					}else{
						$pdf_invoice->Output("#" . $order->get_order_number() . "-Invoice.pdf", "I");
						exit;
					}
				}
			}
		}
		
		private function download_packinglist($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			include_once $this->wf_packinglist_template('dir', 'wf-packinglist-pdf-template.php') . 'wf-packinglist-pdf-template.php';
			$pdf_invoice_packinglist = new Pdf_Packinglist();
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$create_order_packages;
				if (in_array($action, $this->create_package_documents)) {
					$create_order_packages = $this->wf_pklist_create_order_package($order);
				}
				$order_package_loop = 0;
				$number_of_order_package = count($create_order_packages);
				if(!empty($create_order_packages)) {
					foreach ($create_order_packages as $order_package_id => $order_package) {
						$order_package_loop++;
						$pdf_invoice_packinglist->init($this->wf_pklist_font_name, $this->wf_pklist_font_size);
						if ($this->wf_packinglist_get_companyname() != '') {
							$pdf_invoice_packinglist->add_Companyname($this->wf_packinglist_get_companyname());
						}
						$pdf_invoice_packinglist->packinglist_num($order->get_order_number());
						$pdf_invoice_packinglist->order_date(date("d-m-Y", strtotime($order->order_date)));
						$faddress=$this->wf_shipment_label_get_from_address(); 
						$pdf_invoice_packinglist->from_address($faddress);
						$pdf_invoice_packinglist->billing_address($order);
						$pdf_invoice_packinglist->shipping_address($order);
						$pdf_invoice_packinglist->OrderDetails_packinglist($order_package, $this); 
					}
					if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
					}
					else{
						if(isset($_GET['attaching_pdf'])){
							$pdf_invoice_packinglist->Output($this->wf_packinglist_plugin_path .'/'.$order->id ."-Packinglist.pdf","F");
							unset($pdf_invoice_packinglist);
						}else{
							$pdf_invoice_packinglist->Output("#" . $order->get_order_number() . "-PackingList.pdf", "I");
							exit;
						}
					}
				}  else {
					wp_die( __("Unable to download Packing List. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
				}
			}
		}
		
		private function download_shippinglabel($orders, $action, $is_shipping_from_address_available)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			include $this->wf_packinglist_template('dir', 'wf-label-pdf-template.php') . 'wf-label-pdf-template.php';
			$pdf = new PDF4x6();
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$order_additional_information = array(
					'order' => $order
				);
				$order_additional_information = apply_filters('wf_pklist_label_add_additional_information',$order_additional_information);
				$create_order_packages;
				if (in_array($action, $this->create_package_documents)) {
					$create_order_packages = $this->wf_pklist_create_order_package($order);
				}
				$order_package_loop = 0;
				$number_of_order_package = count($create_order_packages);
				if(!empty($create_order_packages)) {
					foreach ($create_order_packages as $order_package_id => $order_package) {
						$order_package_loop++;
						$pdf->init($this->wf_shipment_label_get_label_size(),$this->wf_pklist_font_name, $this->wf_pklist_font_size);
						if ($is_shipping_from_address_available == 1) {
							_e('You need to Add Shipping from Address to Print shipping labels','wf-woocommerce-packing-list');
							exit;
						}
						if ($this->wf_packinglist_get_companyname() != '') {
							$pdf->addCompanyname($this->wf_packinglist_get_companyname());
						}
						$pdf->addShippingFromAddress($this->wf_shipment_label_get_from_address(), $this->wf_packinglist_get_table_content($order, $order_package), $order_additional_information);
						$pdf->addShippingToAddress($this->wf_shipment_label_get_to_address($order), $order_additional_information);
					}
					if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
					} else {
						$pdf->Output("#" . $order->get_order_number() . "-Shipping-Label.pdf", "D");
						exit;
					}
				}  else {
					wp_die( __("Unable to download Shipping Label. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
				}
			}
		}
		
		private function print_shippinglabel($orders, $action, $is_shipping_from_address_available)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			// building shipment label headers
			ob_start();
			$content = '';
			require_once $this->wf_packinglist_template('dir', 'wf-label-template-header.php') . 'wf-label-template-header.php';
			$content.= ob_get_clean();
			// function to check that the shipping from address is added or not
			if ($is_shipping_from_address_available == 1) {
				$content.= __("You need to Add Shipping from Address to Print shipping labels",'wf-woocommerce-packing-list');
			} else {
				// building shipment label body
				$content1 = '';
				foreach($orders as $order_id) {
					$order_loop++;
					$order = new WC_Order($order_id);
					$order_additional_information = array(
						'order' => $order
					);
					$order_additional_information = apply_filters('wf_pklist_label_add_additional_information',$order_additional_information);
					ob_start();
					$create_order_packages;
					if (in_array($action, $this->create_package_documents)) {
						$create_order_packages = $this->wf_pklist_create_order_package($order);
					}
					$order_package_loop = 0;
					$number_of_order_package = count($create_order_packages);
					if(!empty($create_order_packages)) {
						foreach ($create_order_packages as $order_package_id => $order_package) {
							$order_package_loop++;
							ob_start();
							include $this->wf_packinglist_template('dir', 'wf-label-template-body.php') . 'wf-label-template-body.php';
							$content1.= ob_get_clean();
							if ($number_of_order_package > 1 && $order_package_loop < $number_of_order_package) {
								$content1.= "<p class=\"pagebreak\"></p><br/>";
							} else {
								$content1.= "<p class=\"no-page-break\"></p>";
							}
						}
						if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
							$content1.= "<p class=\"pagebreak\"></p><br/>";
						} else {
							$content1.= "<p class=\"no-page-break\"></p>";
						}
					}  else {
						wp_die( __("Unable to print Shipping Labels. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
					}
				}
				$content.= $content1;
			}
			// building shipment label footer
			ob_start();
			include $this->wf_packinglist_template('dir', 'wf-label-template-footer.php') . 'wf-label-template-footer.php';
			$content.= ob_get_clean();
			// outputing content to client window
			echo $content;
			exit;
		}
		
		private function print_packinglist($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			//building packinglist headers
			ob_start();
			$content = '';
			require_once $this->wf_packinglist_template('dir', 'wf-template-header.php') . 'wf-template-header.php';
			$content.= ob_get_clean();
			//building packinglist body
			$content1 = '';
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$create_order_packages;
				if (in_array($action, $this->create_package_documents)) {
					$create_order_packages = $this->wf_pklist_create_order_package($order);
				}
				$order_package_loop = 0;
				$number_of_order_package = count($create_order_packages);
				if(!empty($create_order_packages)) {
					foreach ($create_order_packages as $order_package_id => $order_package) {
						$order_package_loop++;
						ob_start();
						include $this->wf_packinglist_template('dir', 'wf-packinglist-template-body.php') . 'wf-packinglist-template-body.php';
						$content1.= ob_get_clean();
						if ($number_of_order_package > 1 && $order_package_loop < $number_of_order_package) {
							$content1.= "<p class=\"pagebreak\"></p><br/>";
						} else {
							$content1.= "<p class=\"no-page-break\"></p>";
						}
					}
					if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
						$content1.= "<p class=\"pagebreak\"></p><br/>";
					} else {
						$content1.= "<p class=\"no-page-break\"></p>";
					}
				} else {
					wp_die( __("Unable to print Packing List. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
				}
			}
			$content.= $content1;
			// building packinglist footer
			ob_start();
			include $this->wf_packinglist_template('dir', 'wf-template-footer.php') . 'wf-template-footer.php';
			$content.= ob_get_clean();
			// outputing content to client window
			echo $content;
			exit;
		}
		
		private function print_invoice($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			// building packinglist headers
			ob_start();
			$content = '';
			require_once $this->wf_packinglist_template('dir', 'wf-template-header.php') . 'wf-template-header.php';
			$content.= ob_get_clean();
			// building packinglist body
			$content1 = '';
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				ob_start();
				include $this->wf_packinglist_template('dir', 'wf-invoice-template-body.php') . 'wf-invoice-template-body.php';
				$content1.= ob_get_clean();
				if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
					$content1.= "<p class=\"pagebreak\"></p><br/>";
				}
				else {
					$content1.= "<p class=\"no-page-break\"></p>";
				}
			}
			$content.= $content1;
			// building packinglist footer
			ob_start();
			include $this->wf_packinglist_template('dir', 'wf-template-footer.php') . 'wf-template-footer.php';
			$content.= ob_get_clean();
			// outputing content to client window
			echo $content;
			exit;
		}
		
		private function print_deliverynote($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			//building packinglist headers
			ob_start();
			$content = '';
			require_once $this->wf_packinglist_template('dir', 'wf-template-header.php') . 'wf-template-header.php';
			$content.= ob_get_clean();
			//building packinglist body
			$content1 = '';
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$create_order_packages;
				if (in_array($action, $this->create_package_documents)) {
					$create_order_packages = $this->wf_pklist_create_order_package($order);
				}
				$order_package_loop = 0;
				$number_of_order_package = count($create_order_packages);
				if(!empty($create_order_packages)) {
					foreach ($create_order_packages as $order_package_id => $order_package) {
						$order_package_loop++;
						ob_start();
						include $this->wf_packinglist_template('dir', 'wf-deliverynote-template-body.php') . 'wf-deliverynote-template-body.php';
						$content1.= ob_get_clean();
						if ($number_of_order_package > 1 && $order_package_loop < $number_of_order_package) {
							$content1.= "<p class=\"pagebreak\"></p><br/>";
						} else {
							$content1.= "<p class=\"no-page-break\"></p>";
						}
					}
					if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
						$content1.= "<p class=\"pagebreak\"></p><br/>";
					} else {
						$content1.= "<p class=\"no-page-break\"></p>";
					}
				} else {
					wp_die( __("Unable to print Delivery Note. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
				}
			}
			$content.= $content1;
			// building packinglist footer
			ob_start();
			include $this->wf_packinglist_template('dir', 'wf-template-footer.php') . 'wf-template-footer.php';
			$content.= ob_get_clean();
			// outputing content to client window
			echo $content;
			exit;
		}

		private function download_deliverynote($orders, $action)
		{
			$number_of_orders = count($orders);
			$order_loop = 0;
			include_once $this->wf_packinglist_template('dir', 'wf-deliverynote-pdf-template.php') . 'wf-deliverynote-pdf-template.php';
			$pdf_invoice_packinglist = new Pdf_Deliverynote();
			foreach($orders as $order_id) {
				$order_loop++;
				$order = new WC_Order($order_id);
				$create_order_packages;
				if (in_array($action, $this->create_package_documents)) {
					$create_order_packages = $this->wf_pklist_create_order_package($order);
				}
				$order_package_loop = 0;
				$number_of_order_package = count($create_order_packages);
				if(!empty($create_order_packages)) {
					foreach ($create_order_packages as $order_package_id => $order_package) {
						$order_package_loop++;
						$pdf_invoice_packinglist->init($this->wf_pklist_font_name, $this->wf_pklist_font_size);
						if ($this->wf_packinglist_get_companyname() != '') {
							$pdf_invoice_packinglist->add_Companyname($this->wf_packinglist_get_companyname());
						}
						$pdf_invoice_packinglist->packinglist_num($order->get_order_number());
						$pdf_invoice_packinglist->order_date(date("d-m-Y", strtotime($order->order_date)));
						$faddress=$this->wf_shipment_label_get_from_address(); 
						$pdf_invoice_packinglist->from_address($faddress);
						$pdf_invoice_packinglist->billing_address($order);
						$pdf_invoice_packinglist->shipping_address($order);
						$pdf_invoice_packinglist->OrderDetails_packinglist($order_package, $this);
					}
					if ($number_of_orders > 1 && $order_loop < $number_of_orders) {
					} else {
						if(isset($_GET['attaching_pdf'])){
							$pdf_invoice_packinglist->Output($this->wf_packinglist_plugin_path .'/'.$order->id ."-Deliverynote.pdf","F");
							unset($pdf_invoice_packinglist);
						}else{
							$pdf_invoice_packinglist->Output("#" . $order->get_order_number() . "-DeliveryNote.pdf", "I");
							exit;
						}
					}
				} else {
					wp_die( __("Unable to download Delivery Note. Please check the items in the order.", "wf-woocommerce-packing-list" ), "", array());
				}
			}
		}
		
		function wf_packinglist_template($type, $template)
		{
			$templates = array();
			if (file_exists(trailingslashit(get_stylesheet_directory()) . 'woocommerce/wf-template/' . $template)) {
				$templates['uri'] = trailingslashit(get_stylesheet_directory_uri()) . 'woocommerce/wf-template/';
				$templates['dir'] = trailingslashit(get_stylesheet_directory()) . 'woocommerce/wf-template/';
			}
			else {
				$templates['uri'] = $this->wf_packinglist_get_plugin_url() . '/wf-template/';
				$templates['dir'] = $this->wf_packinglist_get_plugin_path() . '/wf-template/';
			}
			return $templates[$type];
		}

		// to check preview is enabled for packinglist
		function wf_packinglist_preview()
		{
			return 'onload="window.print()"';
		}
		
		// function to add company name
		function wf_packinglist_get_companyname()
		{
			if (get_option('woocommerce_wf_packinglist_companyname') != '') {
				return get_option('woocommerce_wf_packinglist_companyname');
			}
		}

		// function to get template body table body content
		function wf_packinglist_get_table_content($order, $order_package, $show_price = false)
		{
			$return = "";
			$weight = 0;
			if (key_exists('Value',$order_package)) {
				$weight = ($order_package['Value'] != '') ? $order_package['Value'] : __('n/a', 'wf-woocommerce-packing-list');
			} else {
				foreach ($order_package as $order_package_individual_item) {
					$weight += (!empty($order_package_individual_item['weight'])) ? $order_package_individual_item['weight'] * $order_package_individual_item['quantity'] : __('n/a', 'wf-woocommerce-packing-list');
				}
			}
			$orderdetails = array(
				'order_id' => $order->get_order_number() ,
				'weight' => ($weight !='') ? $weight.' '.get_option('woocommerce_weight_unit') : __('n/a', 'wf-woocommerce-packing-list')
			);
			return apply_filters('wf_pklist_modify_label_order_details',$orderdetails);
		}

		// fucntion to load client scripts
		function wf_packinglist_client_scripts()
		{
			$version = '2.4.2';
			wp_register_script('woocommerce-packinglist-client-js', untrailingslashit(plugins_url('/', __FILE__)) . '/js/woocommerce-packinglist-client.js', array(
				'jquery'
			) , $version, true);
			if (is_page(get_option('woocommerce_view_order_page_id'))) {
				wp_enqueue_script('woocommerce-packinglist-client-js');
			}
		}

		// function to add menu in woocommerce
		function wf_packinglist_admin_menu()
		{
			global $packinglist_settings_page;
			$packinglist_settings_page = add_submenu_page('woocommerce', __('Print Options', 'wf-woocommerce-packing-list') , __('Print Options', 'wf-woocommerce-packing-list') , 'manage_woocommerce', 'wf_woocommerce_packing_list', array(
				$this,
				'wf_woocommerce_packinglist_printing_page'
			));
		}

		// function to add settings options in settings menu
		function wf_woocommerce_packinglist_printing_page()
		{
			// check user access limit
			if (!current_user_can('manage_woocommerce')) {
				die("You are not authorized to view this page");
			}
			// functions to upload media
			wp_enqueue_media();
			?>
			<div class="wrap">
				<div class="wf-banner updated below-h2">
					<p class="main">
					<ul>
						<li style='color:red;'><strong>Your Business is precious! Go Premium!</li></strong>
						<li><strong>- Various Packing Options like Box Packing, Weight Based Packing, Pack Items Indvidually and Single Package</strong></li>
						<li><strong>- Bulk printing Invoice, Packing List, Delivery Note & Label from Order List.</strong ></li>
						<li><strong>- Add your company logo as part of Label, Invoice and Packing List.</strong ></li>
						<li><strong>- Options to add customized return policy and footer.</strong ></li>
						<li><strong>- Customize Invoice Number by prefix,postfix and padding feature.</strong ></li>
						<li><strong>- Attach invoice and packing slip with Order Completion Email.</strong ></li>
						<li><strong>- Add addtional checkout fields SSN and VAT and display it on Invoice.</strong ></li>
						<li><strong>- WPML compatible. FR(French), DE(German) and DK(Danish) supported out of the box.</strong ></li>
						<li><strong>- Third Party Tracking Number and Shipment Date supported through code snippet.</strong ></li>
						<li><strong>- Timely compatibility updates and bug fixes.</strong ></li>
						<li><strong>- Premium Support:</strong> Faster and time bound response for support requests.</li>
						<li><strong>- More Features:</strong> Print Packing List, Print Invoice, Label in PDF format, 4x6 Label and Many more..</li>
					</ul>
					</p>
					<p><a href="http://www.xadapter.com/product/print-invoices-packing-list-labels-for-woocommerce/" target="_blank" class="button button-primary">Upgrade to Premium Version</a> <a href="http://packingslipwoodemo.wooforce.com/wp-admin/admin.php?page=wf_woocommerce_packing_list" target="_blank" class="button">Live Demo</a></p>
				</div>
				<style>
				.wf-banner img {
					float: right;
					margin-left: 1em;
					padding: 15px 0
				}
				</style>
				<div id="icon-options-general" class="icon32"><br/></div>
				<h2><?php _e('WooCommerce - Print Invoice, Packing Slip, Delivery Note & Label Settings (Basic)', 'wf-woocommerce-packing-list'); ?></h2>
				<?php
					if (isset($_POST['wf_packinglist_fields_submitted']) && $_POST['wf_packinglist_fields_submitted'] == 'submitted') {
						$this->wf_packinglist_settings_data_validate();
						foreach($_POST as $key => $value) {
							if (get_option($key) != $value) {
							if ($key == "woocommerce_wf_packinglist_boxes") {
								$value = $this->validate_box_packing_field($value);
							}
							update_option($key, $value);
						} else {
							if ($key == "woocommerce_wf_packinglist_boxes") {
								$value = $this->validate_box_packing_field($value);
							}
							$status = add_option($key, $value, '', 'no');
						}
					}
				?>
				<div id="message" class="updated fade"><p><strong><?php _e('Your settings have been saved.', 'wf-woocommerce-packing-list'); ?></strong></p></div>
				<?php
					$this->wf_pklist_init_fields();
				}
				?>
				<div id="content">			
					<style>
						#Invoice{display: none;}
						.active{ background-color: white ;}
						.settings_headings {
							font-size: 20px;
							padding: 8px 12px;
							margin: 0;
							line-height: 1.4;
							border-bottom: 1px solid #eee;
						}
						#Email{display: none;}
						.active{ background-color: white ;}
						.settings_headings {
							font-size: 20px;
							padding: 8px 12px;
							margin: 0;
							line-height: 1.4;
							border-bottom: 1px solid #eee;
						}
					</style>
					<form method="post" action="" id="packinglist_settings">
						<input type="hidden" name="wf_packinglist_fields_submitted" value="submitted">
						<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
							<ul>
								<li><a href="#" id="general_tab" style="margin-left:1px;" class="nav-tab active"  onclick="tabs(this, 'General')"><?php _e('General', 'wf-woocommerce-packing-list'); ?></a> </li>
								<li><a href="#" id="invoice_tab"class="nav-tab" onclick="tabs(this, 'Invoice')"><?php _e('Invoice', 'wf-woocommerce-packing-list'); ?></a></li> 
							</ul>
						</nav>	
						<div id="poststuff" style="padding:0px">
							<div class="postbox">
								<?php 
									//include generic settings
									include_once('includes/settings/generic_settings.php');
									include_once('includes/settings/invoice_settings.php');
								?>
							</div>
						</div>
						<p class="submit">
							<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'wf-woocommerce-packing-list'); ?>" />
						</p>
					</form>
				</div>
			</div>
			<?php
		}

		// function to add admin meta box
		function wf_packinglist_add_box()
		{
			add_meta_box('woocommerce-packinglist-box', __('Print Actions', 'wf-woocommerce-packing-list') , array(
				$this,
				'woocommerce_packinglist_create_box_content'
			) , 'shop_order', 'side', 'default');
		}

		// function to add content to meta boxes
		function woocommerce_packinglist_create_box_content()
		{
			global $post;
			$order = new WC_Order($post->ID);
			?>
			<table class="form-table">
				<tr>
					<td><a class="button tips wf-packing-list-link" target="_blank" data-tip="<?php
					esc_attr_e('Print Invoice', 'wf-woocommerce-packing-list'); ?>" href="<?php
					echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=print_invoice') , 'print-packinglist'); ?>"><img src="<?php
					echo $this->wf_packinglist_get_plugin_url() . '/assets/images/invoice-icon.png'; //exit();
					 ?>" alt="<?php
					esc_attr_e('Print Invoice', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
					_e('Print Invoice', 'wf-woocommerce-packing-list'); ?></a>
					</td>
				</tr>
				<tr>
					<td><a class="button tips wf-packing-list-link" target="_blank" data-tip="<?php
					esc_attr_e('Print Packing List', 'wf-woocommerce-packing-list'); ?>" href="<?php
					echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=print_packing_list') , 'print-packinglist'); ?>"><img src="<?php
					echo $this->wf_packinglist_get_plugin_url() . '/assets/images/packinglist-icon.png'; //exit();
					 ?>" alt="<?php
					esc_attr_e('Print Packing List', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
					_e('Print Packing List', 'wf-woocommerce-packing-list'); ?></a>
					</td>
				</tr>
				<tr>
					<td><a class="button tips wf-packing-list-link" target="_blank" data-tip="<?php
					esc_attr_e('Print Shipping Label', 'wf-woocommerce-packing-list'); ?>" href="<?php
					echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=print_shipment_label') , 'print-packinglist'); ?>"><img src="<?php
					echo $this->wf_packinglist_get_plugin_url() . '/assets/images/Label-print-icon.png'; //exit();
					 ?>" alt="<?php
					esc_attr_e('Print Shipping Label', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
					_e('Print Shipping Label', 'wf-woocommerce-packing-list'); ?></a>
					</td>
				</tr>
					<tr>
						<td><a class="button tips wf-packing-list-link" target="_blank" data-tip="<?php
						esc_attr_e('Print Delivery Note', 'wf-woocommerce-packing-list'); ?>" href="<?php
						echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=print_delivery_note') , 'print-packinglist'); ?>"><img src="<?php
						echo $this->wf_packinglist_get_plugin_url() . '/assets/images/packinglist-icon.png'; //exit();
						 ?>" alt="<?php
						esc_attr_e('Print Delivery Note', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
						_e('Print Delivery Note', 'wf-woocommerce-packing-list'); ?></a>
						</td>
					</tr>
					<tr>
						<td><a class="button tips wf-link" data-tip="<?php
						esc_attr_e('Download Invoice', 'wf-woocommerce-packing-list'); ?>" href="<?php
						echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=download_invoice') , 'print-packinglist'); ?>"><img src="<?php
						echo $this->wf_packinglist_get_plugin_url() . '/assets/images/pdf-icon.png'; //exit();
						 ?>" alt="<?php
						esc_attr_e('Download Invoice', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
						_e('Download Invoice', 'wf-woocommerce-packing-list'); ?></a>
						</td>
					</tr>
					<tr>
						<td><a class="button tips wf-link" data-tip="<?php
						esc_attr_e('Download PackingList', 'wf-woocommerce-packing-list'); ?>" href="<?php
						echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=download_packinglist') , 'print-packinglist'); ?>"><img src="<?php
						echo $this->wf_packinglist_get_plugin_url() . '/assets/images/pdf-icon.png'; //exit();
						 ?>" alt="<?php
						esc_attr_e('Download PackingList', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
						_e('Download PackingList', 'wf-woocommerce-packing-list'); ?></a>
						</td>
					</tr>
					<tr>
						<td><a class="button tips wf-link" data-tip="<?php
						esc_attr_e('Download Shipping Label', 'wf-woocommerce-packing-list'); ?>" href="<?php
						echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=download_shipment_label') , 'print-packinglist'); ?>"><img src="<?php
						echo $this->wf_packinglist_get_plugin_url() . '/assets/images/pdf-icon.png'; //exit();
						 ?>" alt="<?php
						esc_attr_e('Download Shipping Label', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
						_e('Download Shipping Label', 'wf-woocommerce-packing-list'); ?></a>
						</td>
					</tr>
						<tr>
							<td><a class="button tips wf-link" data-tip="<?php
							esc_attr_e('Download Delivery Note', 'wf-woocommerce-packing-list'); ?>" href="<?php
							echo wp_nonce_url(admin_url('?print_packinglist=true&post=' . $order->id . '&type=download_delivery_note') , 'print-packinglist'); ?>"><img src="<?php
							echo $this->wf_packinglist_get_plugin_url() . '/assets/images/pdf-icon.png'; //exit();
							 ?>" alt="<?php
							esc_attr_e('Download Delivery Note', 'wf-woocommerce-packing-list'); ?>" width="14">  <?php
							_e('Download Delivery Note', 'wf-woocommerce-packing-list'); ?></a>
							</td>
						</tr>
			</table>
			<?php
		}

		// function to add required javascript files
		function wf_packinglist_scripts()
		{
			wp_register_script('woocommerce-packinglist-js', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/js/woocommerce-packinglist.js', array(
				'jquery'
			) , '');
			wp_enqueue_script('woocommerce-packinglist-js');
			
		}

		function admin_scripts(){ 
			wp_enqueue_script('wc-enhanced-select');
			$plugin_url =  untrailingslashit(plugins_url('/', __FILE__));
			wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css');
			wp_enqueue_style('woocommerce_admin_box_pack_styles', $plugin_url  . '/assets/css/box_packing.css');
			wp_enqueue_style('wf_order_admin_styles',  untrailingslashit(plugins_url('/', __FILE__))  . '/assets/css/order-admin.css');
		}	
		
		// function to load scripts required for admin
		function wf_packinglist_admin_scripts($hook)
		{
			global $packinglist_settings_page;
			wp_enqueue_script('wf-order-admin-js', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/js/wf_order_admin.js', array('jquery') ,'');
			if ($hook != $packinglist_settings_page) {
				return;
			}
			// Version number for scripts
			$version = '2.4.2';
			wp_register_script('wf-packinglist-admin-js', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/js/woocommerce-packinglist-admin.js', array('jquery') , $version);
			wp_register_script('wf-packinglist-validate', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/js/jquery.validate.min.js', array('jquery') , $version);
			wp_register_script('wf_common', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/js/wf_common.js', array('jquery') , $version);
			wp_enqueue_script('wf-packinglist-admin-js');
			wp_enqueue_script('wf-packinglist-validate');
			wp_enqueue_script('wf_common');
		}

		// function to handle bulk actions

		function wf_packinglist_bulk_admin_footer()
		{
			?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						if (jQuery('[name=woocommerce_wf_invoice_as_ordernumber]').is(':checked')){
							jQuery('.invoice_hide').hide();
						}
						jQuery('[name=woocommerce_wf_invoice_as_ordernumber]').click(function(){
							if(this.checked) {
								jQuery('.invoice_hide').hide();
							}else jQuery('.invoice_hide').show();
						});
						jQuery('[name=woocommerce_wf_invoice_regenerate]').click(function(){
							if(this.checked) {
								jQuery('[name=woocommerce_wf_invoice_start_number]').prop("readonly", false);
							}else jQuery('[name=woocommerce_wf_invoice_start_number]').prop("readonly", true); 
						});
						jQuery('#order_status').change(function() {
							//  Select options for Invoice select Box 
							var multipleValues = jQuery('#order_status').val();
							var multipletext = []; 
							jQuery('#order_status :selected').each(function(i, selected){ 
							  multipletext[i] = jQuery(selected).text(); 
							});
							jQuery('#invoice_pdf').select2('val',''); 
							var select = jQuery('#invoice_pdf');
							jQuery('option', select).remove();	
							for (i = 0; i < multipleValues.length; i++) { 
								jQuery('<option>').val(multipleValues[i]).text(multipletext[i]).appendTo("select[id='invoice_pdf']");
							}
							//  Select options for Packinglist select Box 
							jQuery('#packinglist_pdf').select2('val',''); 
							var select = jQuery('#packinglist_pdf');
							jQuery('option', select).remove();	
							for (i = 0; i < multipletext.length; i++) { 
								jQuery('<option>').val(multipleValues[i]).text(multipletext[i]).appendTo("select[id='packinglist_pdf']");
							}
							//  Select options for Delivery Note select Box 
							jQuery('#deliverynote_pdf').select2('val',''); 
							var select = jQuery('#deliverynote_pdf');
							jQuery('option', select).remove();	
							for (i = 0; i < multipletext.length; i++) { 
								jQuery('<option>').val(multipleValues[i]).text(multipletext[i]).appendTo("select[id='deliverynote_pdf']");
							}
						});					
					}); 
				</script>
				<?php
		}

		// function to validate the length of the settings options
		function wf_packinglist_settings_data_validate()
		{
			if (strlen($_POST['woocommerce_wf_packinglist_companyname']) > 25) {
				$_POST['woocommerce_wf_packinglist_companyname'] = substr($_POST['woocommerce_wf_packinglist_companyname'], 0, 25);
			}
			
			if(!isset($_POST['woocommerce_wf_packinglist_contact_number'])) { 
				$_POST['woocommerce_wf_packinglist_contact_number'] = 'no'; 
			}
			
			if (strlen($_POST['woocommerce_wf_packinglist_sender_name']) > 25) {
				$_POST['woocommerce_wf_packinglist_sender_name'] = substr($_POST['woocommerce_wf_packinglist_sender_name'], 0, 25);
			}
			if (strlen($_POST['woocommerce_wf_packinglist_sender_address_line1']) > 25) {
				$_POST['woocommerce_wf_packinglist_sender_address_line1'] = substr($_POST['woocommerce_wf_packinglist_sender_address_line1'], 0, 25);
			}
			if (strlen($_POST['woocommerce_wf_packinglist_sender_address_line2']) > 25) {
				$_POST['woocommerce_wf_packinglist_sender_address_line2'] = substr($_POST['woocommerce_wf_packinglist_sender_address_line2'], 0, 25);
			}
			
			if(!isset($_POST['woocommerce_wf_invoice_as_ordernumber'])){
				$_POST['woocommerce_wf_invoice_as_ordernumber']="No";
			}
			if(!isset($_POST['woocommerce_wf_generate_for_orderstatus'])){
				$_POST['woocommerce_wf_generate_for_orderstatus']="";
			}
			
			if(!isset($_POST['woocommerce_wf_attach_image_packinglist'])){
				$_POST['woocommerce_wf_attach_image_packinglist']="No";
			}
			
			if(isset($_POST['woocommerce_wf_invoice_regenerate'])){
				if(trim($_POST['woocommerce_wf_invoice_start_number'])=="" or trim($_POST['woocommerce_wf_invoice_start_number'])==NULL){
					$_POST['woocommerce_wf_Current_Invoice_number']=$_POST['woocommerce_wf_invoice_start_number']=1;
				}else{
					$_POST['woocommerce_wf_Current_Invoice_number']=$_POST['woocommerce_wf_invoice_start_number'];
				}
			}else{
				if($_POST['woocommerce_wf_invoice_start_number']=="" or $_POST['woocommerce_wf_invoice_start_number']==NULL){
					$_POST['woocommerce_wf_Current_Invoice_number']=$_POST['woocommerce_wf_invoice_start_number']=1;
				}			
			}
		}

		function woocommerce_invoice_order_items_table($order, $show_price = FALSE)
		{
			$return = '';
			foreach($order->get_items() as $item) {
				// get the product; if this variation or product has been deleted, this will return null...
				$_product = $order->get_product_from_item($item);
				if($_product) {
					$image_id = get_post_thumbnail_id( $_product->id );
					$attachment = wp_get_attachment_image_src($image_id);
					$sku = $variation = '';
					$sku = $_product->get_sku();
					$item_meta = new WC_Order_Item_Meta($item);
					// first, is there order item meta avaialble to display?
					$variation;
					$variation = $item_meta->display(true, true);
					if (!$variation && $_product && isset($_product->variation_data)) {
						// otherwise (for an order added through the admin) lets display the formatted variation data so we have something to fall back to
						$variation = wc_get_formatted_variation($_product->variation_data, true);
					}
					if ($variation) {
						$variation = '<br/><small>' . $variation . '</small>';
					}
					$return.= '<tr>';
					if(get_option('woocommerce_wf_attach_image_packinglist')=='Yes' && $show_price===FALSE){
						$return.= '<td class="thumb column-thumb" data-colname="Image" style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">';
							if(!empty($attachment[0])){
								$return.='<a><img src="'.$attachment[0].'" class="attachment-thumbnail size-thumbnail wp-post-image" height="30" width="60"/></a>';
							}
						$return.='</td>';
					}
					$return .= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:10px; min-width: 60px; max-width: 70px; width: auto; word-wrap: break-word;">' . $sku . '</td>
								<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px; min-width: 430px; max-width: 450px; width: auto; word-wrap: break-word;">' . apply_filters('woocommerce_order_product_title', $item['name'], $_product) . $variation . '</td>';
					$return.='<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px; min-width: 70px; max-width: 90px; width: auto; word-wrap: break-word;">' . $item['qty'] . '</td>';
					if ($show_price) {
						$return.= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px; min-width: 140px; max-width: 160px; width: auto; word-wrap: break-word;">';
						if ($order->display_cart_ex_tax || !$order->prices_include_tax) {
							$ex_tax_label = ($order->prices_include_tax) ? 1 : 0;
							$return.= wc_price($order->get_line_subtotal($item) , array(
								'ex_tax_label' => $ex_tax_label
							));					
						} else {
							$return.= wc_price($order->get_line_subtotal($item, TRUE));
						}

						$return.= '</td>';
					} else {
						$return.= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">';
						$return.= ($_product && $_product->get_weight()) ? $_product->get_weight() * $item['qty'] . ' ' . get_option('woocommerce_weight_unit') : __('n/a', 'wf-woocommerce-packing-list');
						$return.= '</td>';
						if(get_option('woocommerce_wf_attach_price_packinglist')=='Yes'){
							$return.= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">';
							if ($order->display_cart_ex_tax || !$order->prices_include_tax) {
								$ex_tax_label = ($order->prices_include_tax) ? 1 : 0;
								$return.= wc_price($order->get_line_subtotal($item) , array(
									'ex_tax_label' => $ex_tax_label
								));					
							} else {
								$return.= wc_price($order->get_line_subtotal($item, TRUE));
							}
							$return.= '</td>';
						}
					}
					$return.= '</tr>';
				}
			}
			$return = apply_filters('woocommerce_packinglist_order_items_table', $return);
			return $return;
		}

		function woocommerce_packinglist_order_items_table($order, $show_price = FALSE)
		{
			$return = '';
			foreach($order as $id => $item) {
				$image_id = ($item['variation_id'] != '') ? get_post_thumbnail_id($item['variation_id']) : get_post_thumbnail_id($item['id']);
				$attachment = wp_get_attachment_image_src($image_id);
				if(($item['variation_id'] != '') && empty($attachment[0])) {
					$image_id = get_post_thumbnail_id($item['id']);
					$attachment = wp_get_attachment_image_src($image_id);
				}
				$return.= '<tr>';
				if (get_option('woocommerce_wf_attach_image_packinglist')=='Yes' && $show_price===FALSE) {
					$return.= '<td class="thumb column-thumb" data-colname="Image" style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">';
					if(!empty($attachment[0])){
						$dimensions = $this->wf_pklist_get_new_dimensions($attachment[0], 30, 40);
						$return.='<a><img src="'.$attachment[0].'" class="attachment-thumbnail size-thumbnail wp-post-image" height="'.$dimensions['height'].'" width="'.$dimensions['width'].'"/></a>';
					}
					$return.='</td>';
				}
				$variation = '';
				$variation = $item['variation_data'];
				$return .= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">' . $item['sku'] . '</td>';
				$return.= '
					<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">' . $item['name'].'<br/>'. $variation . '</td>
					<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">' . $item['quantity'] . '</td>';
					$return.= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">';
					$return.= ($item['weight'] !='') ? $item['weight'] * $item['quantity'] . ' ' . $this->weight_unit : __('n/a', 'wf-woocommerce-packing-list');
					$return.= '</td>';
					if (get_option('woocommerce_wf_attach_price_packinglist')=='Yes') {
						$currency=get_woocommerce_currency();
						$currency_symbol=get_woocommerce_currency_symbol( $currency );
						$return.= '<td style="color:black;text-align:center; border: 1px solid lightgrey; padding:5px;">'.$currency_symbol.$item['quantity']*$item['price'].'</td>';
					}
				$return.= '</tr>';
			}
			$return = apply_filters('woocommerce_packinglist_order_items_table', $return);
			return $return;
		}
		
		// function to check wheter the user has added shipping from address
		function wf_packinglist_check_from_address()
		{
			if (!(get_option('woocommerce_wf_packinglist_sender_name') != '' && get_option('woocommerce_wf_packinglist_sender_address_line1') != '' && get_option('woocommerce_wf_packinglist_sender_city') != '' && get_option('woocommerce_wf_packinglist_sender_country') != '' && get_option('woocommerce_wf_packinglist_sender_postalcode') != '')) {
				return true;
			} else {
				return false;
			}
		}

		// function to determine the size of the label
		function wf_shipment_label_get_label_size()
		{
			if (get_option('woocommerce_wf_packinglist_label_size') != '') {
				$var = get_option('woocommerce_wf_packinglist_label_size');
				return $var;
			}
		}

		// function to get shipping to address
		function wf_shipment_label_get_to_address($order)
		{
			$shipping_address = array();
			if ($_GET['type'] == 'print_shipment_label') {
				if (get_post_meta($order->id, '_wcmspackage', true)) {
					$packages = get_post_meta($order->id, '_wcmspackage', true);
					foreach($packages as $package) {
						echo '<p>' . WC()->countries->get_formatted_address($package['full_address']) . '</p>';
					}
				}
				else {
					echo '<p>' . $order->get_formatted_shipping_address() . '</p>';
				}
				if($this->wf_enable_contact_number == 'yes') {
					echo "<p><strong>";
					_e('Ph No : ', 'wf-woocommerce-shipment-label-printing');
					echo $order->billing_phone . '</strong></p>';
				}
			} else {
				$countries = new WC_Countries;
				$billing_country = get_post_meta($order->id,'_billing_country',true);
				$billing_state = get_post_meta($order->id,'_billing_state',true);
				$billing_state_full = ( $billing_country && $billing_state && isset( $countries->states[ $billing_country ][ $billing_state ] ) ) ? $countries->states[ $billing_country ][ $billing_state ] : $billing_state;
				$billing_country_full = ( $billing_country && isset( $countries->countries[ $billing_country ] ) ) ? $countries->countries[ $billing_country ] : $billing_country;
				$shipping_address = array(
					'first_name' => $order->shipping_first_name,
					'last_name' => $order->shipping_last_name,
					'company' => $order->shipping_company,
					'address_1' => $order->shipping_address_1,
					'address_2' => $order->shipping_address_2,
					'city' => $order->shipping_city,
					'state' => $billing_state_full,
					'postcode' => $order->shipping_postcode,
					'country' => $billing_country_full
				);
				if($this->wf_enable_contact_number == 'yes') {
					$shipping_address['phone'] = $order->billing_phone;
				}
			// clear the $countries object when we're done to free up memory
				unset($countries);
				return $shipping_address;
			}
		}

		// function to get shipping from address
		function wf_shipment_label_get_from_address()
		{
			$fromaddress = array();
			if (get_option('woocommerce_wf_packinglist_sender_name') != '') {
				$fromaddress['sender_name'] = get_option('woocommerce_wf_packinglist_sender_name');
			}
			if (get_option('woocommerce_wf_packinglist_sender_address_line1') != '') {
				$fromaddress['sender_address_line1'] = get_option('woocommerce_wf_packinglist_sender_address_line1');
			}
			if (get_option('woocommerce_wf_packinglist_sender_address_line2') != '') {
				$fromaddress['sender_address_line2'] = get_option('woocommerce_wf_packinglist_sender_address_line2');
			} else {
				$fromaddress['sender_address_line2'] = '';
			}
			if (get_option('woocommerce_wf_packinglist_sender_city') != '') {
				$fromaddress['sender_city'] = get_option('woocommerce_wf_packinglist_sender_city');
			}
			if (get_option('woocommerce_wf_packinglist_sender_country') != '') {
				$fromaddress['sender_country'] = get_option('woocommerce_wf_packinglist_sender_country');
			}
			if (get_option('woocommerce_wf_packinglist_sender_postalcode') != '') {
				$fromaddress['sender_postalcode'] = get_option('woocommerce_wf_packinglist_sender_postalcode');
			}
			return $fromaddress;
		}
		
		//function to determine the packaging type
		public function wf_pklist_create_order_package($order)
		{
			switch ($this->wf_package_type) {
				default:
					return $this->wf_pklist_create_order_single_package($order);
					break;
			}
		}
				
		//function to create packaging list and shipping lables package
		private function wf_pklist_create_order_single_package($order) 
		{
			$order_items = $order->get_items();
			$packinglist_package = array();
			foreach($order_items as $id => $item) {
				$product = $order->get_product_from_item($item);
				$sku = $variation = '';
				if ($product) {
					$sku = $product->get_sku();
					$item_meta = new WC_Order_Item_Meta($item);
					$variation = $item_meta->display(true, true);
					if (!$variation && $product && isset($product->variation_data)) {
						$variation = wc_get_formatted_variation($product->variation_data, true);
					}
					$variation_details = $product->product_type == 'variation' ? wc_get_formatted_variation($product->variation_data, true) : '';
					$variation_id = $product->product_type == 'variation' ? $product->variation_id : '';
					$packinglist_package[0][] = array(
						'sku' => $product->get_sku(),
						'name' => $product->get_title(),
						'type' => $product->product_type,
						'weight' => $product->get_weight(),
						'id' => $product->id,
						'variation_id' => $variation_id,
						'price' => $product->get_price(),
						'variation_data' => $variation_details,
						'quantity' => $item['qty']
					);
				}
			}
			return $packinglist_package;
		}
		
		//function to get new dimensions
		public function wf_pklist_get_new_dimensions($image_url, $target_height, $target_width)
		{
			$new_dimensions = array();
			$image_info = getimagesize($image_url);
			if (($image_info[1] <= $target_height) && ($image_info[0] <= $target_width)) {
				$new_dimensions['width'] = $image_info[0];
				$new_dimensions['height'] = $image_info[1];
			} else {
				$new_dimensions = $this->wf_pklist_get_calculate_new_dimensions($image_info[1], $image_info[0], $target_height, $target_width);
			}
			return $new_dimensions;
		}
		
		//function to resize image with aspect ratio
		public function wf_pklist_get_calculate_new_dimensions($current_height, $current_width, $target_height, $target_width)
		{
			$aspect_ratio;
			$new_dimensions = array(
				'height' => $current_height,
				'width' => $current_width
			);
			$calculate_dimensions = true;
			if ($current_height > $current_width) {
				$aspect_ratio = $target_height / $current_height;
			} else {
				$aspect_ratio = $target_width / $current_width;
			}
			while ($calculate_dimensions) {
				$new_dimensions['height'] = floor($aspect_ratio * $new_dimensions['height']);
				$new_dimensions['width'] = floor($aspect_ratio * $new_dimensions['width']);
				if (($new_dimensions['height']) > $target_height) {
					$aspect_ratio = $target_height / $new_dimensions['height'];
				} else if(($new_dimensions['width']) > $target_width) {
					$aspect_ratio = $target_width / $new_dimensions['width'];
				} else {
					$calculate_dimensions = false;
				}
			}
			return $new_dimensions;
		}
		
		//function to create available font list 
		public function wf_pklist_get_fonts()
		{
			return array(
				'arial' => 'Default'
				);
		}
		
		//function to determine the document name
		public function get_document_name($action)
		{
			$document_name;
			if($action == 'print_invoice' || $action == 'download_invoice') {
				$document_name = 'INVOICE:';
			}
			return apply_filters('wf_pklist_modify_document_name',$document_name);
		}
		
		//function to set labels used for invoice
		public function get_invoice_labels()
		{
			$labels = array(
				'document_name'       => 'INVOICE',
				'order_date'          => 'Order Date',
				'billing_address'     => 'Billing address',
				'shipping_address'    => 'Shipping address',
				'email'               => 'Email',
				'contact_number'      => 'Tel',
				'vat'                 => 'VAT',
				'ssn'                 => 'SSN',
				'sku'                 => 'SKU',
				'product_name'        => 'Product',
				'quantity'            => 'Quantity',
				'total_price'         => 'Total Price',
				'sub_total'           => 'Subtotal',
				'total'               => 'Total',
				'payment_method'      => 'Payment Method',
				'tracking_provider'   => 'Tracking provider',
				'tracking_number'     => 'Tracking number',
				'shipping'            => 'Shipping',
				'cart_discount'       => 'Cart Discount',
				'order_discount'      => 'Order Discount',
				'total_tax'           => 'Total Tax',
			);
			 return $labels;
		}
		
		//function to calculate size for columns in invoice
		public function get_table_column_sizes($order)
		{
			$table_column_content_sizes = array(
				'sku'          => 10,
				'product'      => 7,
				'quantity'     => 8,
				'total_price'  => 11
			);
			foreach($order->get_items() as $item) {
				$_product = $order->get_product_from_item($item);
				if($_product) {
					$image_id = get_post_thumbnail_id( $_product->id );
					$attachment = wp_get_attachment_image_src($image_id);
					$sku = $variation = '';
					$sku = $_product->get_sku();
					$item_meta = new WC_Order_Item_Meta($item);
					$variation;
					$variation = $item_meta->display(true, true);
					if (!$variation && $_product && isset($_product->variation_data)) {
						// otherwise (for an order added through the admin) lets display the formatted variation data so we have something to fall back to
						$variation = wc_get_formatted_variation($_product->variation_data, true);
					}
					$price = $order->get_line_subtotal($item);
					if(strlen($item['name']. $variation) > $table_column_content_sizes['product']) {
						$table_column_content_sizes['product'] = strlen($item['name']. $variation);
					}
					if(strlen($item['qty']) > $table_column_content_sizes['quantity']) {
						$table_column_content_sizes['quantity'] = strlen($item['qty']);
					}
					if(strlen($price) > $table_column_content_sizes['total_price']) {
						$table_column_content_sizes['total_price'] = strlen($price);
					}
				}
			}
			if(strlen($order->cart_discount) > $table_column_content_sizes['total_price']) {
				$table_column_content_sizes['total_price'] = strlen($order->cart_discount) + 2;
			}
			if(strlen($order->order_discount) > $table_column_content_sizes['total_price']) {
				$table_column_content_sizes['total_price'] = strlen($order->order_discount) + 2;
			}
			if(strlen($order->order_total) > $table_column_content_sizes['total_price']) {
				$table_column_content_sizes['total_price'] = strlen($order->order_total) + 2;
			}
			if(strlen($order->payment_method_title) > $table_column_content_sizes['total_price']) {
				$table_column_content_sizes['total_price'] = strlen($order->payment_method_title);
			}
			$total_width = 180;
			$table_column_sizes = array();
			$table_column_sizes['quantity'] = 3 * $table_column_content_sizes['quantity'];
			$table_column_sizes['price'] = 3 * $table_column_content_sizes['total_price'];
			$table_column_sizes['sku'] = 3 * $table_column_content_sizes['sku'];
			$table_column_sizes['product'] = 180 - ($table_column_sizes['quantity'] + $table_column_sizes['price'] + $table_column_sizes['sku']);
			return $table_column_sizes;
		}
	}
	new Wf_WooCommerce_Packing_List();
}