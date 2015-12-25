
<div id="main">
<div id="options">
			<a href="<?php echo base_url()?>projects/media/<?php echo $project->id;?>/add" class="btn" data-toggle="modal"><?php echo $this->lang->line('application_add_media');?></a>
		</div>
	 	<div class="table_head"><img src="<?php echo base_url()?>assets/img/media.png"><h6><?php echo $this->lang->line('application_media');?></h6></div>
		<table class="data" id="media" rel="<?php echo base_url()?>projects/media/<?php echo $project->id;?>" cellspacing="0" cellpadding="0">
		<thead>
			<th class="listicon"></th>
			<th><?php echo $this->lang->line('application_name');?></th>
			<th><?php echo $this->lang->line('application_filename');?></th>
			<th><?php echo $this->lang->line('application_description');?></th>
			<th><?php echo $this->lang->line('application_phase');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($project->project_has_files as $value):?>

		<tr id="<?php echo $value->id;?>">
			<td id="icon" class="<?php $type = explode('.', $value->filename); echo $type[1]; ?>"></td>
			<td><?php echo $value->name;?></td>
			<td><?php echo $value->filename;?></td>
			<td><?php echo $value->description;?></td>
			<td><?php echo $value->phase;?></td>
			<td class="option btn-group">
				<a class="btn btn-mini po" rel="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>projects/media/<?php echo $project->id;?>/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="icon-trash"></i></a>
				<a href="<?php echo base_url()?>projects/media/<?php echo $project->id;?>/update/<?php echo $value->id;?>" class="btn btn-mini" data-toggle="modal"><i class="icon-edit"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	<br clear="all">

	</div>