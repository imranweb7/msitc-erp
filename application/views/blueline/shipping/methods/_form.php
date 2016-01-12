<?php
$attributes = array('class' => '', 'id' => '_shippingmethod');
echo form_open($form_action, $attributes);
if(isset($shipping_method)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $shipping_method->id; ?>" />
<?php } ?>


<div class="form-group">
    <label for="name"><?php echo $this->lang->line('application_shipping_method_title');?> *</label>
    <input type="text" name="name" class="form-control" id="name"  value="<?php if(isset($shipping_method)){echo $shipping_method->name;} ?>" required/>
</div>

<div class="form-group">
    <label for="textfield"><?php echo $this->lang->line('application_shipping_method_description');?></label>
    <textarea class="input-block-level form-control"  id="textfield" name="description"><?php if(isset($shipping_method)){echo $shipping_method->description;} ?></textarea>
</div>

<div class="form-group">
    <label for="inactive"><?php echo $this->lang->line('application_shipping_method_status');?></label><br>
    <?php
    $options = array();
    $options['0'] = 'Yes';
    $options['1'] = 'No';
    if(isset($shipping_method)){$shipping_method_status_selected = $shipping_method->inactive;}else{$shipping_method_status_selected = "0";}
    echo form_dropdown('inactive', $options, $shipping_method_status_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
</div>

<?php echo form_close(); ?>
