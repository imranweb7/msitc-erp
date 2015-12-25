<div id="row">
	
		<div class="col-md-3">
			<div class="list-group">
				<?php foreach ($submenu as $name=>$value):
				$badge = "";
				$active = "";
				if($value == "settings/updates" && $update_count){ $badge = '<span class="badge badge-success">'.$update_count.'</span>';}
				if($value == "settings"){ $active = 'active';}?>
	               <a class="list-group-item <?php echo $active;?>" id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>"><?php echo $badge?> <?php echo $name?></a>
	            <?php endforeach;?>
			</div>
		</div>


<div class="col-md-9">
<div class="table-head"><?php echo $this->lang->line('application_settings');?></div>
<?php   
$attributes = array('class' => '', 'id' => 'settings_form');
echo form_open_multipart($form_action, $attributes); 
?>
<div class="table-div">
<br>
<div class="form-group">

            <input name="registration" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?php echo $this->lang->line('application_clients_can_register');?>" value="1" <?php if($settings->registration == "1"){ ?> checked="checked" <?php } ?>>

 </div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_company_name');?></label>
		<input type="text" name="company" class="required form-control" value="<?php echo $settings->company;?>" required>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_contact');?></label>
		<input type="text" name="invoice_contact" class="required form-control" value="<?php echo $settings->invoice_contact;?>" required>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_address');?></label>
		<input type="text" name="invoice_address" class="required form-control" value="<?php echo $settings->invoice_address;?>" required>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_city');?></label>
		<input type="text" name="invoice_city" class="required form-control" value="<?php echo $settings->invoice_city;?>" required>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_phone');?></label>
		<input type="text" name="invoice_tel" class="required form-control" value="<?php echo $settings->invoice_tel;?>" required>
	</div>
		<div class="form-group">
		<label><?php echo $this->lang->line('application_email');?></label>
		<input type="text" name="email" class="required form-control" value="<?php echo $settings->email;?>" required>
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_domain');?> <button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="left" data-content="Full URL to your Freelance Cockpit installation. Including subfolder i.e. http://www.yoursite.com/FC/" data-original-title="Domain URL"> <i class="fa fa-info-circle"></i></button>
		</label>
		<input type="text" name="domain" class="required form-control" value="<?php echo $settings->domain;?>" required>
			
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_logo');?> (max 200x200) <button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="right" data-content="<div class='logo' style='padding:10px'><img src='<?php echo $core_settings->logo;?>'></div>" data-original-title="<?php echo $this->lang->line('application_logo');?>"> <i class="fa fa-info-circle"></i></button>
		</label>
		<div class="form-group">
                <div><input id="uploadFile" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
            </div>
        </div>
                	
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_invoice');?> <?php echo $this->lang->line('application_logo');?>  (max 200x200) <button type="button" class="btn-option po " data-toggle="popover" data-placement="right"  data-content="<div style='padding:10px'><img src='<?php echo $core_settings->invoice_logo;?>'></div>" data-original-title="<?php echo $this->lang->line('application_invoice');?> <?php echo $this->lang->line('application_logo');?>"> <i class="fa fa-info-circle"></i></button>
		</label>
		
			<div class="form-group">
                <div>
                <input id="uploadFile2" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn2" type="file" name="userfile2" class="upload" />
                          </div>
                  </div>
              </div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_company_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="company_prefix"  value="<?php echo $settings->company_prefix;?>" class="form-control" >

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_invoice_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="invoice_prefix"  value="<?php echo $settings->invoice_prefix;?>" class="form-control" >

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_subscription_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="subscription_prefix"  value="<?php echo $settings->subscription_prefix;?>" class="form-control" >

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_project_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="project_prefix"  value="<?php echo $settings->project_prefix;?>" class="form-control">

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_quotation_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="quotation_prefix"  value="<?php echo $settings->quotation_prefix;?>" class="form-control" >

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_estimate_prefix');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="estimate_prefix"  value="<?php echo $settings->estimate_prefix;?>" class="form-control" placeholder="EST">

			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_tax');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="tax"  value="<?php echo $settings->tax;?>" class="form-control" placeholder="">
			 
			  <span class="input-group-addon">%</span>
			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_second_tax');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="second_tax"  value="<?php echo $settings->second_tax;?>" class="form-control" placeholder="">
			 
			  <span class="input-group-addon">%</span>
			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_vat');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="vat"  value="<?php echo $settings->vat;?>" class="form-control" placeholder="">
			 
			</div>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_default_currency');?></label>
		

			<div class="input-group col-md-3">
			  
			  <input type="text"  name="currency" class="form-control" value="<?php echo $settings->currency;?>">
			</div>
		
	</div>

	<div class="form-group">
		<label><?php echo $this->lang->line('application_default_template');?></label>
		 <?php $options = array();
			if ($handle = opendir('application/views/')) {

		        while (false !== ($entry = readdir($handle))) {
		              if ($entry != "." && $entry != ".." && $entry != "index.html") {
		              	$options[$entry] = ucwords($entry);
	                	}
				}
				closedir($handle);
			}
			echo form_dropdown('template', $options, $settings->template, 'style="width:250px" class="chosen-select"'); ?>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_default_language');?></label>
		 <?php $options = array();
			if ($handle = opendir('application/language/')) {

		        while (false !== ($entry = readdir($handle))) {
		              if ($entry != "." && $entry != "..") {
		              	$options[$entry] = ucwords($entry);
	                	}
				}
				closedir($handle);
			}
			echo form_dropdown('language', $options, $settings->language, 'style="width:250px" class="chosen-select"'); ?>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_date_format');?></label>
		 <?php $options = array(
			'F j, Y'  => date("F j, Y"),
			'Y/m/d'    => date("Y/m/d"),
			'm/d/Y' => date("m/d/Y"),
			'd/m/Y' => date("d/m/Y"),
			'd.m.Y' => date("d.m.Y"),
			'd-m-Y' => date("d-m-Y"),
			);
			echo form_dropdown('date_format', $options, $settings->date_format, 'style="width:250px" class="chosen-select"'); ?>
		
	</div>
	<div class="form-group">
		<label><?php echo $this->lang->line('application_date_time_format');?></label>
		 <?php $options = array(
			'g:i a'  => date("g:i a"),
			'g:i A'    => date("g:i A"),
			'H:i' => date("H:i"),
			);
			echo form_dropdown('date_time_format', $options, $settings->date_time_format, 'style="width:250px" class="chosen-select"'); ?>
		
	</div>

	<div class="form-group">
			  <label><?php echo $this->lang->line('application_money_format');?></label>
			  <?php $options = array(
			'1'  => "1,234.56",
			'2'  => "1.234,56",
			'3'  => "1234.56",
			'4'  => "1234,56",
			);
			echo form_dropdown('money_format', $options, $settings->money_format, 'style="width:100%" class="chosen-select"'); ?>
		
	</div>
	<div class="form-group">
			  <label><?php echo $this->lang->line('application_currency_position');?></label>
			  <?php $options = array(
			'1'  => "$ 100",
			'2'  => "100 $",
			);
			echo form_dropdown('money_currency_position', $options, $settings->money_currency_position, 'style="width:100%" class="chosen-select"'); ?>
		
	</div>
		<div class="form-group">
			<label><?php echo $this->lang->line('application_default_terms');?></label>
			<textarea class="textarea summernote" name="invoice_terms" rows="5"><?php echo $settings->invoice_terms;?></textarea>
		</div>
		<div class="form-group">
			 <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
			
		</div>

	</table>
	
	<?php echo form_close(); ?>
	</div>
	</div>

	</div>
