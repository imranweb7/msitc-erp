<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'item-list', 'id' => '_item');
echo form_open_multipart($form_action, $attributes);
$public = "0";
?>

<?php if(isset($item)){ ?>
  <input id="id" type="hidden" name="id" value="<?php echo $item->id; ?>" />
<?php } ?>

    <input id="new_item" type="hidden" name="new_item" value="0" />

<div id="item-selector">
    <label for="item_id"><?php echo $this->lang->line('application_item');?></label><br>
    <?php $options = array();
    foreach ($items as $value):
        $options[$value->id] = $value->name." - ".$value->value." ".$core_settings->currency;
        ?><span class="hidden" id="item<?php echo $value->id;?>"><?php echo $value->description;?></span><?php
    endforeach;

    echo form_dropdown('item_id', $options, '', ' class="chosen-select description-setter" ');?>
    <a class="btn btn-primary tt additem addNewitem" style="margin-left:6px; width:8%; line-height: 24px; height: 35px !important;" titel="<?php echo $this->lang->line('application_custom_item');?>"><i class="fa fa-plus"></i></a>
</div>
    <div id="item-editor">
        <div class="form-group">
        <label for="name"><?php echo $this->lang->line('item_application_name');?> *</label>
        <input id="name" type="text" name="name" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->name;} ?>" />
</div>

        <div class="form-group">
        <label for="sku"><?php echo $this->lang->line('item_application_sku');?> *</label>
        <input id="sku" type="text" name="sku" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->sku;} ?>" />
    </div>

        <div class="form-group">
            <label for="inactive"><?php echo $this->lang->line('application_status');?></label>
         <?php
         $options = array();
         $options['0'] = 'Active';
         $options['1'] = 'Inactive';
         if(isset($item)){$status_selected = $item->inactive;}else{$status_selected = "0";}
         echo form_dropdown('inactive', $options, $status_selected, 'style="width:100%" class="chosen-select"');?>
    </div>

        <div class="form-group">
        <label for="userfile"><?php echo $this->lang->line('item_application_file');?> *</label><div>
            <input id="uploadFile" class="form-control uploadFile" placeholder="<?php if(isset($item)){ echo $item->photo; }else{ echo "Choose File";} ?>" disabled="disabled" />
            <div class="fileUpload btn btn-primary">
                <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload item-new" />
            </div>
        </div>
    </div>
    </div>

    <div class="form-group">
        <label for="cost"><?php echo $this->lang->line('item_application_cost');?> *</label>
        <div class="input-group">
            <span class="input-group-addon"><?php echo $core_settings->currency; ?></span>
            <input id="cost" type="text" name="cost" class="form-control resetvalue" value="<?php if(isset($item)){echo $item->cost;} ?>"  required/>
        </div>
    </div>


        <div class="modal-footer">
          <?php if(isset($item)){ ?>
            <a href="<?php echo base_url()?>projects/item/<?php echo $item->project_id;?>/delete/<?php echo $item->id;?>" class="btn btn-danger pull-left button-loader" ><?php echo $this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        <i class="fa fa-spinner fa-spin" id="showloader" style="display:none"></i>
        <button id="send" name="send" data-keepModal="true" class="btn btn-primary send button-loader"><?php echo $this->lang->line('application_save_and_add');?></button>
        <?php } ?>
        <button name="send" class="btn btn-primary send button-loader"><?php echo $this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>