<div class="row">
              <div class="col-xs-12 col-sm-12">
            <a href="<?php echo base_url()?>invoices/update/<?php echo $invoice->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-edit visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_edit_invoice');?></span></a>
			<?php if($invoice->estimate_status != "Invoiced" && $invoice->invoice_type != 'Shipment'){ ?><a href="<?php echo base_url()?>invoices/item/<?php echo $invoice->id;?>" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-plus visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_item');?></span></a><?php } ?>
				  <?php if($invoice->invoice_type == 'Shipment'){ ?><a href="<?php echo base_url()?>invoices/addTracking/<?php echo $invoice->id;?>" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-plus visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_tracking');?></span></a><?php } ?>
				  <a href="<?php echo base_url()?>invoices/payment/<?php echo $invoice->id;?>" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-credit-card visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_payment');?></span></a>
			
			<a href="<?php echo base_url()?>invoices/preview/<?php echo $invoice->id;?>" class="btn btn-primary"><i class="fa fa-file visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_preview');?></span></a>
			<!-- <a href="<?php echo base_url()?>invoices/previewHTML/<?php echo $invoice->id;?>" class="btn btn-primary" target="_blank"><i class="fa fa-file visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_HTML_Preview');?></span></a>-->
			<?php if($invoice->status != "Paid" && isset($invoice->company->name)){ ?><a href="<?php echo base_url()?>invoices/sendinvoice/<?php echo $invoice->id;?>" class="btn btn-primary"><i class="fa fa-envelope visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_send_invoice_to_client');?></span></a><?php } ?>

              </div>
          </div>
          <div class="row">

		<div class="col-md-12">
			<div class="table-head"><?php if($invoice->invoice_type != 'Shipment') {echo $this->lang->line('application_invoice_details'); } else { echo $this->lang->line('application_shipping_plan_detaile_title'); }?></div>
		<div class="subcont">
		<ul class="details col-xs-12 col-sm-6">
			<li><span><?php echo $this->lang->line('application_invoice_id');?>:</span> <?php echo $core_settings->invoice_prefix;?><?php echo $invoice->reference;?></li>
			<li class="<?php echo $invoice->status;?>"><span><?php echo $this->lang->line('application_status');?>:</span>
			<a class="label label-default <?php $unix = human_to_unix($invoice->sent_date.' 00:00'); $unix2 = human_to_unix($invoice->paid_date.' 00:00'); if($invoice->status == "Paid"){echo 'label-success tt" title="'.date($core_settings->date_format, $unix2);}elseif($invoice->status == "Sent"){ echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);} ?>"><?php echo $this->lang->line('application_'.$invoice->status);?>
			</a>
			</li>
			<li><span><?php echo $this->lang->line('application_issue_date');?>:</span> <?php $unix = human_to_unix($invoice->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<li><span><?php echo $this->lang->line('application_due_date');?>:</span> <a class="label label-default <?php if($invoice->status == "Paid"){echo 'label-success';} if($invoice->due_date <= date('Y-m-d') && $invoice->status != "Paid"){ echo 'label-important tt" title="'.$this->lang->line('application_overdue'); } ?>"><?php $unix = human_to_unix($invoice->due_date.' 00:00'); echo date($core_settings->date_format, $unix);?></a></li>
			<?php if(isset($invoice->company->vat)){?> 
			<li><span><?php echo $this->lang->line('application_vat');?>:</span> <?php echo $invoice->company->vat; ?></li>
			<?php } ?>
			<?php if(isset($invoice->project->name)){?>
			<li><span><?php echo $this->lang->line('application_projects');?>:</span> <?php echo $invoice->project->name; ?></li>
			<?php } ?>

			<span class="visible-xs"></span>
		</ul>
			<?php if($invoice->invoice_type != 'Shipment'){ ?>
				<ul class="details col-xs-12 col-sm-6">
					<?php if(isset($invoice->company->name)){ ?>
						<li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $invoice->company->id;?>" class="label label-info"><?php echo $invoice->company->name;?></a></li>
						<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($invoice->company->client->firstname)){ ?><?php echo $invoice->company->client->firstname;?> <?php echo $invoice->company->client->lastname;?> <?php }else{echo "-";} ?></li>

						<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $invoice->company->address;?></li>
						<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $invoice->company->zipcode;?> <?php echo $invoice->company->city;?></li>
						<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $invoice->company->province = empty($invoice->company->province) ? "-" : $invoice->company->province; ?></li>
					<?php }else{ ?>
						<li><?php echo $this->lang->line('application_no_client_assigned');?></li>
					<?php } ?>
				</ul>
			<?php } ?>
		<br clear="all">
		</div>
		</div>
		</div>

<?php if($invoice->invoice_type == 'Shipment'){ ?>
	<div class="row">
		<div class="col-md-6">

			<div class="table-head"><?php echo $this->lang->line('application_billing_address_label');?></div>

			<ul class="details col-md-12 subcont">
				<?php if(count($invoice_addresses) > 0){ foreach($invoice_addresses as $invoice_address){ ?>
					<?php if(!empty($invoice_address->billing_company)){ ?><li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="#" class="label label-info"><?php echo $invoice_address->billing_company;?></a></li><?php } ?>
					<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php echo $invoice_address->billing_name;?></li>
					<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $invoice_address->billing_address;?></li>
					<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $invoice_address->billing_city;?></li>
					<li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $invoice_address->billing_zip;?></li>
					<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $invoice_address->billing_state = empty($invoice_address->billing_state) ? "-" : $invoice_address->billing_state; ?></li>
					<li><span><?php echo $this->lang->line('application_country');?>:</span> <?php echo $invoice_address->billing_country;?></li>
					<?php if(!empty($invoice_address->billing_phone)){ ?><li><span><?php echo $this->lang->line('application_phone');?>:</span> <?php echo $invoice_address->billing_phone;?></li><?php } ?>
					<?php if(!empty($invoice_address->billing_email)){ ?><li><span><?php echo $this->lang->line('application_email');?>:</span> <?php echo $invoice_address->billing_email;?></li><?php } ?>
					<?php if(!empty($invoice_address->billing_website)){ ?><li><span><?php echo $this->lang->line('application_website');?>:</span> <?php echo $invoice_address->billing_website;?></li><?php } ?>

				<?php } }else if(isset($invoice->company->name)){ ?>
					<li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $invoice->company->id;?>" class="label label-info"><?php echo $invoice->company->name;?></a></li>
					<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($invoice->company->client->firstname)){ ?><?php echo $invoice->company->client->firstname;?> <?php echo $invoice->company->client->lastname;?> <?php }else{echo "-";} ?></li>
					<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $invoice->company->address;?></li>
					<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $invoice->company->city;?></li>
					<li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $invoice->company->zipcode;?></li>
					<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $invoice->company->province = empty($invoice->company->province) ? "-" : $invoice->company->province; ?></li>
				<?php }else{ ?>

				<?php } ?>
			</ul>

		</div>

		<div class="col-md-6">
			<div class="table-head"><?php echo $this->lang->line('application_shipping_address_label');?></div>

			<ul class="details col-md-12 subcont">
				<?php if(count($invoice_addresses) > 0){ foreach($invoice_addresses as $invoice_address){ ?>
					<?php if(!empty($invoice_address->shipping_company)){ ?><li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="#" class="label label-info"><?php echo $invoice_address->shipping_company;?></a></li><?php } ?>
					<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php echo $invoice_address->shipping_name;?></li>
					<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $invoice_address->shipping_address;?></li>
					<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $invoice_address->shipping_city;?></li>
					<li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $invoice_address->shipping_zip;?></li>
					<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $invoice_address->shipping_state = empty($invoice_address->shipping_state) ? "-" : $invoice_address->shipping_state; ?></li>
					<li><span><?php echo $this->lang->line('application_country');?>:</span> <?php echo $invoice_address->shipping_country;?></li>
					<?php if(!empty($invoice_address->shipping_phone)){ ?><li><span><?php echo $this->lang->line('application_phone');?>:</span> <?php echo $invoice_address->shipping_phone;?></li><?php } ?>
					<?php if(!empty($invoice_address->shipping_email)){ ?><li><span><?php echo $this->lang->line('application_email');?>:</span> <?php echo $invoice_address->shipping_email;?></li><?php } ?>
					<?php if(!empty($invoice_address->shipping_website)){ ?><li><span><?php echo $this->lang->line('application_website');?>:</span> <?php echo $invoice_address->shipping_website;?></li><?php } ?>

				<?php } }else if(isset($invoice->company->name)){ ?>
					<li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $invoice->company->id;?>" class="label label-info"><?php echo $invoice->company->name;?></a></li>
					<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($invoice->company->client->firstname)){ ?><?php echo $invoice->company->client->firstname;?> <?php echo $invoice->company->client->lastname;?> <?php }else{echo "-";} ?></li>
					<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $invoice->company->address;?></li>
					<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $invoice->company->city;?></li>
					<li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $invoice->company->zipcode;?></li>
					<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $invoice->company->province = empty($invoice->company->province) ? "-" : $invoice->company->province; ?></li>
				<?php }else{ ?>

				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">

			<div class="table-head"><?php echo $this->lang->line('application_shipping_details_label');?></div>

			<ul class="details col-md-12 subcont">
				<?php if($invoice->shipping_method != ''){?>
					<li><span><?php echo $this->lang->line('application_select_shipping_method');?>:</span> <?php echo $invoice->shipping_method;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_goods_description');?>:</span> <?php echo $invoice->shipping_goods_description;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_total_boxes');?>:</span> <?php echo $invoice->shipping_total_boxes;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_qty_per_box');?>:</span> <?php echo $invoice->shipping_qty_per_box;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_box_size_length');?>:</span> <?php echo $invoice->shipping_box_size_length;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_box_size_width');?>:</span> <?php echo $invoice->shipping_box_size_width;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_box_size_height');?>:</span> <?php echo $invoice->shipping_box_size_height;?></li>
					<li><span><?php echo $this->lang->line('application_shipping_box_weight');?>:</span> <?php echo $invoice->shipping_box_weight; ?></li>
				<?php } else {?>

					<?php foreach ($items as $value):?>

						<li><span><?php echo $this->lang->line('application_shipping_goods_description');?>:</span> <?php echo $value->name;?></li>
						<li><span><?php echo $this->lang->line('application_shipping_qty_require');?>:</span> <?php echo $value->amount; ?></li>

						<li><span><?php echo $this->lang->line('shipping_item_application_handling_fee');?>:</span> <?php echo $core_settings->currency.display_money(sprintf("%01.2f", $value->value));?> / <?php echo $this->lang->line('application_quantity');?></li>


						<li><span><?php echo $this->lang->line('application_select_shipping_method');?>:</span> <?php echo $value->shipping_method;?></li>
						<li><span><?php echo $this->lang->line('application_shipping_box_size_length');?>:</span> <?php echo $value->shipping_box_size_length;?></li>
						<li><span><?php echo $this->lang->line('application_shipping_box_size_width');?>:</span> <?php echo $value->shipping_box_size_width;?></li>
						<li><span><?php echo $this->lang->line('application_shipping_box_size_height');?>:</span> <?php echo $value->shipping_box_size_height;?></li>
						<li><span><?php echo $this->lang->line('application_shipping_box_weight');?>:</span> <?php echo $value->shipping_box_size_weight; ?></li>

					<?php endforeach; ?>
				<?php } ?>

			</ul>

		</div>

		<div class="col-md-6">
			<div class="table-head"><?php echo $this->lang->line('application_shipping_lebel');?></div>

			<div class="subcont" >
				<?php
				if(!empty($invoice->shipping_lebel)){
					$type = array_reverse(explode('.', $invoice->shipping_lebel));
					$type = strtolower($type[0]);

					$img_type = array('jpg' , 'jpeg', 'gif', 'png', 'bpm');

					if(in_array($type, $img_type)) {
						?>
						<img class="img-responsive"
							 src="<?php echo base_url() . 'files/media/' . $invoice->shipping_lebel; ?>"/>
						<?php
					}
					?>
					<br />
					<a href="<?php echo base_url()?>invoices/downloadLabel/<?php echo $invoice->id;?>" class="btn btn-xs btn-success"><i class="icon-download icon-white"></i> <?php echo $this->lang->line('application_download');?></a>

					<?php
				}
				?>
			</div>
		</div>
	</div>
