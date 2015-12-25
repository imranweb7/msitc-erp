<div class="col-sm-12  col-md-12 main">
		<div class="row">
			<a href="<?php echo base_url()?>clients/company/create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_add_new_company');?></a>
		</div>
		<div class="row">
		<div class="table-head"> <?php echo $this->lang->line('application_companies');?></div>
		<div class="table-div">
		<table class="data table" id="clients" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			
			<th class="hidden-xs" style="width:70px"><?php echo $this->lang->line('application_company_id');?></th>
			<th><?php echo $this->lang->line('application_company_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_primary_contact');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_email');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_website');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($companies as $value):?>

		<tr  id="<?php echo $value->id;?>" ><td class="hidden-xs" style="width:70px"><?php echo $core_settings->company_prefix;?><?php if(isset($value->reference)){ echo $value->reference;} ?></td>
						
			<td><span class="label label-info"><?php if(isset($value->name)){echo $value->name;} else{echo $this->lang->line('application_no_company_assigned'); }?></span></td>
			<td class="hidden-xs"><?php if(isset($value->client->firstname)){ echo $value->client->firstname.' '.$value->client->lastname;}else{ echo $this->lang->line('application_no_contact_assigned');} ?></td>
			<td class="hidden-xs"><?php if(isset($value->client->email)){ echo $value->client->email;}else{ echo $this->lang->line('application_no_contact_assigned');}?></td>
			<td class="hidden-xs"><?php echo $value->website = empty($value->website) ? "-" : '<a target="_blank" href="http://'.$value->website.'">'.$value->website.'</a>' ?></td>
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>clients/company/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>clients/company/update/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	 	</table>
	 	<br clear="all">
		
	</div>