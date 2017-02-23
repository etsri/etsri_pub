<div id="Invoice" class="tabcontent">
	<h3 class="settings_headings"><?php	_e('Invoice Settings : ', 'wf-woocommerce-packing-list'); ?></h3>
	<div class="inside packinglist-printing-preview">
		<table class="form-table">
			<tr>
				<th><span><?php _e('Use Order Number as Invoice Number', 'wf-woocommerce-packing-list'); ?></span></th>
				<td>
					<input type="checkbox" value="Yes" name="woocommerce_wf_invoice_as_ordernumber" class=""
					<?php if(get_option('woocommerce_wf_invoice_as_ordernumber')== "Yes") 
						_e('checked', 'wf-woocommerce-packing-list');					
					?> >
				</td>
			</tr>
			<tr class="invoice_hide">
				<th></span><?php _e('Invoice Start Number', 'wf-woocommerce-packing-list'); ?></span></th>
				<td>	
					<input type="number" min="0" name="woocommerce_wf_invoice_start_number" readonly class=""
					value="<?php echo stripslashes(get_option('woocommerce_wf_invoice_start_number')); ?>">
				</td>	
			</tr>
			<tr class="invoice_hide">
				<th><span><?php _e('Reset Invoice Number', 'wf-woocommerce-packing-list'); ?></span></th>
				<td><input type="checkbox"  name="woocommerce_wf_invoice_regenerate" class=""></td>
			</tr>
			<tr>
				<th></span><?php _e('Generate Invoice For', 'wf-woocommerce-packing-list'); ?></span></th>
				<td>	
					<select style="width:350px" class="wc-enhanced-select" id="order_status" data-placeholder='Choose Order Status' name="woocommerce_wf_generate_for_orderstatus[]" multiple="multiple">
						<?php
						$statuses = wc_get_order_statuses();
						foreach($statuses as $key =>$value) {			
							echo "<option value=$key"; if(in_array($key,$this->wf_generate_invoice_for)) echo "  selected"; echo ">$value</option>";
						} ?>
					</select>
				</td>	
			</tr>
		</table>	
	</div>
</div>