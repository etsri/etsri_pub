<div id="General" class="tabcontent">
	<h3 class="settings_headings"><?php	_e('Generic Settings :', 'wf-woocommerce-packing-list'); ?></h3>
	<div class="inside packinglist-printing-preview">
		<table class="form-table">
			<tr>
				<th><label for="woocommerce_wf_packinglist_companyname"><b><?php _e('Company Name', 'wf-woocommerce-packing-list'); ?></b></label></th>
				<td><input type="text" name="woocommerce_wf_packinglist_companyname" class="regular-text" value="<?php echo stripslashes(get_option('woocommerce_wf_packinglist_companyname')); ?>" /><br />
					<span class="description"><?php
						echo __('Your custom company name for the print. Not exceeding 25 characters. Remains will be discarded.', 'wf-woocommerce-packing-list');
						echo '<br /><strong>' . __('Note:', 'wf-woocommerce-packing-list') . '</strong> ';
						echo __('Leave blank to not to print a company name.', 'wf-woocommerce-packing-list');?>
					</span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="label_size"><b>
					<?php _e('Packaging Type', 'wf-woocommerce-packing-list'); ?></b>
					</label>
				</th>
				<td>
					<select name="woocommerce_wf_packinglist_package_type" id="woocommerce_wf_packinglist_package_type">
					<?php
						foreach ($this->wf_package_type_options as $id => $value) {
							if ($this->wf_package_type == $id) { ?>
								<option value=<?php _e($id, 'wf-woocommerce-packing-list'); ?> selected>
								<?php _e($value, 'wf-woocommerce-packing-list'); ?></option>
							<?php } else { ?>
								<option value=<?php _e($id, 'wf-woocommerce-packing-list'); ?> >
								<?php _e($value, 'wf-woocommerce-packing-list'); ?></option>
							<?php } 
						}?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="font_size"><b><?php _e('Font Size', 'wf-woocommerce-packing-list'); ?></b></label></th>
				<td>
					<select name="woocommerce_wf_packinglist_font_size">
						<?php 
							foreach($this->font_size_options as $id => $name) {
								if ($this->wf_pklist_font_size == $id) {
									echo '<option value="'.$id.'" selected>'. __($name, 'wf-woocommerce-packing-list').'</option>';
								} else {
									echo '<option value="'.$id.'">'. __($name, 'wf-woocommerce-packing-list').'</option>';
								}
							}
						?>
					</select>
					<span class="description">
					</span>
				</td>
			</tr>
		</table>
	</div>
	<h3 class="settings_headings"><?php	_e('Shipping From Address : ', 'wf-woocommerce-packing-list'); ?></h3>
		<div class="inside shipment-label-printing-preview">
			<table class="form-table">
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_name"><b><?php _e('Sender Name', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<input type="text" name="woocommerce_wf_packinglist_sender_name" class="regular-text" value="<?php echo stripslashes(get_option('woocommerce_wf_packinglist_sender_name')); ?>" /><br />
						<span class="description"><?php
							echo __('Sender name (Required for from address). Not exceeding 25 characters. Remains will be discarded.', 'wf-woocommerce-packing-list');?>
						</span>
					</td>
				</tr>
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_address_line1"><b><?php _e('Sender Address Line1', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<input type="text" name="woocommerce_wf_packinglist_sender_address_line1" class="regular-text" value="<?php	echo stripslashes(get_option('woocommerce_wf_packinglist_sender_address_line1')); ?>" /><br />
						<span class="description"><?php
							echo __('Sender Address Line1 (Required for from address). Not exceeding 25 characters. Remains will be discarded.', 'wf-woocommerce-packing-list');?>
						</span>
					</td>
				</tr>
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_address_line2"><b><?php _e('Sender Address Line2', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<input type="text" name="woocommerce_wf_packinglist_sender_address_line2" class="regular-text" value="<?php	echo stripslashes(get_option('woocommerce_wf_packinglist_sender_address_line2')); ?>" /><br />
						<span class="description"><?php	echo __('Sender Address Line2 (Optional). Not exceeding 25 characters. Remains will be discarded.', 'wf-woocommerce-packing-list');?></span>
					</td>
				</tr>
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_city"><b><?php _e('Sender City', 'wf-woocommerce-packing-list'); ?></b></label></th>
				<td>
					<input type="text" name="woocommerce_wf_packinglist_sender_city" class="regular-text" value="<?php	echo stripslashes(get_option('woocommerce_wf_packinglist_sender_city')); ?>" /><br />
						<span class="description"><?php echo __('Sender City(Required for from address).', 'wf-woocommerce-packing-list');?></span>
				</td>
				</tr>
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_country"><b><?php	_e('Sender Country', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<input type="text" name="woocommerce_wf_packinglist_sender_country" class="regular-text" value="<?php echo stripslashes(get_option('woocommerce_wf_packinglist_sender_country')); ?>" /><br />
						<span class="description"><?php	echo __('Sender Country (Required for from address).', 'wf-woocommerce-packing-list');?></span>
					</td>
				</tr>
				<tr>
					<th><label for="woocommerce_wf_packinglist_sender_postalcode"><b><?php	_e('Sender Postal Code', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<input type="text" name="woocommerce_wf_packinglist_sender_postalcode" class="regular-text" value="<?php echo stripslashes(get_option('woocommerce_wf_packinglist_sender_postalcode')); ?>" /><br />
						<span class="description"><?php		echo __('Sender Postal Code (Required for from address).', 'wf-woocommerce-packing-list');?></span>
					</td>
				</tr>
			</table>
		</div>
		<h3 class="settings_headings"><?php	_e('Shipping Label Settings :', 'wf-woocommerce-packing-list'); ?></h3>
		<div class="inside shipment-label-printing-preview">
			<table class="form-table">
				<tr>
					<th><label for="label_size"><b><?php _e('Shipping Label Size', 'wf-woocommerce-packing-list'); ?></b></label></th>
					<td>
						<select name="woocommerce_wf_packinglist_label_size">
							<option value='2' selected><?php _e('Full Page', 'wf-woocommerce-packing-list'); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><span><?php _e('Enable Contact Number', 'wf-woocommerce-packing-list'); ?></span></th>
					<td>
						<input type="checkbox" value="Yes" name="woocommerce_wf_packinglist_contact_number" class=""
						<?php if($this->wf_enable_contact_number == 'Yes') 
							_e('checked', 'wf-woocommerce-packing-list');					
						?> >
						<span class="description"><?php
							_e('Check to add Contact Number to Shipping Labels', 'wf-woocommerce-packing-list'); ?>
						</span>
					</td>
				</tr>
			</table>
		</div>
	<h3 class="settings_headings"><?php	_e('Packing List Settings :', 'wf-woocommerce-packing-list'); ?></h3>	
		<div class="inside shipment-label-printing-preview">
			<table class="form-table">
				<tr>
					<th>
						<span><?php _e('Include Item/Product Image', 'wf-woocommerce-packing-list'); ?></span>
					</th>
					<td>
						<input type="checkbox" value="Yes" name="woocommerce_wf_attach_image_packinglist" class=""
						<?php if(get_option('woocommerce_wf_attach_image_packinglist')== "Yes") 
							_e('checked', 'wf-woocommerce-packing-list');					
						?> >
					</td>
				</tr>
			</table>
		</div>
	</div>