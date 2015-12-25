<?php $attributes = array('class' => 'form-signin', 'role'=> 'form', 'id' => 'login'); ?>
<?php echo form_open('login', $attributes)?>
        <div class="logo"><img src="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>" alt="<?php echo $core_settings->company;?>"></div>
        <?php if($error == "true") { $message = explode(':', $message)?>
            <div id="error">
              <?php echo $message[1]?>
            </div>
        <?php } ?>
        
          <div class="form-group">
            <label for="username"><?php echo $this->lang->line('application_username');?></label>
            <input type="username" class="form-control" id="username" name="username" />
          </div>
          <div class="form-group">
            <label for="password"><?php echo $this->lang->line('application_password');?></label>
            <input type="password" class="form-control" id="password" name="password" />
          </div>

          <input type="submit" class="btn btn-primary fadeoutOnClick" value="<?php echo $this->lang->line('application_login');?>" />
          <div class="forgotpassword"><a href="<?php echo site_url("forgotpass");?>"><?php echo $this->lang->line('application_forgot_password');?></a></div>

          <?php if($core_settings->registration == 1){ ?><div class="small"><small><?php echo $this->lang->line('application_you_dont_have_an_account');?></small></div><hr/><a href="<?php echo site_url("register");?>" class="btn btn-success"><?php echo $this->lang->line('application_create_account');?></a> <?php } ?>
        
<?php echo form_close()?>

