<div class="col-sm-12  col-md-12 main">  
	<div id="options" class="row">
			<a href="<?php echo base_url()?>quotations" class="btn btn-primary"><i class="fa fa-arrow-left visible-xs"></i> <span class="hidden-xs"><?php echo $this->lang->line('application_custom_quotations');?></span></a>
			<a href="<?php echo base_url()?>quotations/formbuilder" class="btn btn-primary"><?php echo $this->lang->line('application_create_quotation');?></a>
			
			
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
	            	$('.nav-tabs #<?php $last_uri = end(explode("/", uri_string())); if($val_id[count($val_id)-2] != "filter"){echo end($val_id);}else{ echo $last_uri;} ?>').button('toggle'); });
	        </script> 

		</div>
		<div class="row">
		<div class="table-head"><?php echo $this->lang->line('application_custom_quotation_forms');?></div>
		<div class="table-div">
		<table class="table data" id="quotation_form" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="20px" class="hidden-xs"><?php echo $this->lang->line('application_quotation_id');?></th>
			<th><?php echo $this->lang->line('application_name');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($quotations as $value):?>

		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $value->id;?></td>
			<td><?php echo $value->name;?></td>
			<td><? if($value->inactive == "1"){ echo '<span class="label label-error">'.$this->lang->line('application_inactive').'</span>'; }else{echo '<span class="label label-success">'.$this->lang->line('application_active').'</span>'; } ?></td>
			
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>quotations/formdelete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>quotation/qid/<?php echo $value->id;?>" class="btn-option" target="_blank"><i class="fa fa-eye"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
		</div>
	</div>