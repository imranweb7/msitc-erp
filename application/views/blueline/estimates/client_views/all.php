	<div class="col-sm-12  col-md-12 main">  
 
     <div class="row">
         <a href="<?php echo base_url()?>cestimates/createShippingEstimate" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_estimate');?></a>
         <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if($last_uri != "cestimates"){echo $this->lang->line('application_'.$last_uri);}else{echo $this->lang->line('application_all');} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php foreach ($submenu as $name=>$value):?>
	                <li><a id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>"><?php echo $name?></a></li>
	            <?php endforeach;?>
          </ul>
      </div>
    </div>  
      <div class="row">

         <div class="table-head"><?php echo $this->lang->line('application_estimates');?></div>
         <div class="table-div">
		<table class="data table" id="cestimates" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="70px" class="hidden-xs"><?php echo $this->lang->line('application_estimate_id');?></th>
			<th ><?php echo $this->lang->line('application_client');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_issue_date');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_total');?></th>
			<th><?php echo $this->lang->line('application_status');?></th>
		</thead>
		<?php foreach ($estimates as $value):
        $change_date = "";
        switch($value->estimate_status){
          case "Open": $custom_status = $value->estimate_status; $label = "label-default"; break;
          case "Accepted": $custom_status = $value->estimate_status; $label = "label-success"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($value->estimate_accepted_date.' 00:00')).'"'; break;
          case "Sent": $custom_status = "Open"; $label = "label-warning"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($value->estimate_sent.' 00:00')).'"'; break; 
          case "Declined": $custom_status = $value->estimate_status; $label = "label-important"; $change_date = 'title="'.date($core_settings->date_format, human_to_unix($value->estimate_accepted_date.' 00:00')).'"'; break;
          case "Invoiced": $custom_status = $value->estimate_status; $label = "label-chilled"; $change_date = 'title="'.$this->lang->line('application_Accepted').' '.date($core_settings->date_format, human_to_unix($value->estimate_accepted_date.' 00:00')).'"'; break;
          case "Revised": $custom_status = $value->estimate_status; $label = "label-warning"; $change_date = 'title="'.$this->lang->line('application_Revised').' '.date($core_settings->date_format, human_to_unix($value->estimate_accepted_date.' 00:00')).'"'; break;
         

          default: $label = "label-default"; break;
        } ?>
		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $core_settings->estimate_prefix;?><?php echo $value->reference;?></td>
			<td><span class="label label-info"><?php if(isset($value->company->name)){echo $value->company->name; }?></span></td>
			<td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date.' 00:00'); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td class="hidden-xs"><?php echo display_money(sprintf("%01.2f", round($value->sum, 2)));?></td>
			<td><span class="label  <?php echo $label?> tt" <?php echo $change_date;?>><?php echo $this->lang->line('application_'.$custom_status);?></span></td>
		
		</tr>

		<?php endforeach;?>
	 	</table>
            </div>

      </div>
