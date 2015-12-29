<div class="row">

	<div class="col-md-12">
		<h2><?php echo $item->name;?></h2>
	</div>
</div>
<div class="row">
	<div class="details col-md-6 col-xs-12">
		<div class="table-head"><?php echo $this->lang->line('item_application_information');?></div>
		<ul class="details col-md-12 col-xs-12">
			<li><span><?php echo $this->lang->line('item_application_name');?>:</span> <?php echo $item->name = empty($item->name) ? "-" : $item->name; ?></li>
			<li><span><?php echo $this->lang->line('item_application_sku');?>:</span> <?php if(isset($item->sku)){ echo $item->sku;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('item_application_cost');?>:</span> <?php echo $core_settings->currency.display_money($item->cost);?></li>
			<li><span><?php echo $this->lang->line('item_application_qty');?>:</span> <?php if(isset($item->quantity)){ echo $item->quantity;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('application_status');?>:</span> <?php if($item->inactive == "0"){ echo 'Active'; }else{ echo "Inactive"; } ?></li>
			<li><span><?php echo $this->lang->line('item_application_description');?>:</span> <?php echo $item->description;?></li>
		</ul>
	</div>

	<div class="details col-md-6 col-xs-12">
		<div class="table-head"><?php echo $this->lang->line('item_application_file');?></div>
		<img class="img-responsive" src="<?php echo base_url().'files/media/'.$item->photo;?>" />
	</div>
</div>