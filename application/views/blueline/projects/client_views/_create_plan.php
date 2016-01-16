<?php
if($max_qty <= 0){
    echo '<p class="btn btn-danger">Sorry, item out of stock!!!</p>';

}else{

$attributes = array('class' => 'dynamic-pre-form', 'id' => '_create_plan');
echo form_open_multipart($form_action, $attributes);
?>

<div class="form-group">
    <label for="shipping_qty"><?php echo $this->lang->line('application_shipping_qty_require');?> *</label>
    <input type="number" name="amount" class="form-control" id="amount"  value="<?php if(isset($plan)){echo $plan->amount;} ?>" max="<?php echo $max_qty; ?>" data-error=
    "Please enter quantity between 1 to <?php echo $max_qty; ?>" required/>
    <div class="help-block with-errors"></div>
</div>

<div class="form-group">
    <label for="shipping_name"><?php echo $this->lang->line('application_shipping_contact');?> *</label>
    <input type="text" name="shipping_name" class="form-control" id="shipping_name"  value="<?php if(isset($plan)){echo $plan->shipping_name;} ?>" required/>
</div>


<div class="form-group">
    <label for="shipping_company"><?php echo $this->lang->line('application_shipping_company');?></label>
    <input type="text" name="shipping_company" class="form-control" id="shipping_company"  value="<?php if(isset($plan)){echo $plan->shipping_company;} ?>"/>
</div>


<div class="form-group">
    <label for="shipping_address'"><?php echo $this->lang->line('application_shipping_address');?> *</label>
    <textarea class="input-block-level form-control" id="shipping_address'" name="shipping_address" required><?php if(isset($plan)){echo $plan->shipping_address;} ?></textarea>
</div>

<div class="form-group">
    <label for="shipping_city"><?php echo $this->lang->line('application_shipping_city');?> *</label>
    <input type="text" name="shipping_city" class="form-control" id="shipping_city"  value="<?php if(isset($plan)){echo $plan->shipping_city;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_state"><?php echo $this->lang->line('application_shipping_state');?></label>
    <input type="text" name="shipping_state" class="form-control" id="shipping_state"  value="<?php if(isset($plan)){echo $plan->shipping_state;} ?>"/>
</div>

<div class="form-group">
    <label for="shipping_zip"><?php echo $this->lang->line('application_shipping_zip');?> *</label>
    <input type="text" name="shipping_zip" class="form-control" id="shipping_zip"  value="<?php if(isset($plan)){echo $plan->shipping_zip;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_country"><?php echo $this->lang->line('application_shipping_country');?> *</label>

    <?php
    $options = $geolib->getCountryAssociativeArray();
    if(isset($item)){$country_selected = $item->shipping_country;}else{$country_selected = "";}
    echo form_dropdown('shipping_country', $options, $country_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="form-group">
    <label for="shipping_phone"><?php echo $this->lang->line('application_shipping_phone');?> </label>
    <input type="text" name="shipping_phone" class="form-control" id="shipping_phone"  value="<?php if(isset($plan)){echo $plan->shipping_phone;} ?>" />
</div>

<!--
<div class="form-group">
    <label for="shipping_email"><?php echo $this->lang->line('application_shipping_email');?> *</label>
    <input type="text" name="shipping_email" class="form-control" id="shipping_email"  value="<?php if(isset($plan)){echo $plan->shipping_email;} ?>" required/>
</div>
-->

<input type="hidden" name="shipping_email" id="shipping_email" value="<?php if(isset($plan)){echo $plan->shipping_email;} ?>"/>

<!--<div class="form-group">
    <label for="shipping_website"><?php echo $this->lang->line('application_shipping_website');?> *</label>
    <input type="text" name="shipping_website" class="form-control" id="shipping_website"  value="<?php if(isset($plan)){echo $plan->shipping_website;} ?>" required/>
</div>
-->
<input type="hidden" name="shipping_website" id="shipping_website" value="<?php if(isset($plan)){echo $plan->shipping_website;} ?>"/>


<div class="form-group">
    <label for="shipping_lebel"><?php echo $this->lang->line('application_shipping_lebel');?></label>
    <div>
        <input id="uploadFile" type="text" name="dummy" class="form-control uploadFile" placeholder="<?php if(isset($plan->shipping_lebel)){ echo $plan->shipping_lebel; }else{ echo "Choose File";} ?>" readonly/>
        <div class="fileUpload btn btn-primary">
            <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
            <input id="uploadBtn" type="file" data-switcher="attachment_description" name="userfile" class="upload switcher" accept="capture=camera" />
        </div>
    </div>
</div>

<input name="tax" type="hidden" value="<?php if(isset($plan)){ echo $plan->tax;}else{echo $core_settings->tax;} ?>"/>
<input name="second_tax" type="hidden" value="<?php if(isset($plan)){ echo $plan->second_tax;} ?>"/>


<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
</div>

<?php echo form_close(); } ?>
