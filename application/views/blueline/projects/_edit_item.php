<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'item-list', 'id' => '_item');
echo form_open_multipart($form_action, $attributes);
$public = "0";
?>

<input id="id" type="hidden" name="id" value="<?php echo $item->id; ?>" />


<div class="form-group">
        <label for="name"><?php echo $this->lang->line('item_application_name');?></label>
        <input id="name" name="name" type="text" class="required form-control"  value="<?php if(isset($item)){ echo $item->name; } ?>"  required/>
</div>

<div class="form-group">
        <label for="sku"><?php echo $this->lang->line('item_application_sku');?> </label>
    <input id="sku" type="text" name="sku" class="required form-control" value="<?php if(isset($item)){echo $item->sku;} ?>" required />
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
        <label for="userfile"><?php echo $this->lang->line('item_application_file');?></label>
        <img class="img-responsive" src="<?php echo base_url().'files/media/'.$item->photo;?>" />
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