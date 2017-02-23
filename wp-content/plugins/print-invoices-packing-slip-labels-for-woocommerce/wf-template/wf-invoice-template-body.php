<div style='height:100%; width:100%;'>
	<header >
		<a class="print" href="#" onclick="window.print()" ><?php _e('Print', 'wf-woocommerce-packing-list'); ?></a>
		<div style="float:left; width:35%; text-align:left;"> 
			<strong>
				<div style="font-size:<?php echo $title_size;?>px;  margin-top:15px;">
					<?php
						_e($this->invoice_labels['document_name'].' : ', 'wf-woocommerce-packing-list');
						$invoice_number = $this->wf_generate_invoice_number($order);
						_e(' '.$invoice_number,'wf-woocommerce-packing-list');
					?>
				</div>
			</strong>
			<div style="margin-top:10px; font-size:<?php echo $title_size;?>px;"><?php
			_e(($this->invoice_labels['order_date'].' : '.date("d-m-Y", strtotime($order->order_date))) , 'wf-woocommerce-packing-list'); ?>
			</div>
		</div>
		<div style="float:left; width:45%; text-align:left; margin: 10px 20px 0 0;font-size:<?php echo $heading_size;?>px;">
			<?php _e($this->wf_packinglist_get_companyname() , 'wf-woocommerce-packing-list'); ?><br/>
		</div>
		<div style="float:right; text-align:left; width:25%; line-height: 20px;">
			<p style="font-size:<?php echo $content_size;?>px;margin-top:0px;">
				<?php 
					$faddress=$this->wf_shipment_label_get_from_address();
					foreach ($faddress as $key => $value) {
						if (!empty($value)) {
							_e($value,'wf-woocommerce-packing-list');
							echo '<br>';
						}
					}
				?>
			</p>
		</div>
		<div style="clear:both;"></div>
	</header>
	<div>
		<div class="article" >
			<header style="height: 200px;">
				<div style="float:left; width: 49%;font-size:<?php echo $title_size;?>px;">
					<p style="margin-bottom: 0px;"><strong><?php _e($this->invoice_labels['billing_address'].':', 'wf-woocommerce-packing-list'); ?></strong></p>
					<p style="font-size:<?php echo $content_size;?>px; line-height: 25px; margin-top: 5px;">
						<?php _e($order->get_formatted_billing_address() , 'wf-woocommerce-packing-list'); ?>
					</p>
					<div style="font-size:<?php echo $content_size;?>px;">
					<?php
						if ($order->billing_email){ ?>
						<p>
							<strong>
								<?php _e('Email:', 'wf-woocommerce-packing-list'); ?>
							</strong>
						<?php echo $order->billing_email; ?></p>
					<?php 
						}
						if ($order->billing_phone): ?>
						<p><strong><?php _e('Tel:', 'wf-woocommerce-packing-list'); ?></strong> <?php
						echo $order->billing_phone; ?></p>
					<?php endif;
						if ($order->billing_VAT): ?>
						<p><strong><?php _e('VAT:', 'wf-woocommerce-packing-list'); ?></strong> <?php echo $order->billing_VAT; ?></p>
					<?php endif;
						if ($order->billing_SSN): ?>
							<p><strong><?php _e('SSN:', 'wf-woocommerce-packing-list'); ?></strong> <?php echo $order->billing_SSN; ?></p>
						<?php endif; 
					?></div>
				</div>
				<div style="float:right; width: 49%;font-size:<?php echo $title_size;?>px;">
					<p style="margin-bottom: 0px;"><strong><?php _e($this->invoice_labels['shipping_address'].':', 'wf-woocommerce-packing-list'); ?></strong></p>
					<div style="font-size:<?php echo $content_size;?>px; line-height: 25px;  margin-top: 5px;">
						<?php
							if (get_post_meta($order_id, '_wcms_packages', true)) { 
								$packages = get_post_meta($order_id, '_wcms_packages', true);
								foreach($packages as $package):
									echo '<p style="margin-top: 0px;">' . WC()->countries->get_formatted_address($package['full_address']) . '</p>';
								endforeach;
							} else { 
						?>
						<p style="margin-top: 0px;"><?php echo $order->get_formatted_shipping_address(); ?></p>
						<?php }
							if (get_post_meta($order_id, '_tracking_provider', true)): ?>
								<p>
									<strong><?php _e($this->invoice_labels['tracking_provider'].':', 'wf-woocommerce-packing-list'); ?></strong> 
									<?php	echo get_post_meta($order_id, '_tracking_provider', true); ?>
								</p>
						<?php endif;
							if (get_post_meta($order_id, '_tracking_number', true)): ?>
								<p>
									<strong><?php _e($this->invoice_labels['tracking_number'].':', 'wf-woocommerce-packing-list'); ?></strong> 
									<?php echo get_post_meta($order_id, '_tracking_number', true); ?>
								</p><?php endif; ?>
					</div>
				</div>
				<div style="clear:both;"></div>
			</header>
			<div class="datagrid">
			<?php
				if ($action == 'print_invoice') { 
				$table_column_sizes = $this->get_table_column_sizes($order);
			?>
					<table class="tableclass" style="width: 100%; border-collapse: collapse;border-bottom-width: thin; border-top-width: thick; border-top-color: #1e73be;" cellspacing="0" cellpadding="0">
						<tr style="background-color:#1e73be; color: #FFFFFF;width:100%; font-size:<?php echo $title_size;?>px;">
							<th scope="col" style="text-align:center; border: 1px solid #1e73be; border-top-width: thin; padding: 5px;">
							<?php _e($this->invoice_labels['sku'], 'wf-woocommerce-packing-list'); ?></th>
							<th scope="col" style="text-align:center; border: 1px solid #1e73be; border-top-width: thin; padding: 5px;">
							<?php _e($this->invoice_labels['product_name'], 'wf-woocommerce-packing-list'); ?></th>
							<th scope="col" style="text-align:center; border: 1px solid #1e73be; border-top-width: thin; padding: 5px;">
							<?php _e($this->invoice_labels['quantity'], 'wf-woocommerce-packing-list'); ?></th>
							<th scope="col" style="text-align:center; border: 1px solid #1e73be; border-top-width: thin; padding: 5px;">
							<?php _e($this->invoice_labels['total_price'], 'wf-woocommerce-packing-list'); ?></th>
						</tr>
						<tfoot style="font-size:<?php echo $content_size;?>px;">
							<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;">
								<th colspan="2" style="color:black;text-align:center; border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; border-bottom: 1px solid lightgrey; padding: 5px;">
								<?php _e($this->invoice_labels['sub_total'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php _e($order->get_subtotal_to_display() , 'wf-woocommerce-packing-list'); ?></td>
							</tr>
							<?php if (get_option('woocommerce_calc_shipping') == 'yes'): ?>
							<tr style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<th colspan="2" style="color:black;text-align:center;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['shipping'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php
									$Shippingdetials= $order->get_items('shipping' );
									if(!empty($Shippingdetials)){
										foreach($Shippingdetials as $key){
											$Shipping=get_woocommerce_currency_symbol().' '.$key['cost'].' via '.$key['name'];
										}
									} else {
									$Shipping=$order->get_shipping_to_display();
									}
									_e($Shipping , 'wf-woocommerce-packing-list'); ?></td>

							</tr><?php endif;
								if ($order->cart_discount > 0): ?><tr style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['cart_discount'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php _e(wc_price($order->cart_discount) , 'wf-woocommerce-packing-list'); ?></td>
							</tr><?php endif;
								if ($order->order_discount > 0): ?><tr style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['order_discount'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php _e(wc_price($order->order_discount) , 'wf-woocommerce-packing-list'); ?></td>
							</tr><?php endif;
							// If there is more than one tax
							$tax_items = $order->get_tax_totals();
							if (count($tax_items) > 1):
								foreach($tax_items as $tax_item): ?>
								<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;">
									<th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
									<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
									<?php _e(esc_html($tax_item->label) , 'wf-woocommerce-packing-list'); ?>:</th>
									<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
									<?php _e(wc_price($tax_item->amount) , 'wf-woocommerce-packing-list'); ?></td>
								</tr>
							<?php endforeach; ?>
							<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;width:100%;">
								<th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['total_tax'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php _e(wc_price($order->get_total_tax()) , 'wf-woocommerce-packing-list'); ?></td>
							</tr>
							<!-- if there is only one tax... -->
							<?php else:
								foreach($tax_items as $tax_item): ?>
								<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;width:100%;">
									<th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
									<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
									<?php _e(esc_html($tax_item->label) , 'wf-woocommerce-packing-list'); ?>:</th>
									<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
									<?php _e(wc_price($tax_item->amount) , 'wf-woocommerce-packing-list'); ?></td>
							</tr><?php
								endforeach;
							endif; ?>
							<!-- end if -->
							<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;width:100%;">
							  <th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['total'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php 
									_e(wc_price($order->order_total) , 'wf-woocommerce-packing-list');
								?>
								</td>
							</tr>
							<tr style="color:black;text-align:center;border-bottom: 1px solid lightgrey;width:100%;">
							  <th colspan="2" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">&nbsp;</th>
								<th scope="row" style="color:black;text-align:center; padding: 3px;border-bottom: 1px solid lightgrey;">
								<?php _e($this->invoice_labels['payment_method'].':', 'wf-woocommerce-packing-list'); ?></th>
								<td style="color:black;text-align:center; padding: 5px; border-bottom: 1px solid lightgrey;border-top: 1px solid lightgrey;border-left: 1px solid lightgrey;">
								<?php 
									_e(ucwords($order->payment_method_title) , 'wf-woocommerce-packing-list'); 
								?>
								</td>
							</tr>
						</tfoot>
					<tbody style="font-size:<?php echo $content_size;?>px;">
					<?php _e($this->woocommerce_invoice_order_items_table($order, true) , 'wf-woocommerce-packing-list'); ?>
					</tbody>
				</table>
				<?php
				} ?>
			<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>