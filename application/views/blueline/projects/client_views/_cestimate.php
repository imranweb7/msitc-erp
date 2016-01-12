<?php
$attributes = array('class' => 'dynamic-form', 'id' => '_cestimate');
echo form_open_multipart($form_action, $attributes);
if(isset($estimate)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $estimate->id; ?>" />
<?php } ?>

<div class="form-group">
    <label for="shipping_method"><?php echo $this->lang->line('application_select_shipping_method');?></label><br>
    <?php
    $options = array();
    $method_found = false;
    foreach ($shipping_methods as $value):
        $options[$value->name] = $value->name;

        if(isset($estimate)){
            if($value->name == $estimate->shipping_method){
                $method_found = true;
            }
        }
    endforeach;

    if(isset($estimate)){
        $shipping_method_selected = $estimate->shipping_method;

        if(!$method_found){
            $options[$shipping_method_selected] = $shipping_method_selected;
        }
    }else{
        $shipping_method_selected = "";
    }
    echo form_dropdown('shipping_method', $options, $shipping_method_selected, 'style="width:100%" class="chosen-select"');?>

</div>


<div class="form-group">
    <label for="shipping_goods_description'"><?php echo $this->lang->line('application_shipping_goods_description');?> *</label>
    <textarea class="input-block-level form-control" id="shipping_goods_description'" name="shipping_goods_description" required><?php if(isset($estimate)){echo $estimate->shipping_goods_description;} ?></textarea>
</div>

<div class="form-group">
    <label for="shipping_total_boxes"><?php echo $this->lang->line('application_shipping_total_boxes');?> *</label>
    <input type="number" name="shipping_total_boxes" class="form-control" id="shipping_total_boxes"  value="<?php if(isset($estimate)){echo $estimate->shipping_total_boxes;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_qty_per_box"><?php echo $this->lang->line('application_shipping_qty_per_box');?> *</label>
    <input type="number" name="shipping_qty_per_box" class="form-control" id="shipping_qty_per_box"  value="<?php if(isset($estimate)){echo $estimate->shipping_qty_per_box;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_box_size"><?php echo $this->lang->line('application_shipping_box_size');?></label><br>
    <?php
    $options = array();
    $options['W'] = 'W';
    $options['L'] = 'L';
    $options['H'] = 'H';
    if(isset($estimate)){$shipping_box_size_selected = $estimate->shipping_box_size;}else{$shipping_box_size_selected = "W";}
    echo form_dropdown('shipping_box_size', $options, $shipping_box_size_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="form-group">
    <label for="shipping_box_weight"><?php echo $this->lang->line('application_shipping_box_weight');?> *</label>
    <input type="text" name="shipping_box_weight" class="form-control" id="shipping_box_weight" value="<?php if(isset($estimate)){echo $estimate->shipping_box_weight;} ?>" required/>
</div>


<div class="form-group">
    <label for="shipping_name"><?php echo $this->lang->line('application_shipping_contact');?> *</label>
    <input type="text" name="shipping_name" class="form-control" id="shipping_name"  value="<?php if(isset($estimate)){echo $estimate->shipping_name;} ?>" required/>
</div>


<div class="form-group">
    <label for="shipping_company"><?php echo $this->lang->line('application_shipping_company');?></label>
    <textarea class="input-block-level form-control" id="shipping_company" name="shipping_company"><?php if(isset($estimate)){echo $estimate->shipping_company;} ?></textarea>
</div>


<div class="form-group">
    <label for="shipping_address'"><?php echo $this->lang->line('application_shipping_address');?> *</label>
    <textarea class="input-block-level form-control" id="shipping_address'" name="shipping_address" required><?php if(isset($estimate)){echo $estimate->shipping_address;} ?></textarea>
</div>

<div class="form-group">
    <label for="shipping_city"><?php echo $this->lang->line('application_shipping_city');?> *</label>
    <input type="text" name="shipping_city" class="form-control" id="shipping_city"  value="<?php if(isset($estimate)){echo $estimate->shipping_city;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_state"><?php echo $this->lang->line('application_shipping_state');?></label>
    <input type="text" name="shipping_state" class="form-control" id="shipping_state"  value="<?php if(isset($estimate)){echo $estimate->shipping_state;} ?>"/>
</div>

<div class="form-group">
    <label for="shipping_zip"><?php echo $this->lang->line('application_shipping_zip');?> *</label>
    <input type="text" name="shipping_zip" class="form-control" id="shipping_zip"  value="<?php if(isset($estimate)){echo $estimate->shipping_zip;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_country"><?php echo $this->lang->line('application_shipping_country');?> *</label>
    <input type="text" name="shipping_country" class="form-control" id="shipping_country"  value="<?php if(isset($estimate)){echo $estimate->shipping_country;} ?>" required/>
</div>

<div class="form-group">
    <label for="shipping_phone"><?php echo $this->lang->line('application_shipping_phone');?> *</label>
    <input type="text" name="shipping_phone" class="form-control" id="shipping_phone"  value="<?php if(isset($estimate)){echo $estimate->shipping_phone;} ?>" required/>
</div>

<!--
<div class="form-group">
    <label for="shipping_email"><?php echo $this->lang->line('application_shipping_email');?> *</label>
    <input type="text" name="shipping_email" class="form-control" id="shipping_email"  value="<?php if(isset($estimate)){echo $estimate->shipping_email;} ?>" required/>
</div>
-->

<input type="hidden" name="shipping_email" id="shipping_email" value="<?php if(isset($estimate)){echo $estimate->shipping_email;} ?>"/>

<!--<div class="form-group">
    <label for="shipping_website"><?php echo $this->lang->line('application_shipping_website');?> *</label>
    <input type="text" name="shipping_website" class="form-control" id="shipping_website"  value="<?php if(isset($estimate)){echo $estimate->shipping_website;} ?>" required/>
</div>
-->
<input type="hidden" name="shipping_website" id="shipping_website" value="<?php if(isset($estimate)){echo $estimate->shipping_website;} ?>"/>


<div class="form-group">
    <label for="shipping_lebel"><?php echo $this->lang->line('application_shipping_lebel');?></label>
    <div>
        <input id="uploadFile" type="text" name="dummy" class="form-control uploadFile" placeholder="<?php if(isset($estimate->shipping_lebel)){ echo $estimate->shipping_lebel; }else{ echo "Choose File";} ?>" readonly/>
        <div class="fileUpload btn btn-primary">
            <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
            <input id="uploadBtn" type="file" data-switcher="attachment_description" name="userfile" class="upload switcher" accept="capture=camera" />
        </div>
    </div>
</div>

<input name="tax" type="hidden" value="<?php if(isset($estimate)){ echo $estimate->tax;}else{echo $core_settings->tax;} ?>"/>
<input name="second_tax" type="hidden" value="<?php if(isset($estimate)){ echo $estimate->second_tax;} ?>"/>


<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
</div>

<?php echo form_close(); ?>
