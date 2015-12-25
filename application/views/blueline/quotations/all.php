<div class="col-sm-12  col-md-12 main">  
	<div id="options" class="row">
			<a href="<?php echo base_url()?>quotation" class="btn btn-primary" target="_blank"><?php echo $this->lang->line('application_view_quotation_form');?></a>
			
			<div class="btn-group pull-right-responsive margin-right-3">
		          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if($last_uri != "quotations"){echo $this->lang->line('application_status');}else{echo $this->lang->line('application_all');} ?> <span class="caret"></span>
		          </button>
		          <ul class="dropdown-menu pull-right" role="menu">
		            <?php foreach ($submenu as $name=>$value):?>
			                <li><a id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>"><?php echo $name?></a></li>
			            <?php endforeach;?>
		          </ul>
		      </div>
			<script type="text/javascript">$(document).ready(function() { 
	            	$('.nav-tabs #<?php $last_uri = end(explode("/", uri_string())); if($val_id[count($val_id)-2] == "filter"){echo $last_uri;} ?>').button('toggle'); });
	        </script> 

		</div>
		<div class="row">
		
		<div class="table-head"><?php echo $this->lang->line('application_quotations');?></div>
		<div class="table-div">
		<table class="table data" id="quotations" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="20px" class="hidden-xs"><?php echo $this->lang->line('application_quotation_id');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
			<th><?php echo $this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_company');?> / <?php echo $this->lang->line('application_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_worker');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($quotations as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $core_settings->quotation_prefix;?><?php echo $value->id;?></td>
			<td><span class="label <?php if($value->status == "New"){echo "label-important";}elseif($value->status == "Accepted"){ echo "label-success";}elseif($value->status == "Reviewed"){ echo "label-warning";} ?>"><?php echo $this->lang->line('application_'.$value->status);?></span></td>
			<td><?php $unix = human_to_unix($value->date); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></td>
			<td class="hidden-xs"><?php if(!empty($value->company)){echo $value->company;}else{echo $value->fullname;}?></td>
			<td class="hidden-xs"><span class="label <?php if(isset($value->user->firstname)){echo 'label-info">'.$value->user->firstname.' '.$value->user->lastname;}else{echo '">'.$this->lang->line('application_not_assigned');}?> </span></td>
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>quotations/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>quotations/update/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
	 	<hr>
	 	</div>

	 	<div id="options" class="row">
			<a href="<?php echo base_url()?>quotations/quoteforms" class="btn btn-primary"><?php echo $this->lang->line('application_custom_quotation_forms');?></a>
			
			<div class="btn-group pull-right-responsive margin-right-3">
		          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if($last_uri != "quotations"){echo $this->lang->line('application_status');}else{echo $this->lang->line('application_all');} ?> <span class="caret"></span>
		          </button>
		          <ul class="dropdown-menu pull-right" role="menu">
		            <?php foreach ($submenu as $name=>$value):?>
			                <li><a id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>#custom_quotations_requests_filter"><?php echo $name?></a></li>
			            <?php endforeach;?>
		          </ul>
		      </div>
			<script type="text/javascript">$(document).ready(function() { 
	            	$('.nav-tabs2 #<?php $last_uri2 = end(explode("/", uri_string())); if($val_id[count($val_id)-2] == "customfilter"){echo $last_uri2;} ?>2').button('toggle'); });
	        </script> 

		</div>
		<div class="row">
		<div class="table-head"><?php echo $this->lang->line('application_custom_quotations');?></div>
		<div class="table-div">
		<table class="table data" id="custom_quotations_requests" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="20px" class="hidden-xs"><?php echo $this->lang->line('application_quotation_id');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
			<th  class="hidden-xs"><?php echo $this->lang->line('application_quotation');?></th>
			<th><?php echo $this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_worker');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($custom_quotations as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $core_settings->quotation_prefix;?><?php echo $value->id;?></td>
			<td><span class="label <?php if($value->status == "New"){echo "label-important";}elseif($value->status == "Accepted"){ echo "label-success";}elseif($value->status == "Reviewed"){ echo "label-warning";} ?>"><?php echo $this->lang->line('application_'.$value->status);?></span></td>
			<td class="hidden-xs"><?php  if(isset($value->customquote->name)){echo $value->customquote->name;}else{echo "-";}?></td>
			<td><?php $unix = human_to_unix($value->date); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></td>
			<td  class="hidden-xs"><span class="label <?php if(isset($value->user->firstname)){echo 'label-info">'.$value->user->firstname; echo " ".$value->user->lastname;}else{echo '">'.$this->lang->line('application_not_assigned');}?></span></td>
			
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>quotations/cdelete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>quotations/cupdate/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
	 	
		</div>
	</div>