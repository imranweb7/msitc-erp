<div class="row">

	<div class="col-md-12">
		<h2><?php echo $item->name;?></h2>
		<h4><?php echo $item->description;?></h4>
	</div>
</div>
<div class="row">
	<div class="details col-md-12 col-xs-12">
		<div class="table-head"><?php echo $this->lang->line('item_application_information');?></div>
		<ul class="details col-md-12 col-xs-12">
			<li><span><?php echo $this->lang->line('application_select_shipping_method');?>:</span> <?php if(isset($item->shipping_method)){ echo $item->shipping_method;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_handling_fee');?>:</span> <?php echo $core_settings->currency.display_money($item->cost);?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_available_inventory');?>:</span> <?php if(isset($item->shipping_available_inventory)){ echo $item->shipping_available_inventory;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('application_status');?>:</span> <?php if($item->inactive == "0"){ echo 'Active'; }else{ echo "Inactive"; } ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_box_size_length');?>:</span> <?php if(isset($item->shipping_box_size_length)){ echo $item->shipping_box_size_length;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_box_size_width');?>:</span> <?php if(isset($item->shipping_box_size_width)){ echo $item->shipping_box_size_width;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_box_size_height');?>:</span> <?php if(isset($item->shipping_box_size_height)){ echo $item->shipping_box_size_height;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_box_size_weight');?>:</span> <?php if(isset($item->shipping_box_size_weight)){ echo $item->shipping_box_size_weight;}else{echo "-";} ?></li>
			<li><span><?php echo $this->lang->line('shipping_item_application_pcs_in_carton');?>:</span> <?php if(isset($item->shipping_pcs_in_carton)){ echo $item->shipping_pcs_in_carton;}else{echo "-";} ?></li>
		</ul>
	</div>

</div>