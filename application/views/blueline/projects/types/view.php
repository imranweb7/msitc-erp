<div class="row">

	<div class="col-md-12">
		<h2><?php echo $project_type->name;?></h2>
	</div>
</div>
<div class="row">
	<div class="col-md-12 marginbottom20">
		<div class="table-head"><?php echo $this->lang->line('application_project_type_details');?> <span class="pull-right"><a href="<?php echo base_url()?>projecttypes/update/<?php echo $project_type->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="icon-edit"></i> <?php echo $this->lang->line('application_edit');?></a></div>
		<div class="subcont">
			<ul class="details col-md-12">
				<li><span><?php echo $this->lang->line('application_project_type_name');?>:</span> <?php echo $project_type->name = empty($project_type->name) ? "-" : $project_type->name; ?></li>
				<li><span><?php echo $this->lang->line('application_project_type_description');?>:</span> <?php if(isset($project_type->description)){ echo $project_type->description;}else{echo "-";} ?></li>
				<li><span><?php echo $this->lang->line('application_project_type_status');?>:</span> <?php if($project_type->inactive == "0"){ echo 'Yes'; }else{ echo "No"; } ?></li>
			</ul>

			<br clear="all">
		</div>
	</div>
</div>
		

