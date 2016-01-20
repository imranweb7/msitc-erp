<div class="row">

	<div class="col-md-12">
		<h2><?php echo $item->name;?></h2>
	</div>
</div>
<div class="row">
	<div class="col-md-12 marginbottom20">
		<div class="table-head"><?php echo $this->lang->line('application_item_details');?></div>
		<div class="subcont">
			<div class="row">
				<div class="details col-md-6 col-xs-12">
					<div class="table-head"><?php echo $this->lang->line('item_application_information');?></div>
					<ul class="details col-md-12 col-xs-12">
						<li><span><?php echo $this->lang->line('item_application_name');?>:</span> <?php echo $item->name = empty($item->name) ? "-" : $item->name; ?></li>
						<li><span><?php echo $this->lang->line('item_application_sku');?>:</span> <?php if(isset($item->sku)){ echo $item->sku;}else{echo "-";} ?></li>
						<li><span><?php echo $this->lang->line('application_value');?>:</span> <?php echo $core_settings->currency.display_money($item->value);?></li>
					</ul>
				</div>

				<div class="details col-md-6 col-xs-12">
					<div class="table-head"><?php echo $this->lang->line('item_application_file');?></div>
					<?php if(!empty($item->photo)){?>
					<img class="img-responsive" src="<?php echo base_url().'files/media/'.$item->photo;?>" />
					<?php } ?>
				</div>
			</div>
			<br clear="all">
		</div>
	</div>
</div>
		

