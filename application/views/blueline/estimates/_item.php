<?php   
$attributes = array('class' => '', 'id' => '_item');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($estimate)){ ?>
<input id="invoice_id" type="hidden" name="invoice_id" value="<?php echo $estimate->id;?>" />
<?php } 
if(isset($estimate_has_items)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $estimate_has_items->id;?>" />
<input id="invoice_id" type="hidden" name="invoice_id" value="<?php echo $estimate_has_items->invoice_id;?>" />
<?php } else{ ?>
<div id="item-selector" class="form-group">
        <label for="item_id"><?php echo $this->lang->line('application_item');?></label><br>
        <?php $options = array(); 
        $options['0'] = '-';
        foreach ($items as $value):
        $options[$value->id] = $value->name." - ".$value->value." ".$core_settings->currency;
?><span class="hidden" id="item<?php echo $value->id;?>"><?php echo $value->description;?></span><?php
        endforeach;
        echo form_dropdown('item_id', $options, '', ' class="chosen-select form-control" ');?>
        <!-- <a class="btn btn-primary tt additem" style="margin-left:6px; width:8%; line-height: 24px; height: 35px !important;" titel="<?php echo $this->lang->line('application_custom_item');?>"><i class="fa fa-plus"></i></a> -->
 </div>
    <!-- <div id="item-editor">
 <div class="form-group">
        <label for="name"><?php echo $this->lang->line('application_name');?></label>
        <input id="name" name="name" type="text" class="required form-control"  value="" />
 </div>
 <div class="form-group">
        <label for="value"><?php echo $this->lang->line('application_value');?></label>
        <input id="value" type="text" name="value" class="required form-control number"  value="" />
 </div>
 <div class="form-group">
        <label for="type"><?php echo $this->lang->line('application_type');?></label>
        <input id="type" type="text" name="type" class="required form-control"  value="" />
 </div>
</div> -->
<?php } ?>

 <div class="form-group">
        <label for="amount"><?php echo $this->lang->line('application_quantity_hours');?></label>
        <input id="amount" type="text" name="amount" class="required form-control number"  value="<?php if(isset($estimate_has_items)){ echo $estimate_has_items->amount; }else{echo '1';} ?>"  />
 </div>

<div class="form-group">
    <label for="value"><?php echo $this->lang->line('item_application_cost');?> *</label>
    <div class="input-group">
        <span class="input-group-addon"><?php echo $core_settings->currency; ?></span>
        <input id="value" type="text" name="value" class="form-control resetvalue" value="<?php if(isset($estimate_has_items)){echo $estimate_has_items->value;} ?>"  required/>
    </div>
</div>

<!--
 <div class="form-group">
        <label for="description"><?php echo $this->lang->line('application_description');?></label>
        <textarea id="description" class="form-control" name="description"><?php if(isset($estimate_has_items)){ echo $estimate_has_items->description; } ?></textarea>
 </div>
 -->

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>