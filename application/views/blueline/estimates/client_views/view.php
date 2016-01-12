 
          <div class="row">
              <div class="col-xs-12 col-sm-12">
				  <?php if($estimate->sum > 0){?>

            <a href="<?php echo base_url()?>cestimates/preview/<?php echo $estimate->id;?>" class="btn btn-primary"><i class="fa fa-file visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_preview');?></span></a>
			<?php if($estimate->estimate_status != "Declined" && $estimate->estimate_status != "Invoiced" && $estimate->estimate_status != "Accepted"){ ?><a href="<?php echo base_url()?>cestimates/decline/<?php echo $estimate->id;?>" class="btn btn-danger" data-toggle="mainmodal"><i class="fa fa-times visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_decline');?></span></a><?php } ?>
			<?php if($estimate->estimate_status != "Accepted" && $estimate->estimate_status != "Invoiced"){ ?><a href="<?php echo base_url()?>cestimates/accept/<?php echo $estimate->id;?>" class="btn btn-success"><i class="fa fa-check visible-xs"></i><span class="hidden-xs"><?php echo $this->lang->line('application_accept');?></span></a><?php } ?>

<?php } ?>
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
					  case "Open": $custom_status = $estimate->estimate_status; $label = "label-default"; break;
			          case "Accepted": $custom_status = $estimate->estimate_status; $label = "label-success"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
			          case "Sent": $custom_status = "Open"; $label = "label-warning"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_sent.' 00:00')).'"'; break; 
			          case "Declined": $custom_status = $estimate->estimate_status; $label = "label-important"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
			          case "Invoiced": $custom_status = $estimate->estimate_status; $label = "label-chilled"; $change_date = 'title="'.$this->lang->line('application_Accepted').' '.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;
			          case "Revised": $custom_status = $estimate->estimate_status; $label = "label-warning"; $change_date = 'title="'.$this->lang->line('application_Revised').' '.date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date.' 00:00')).'"'; break;

					default: $label = "label-default"; break;
				}
			?>
			<a class="label <?php echo $label?> tt" <?php echo $change_date;?>><?php echo $this->lang->line('application_'.$custom_status);?>
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

				<div class="col-xs-12 col-sm-6">

				</div>

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
							  ?>
							  <img class="img-responsive" src="<?php echo base_url().'files/media/'.$estimate->shipping_lebel;?>" />
							  <?php
						  }
						  ?>
					  </div>
				  </div>
			  </div>
<?php } ?>

		<div class="row">
		<div class="col-md-12">
		<div class="table-head"><?php echo $this->lang->line('application_items');?> </div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="items" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th><?php echo $this->lang->line('item_application_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('item_application_description');?></th>
			<th class="hidden-xs" width="8%"><?php echo $this->lang->line('item_application_sku');?></th>
			<th class="hidden-xs" width="8%"><?php echo $this->lang->line('application_hrs_qty');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_unit_price');?></th>
			<th class="hidden-xs" width="12%"><?php echo $this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php foreach ($items as $value):?>
		<tr id="<?php echo $value->id;?>" >

			<td><?php if(!empty($value->name)){echo $value->name;}else{ echo $estimate->invoice_has_items[$i]->item->name; }?></td>
			<td class="hidden-xs"><?php echo $estimate->invoice_has_items[$i]->description;?></td>
			<td class="hidden-xs"><?php echo $estimate->invoice_has_items[$i]->sku;?></td>
			<td class="hidden-xs" align="center"><?php echo $estimate->invoice_has_items[$i]->amount;?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$estimate->invoice_has_items[$i]->value));?></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f",$estimate->invoice_has_items[$i]->amount*$estimate->invoice_has_items[$i]->value));?></td>

		</tr>
		
		<?php $sum = $sum+$estimate->invoice_has_items[$i]->amount*$estimate->invoice_has_items[$i]->value; $i++;?>
		
		<?php endforeach;
		if(empty($items)){ echo "<tr><td colspan='6'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
		if(substr($estimate->discount, -1) == "%"){ $discount = sprintf("%01.2f", round(($sum/100)*substr($estimate->discount, 0, -1), 2)); }
		else{$discount = $estimate->discount;}
		$sum = $sum-$discount;

		if($estimate->tax != ""){
			$tax_value = $estimate->tax;
		}else{
			$tax_value = $core_settings->tax;
		}

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$sum = sprintf("%01.2f", round($sum+$tax, 2));
		?>
		<?php if ($discount != 0): ?>
		<tr>
			<td colspan="5" align="right"><?php echo $this->lang->line('application_discount');?></td>
			<td>- <?php echo display_money($estimate->discount);?></td>
		</tr>	
		<?php endif ?>
		<?php if ($tax_value != "0"){ ?>
		<tr>
			<td colspan="5" align="right"><?php echo $this->lang->line('application_tax');?> (<?php echo  $tax_value?>%)</td>
			<td><?php echo display_money($tax)?></td>
		</tr>
		<?php } ?>
		<tr class="active">
			<td colspan="5" align="right"><?php echo $this->lang->line('application_total');?></td>
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

		

