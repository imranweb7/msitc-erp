<?php   
$attributes = array('class' => '', 'id' => '_tracking_form');
echo form_open($form_action, $attributes); 
?>

 <div class="form-group">
        <label for="tracking_id"><?php echo $this->lang->line('application_tracking_id');?></label>
        <input class="form-control" name="tracking_id" id="tracking_id" type="text" value="" required/>
 </div>
 <div class="form-group">
        <label for="comments"><?php echo $this->lang->line('application_tracking_desc');?></label>
        <textarea id="comments" name="comments" class="textarea form-control" style="height:100px"></textarea>
 </div>


        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>