 
          <div class="row">
              <div class="col-xs-12 col-sm-12">
            <a href="<?php echo base_url()?>estimates/update/<?php echo $estimate->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-edit visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_edit_estimate');?></span></a>
			<?php if($estimate->estimate_status != "Accepted" && $estimate->estimate_status != "Invoiced"){ ?><a href="<?php echo base_url()?>estimates/item/<?php echo $estimate->id;?>" class="btn btn-primary" data-toggle="mainmodal"><i class="fa fa-plus visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_item');?></span></a><?php } ?>
			<a href="<?php echo base_url()?>estimates/preview/<?php echo $estimate->id;?>" class="btn btn-primary"><i class="fa fa-file visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_preview');?></span></a>
			<?php if(($estimate->estimate_status == "Open" || $estimate->estimate_status == "Revised") && isset($estimate->company->name)){ ?><a href="<?php echo base_url()?>estimates/sendestimate/<?php echo $estimate->id;?>" class="btn btn-primary"><i class="fa fa-envelope visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_send_estimate_to_client');?></span></a><?php } ?>
			<?php if($estimate->estimate_status == "Accepted"){ ?><a href="<?php echo base_url()?>estimates/estimateToInvoice/<?php echo $estimate->id;?>" class="btn btn-success"><i class="fa fa-envelope visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_convert_to_invoice');?></span></a><?php } ?>
			<?php if($estimate->estimate_status == "Invoiced"){ ?><a href="<?php echo base_url()?>invoices/view/<?php echo $estimate->id;?>" class="btn btn-success"><i class="fa fa-envelope visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_go_to_invoice');?></span></a><?php } ?>


              </div>
          </div>
          <div class="row">

		<div class="col-md-12">
		<div class="table-head"><?php if($estimate->invoice_type != 'Shipment') { echo $this->lang->line('application_estimate_details'); } else { echo $this->lang->line('application_shipping_plan_detaile_title'); }?></div>
		<div class="subcont">
		<ul class="details col-xs-12 col-sm-6">
			<li><span><?php echo $this->lang->line('application_estimate_id');?>:</span> <?php echo $core_settings->estimate_prefix;?><?php echo $estimate->reference;?></li>
			<li class="<?php echo $estimate->estimate_status;?>"><span><?php echo $this->lang->line('application_status');?>:</span>
			<?php $unix = human_to_unix($estimate->estimate_sent.' 00:00'); 
					$change_date = "";
				switch($estimate->estimate_status){
					case "Open": $label = "label-default"; break;
					case "Accepted": $label = "label-success"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
					case "Sent": $label = "label-warning"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_sent.' 00:00')).'"'; break; 
					case "Declined": $label = "label-important"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
          			case "Invoiced": $label = "label-chilled"; $change_date = 'title="'.$this->lang->line('application_Accepted').' '.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
          			case "Revised": $label = "label-warning"; $change_date = 'title="'.$this->lang->line('application_Revised').' '.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
					
					default: $label = "label-default"; break;
				}
			?>
			<a class="label <?php echo $label?> tt" <?php echo $change_date;?>><?php echo $this->lang->line('application_'.$estimate->estimate_status);?>
			</a>
			</li>
			<li><span><?php echo $this->lang->line('application_issue_date');?>:</span> <?php $unix = human_to_unix($estimate->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<li><span><?php echo $this->lang->line('application_due_date');?>:</span> <?php $unix = human_to_unix($estimate->due_date.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<?php if(isset($estimate->company->vat)){?> 
			<li><span><?php echo $this->lang->line('application_vat');?>:</span> <?php echo $estimate->company->vat; ?></li>
			<?php } ?>
			<?php if(isset($estimate->project->name)){?>
			<li><span><?php echo $this->lang->line('application_projects');?>:</span> <?php echo $estimate->project->name; ?></li>
			<?php } ?>
			<span class="visible-xs"></span>
		</ul>
			<?php if($estimate->invoice_type != 'Shipment'){ ?>
				<ul class="details col-xs-12 col-sm-6">
			<?php if(isset($estimate->company->name)){ ?>
			<li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $estimate->company->id;?>" class="label label-info"><?php echo $estimate->company->name;?></a></li>
			<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($estimate->company->client->firstname)){ ?><?php echo $estimate->company->client->firstname;?> <?php echo $estimate->company->client->lastname;?> <?php }else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $estimate->company->address;?></li>
			<li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $estimate->company->zipcode;?> <?php echo $estimate->company->city;?></li>
			<li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $estimate->company->province = empty($estimate->company->province) ? "-" : $estimate->company->province; ?></li>
			<?php }else{ ?>
				<li><?php echo $this->lang->line('application_no_client_assigned');?></li>
			<?php } ?>
		</ul>
			<?php }else{
				?>
				<div class="col-xs-12 col-sm-6"> </div>

			<?php } ?>
		<br clear="all">
		</div>
		</div>
		</div>

		  <?php if($estimate->invoice_type == 'Shipment'){ ?>
			  <div class="row">
				  <div class="col-md-6">

					  <div class="table-head"><?php echo $this->lang->line('application_billing_address_label');?></div>

					  <ul class="details col-md-12 subcont">
						  <?php if(count($estimate_addresses) > 0){ foreach($estimate_addresses as $invoice_address){ ?>
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

						  <?php } }else if(isset($estimate->company->name)){ ?>
							  <li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $estimate->company->id;?>" class="label label-info"><?php echo $estimate->company->name;?></a></li>
							  <li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($invoice->company->client->firstname)){ ?><?php echo $estimate->company->client->firstname;?> <?php echo $estimate->company->client->lastname;?> <?php }else{echo "-";} ?></li>
							  <li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $estimate->company->address;?></li>
							  <li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $estimate->company->city;?></li>
							  <li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $estimate->company->zipcode;?></li>
							  <li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $estimate->company->province = empty($estimate->company->province) ? "-" : $estimate->company->province; ?></li>
						  <?php }else{ ?>

						  <?php } ?>
					  </ul>

				  </div>

				  <div class="col-md-6">
					  <div class="table-head"><?php echo $this->lang->line('application_shipping_address_label');?></div>

					  <ul class="details col-md-12 subcont">
						  <?php if(count($estimate_addresses) > 0){ foreach($estimate_addresses as $invoice_address){ ?>
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

						  <?php } }else if(isset($estimate->company->name)){ ?>
							  <li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $estimate->company->id;?>" class="label label-info"><?php echo $estimate->company->name;?></a></li>
							  <li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($invoice->company->client->firstname)){ ?><?php echo $estimate->company->client->firstname;?> <?php echo $estimate->company->client->lastname;?> <?php }else{echo "-";} ?></li>
							  <li><span><?php echo $this->lang->line('application_street');?>:</span> <?php echo $estimate->company->address;?></li>
							  <li><span><?php echo $this->lang->line('application_city');?>:</span> <?php echo $estimate->company->city;?></li>
							  <li><span><?php echo $this->lang->line('application_zip_code');?>:</span> <?php echo $estimate->company->zipcode;?></li>
							  <li><span><?php echo $this->lang->line('application_province');?>:</span> <?php echo $estimate->company->province = empty($estimate->company->province) ? "-" : $estimate->company->province; ?></li>
						  <?php }else{ ?>

						  <?php } ?>
					  </ul>
				  </div>
			  </div>

			  <div class="row">
				  <div class="col-md-6">

					  <div class="table-head"><?php echo $this->lang->line('application_shipping_details_label');?></div>

					  <ul class="details col-md-12 subcont">
						  <li><span><?php echo $this->lang->line('application_select_shipping_method');?>:</span> <?php echo $estimate->shipping_method;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_goods_description');?>:</span> <?php echo $estimate->shipping_goods_description;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_total_boxes');?>:</span> <?php echo $estimate->shipping_total_boxes;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_qty_per_box');?>:</span> <?php echo $estimate->shipping_qty_per_box;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_box_size_length');?>:</span> <?php echo $estimate->shipping_box_size_length;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_box_size_width');?>:</span> <?php echo $estimate->shipping_box_size_width;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_box_size_height');?>:</span> <?php echo $estimate->shipping_box_size_height;?></li>
						  <li><span><?php echo $this->lang->line('application_shipping_box_weight');?>:</span> <?php echo $estimate->shipping_box_weight; ?></li>
					  </ul>

				  </div>

				  <div class="col-md-6">
					  <div class="table-head"><?php echo $this->lang->line('application_shipping_lebel');?></div>

					  <div class="subcont" >
						  <?php
						  if(!empty($estimate->shipping_lebel)){
							  $type = array_reverse(explode('.', $estimate->shipping_lebel));
							  $type = strtolower($type[0]);

							  $img_type = array('jpg' , 'jpeg', 'gif', 'png', 'bpm');

							  if(in_array($type, $img_type)) {
								  ?>
								  <img class="img-responsive"
									   src="<?php echo base_url() . 'files/media/' . $estimate->shipping_lebel; ?>"/>
								  <?php
							  }
							  ?>
							  <br />
							  <a href="<?php echo base_url()?>estimates/download/<?php echo $estimate->id;?>" class="btn btn-xs btn-success"><i class="icon-download icon-white"></i> <?php echo $this->lang->line('application_download');?></a>

							  <?php
						  }
						  ?>
					  </div>
				  </div>
			  </div>
		  <?php } ?>

		<div class="row">
		<div class="col-md-12">
		<div class="table-head"><?php echo $this->lang->line('application_items');?> <?php if($estimate->estimate_status != "Accepted" && $estimate->estimate_status != "Invoiced"){ ?><span class=" pull-right"><a href="<?php echo base_url()?>estimates/item/<?php echo $estimate->id;?>" class="btn btn-md btn-primary" data-toggle="mainmodal"><i class="fa fa fa-plus visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_add_item');?></span></a></span> <?php } ?></div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="items" rel="<?php echo base_url()?>items" cellspacing="0" cellpadding="0">
		<thead>
			<th width="4%"><?php echo $this->lang->line('application_action');?></th>
			<th><?php echo $this->lang->line('item_application_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('item_application_description');?></th>
			<th class="hidden-xs" width="8%"><?php echo $this->lang->line('item_application_sku');?></th>
			<th class="hidden-xs" width="8%"><?php echo $this->lang->line('application_hrs_qty');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_unit_price');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php

		if($estimate->invoice_type == 'Shipment'){
			$item_type = 'invoice_has_shipping_items';
		}else{
			$item_type = 'invoice_has_items';
		}

		$invoice_item = $estimate->$item_type;

		foreach ($items as $value):?>
		<tr id="<?php echo $value->item_id;?>" >
		
		<td class="option" style="text-align:left;" width="8%">
				        <?php if($estimate->estimate_status != "Accepted" && $estimate->estimate_status != "Invoiced"){ ?>
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>estimates/item_delete/<?php echo $invoice_item[$i]->id;?>/<?php echo $estimate->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>estimates/item_update/<?php echo $invoice_item[$i]->id;?>" title="<?php echo $this->lang->line('application_edit');?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
						<?php } else{ echo '<i class="btn-option fa fa-lock"></i>';}?>
			</td>
	
			<td><?php if(!empty($value->name)){echo $value->name;}else{ echo $invoice_item[$i]->name; }?></td>
			<td class="hidden-xs"><?php echo $invoice_item[$i]->description;?></td>
			<td class="hidden-xs"><?php echo $invoice_item[$i]->sku;?></td>
			<td class="hidden-xs" align="center"><?php echo $invoice_item[$i]->amount;?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->value));?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->amount*$invoice_item[$i]->value));?></td>

		</tr>
		
		<?php $sum = $sum+$invoice_item[$i]->amount*$invoice_item[$i]->value; $i++;?>
		
		<?php endforeach;
		if(empty($items)){ echo "<tr><td colspan='7'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
		if(substr($estimate->discount, -1) == "%"){ $discountpercent = TRUE; $discount = sprintf("%01.2f", round(($sum/100)*substr($estimate->discount, 0, -1), 2)); }
		else{$discount = $estimate->discount;}
		$sum = $sum-$discount;

		if($estimate->tax != ""){
			$tax_value = $estimate->tax;
		}else{
			$tax_value = $core_settings->tax;
		}

		if($estimate->second_tax != ""){
	      $second_tax_value = $estimate->second_tax;
	    }else{
	      $second_tax_value = $core_settings->second_tax;
	    }

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$second_tax = sprintf("%01.2f", round(($sum/100)*$second_tax_value, 2));

    	$sum = sprintf("%01.2f", round($sum+$tax+$second_tax, 2));
		?>
		<?php if ($discount != 0): ?>
		<tr>
			<td colspan="6" align="right"><?php echo $this->lang->line('application_discount');?> <?php if(isset($discountpercent)){ echo "(".$estimate->discount.")";}?></td>
			<td>- <?php echo display_money($discount);?></td>
		</tr>	
		<?php endif ?>
		<?php if ($tax_value != "0"){ ?>
		<tr>
			<td colspan="6" align="right"><?php echo $this->lang->line('application_tax');?> (<?php echo  $tax_value?>%)</td>
			<td><?php echo display_money($tax)?></td>
		</tr>
		<?php } ?>
		<?php if ($second_tax != "0"){ ?>
		<tr>
			<td colspan="6" align="right"><?php echo $this->lang->line('application_second_tax');?> (<?php echo  $second_tax_value?>%)</td>
			<td><?php echo display_money($second_tax);?></td>
		</tr>
		<?php } ?>
		<tr class="active">
			<td colspan="6" align="right"><?php echo $this->lang->line('application_total');?></td>
			<td><?php echo display_money($sum, $estimate->currency);?></td>
		</tr>
		</table>
		
		</div>
		<div class="row">


<div class=" col-md-12" align="right">
			



</div>	
</div>




<br>



		</div>
		</div>

		

