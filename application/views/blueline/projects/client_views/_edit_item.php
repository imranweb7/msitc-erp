<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'item-list', 'id' => '_item');
echo form_open_multipart($form_action, $attributes);
$public = "0";
?>

<input id="id" type="hidden" name="id" value="<?php echo $item->id; ?>" />


<h2><?php if(isset($item)){ echo $item->name; } ?></h2>


<div class="form-group">
    <label for="quantity"><?php echo $this->lang->line('item_application_qty');?> </label>
    <input id="quantity" type="text" name="quantity" class="required form-control" value="<?php if(isset($item)){echo $item->quantity;} ?>" required />
</div>


        <div class="modal-footer">
           <button name="send" class="btn btn-primary send button-loader"><?php echo $this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>