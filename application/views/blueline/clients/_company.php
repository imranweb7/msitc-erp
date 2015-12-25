<?php   
$attributes = array('class' => '', 'id' => '_company');
echo form_open_multipart($form_action, $attributes); 
?>

<?php if(isset($company)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $company->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>

<div class="form-group">

        <label for="reference"><?php echo $this->lang->line('application_reference_id');?> *</label>
        <?php if(!empty($core_settings->company_prefix)){ ?>
       <div class="input-group"> <div class="input-group-addon"><?php echo $core_settings->company_prefix;?></div> <?php } ?>
        <input id="reference" type="text" name="reference" class="required form-control"  value="<?php if(isset($company)){echo $company->reference;} else{ echo $core_settings->company_reference; } ?>"   readonly="readonly"  />
        <?php if(!empty($core_settings->company_prefix)){ ?></div> <?php } ?>
</div>

<?php if(isset($company)){ ?>
<div class="form-group">
        <label for="contact"><?php echo $this->lang->line('application_primary_contact');?></label>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($company->clients as $value):  
                $options[$value->id] = $value->firstname.' '.$value->lastname;
                endforeach;
        if(isset($company->client->id)){ $client = $company->client->id; }else{$client = "0";} 
        echo form_dropdown('client_id', $options, $client, 'style="width:100%" class="chosen-select"');?>
</div>      
<?php } ?>

<div class="form-group">
        <label for="name"><?php echo $this->lang->line('application_company');?> <?php echo $this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if(isset($company)){echo $company->name;} ?>"  required/>
</div>
<div class="form-group">
        <label for="website"><?php echo $this->lang->line('application_website');?></label>
        <input id="website" type="text" name="website" class="required form-control" value="<?php if(isset($company)){echo $company->website;} ?>" />
</div>
<div class="form-group">
        <label for="phone"><?php echo $this->lang->line('application_phone');?></label>
        <input id="phone" type="text" name="phone" class="form-control" value="<?php if(isset($company)){echo $company->phone;}?>" />
</div>
<div class="form-group">
        <label for="mobile"><?php echo $this->lang->line('application_mobile');?></label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if(isset($company)){echo $company->mobile;}?>" />
</div>
<div class="form-group">
        <label for="address"><?php echo $this->lang->line('application_address');?></label>
        <input id="address" type="text" name="address" class="form-control" value="<?php if(isset($company)){echo $company->address;}?>" />
</div>
<div class="form-group">
        <label for="zipcode"><?php echo $this->lang->line('application_zip_code');?></label>
        <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if(isset($company)){echo $company->zipcode;}?>" />
</div>
<div class="form-group">
        <label for="city"><?php echo $this->lang->line('application_city');?></label>
        <input id="city" type="text" name="city" class="form-control" value="<?php if(isset($company)){echo $company->city;}?>" />
</div>
<div class="form-group">
        <label for="country"><?php echo $this->lang->line('application_country');?></label>
        <input id="country" type="text" name="country" class="form-control" value="<?php if(isset($company)){echo $company->country;}?>" />
</div>
<div class="form-group">
        <label for="province"><?php echo $this->lang->line('application_province');?></label>
        <input id="province" type="text" name="province" class="form-control" value="<?php if(isset($company)){echo $company->province;}?>" />
</div>
<div class="form-group">
        <label for="vat"><?php echo $this->lang->line('application_vat');?></label>
        <input id="vat" type="text" name="vat" class="form-control" value="<?php if(isset($company)){echo $company->vat;}?>" />
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>