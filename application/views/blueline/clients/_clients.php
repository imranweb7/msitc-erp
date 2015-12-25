<?php   
$attributes = array('class' => '', 'id' => '_clients');
echo form_open_multipart($form_action, $attributes); 
?>
<?php if(isset($client)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $client->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<div class="form-group">
        <label for="firstname"><?php echo $this->lang->line('application_firstname');?> *</label>
        <input id="firstname" type="text" name="firstname" class=" form-control" value="<?php if(isset($client)){echo $client->firstname;} ?>" required/>
</div>
<div class="form-group">
        <label for="lastname"><?php echo $this->lang->line('application_lastname');?> *</label>
        <input id="lastname" type="text" name="lastname" class="required form-control" value="<?php if(isset($client)){echo $client->lastname;} ?>" required/>
</div>
<div class="form-group">
        <label for="email"><?php echo $this->lang->line('application_email');?> *</label>
        <input id="email" type="email" name="email" class="required email form-control" value="<?php if(isset($client)){echo $client->email;} ?>" required/>
</div>
<div class="form-group">
        <label for="phone"><?php echo $this->lang->line('application_phone');?></label>
        <input id="phone" type="text" name="phone" class="form-control" value="<?php if(isset($client)){echo $client->phone;}?>" />
</div>
<div class="form-group">
        <label for="mobile"><?php echo $this->lang->line('application_mobile');?></label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if(isset($client)){echo $client->mobile;}?>" />
</div>
<div class="form-group">
        <label for="address"><?php echo $this->lang->line('application_address');?></label>
        <input id="address" type="text" name="address" class="form-control" value="<?php if(isset($client)){echo $client->address;}?>" />
</div>
<div class="form-group">
        <label for="zipcode"><?php echo $this->lang->line('application_zip_code');?></label>
        <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if(isset($client)){echo $client->zipcode;}?>" />
</div>
<div class="form-group">
        <label for="city"><?php echo $this->lang->line('application_city');?></label>
        <input id="city" type="text" name="city" class="form-control" value="<?php if(isset($client)){echo $client->city;}?>" />
</div>
<div class="form-group">
        <label for="password"><?php echo $this->lang->line('application_password');?> <?php if(!isset($client)){echo "*";}?></label>
        <input id="password" type="password" name="password" class="form-control" value="<?php if(isset($client)){echo $client->password;}?>" <?php if(!isset($client)){echo "required";}?> />
</div>
<div class="form-group">
                <label for="userfile"><?php echo $this->lang->line('application_profile_picture');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="Choose File" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div>

<div class="form-group">
<?php
$access = array();
if(isset($client)){ $access = explode(",", $client->access); }
?>
<label><?php echo $this->lang->line('application_module_access');?></label>
</div>
<div class="form-group">
<ul class="accesslist">
  <?php foreach ($modules as $key => $value) { ?>
<li> <input type="checkbox" class="checkbox" id="r_<?php echo $value->link;?>" name="access[]" value="<?php echo $value->id;?>" <?php if(in_array($value->id, $access)){ echo 'checked="checked"';}?> data-labelauty="<?php echo $this->lang->line('application_'.$value->link);?>"> </li>
<?php } ?>
</ul>
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>