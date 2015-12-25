<div class="row">
              <div class="col-xs-12 col-sm-12">
			
			
			<?php if($core_settings->paypal == "1" && isset($subscription->subscription_has_items[0]) && $subscription->subscribed == "0"){ ?>
			<a href="javascript:document.forms['paypal_subscribe'].submit();" class="btn btn-success pull-right"><?php echo $this->lang->line('application_subscribe_via_paypal');?></a>
			<?php } ?>
		</div>
		</div>
		<div class="row">
		<div class="col-xs-12 col-sm-12">
		<div class="table-head"><?php echo $this->lang->line('application_subscription_details');?></div>
		<div class="subcont">
		<ul class="details col-xs-12 col-sm-6">
			<li><span><?php echo $this->lang->line('application_subscription_id');?>:</span> <?php echo $core_settings->subscription_prefix;?><?php echo $subscription->reference;?></li>
			<li class="<?php echo $subscription->status;?>"><span><?php echo $this->lang->line('application_status');?>:</span>
			<a class="label <?php if($subscription->status == 'Active'){ echo 'label-success';}else{echo 'label-important'; } ?>"><?php if($subscription->end_date <= date('Y-m-d') && $subscription->status != "Inactive"){ echo $this->lang->line('application_ended'); }else{ echo $this->lang->line('application_'.$subscription->status);}?></a>
			<?php if($subscription->subscribed != "0"){ ?>  <a class="label label-success margin-left-5 tt" title="<?php $unix = human_to_unix($subscription->subscribed.' 00:00'); echo date($core_settings->date_format, $unix);?>" ><?php echo $this->lang->line('application_subscribed_via_paypal');?></a> <?php } ?>
			</li>
			<li><span><?php echo $this->lang->line('application_issue_date');?>:</span> <?php $unix = human_to_unix($subscription->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
			<li><span><?php echo $this->lang->line('application_end_date');?>:</span> <a class="label <?php if($subscription->end_date <= date('Y-m-d') && $subscription->status != "Inactive"){ echo 'label-success tt" title="'.$this->lang->line('application_subscription_has_ended'); } ?>"><?php $unix = human_to_unix($subscription->end_date.' 00:00'); echo date($core_settings->date_format, $unix);?></a></li>
			<li><span><?php echo $this->lang->line('application_frequency');?>:</span>
				
					<?php $freq = array('+7 day'  => $this->lang->line('application_weekly'),
                  '+14 day' => $this->lang->line('application_every_other_week'),
                  '+1 month' => $this->lang->line('application_monthly'),
                  '+3 month' => $this->lang->line('application_quarterly'),
                  '+6 month' => $this->lang->line('application_semi_annually'),
                  '+1 year' => $this->lang->line('application_annually')); 
					echo $freq[$subscription->frequency];
                  ?>
				</li>
			<li><span><?php echo $this->lang->line('application_next_payment');?>:</span> <a class="label <?php
			if($subscription->status == "Active" && $subscription->next_payment > date('Y-m-d')){
				echo 'label-success ';} 
			if($subscription->next_payment <= date('Y-m-d') && $subscription->end_date > $subscription->next_payment && $subscription->status != "Inactive"){ 
				echo 'label-important tt" title="'.$this->lang->line('application_new_invoice_needed'); 
			} ?>"><?php $unix = human_to_unix($subscription->next_payment.' 00:00'); 
			if($subscription->end_date >= $subscription->next_payment){ 
				echo date($core_settings->date_format, $unix); 
			}else{ echo "-";} ?>
		</a></li>
		<span class="visible-xs"></span>
		
		</ul>
		<ul class="details col-xs-12 col-sm-6">
			<?php if(isset($subscription->company->name)){ ?>
			<li><span><?php echo $this->lang->line('application_company');?>:</span> <a href="<?php echo base_url()?>clients/view/<?php echo $subscription->company->id;?>" class="label label-info"><?php echo $subscription->company->name;?></a></li>
			<li><span><?php echo $this->lang->line('application_contact');?>:</span> <?php if(isset($subscription->company->client->firstname)){ ?> <?php echo $subscription->company->client->firstname;?> <?php echo $subscription->company->client->lastname;?> <?php }else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('application_street'); ?>:</span> <?php echo $subscription->company->address;?></li>
			<li><span><?php echo $this->lang->line('application_city');   ?>:</span> <?php echo $subscription->company->zipcode;?> <?php echo $subscription->company->city;?></li>
			<li><span><?php echo $this->lang->line('application_website');?>:</span> <?php echo $subscription->company->website;?></li>

			<?php }else{ ?>
				<li><?php echo $this->lang->line('application_no_client_assigned');?></li>
			<?php } ?>
		</ul>
		<br clear="all">
		</div>
		</div>
		</div>

		<div class="row">
		<div class="col-xs-12 col-sm-12">
		<div class="table-head"><?php echo $this->lang->line('application_subscription_items');?> </div>
		<div class="table-div min-height-200">
		<table id="items" class="table" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
		
			<th><?php echo $this->lang->line('application_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_description');?></th>
			<th width="8%"><?php echo $this->lang->line('application_hrs_qty');?></th>
			<th width="12%"><?php echo $this->lang->line('application_unit_price');?></th>
			<th width="12%"><?php echo $this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php foreach ($items as $value):?>
		<tr id="<?php echo $value->id;?>" >
			 
			<td class="hidden-xs"><?php echo $subscription->subscription_has_items[$i]->name;?></td>
			<td><?php echo $subscription->subscription_has_items[$i]->description;?></td>
			<td align="center"><?php echo $subscription->subscription_has_items[$i]->amount;?></td>
			<td><?php echo display_money(sprintf("%01.2f",$subscription->subscription_has_items[$i]->value));?></td>
			<td><?php echo display_money(sprintf("%01.2f",$subscription->subscription_has_items[$i]->amount*$subscription->subscription_has_items[$i]->value));?></td>

		</tr>
		
		<?php $sum = $sum+$subscription->subscription_has_items[$i]->amount*$subscription->subscription_has_items[$i]->value; $i++;?>
		
		<?php endforeach;
		if($items == NULL){ echo "<tr><td colspan='6'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
		if(substr($subscription->discount, -1) == "%"){ $discount = sprintf("%01.2f", round(($sum/100)*substr($subscription->discount, 0, -1), 2)); }
	    else{$discount = $subscription->discount;}
	    $sum = $sum-$discount;

	    
	    if($subscription->tax != ""){
			$tax_value = $subscription->tax;
		}else{
			$tax_value = $core_settings->tax;
		}

		if($subscription->second_tax != ""){
	      $second_tax_value = $subscription->second_tax;
	    }else{
	      $second_tax_value = $core_settings->second_tax;
	    }

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$second_tax = sprintf("%01.2f", round(($sum/100)*$second_tax_value, 2));

    	$sum = sprintf("%01.2f", round($sum+$tax+$second_tax, 2));
		?>
		<?php if ($subscription->discount != 0): ?>
		<tr>
			<td colspan="4" align="right"><?php echo $this->lang->line('application_discount');?></td>
			<td>- <?php echo display_money($subscription->discount);?></td>
		</tr>	
		<?php endif ?>
		
		<?php if ($tax_value != "0"){ ?>
		<tr>
			<td colspan="4" align="right"><?php echo $this->lang->line('application_tax');?> (<?php echo  $tax_value?>%)</td>
			<td><?php echo display_money($tax)?></td>
		</tr>
		<?php } ?>
		<?php if ($second_tax != "0"){ ?>
		<tr>
			<td colspan="4" align="right"><?php echo $this->lang->line('application_second_tax');?> (<?php echo  $second_tax_value?>%)</td>
			<td><?php echo display_money($second_tax);?></td>
		</tr>
		<?php } ?>
		<tr class="active">
			<td colspan="4" align="right"><?php echo $this->lang->line('application_total');?></td>
			<td> <?php echo display_money($sum, $subscription->currency);?></td>
		</tr>
		</table>
		</div>
		</div>

			<?php if($core_settings->paypal == "1" && $sum != "0.00" && $subscription->subscribed == "0"){ ?><br/>	
			<form action="https://www.paypal.com/cgi-bin/webscr" id="paypal_subscribe" target="_blank" method="post">
			  <input type="hidden" name="cmd" value="_xclick-subscriptions">
			  <input type="hidden" name="business" value="<?php echo $core_settings->paypal_account;?>">
			  <input type="hidden" name="item_name" value="<?php echo $this->lang->line('application_subscription');?> #<?php echo $subscription->reference;?>">
			  <input type="hidden" name="item_number" value="<?php echo $subscription->reference;?>">
			  <input type="hidden" name="image_url" value="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>">
			  <input type="hidden" name="no_shipping" value="1">
			  <input type="hidden" name="return" value="<?php echo base_url()?>csubscriptions/view/<?php echo $subscription->id;?>">
			  <input type="hidden" name="cancel_return" value="<?php echo base_url()?>csubscriptions/view/<?php echo $subscription->id;?>">
			  <input type="hidden" name="currency_code" value="<?php echo  $core_settings->paypal_currency;?>">
			  <input type="hidden" name="rm" value="2">
			  <input type="hidden" name="a3" value="<?php echo $sum;?>">
			  <input type="hidden" name="p3" value="<?php echo $p3;?>">
			  <input type="hidden" name="t3" value="<?php echo $t3;?>">
			  <input type="hidden" name="src" value="1">
			  <input type="hidden" name="sra" value="1">
			  <input type="hidden" name="srt" value="<?php echo $run_time;?>">
			  <input type="hidden" name="no_note" value="1">
			  <input type="hidden" name="invoice" value="<?php echo $subscription->reference;?>">
			  <input type="hidden" name="usr_manage" value="1">
			  <input type="hidden" name="notify_url" value="<?php echo base_url()?>paypalipn" />
			  <input type="hidden" name="custom" value="subscription-<?php echo $sum;?>">
			  <!-- <input class="btn btn-primary pull-right" type="submit" value="<?php echo $this->lang->line('application_subscribe_via_paypal');?>" border="0" name="send" > -->
			</form>

			 <?php } ?>	

		</div>

	<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="table-head"><?php echo $this->lang->line('application_subscription');?> <?php echo $this->lang->line('application_invoices');?></div>
		<div class="table-div">
		<table class="data table" id="cinvoices" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="hidden-xs" width="70px"><?php echo $this->lang->line('application_invoice_id');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_client');?></th>
			<th><?php echo $this->lang->line('application_issue_date');?></th>
			<th><?php echo $this->lang->line('application_due_date');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
		</thead>
		<?php foreach ($subscription->invoices as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $core_settings->invoice_prefix;?><?php echo $value->reference;?></td>
			<td class="hidden-xs"><span class="label label-info"><?php if(!isset($value->company->name)){echo $this->lang->line('application_no_client_assigned'); }else{ echo $value->company->name; }?></span></td>
			<td><span><?php $unix = human_to_unix($value->issue_date.' 00:00'); echo date($core_settings->date_format, $unix);?></span></td>
			<td><span class="label <?php if($value->status == "Paid"){echo 'label-success';} if($value->due_date <= date('Y-m-d') && $value->status != "Paid"){ echo 'label-important tt" title="'.$this->lang->line('application_overdue'); } ?>"><?php $unix = human_to_unix($value->due_date.' 00:00'); echo date($core_settings->date_format, $unix);?></span></td>
			<td><span class="label <?php $unix = human_to_unix($value->sent_date.' 00:00'); if($value->status == "Paid"){echo 'label-success';}elseif($value->status == "Sent"){ echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);} ?>"><?php echo $this->lang->line('application_'.$value->status);?></span></td>

		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
	 	</div>
	</div>

