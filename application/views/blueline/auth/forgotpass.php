<?php $attributes = array('class' => 'form-signin', 'role'=> 'form', 'id' => 'forgotpass'); ?>
<?php echo form_open('forgotpass', $attributes)?>
        <div class="logo"><img src="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>" alt="<?php echo $core_settings->company;?>"></div>
        <?php if($this->session->flashdata('message')) { $exp = explode(':', $this->session->flashdata('message')); ?>
            <div class="forgotpass-success">
              <?php echo $exp[1]?>
            </div>
        <?php }else{ ?>
          <div class="forgotpass-info"><?php echo $this->lang->line('application_identify_account');?></div>
          
          <div class="form-group">
            <label for="email"><?php echo $this->lang->line('application_email');?></label>
            <input type="text" class="form-control" name="email" id="email" placeholder="<?php echo $this->lang->line('application_email');?>">
          </div>

          <input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('application_reset_password');?>" />
          <?php } ?>
          <div class="forgotpassword"><a href="<?php echo site_url("login");?>"><?php echo $this->lang->line('application_go_to_login');?></a></div>
<?php echo form_close()?>