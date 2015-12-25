<?php   
$attributes = array('class' => '', 'id' => '_item');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($subscription)){ ?>
<input id="subscription_id" type="hidden" name="subscription_id" value="<?php echo $subscription->id;?>" />
<?php } 
if(isset($subscription_has_items)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $subscription_has_items->id;?>" />
<input id="subscription_id" type="hidden" name="subscription_id" value="<?php echo $subscription_has_items->subscription_id;?>" />
<?php } else{ ?>
<div class="form-group">
<p id="item-selector">
        <label for="item_id"><?php echo $this->lang->line('application_item');?></label><br>
        <?php $options = array(); 
        $options['-'] = '-';
        foreach ($items as $value):
        $options[$value->id] = $value->name." - ".$value->value." ".$core_settings->currency;
        endforeach;
        echo form_dropdown('item_id', $options, '', 'style="width:85%" class="chosen-select"');?>
        <a class="btn btn-primary tt additem" style="margin-left:6px; width:8%; line-height: 24px; height: 35px !important;" titel="<?php echo $this->lang->line('application_custom_item');?>"><i class="fa fa-plus"></i></a>
</p>
</div> 
<div id="item-editor">
<div class="form-group">
        <label for="name"><?php echo $this->lang->line('application_name');?></label>
        <input id="name" name="name" type="text" class="form-control"  value=""  />
</div> 

 <div class="form-group">
        <label for="value"><?php echo $this->lang->line('application_value');?></label>
        <input id="value" type="text" name="value" class="form-control number"  value=""  />
</div> 

 <div class="form-group">
        <label for="type"><?php echo $this->lang->line('application_type');?></label>
        <input id="type" type="text" name="type" class="form-control"  value="" />
</div> 
</div>
<?php } ?>
<div class="form-group">
        <label for="amount"><?php echo $this->lang->line('application_quantity_hours');?></label>
        <input id="amount" type="text" name="amount" class="form-control number"  value="<?php if(isset($subscription_has_items)){ echo $subscription_has_items->amount; }else{echo '1';} ?>"  required/>
</div> 

 <div class="form-group">
        <label for="description"><?php echo $this->lang->line('application_description');?></label>
        <textarea id="description" class="form-control" name="description"><?php if(isset($subscription_has_items)){ echo $subscription_has_items->description; } ?></textarea>
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>