<?php } ?>

		<div class="row">
		<div class="col-md-12">
		<div class="table-head"><?php echo $this->lang->line('application_invoice_items');?> <?php if($invoice->estimate_status != "Invoiced" && $invoice->invoice_type != 'Shipment'){ ?><span class=" pull-right"><a href="<?php echo base_url()?>invoices/item/<?php echo $invoice->id;?>" class="btn btn-md btn-primary" data-toggle="mainmodal"><i class="fa fa fa-plus visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_item');?></span></a></span><?php } ?></div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="items" rel="<?php echo base_url()?>cprojects/items" cellspacing="0" cellpadding="0">
		<thead>
		<th width="4%"><?php echo $this->lang->line('application_action');?></th>
			<th><?php echo $this->lang->line('application_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_description');?></th>
			<th class="hidden-xs" width="8%"><?php echo $this->lang->line('application_hrs_qty');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_unit_price');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php

		if($invoice->invoice_type == 'Shipment'){
			$item_type = 'invoice_has_shipping_items';
		}else{
			$item_type = 'invoice_has_items';
		}

		$invoice_item = $invoice->$item_type;

		foreach ($items as $value):?>
		<tr id="<?php echo $value->item_id;?>" >
		<td class="option" style="text-align:left;" width="8%">
		<?php if($invoice->estimate_status != "Invoiced"){ ?>
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="right" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>invoices/item_delete/<?php echo $invoice->invoice_has_items[$i]->id;?>/<?php echo $invoice->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>invoices/item_update/<?php echo $invoice_item[$i]->id;?>" title="<?php echo $this->lang->line('application_edit');?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
						<?php } else{ echo '<i class="btn-option fa fa-lock"></i>';}?>
			</td>
	
			<td><?php if(!empty($value->name)){echo $value->name;}else{ echo $invoice_item[$i]->name; }?></td>
			<td class="hidden-xs"><?php echo $invoice_item[$i]->description;?></td>
			<td class="hidden-xs" align="center"><?php echo $invoice_item[$i]->amount;?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->value));?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->amount*$invoice_item[$i]->value));?></td>

		</tr>
		
		<?php $sum = $sum+$invoice_item[$i]->amount*$invoice_item[$i]->value; $i++;?>
		
		<?php endforeach;
		if(empty($items)){ echo "<tr><td colspan='6'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
		if(substr($invoice->discount, -1) == "%"){ $discountpercent = TRUE; $discount = sprintf("%01.2f", round(($sum/100)*substr($invoice->discount, 0, -1), 2)); }
		else{$discount = $invoice->discount;}
		$sum = $sum-$discount;

		if($invoice->tax != ""){
			$tax_value = $invoice->tax;
		}else{
			$tax_value = $core_settings->tax;
		}

		if($invoice->second_tax != ""){
	      $second_tax_value = $invoice->second_tax;
	    }else{
	      $second_tax_value = $core_settings->second_tax;
	    }


		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$second_tax = sprintf("%01.2f", round(($sum/100)*$second_tax_value, 2));

    	$sum = sprintf("%01.2f", round($sum+$tax+$second_tax, 2));

    	$payments = $invoice->invoice_has_payments;
    	$sumRest = sprintf("%01.2f", round($sum-$invoice->paid, 2));
    	
		?>
		<?php if ($discount != 0): ?>
		<tr>
			<td colspan="5" align="right"><?php echo $this->lang->line('application_discount');?>  <?php if(isset($discountpercent)){ echo "(".$invoice->discount.")";}?></td>
			<td>- <?php echo display_money($discount);?></td>
		</tr>	
		<?php endif ?>
		<?php if ($tax_value != "0"){ ?>
		<tr>
			<td colspan="5" align="right"><?php echo $this->lang->line('application_tax');?> (<?php echo  $tax_value?>%)</td>
			<td><?php echo display_money($tax);?></td>
		</tr>
		<?php } ?>
		<?php if ($second_tax != "0"){ ?>
		<tr>
			<td colspan="5" align="right"><?php echo $this->lang->line('application_second_tax');?> (<?php echo  $second_tax_value?>%)</td>
			<td><?php echo display_money($second_tax);?></td>
		</tr>
		<?php } ?>
		
		<tr class="active">
			<td colspan="5" align="right"><?php echo $this->lang->line('application_total');?></td>
			<td><?php echo display_money($sum, $invoice->currency);?></td>
		</tr>
		
		</table>
		
		</div>
		<?php if (!empty($payments)){ ?>
		<div class="row">
		<div class="col-md-12">
		<div class="table-head"><?php echo $this->lang->line('application_payments');?> </div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="payments" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
			

		<thead>
			<th><?php echo $this->lang->line('application_action');?></th>
			<th><?php echo $this->lang->line('application_payment_id');?></th>
			<th><?php echo $this->lang->line('application_description');?></th>
			<th><?php echo $this->lang->line('application_type');?></th>
			<th><?php echo $this->lang->line('application_payment_date');?></th>
			<th><?php echo $this->lang->line('application_value');?></th>

		</thead>
		
		<?php
			$i = 0; 
			foreach ($payments as $value) {  ?>

				<tr class="sec">
					<td class="option" style="text-align:left;" width="8%">
						
					        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="right" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>invoices/payment_delete/<?php echo $payments[$i]->id;?>/<?php echo $invoice->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
					        <a href="<?php echo base_url()?>invoices/payment_update/<?php echo $payments[$i]->id;?>" title="<?php echo $this->lang->line('application_edit');?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
						
					</td>
					<td>#<?php echo $payments[$i]->reference;?></td>
					<td><?php echo $payments[$i]->notes;?></td>
					<td><?php echo $this->lang->line('application_'.$payments[$i]->type);?></td>
					<td><?php $unix = human_to_unix($payments[$i]->date.' 00:00'); echo date($core_settings->date_format, $unix);?></td>
					
					<td>- <?php echo display_money($payments[$i]->amount);?></td>
				</tr>
		<?php $i++; } ?>

		<tr class="payments">
			<td colspan="5" align="right"><?php echo $this->lang->line('application_payments_received');?></td>
			<td>- <?php echo display_money($invoice->paid);?></td>
		</tr>
		<tr class="active">
			<td colspan="5" align="right"><?php echo $this->lang->line('application_total_outstanding');?></td>
			<td><?php echo display_money($sumRest, $invoice->currency);?></td>
		</tr>

		</table>
		</div>
		</div>
		</div>
		<?php } ?>

		



		<div class="row">
		<div class=" col-md-12" align="right">
			<?php if($core_settings->paypal == "1" && $sum != "0.00" && $invoice->status != "Paid"){ 

				//Get currency
				# PHP ISO currency => name list
				$currency = $invoice->currency;
			    $currency_codes = array("AFA"=>"Afghani","AFN"=>"Afghani","ALK"=>"Albanian old lek","ALL"=>"Lek","DZD"=>"Algerian Dinar","USD"=>"US Dollar","ADF"=>"Andorran Franc","ADP"=>"Andorran Peseta","EUR"=>"Euro","AOR"=>"Angolan Kwanza Readjustado","AON"=>"Angolan New Kwanza","AOA"=>"Kwanza","XCD"=>"East Caribbean Dollar","ARA"=>"Argentine austral","ARS"=>"Argentine Peso","ARL"=>"Argentine peso ley","ARM"=>"Argentine peso moneda nacional","ARP"=>"Peso argentino","AMD"=>"Armenian Dram","AWG"=>"Aruban Guilder","AUD"=>"Australian Dollar","ATS"=>"Austrian Schilling","AZM"=>"Azerbaijani manat","AZN"=>"Azerbaijanian Manat","BSD"=>"Bahamian Dollar","BHD"=>"Bahraini Dinar","BDT"=>"Taka","BBD"=>"Barbados Dollar","BYR"=>"Belarussian Ruble","BEC"=>"Belgian Franc (convertible)","BEF"=>"Belgian Franc (currency union with LUF)","BEL"=>"Belgian Franc (financial)","BZD"=>"Belize Dollar","XOF"=>"CFA Franc BCEAO","BMD"=>"Bermudian Dollar","INR"=>"Indian Rupee","BTN"=>"Ngultrum","BOP"=>"Bolivian peso","BOB"=>"Boliviano","BOV"=>"Mvdol","BAM"=>"Convertible Marks","BWP"=>"Pula","NOK"=>"Norwegian Krone","BRC"=>"Brazilian cruzado","BRB"=>"Brazilian cruzeiro","BRL"=>"Brazilian Real","BND"=>"Brunei Dollar","BGN"=>"Bulgarian Lev","BGJ"=>"Bulgarian lev A/52","BGK"=>"Bulgarian lev A/62","BGL"=>"Bulgarian lev A/99","BIF"=>"Burundi Franc","KHR"=>"Riel","XAF"=>"CFA Franc BEAC","CAD"=>"Canadian Dollar","CVE"=>"Cape Verde Escudo","KYD"=>"Cayman Islands Dollar","CLP"=>"Chilean Peso","CLF"=>"Unidades de fomento","CNX"=>"Chinese People's Bank dollar","CNY"=>"Yuan Renminbi","COP"=>"Colombian Peso","COU"=>"Unidad de Valor real","KMF"=>"Comoro Franc","CDF"=>"Franc Congolais","NZD"=>"New Zealand Dollar","CRC"=>"Costa Rican Colon","HRK"=>"Croatian Kuna","CUP"=>"Cuban Peso","CYP"=>"Cyprus Pound","CZK"=>"Czech Koruna","CSK"=>"Czechoslovak koruna","CSJ"=>"Czechoslovak koruna A/53","DKK"=>"Danish Krone","DJF"=>"Djibouti Franc","DOP"=>"Dominican Peso","ECS"=>"Ecuador sucre","EGP"=>"Egyptian Pound","SVC"=>"Salvadoran colón","EQE"=>"Equatorial Guinean ekwele","ERN"=>"Nakfa","EEK"=>"Kroon","ETB"=>"Ethiopian Birr","FKP"=>"Falkland Island Pound","FJD"=>"Fiji Dollar","FIM"=>"Finnish Markka","FRF"=>"French Franc","XFO"=>"Gold-Franc","XPF"=>"CFP Franc","GMD"=>"Dalasi","GEL"=>"Lari","DDM"=>"East German Mark of the GDR (East Germany)","DEM"=>"Deutsche Mark","GHS"=>"Ghana Cedi","GHC"=>"Ghanaian cedi","GIP"=>"Gibraltar Pound","GRD"=>"Greek Drachma","GTQ"=>"Quetzal","GNF"=>"Guinea Franc","GNE"=>"Guinean syli","GWP"=>"Guinea-Bissau Peso","GYD"=>"Guyana Dollar","HTG"=>"Gourde","HNL"=>"Lempira","HKD"=>"Hong Kong Dollar","HUF"=>"Forint","ISK"=>"Iceland Krona","ISJ"=>"Icelandic old krona","IDR"=>"Rupiah","IRR"=>"Iranian Rial","IQD"=>"Iraqi Dinar","IEP"=>"Irish Pound (Punt in Irish language)","ILP"=>"Israeli lira","ILR"=>"Israeli old sheqel","ILS"=>"New Israeli Sheqel","ITL"=>"Italian Lira","JMD"=>"Jamaican Dollar","JPY"=>"Yen","JOD"=>"Jordanian Dinar","KZT"=>"Tenge","KES"=>"Kenyan Shilling","KPW"=>"North Korean Won","KRW"=>"Won","KWD"=>"Kuwaiti Dinar","KGS"=>"Som","LAK"=>"Kip","LAJ"=>"Lao kip","LVL"=>"Latvian Lats","LBP"=>"Lebanese Pound","LSL"=>"Loti","ZAR"=>"Rand","LRD"=>"Liberian Dollar","LYD"=>"Libyan Dinar","CHF"=>"Swiss Franc","LTL"=>"Lithuanian Litas","LUF"=>"Luxembourg Franc (currency union with BEF)","MOP"=>"Pataca","MKD"=>"Denar","MKN"=>"Former Yugoslav Republic of Macedonia denar A/93","MGA"=>"Malagasy Ariary","MGF"=>"Malagasy franc","MWK"=>"Kwacha","MYR"=>"Malaysian Ringgit","MVQ"=>"Maldive rupee","MVR"=>"Rufiyaa","MAF"=>"Mali franc","MTL"=>"Maltese Lira","MRO"=>"Ouguiya","MUR"=>"Mauritius Rupee","MXN"=>"Mexican Peso","MXP"=>"Mexican peso","MXV"=>"Mexican Unidad de Inversion (UDI)","MDL"=>"Moldovan Leu","MCF"=>"Monegasque franc (currency union with FRF)","MNT"=>"Tugrik","MAD"=>"Moroccan Dirham","MZN"=>"Metical","MZM"=>"Mozambican metical","MMK"=>"Kyat","NAD"=>"Namibia Dollar","NPR"=>"Nepalese Rupee","NLG"=>"Netherlands Guilder","ANG"=>"Netherlands Antillian Guilder","NIO"=>"Cordoba Oro","NGN"=>"Naira","OMR"=>"Rial Omani","PKR"=>"Pakistan Rupee","PAB"=>"Balboa","PGK"=>"Kina","PYG"=>"Guarani","YDD"=>"South Yemeni dinar","PEN"=>"Nuevo Sol","PEI"=>"Peruvian inti","PEH"=>"Peruvian sol","PHP"=>"Philippine Peso","PLZ"=>"Polish zloty A/94","PLN"=>"Zloty","PTE"=>"Portuguese Escudo","TPE"=>"Portuguese Timorese escudo","QAR"=>"Qatari Rial","RON"=>"New Leu","ROL"=>"Romanian leu A/05","ROK"=>"Romanian leu A/52","RUB"=>"Russian Ruble","RWF"=>"Rwanda Franc","SHP"=>"Saint Helena Pound","WST"=>"Tala","STD"=>"Dobra","SAR"=>"Saudi Riyal","RSD"=>"Serbian Dinar","CSD"=>"Serbian Dinar","SCR"=>"Seychelles Rupee","SLL"=>"Leone","SGD"=>"Singapore Dollar","SKK"=>"Slovak Koruna","SIT"=>"Slovenian Tolar","SBD"=>"Solomon Islands Dollar","SOS"=>"Somali Shilling","ZAL"=>"South African financial rand (Funds code) (discont","ESP"=>"Spanish Peseta","ESA"=>"Spanish peseta (account A)","ESB"=>"Spanish peseta (account B)","LKR"=>"Sri Lanka Rupee","SDD"=>"Sudanese Dinar","SDP"=>"Sudanese Pound","SDG"=>"Sudanese Pound","SRD"=>"Surinam Dollar","SRG"=>"Suriname guilder","SZL"=>"Lilangeni","SEK"=>"Swedish Krona","CHE"=>"WIR Euro","CHW"=>"WIR Franc","SYP"=>"Syrian Pound","TWD"=>"New Taiwan Dollar","TJS"=>"Somoni","TJR"=>"Tajikistan ruble","TZS"=>"Tanzanian Shilling","THB"=>"Baht","TOP"=>"Pa'anga","TTD"=>"Trinidata and Tobago Dollar","TND"=>"Tunisian Dinar","TRY"=>"New Turkish Lira","TRL"=>"Turkish lira A/05","TMM"=>"Manat","RUR"=>"Russian rubleA/97","SUR"=>"Soviet Union ruble","UGX"=>"Uganda Shilling","UGS"=>"Ugandan shilling A/87","UAH"=>"Hryvnia","UAK"=>"Ukrainian karbovanets","AED"=>"UAE Dirham","GBP"=>"Pound Sterling","USN"=>"US Dollar (Next Day)","USS"=>"US Dollar (Same Day)","UYU"=>"Peso Uruguayo","UYN"=>"Uruguay old peso","UYI"=>"Uruguay Peso en Unidades Indexadas","UZS"=>"Uzbekistan Sum","VUV"=>"Vatu","VEF"=>"Bolivar Fuerte","VEB"=>"Venezuelan Bolivar","VND"=>"Dong","VNC"=>"Vietnamese old dong","YER"=>"Yemeni Rial","YUD"=>"Yugoslav Dinar","YUM"=>"Yugoslav dinar (new)","ZRN"=>"Zairean New Zaire","ZRZ"=>"Zairean Zaire","ZMK"=>"Kwacha","ZWD"=>"Zimbabwe Dollar","ZWC"=>"Zimbabwe Rhodesian dollar");
				if(!array_key_exists($currency, $currency_codes)){
					$currency = $core_settings->paypal_currency;
				}

				?>
						<form action="https://www.paypal.com/cgi-bin/webscr" id="paypal" method="post">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $core_settings->paypal_account;?>">
						<input type="hidden" name="item_name" value="<?php echo $invoice->reference;?>">
						<input type="hidden" name="item_number" value="<?php echo $invoice->reference;?>">
						<input type="hidden" name="image_url" value="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>">
						<input type="hidden" name="amount" value="<?php echo $sumRest;?>">
						<input type="hidden" name="no_shipping" value="1">
						<input type="hidden" name="no_note" value="1">
						<input type="hidden" name="currency_code" value="<?php echo $currency;?>">
						<input type="hidden" name="bn" value="FC-BuyNow">
						<input type="hidden" name="return" value="<?php echo base_url()?>invoices/view/<?php echo $invoice->id;?>">
						<input type="hidden" name="cancel_return" value="<?php echo base_url()?>invoices/view/<?php echo $invoice->id;?>">
						<input type="hidden" name="rm" value="2">
						<input type="hidden" name="notify_url" value="<?php echo base_url()?>paypalipn" />
						<input type="hidden" name="custom" value="invoice-<?php echo $sumRest;?>">
						</form>
						<?php } ?>

	<div class="btn-group dropup">
	  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false" <?php if($sum == "0.00" || $invoice->status == "Paid"){ echo 'disabled="disabled" title="Invoice already paid"'; } ?>>
	    <?php echo $this->lang->line('application_pay_invoice');?> <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu dropdown-menu-right" role="menu">
	  <?php if($core_settings->bank_transfer == "1" && $sum != "0.00" && $invoice->status != "Paid" ){ ?>
	    <li><a id="pay_bank_transfer" data-toggle="mainmodal" href="<?php echo base_url()?>invoices/banktransfer/<?php echo $invoice->id;?>/<?php echo $sumRest;?>"><i class="fa fa-money" style="margin-right:5px"></i>  <?php echo $this->lang->line('application_bank_transfer');?></a></li>
	  <?php } ?>

	  <?php if($core_settings->paypal == "1" && $sum != "0.00" && $invoice->status != "Paid" ){ ?>  
	    <li><a id="pay_paypal" onclick="javascript:document.forms['paypal'].submit();" href="#"><i class="fa fa-paypal" style="margin-right:5px"></i>  <?php echo $this->lang->line('application_paypal');?></a></li>
	  <?php } ?>

	  <?php if($core_settings->stripe == "1" && $core_settings->authorize_net == "0" && $sum != "0.00" && $invoice->status != "Paid" ){ ?>  
	    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	    <li><a id="pay_credit_card" data-toggle="mainmodal" href="<?php echo base_url()?>invoices/stripepay/<?php echo $invoice->id;?>/<?php echo $sumRest;?>"><i class="fa fa-credit-card" style="margin-right:5px"></i> <?php echo $this->lang->line('application_credit_card');?></a></li>
	  <?php } ?>

	  <?php if($core_settings->stripe == "0" && $core_settings->authorize_net == "1" && $sum != "0.00" && $invoice->status != "Paid" ){ ?>  
	    <li><a id="pay_credit_card" data-toggle="mainmodal" href="<?php echo base_url()?>invoices/authorizenet/<?php echo $invoice->id;?>/<?php echo $sumRest;?>"><i class="fa fa-credit-card" style="margin-right:5px"></i> <?php echo $this->lang->line('application_credit_card');?></a></li>
	  <?php } ?>
	  </ul>
	</div>

</div>	
</div>




<br>



		</div>
		</div>

<?php if(count($trackings)) { ?><div class="row">
	<div class="col-md-12">
		<div class="table-head"><?php echo $this->lang->line('application_invoice_trackings');?></div>
		<div class="table-div min-height-200">
			<table class="table noclick" id="trackings" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th><?php echo $this->lang->line('application_tracking_id');?></th>
				<th class="hidden-xs"><?php echo $this->lang->line('application_tracking_desc');?></th>
				<th class="hidden-xs"><?php echo $this->lang->line('application_tracking_date');?></th>
				</tr></thead>

				<tbody>
				<?php foreach ($trackings as $value):?>
					<tr id="<?php echo $value->id;?>" >
						<td><?php echo $value->tracking_id; ?></td>
						<td class="hidden-xs"><?php echo $value->comments;?></td>
						<td class="hidden-xs"><span><?php $unix = human_to_unix($value->created.' 00:00'); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format, $unix);?></span></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

		</div>


	</div>
</div> <?php } ?>

		

