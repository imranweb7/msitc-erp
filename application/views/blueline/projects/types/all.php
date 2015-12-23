<div class="col-sm-12  col-md-12 main">
		<div class="row">
			<a href="<?=base_url()?>projecttypes/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_new_project_type');?></a>
		</div>
		<div class="row">
		<div class="table-head"> <?=$this->lang->line('application_projecttypes');?></div>
		<div class="table-div">
		<table class="data table" id="project_types" rel="<?=base_url()?>projecttypes" cellspacing="0" cellpadding="0">
		<thead>
			
			<th class="hidden-xs" style="width:70px"><?=$this->lang->line('application_project_type_id');?></th>
			<th><?=$this->lang->line('application_project_type_name');?></th>
			<th><?=$this->lang->line('application_action');?></th>
		</thead>

		<?php foreach ($project_types as $value):?>

		<tr  id="<?=$value->id;?>" ><td class="hidden-xs" style="width:70px"><?=$value->id;?></td>
						
			<td><span class="label label-info"><?php if(isset($value->name)){echo $value->name;} else{echo $this->lang->line('application_no_project_type_assigned'); }?></span></td>
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>projecttypes/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?=base_url()?>projecttypes/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	 	</table>
	 	<br clear="all">
		
	</div>