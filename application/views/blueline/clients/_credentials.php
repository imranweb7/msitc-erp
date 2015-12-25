
<ul class="details">
<li><span><?php echo $this->lang->line('application_username');?>:</span> <?php echo $client->email;?></li>
 <li><span><?php echo $this->lang->line('application_password');?>:</span> <?php echo $new_password;?></li>
 </ul>

    <div class="modal-footer">
    <a href="<?php echo base_url()?>clients/credentials/<?php echo $client->id;?>/email/<?php echo $new_password;?>" id="submit" class="btn btn-primary"><?php echo $this->lang->line('application_email_login_details');?></a>
	<a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
    </div>