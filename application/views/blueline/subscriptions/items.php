<div id="main">
		<div id="options">
			<a href="<?php echo base_url()?>items/create_items" class="btn" data-toggle="modal"><i class="icon-plus-sign"></i> <?php echo $this->lang->line('application_create_item');?></a>
		</div>
		<div class="table_head"><h6><i class="icon-file"></i> <?php echo $this->lang->line('application_items');?></h6></div>
		<table class="data" id="items" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th><?php echo $this->lang->line('application_name');?></th>
			<th><?php echo $this->lang->line('application_type');?></th>
			<th style="width:50px"><?php echo $this->lang->line('application_value');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($items as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td><?php echo $value->name;?></td>
			<td><?php echo $value->type;?></td>
			<td><?php echo $value->value;?></td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>items/delete_items/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?php echo base_url()?>items/update_items/<?php echo $value->id;?>" class="btn btn-mini" data-toggle="modal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	<br clear="all">
		
	</div>