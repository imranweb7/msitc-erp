<?php $attributes = array('class' => 'form-signin form-register', 'role'=> 'form', 'id' => 'register'); ?>
<?php echo form_open($form_action, $attributes)?>
        <div class="logo"><img src="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>" alt="<?php echo $core_settings->company;?>"></div>
        <?php if($error != 'false') { ?>
            <div id="error" style="display:block">
              <?php echo $error?>
            </div>
        <?php } ?>
<div class="row">
<div class="header"><?php echo $this->lang->line('application_enter_your_details_to_create_an_account');?><hr></div>
  <div class="col-md-6"> 
    <div class="form-group">
            <label for="name"><?php echo $this->lang->line('application_company');?> <?php echo $this->lang->line('application_name');?> *</label>
            <input id="name" type="text" name="name" class="required form-control" value="<?php if(isset($registerdata)){echo $registerdata['name'];} ?>"  required/>
    </div>
    <div class="form-group">
            <label for="firstname"><?php echo $this->lang->line('application_firstname');?> *</label>
            <input id="firstname" type="text" name="firstname" class=" form-control" value="<?php if(isset($registerdata)){echo $registerdata['firstname'];}?>" required/>
    </div>
    <div class="form-group">
            <label for="lastname"><?php echo $this->lang->line('application_lastname');?> *</label>
            <input id="lastname" type="text" name="lastname" class="required form-control" value="<?php if(isset($registerdata)){echo $registerdata['lastname'];}?>" required/>
    </div>
    <div class="form-group <?php if(isset($registerdata)){echo 'has-error';} ?>">
            <label for="email"><?php echo $this->lang->line('application_email');?> *</label>
            <input id="email" type="email" name="email" class="required email form-control" value="<?php if(isset($registerdata)){echo $registerdata['email'];}?>" required/>
    </div>
    <div class="form-group">
            <label for="address"><?php echo $this->lang->line('application_address');?> *</label>
            <input id="address" type="text" name="address" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['address'];}?>" required/>
    </div>
    <div class="form-group">
            <label for="zipcode"><?php echo $this->lang->line('application_zip_code');?> *</label>
            <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['zipcode'];}?>" required/>
    </div>
    <div class="form-group">
            <label for="city"><?php echo $this->lang->line('application_city');?> *</label>
            <input id="city" type="text" name="city" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['city'];}?>" required/>
    </div>
    <div class="form-group">
            <label for="country"><?php echo $this->lang->line('application_country');?> *</label>
            <input id="country" type="text" name="country" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['country'];}?>" required/>
    </div>
  </div>
  <div class="col-md-6"> 
    <div class="form-group">
        <label for="province"><?php echo $this->lang->line('application_province');?></label>
        <input id="province" type="text" name="province" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['province'];}?>" />
    </div>
    <div class="form-group">
            <label for="website"><?php echo $this->lang->line('application_website');?></label>
            <input id="website" type="text" name="website" class="required form-control" value="<?php if(isset($registerdata)){echo $registerdata['website'];} ?>" />
    </div>
    <div class="form-group">
            <label for="phone"><?php echo $this->lang->line('application_phone');?></label>
            <input id="phone" type="text" name="phone" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['phone'];}?>" />
    </div>
    <div class="form-group">
            <label for="mobile"><?php echo $this->lang->line('application_mobile');?></label>
            <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['mobile'];}?>" />
    </div>
    <div class="form-group">
            <label for="vat"><?php echo $this->lang->line('application_vat');?></label>
            <input id="vat" type="text" name="vat" class="form-control" value="<?php if(isset($registerdata)){echo $registerdata['vat'];}?>" />
    </div>

    <div class="form-group">
            <label for="password"><?php echo $this->lang->line('application_password');?> *</label>
            <input id="password" type="password" name="password" class="form-control" value="" required />
    </div>
    <div class="form-group">
            <label for="password"><?php echo $this->lang->line('application_confirm_password');?> *</label>
            <input id="confirm_password" type="password" class="form-control" data-match="#password" required />
    </div>

    <?php   $number1 = rand(1, 10);
            $number2 = rand(1, 10);
            $captcha = $number1+$number2;

            //captcha
          $html_fields = '<input type="hidden" id="captcha" name="captcha" value="'.$captcha.'"><div class="form-group">';
          $html_fields .= '<label class="control-label-e">'.$number1.'+'.$number2.' = ?</label>';
          $html_fields .= '<input type="text" id="confirmcaptch" name="confirmcaptcha" data-match="#captcha" class="form-control" required/></div>';
          echo $html_fields;
    ?>
  </div>

</div>

<hr>
<div class="row">
  <div class="col-md-6"> 
         <a href="<?php echo site_url("login");?>"><?php echo $this->lang->line('application_go_to_login');?></a>
  </div>
  <div class="col-md-6">
          
         <input type="submit" class="btn btn-success" value="<?php echo $this->lang->line('application_send');?>" />
  </div>
</div>
<?php echo form_close()?>

