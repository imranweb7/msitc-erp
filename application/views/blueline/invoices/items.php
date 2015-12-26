	<div class="col-sm-12  col-md-12 main"> 
		<div class="row">
			<a href="<?php echo base_url()?>items/create_items" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_item');?></a>
		</div>
		<div class="row">
		<div class="table-head"> <?php echo $this->lang->line('application_items');?></div>
		<div class="table-div">
		<table class="data table" id="items" rel="<?php echo base_url()?>items" cellspacing="0" cellpadding="0">
		<thead>
			<th><?php echo $this->lang->line('item_application_name');?></th>
			<th><?php echo $this->lang->line('item_application_sku');?></th>
			<th><?php echo $this->lang->line('application_value');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($items as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td onclick=""><?php echo $value->name;?></td>
			<td><?php echo $value->sku;?></td>
			<td><?php echo $core_settings->currency.display_money($value->value);?></td>
			<td><?php if($value->inactive == "0") echo '<span class="label label-success">Active</span>'; else echo '<span class="label label-important">Inactive</span>'; ?></td>
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>items/delete_items/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>items/update_items/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
	 	</div>
	 	<br clear="all">
		
	</div>