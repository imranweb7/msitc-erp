<div class="row">

	<div class="col-md-12">
		<h2><?php echo $shipping_method->name;?></h2>
	</div>
</div>
<div class="row">
	<div class="col-md-12 marginbottom20">
		<div class="table-head"><?php echo $this->lang->line('application_shipping_method_details');?> <span class="pull-right"><a href="<?php echo base_url()?>shippingmethods/update/<?php echo $shipping_method->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="icon-edit"></i> <?php echo $this->lang->line('application_edit');?></a></div>
		<div class="subcont">
			<ul class="details col-md-12">
				<li><span><?php echo $this->lang->line('application_shipping_method_title');?>:</span> <?php echo $shipping_method->name = empty($shipping_method->name) ? "-" : $shipping_method->name; ?></li>
				<li><span><?php echo $this->lang->line('application_shipping_method_description');?>:</span> <?php if(isset($shipping_method->description)){ echo $shipping_method->description;}else{echo "-";} ?></li>
				<li><span><?php echo $this->lang->line('application_shipping_method_status');?>:</span> <?php if($shipping_method->inactive == "0"){ echo 'Yes'; }else{ echo "No"; } ?></li>
			</ul>

			<br clear="all">
		</div>
	</div>
</div>
		

