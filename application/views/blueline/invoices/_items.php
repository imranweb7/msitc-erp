<?php   
$attributes = array('class' => '', 'id' => '_item');
echo form_open_multipart($form_action, $attributes);
?>

<?php if(isset($items)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $items->id;?>" />
<?php } ?>
 <div class="form-group">
        <label for="name"><?php echo $this->lang->line('item_application_name');?></label>
        <input id="name" name="name" type="text" class="required form-control"  value="<?php if(isset($items)){ echo $items->name; } ?>"  required/>
</div>
 <div class="form-group">
        <label for="value"><?php echo $this->lang->line('application_value');?></label>
     <div class="input-group">
         <span class="input-group-addon"><?php echo $core_settings->currency; ?></span>
         <input id="value" type="text" name="value" class="required form-control number"  value="<?php if(isset($items)){ echo $items->value; } ?>"  required/>
     </div>
</div>


    <input id="type" type="hidden" name="type" value="<?php if(isset($items)){ echo $items->type; } ?>" />


     <div class="form-group">
            <label for="description"><?php echo $this->lang->line('item_application_description');?></label>
            <textarea id="description" class="form-control" name="description"><?php if(isset($items)){ echo $items->description; } ?></textarea>
     </div>


    <div class="form-group">
        <label for="sku"><?php echo $this->lang->line('item_application_sku');?> *</label>
        <input id="sku" type="text" name="sku" class="required form-control" value="<?php if(isset($items)){echo $items->sku;} ?>" required />
    </div>

    <div class="form-group">
        <label for="inactive"><?php echo $this->lang->line('application_status');?></label>
        <?php
        $options = array();
        $options['0'] = 'Active';
        $options['1'] = 'Inactive';
        if(isset($items)){$status_selected = $items->inactive;}else{$status_selected = "0";}
        echo form_dropdown('inactive', $options, $status_selected, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="userfile"><?php echo $this->lang->line('item_application_file');?> *</label><div>
            <input id="uploadFile" class="form-control required uploadFile" placeholder="<?php if(isset($items)){ echo $items->photo; }else{ echo "Choose File";} ?>" disabled="disabled" required />
            <div class="fileUpload btn btn-primary">
                <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload item-new" />
            </div>
        </div>
    </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>