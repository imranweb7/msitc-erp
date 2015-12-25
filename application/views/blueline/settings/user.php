<div id="row">
	
		<div class="col-md-3">
			<div class="list-group">
				<?php foreach ($submenu as $name=>$value):
				$badge = "";
				$active = "";
				if($value == "settings/updates"){ $badge = '<span class="badge badge-success">'.$update_count.'</span>';}
				if($name == $breadcrumb){ $active = 'active';}?>
	               <a class="list-group-item <?php echo $active;?>" id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>"><?php echo $badge?> <?php echo $name?></a>
	            <?php endforeach;?>
			</div>
		</div>


<div class="col-md-9">
		<div class="table-head"><?php echo $this->lang->line('application_all_users');?> <span class="pull-right"><a href="<?php echo base_url()?>settings/user_create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_user');?></a></span></div>
		<div class="table-div">
		<table id="users" class="data-no-search table" cellspacing="0" cellpadding="0">
		<thead>
			<th style="width:10px"></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_username');?></th>
			<th><?php echo $this->lang->line('application_full_name');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_title');?></th>
			<th class="hidden-sm hidden-xs hidden-md"><?php echo $this->lang->line('application_email');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_status');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_admin');?></th>
			<th class="hidden-sm hidden-xs hidden-md"><?php echo $this->lang->line('application_last_login');?></th>
			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($users as $user):?>

		<tr id="<?php echo $user->id;?>">
			<td  style="width:10px">
			<img class="minipic" src="
               <?php 
                if($user->userpic != 'no-pic.png'){
                  echo base_url()."files/media/".$user->userpic;
                }else{
                  echo get_gravatar($user->email, '20');
                }
                 ?>
                "/>
            </td>
			<td class="hidden-xs"><?php echo $user->username;?></td>
			<td><?php echo $user->firstname." ".$user->lastname;?></td>
			<td class="hidden-xs"><?php echo $user->title;?></td>
			<td class="hidden-sm hidden-xs hidden-md"><p class="truncate"><?php echo $user->email;?></p></td>
			<td class="hidden-xs"><span class="label label-<?php if($user->status == "active"){ echo "success"; }else{echo "important";} ?>"><?php echo $this->lang->line('application_'.$user->status);?></span></td>
			<td class="hidden-xs"><span class="label label-<?php if($user->admin == "1"){ echo "success"; }else{echo "";} ?>"><?php if($user->admin){echo $this->lang->line('application_yes');}else{echo $this->lang->line('application_no');}?></span></td>
			<td class="hidden-xs hidden-md hidden-sm"><span><?php if(!empty($user->last_login)){ echo date($core_settings->date_format.' '.$core_settings->date_time_format, $user->last_login); } else{echo "-";}?></span></td>
			
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>settings/user_delete/<?php echo $user->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $user->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>settings/user_update/<?php echo $user->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>
	 	</div>
	</div>
</div>