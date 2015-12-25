
<div id="main">
<div id="options">
			<a href="<?php echo base_url()?>projects/tasks/<?php echo $project->id;?>/add" class="btn" data-toggle="modal"><?php echo $this->lang->line('application_add_task');?></a>
		</div>
	 	<div class="table_head"><img src="<?php echo base_url()?>assets/img/tasks.png"><h6><?php echo $this->lang->line('application_tasks');?></h6></div>
		<table class="data" id="tasks" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="listicon"></th>
			<th><?php echo $this->lang->line('application_name');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($project->project_has_tasks as $value):?>

		<tr id="<?php echo $value->id;?>" class="<?php echo $value->status;?>">
			<td class="<?php echo $value->status;?>"></td>
			<td><?php echo $value->name;?></td>
			<td class="option">
				<a href="<?php echo base_url()?>projects/tasks/<?php echo $project->id;?>/delete/<?php echo $value->id;?>" rel="<?php echo $value->name;?>" class="delete confirm"><?php echo $this->lang->line('application_delete');?></a>
				<a href="<?php echo base_url()?>projects/tasks/<?php echo $project->id;?>/update/<?php echo $value->id;?>" class="edit" data-toggle="modal"><?php echo $this->lang->line('application_edit');?></a>
			</td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>projects/tasks/<?php echo $project->id;?>/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?php echo base_url()?>projects/tasks/<?php echo $project->id;?>/update/<?php echo $value->id;?>" class="btn btn-mini" data-toggle="modal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
		<?php if($project->project_has_tasks == NULL){ echo '<tr class="noborder"><td width="120px"> No Tasks yet</td><td></td><td ></td></tr>';}?>
	 	</table>
	 	<br clear="all">

	</div>