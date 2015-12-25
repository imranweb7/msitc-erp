<?php   
$attributes = array('class' => '', 'id' => '_decline');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($estimate)){ ?>
<input id="invoice_id" type="hidden" name="invoice_id" value="<?php echo $estimate->id;?>" />
<?php } ?>


 <div class="form-group">
        <label for="reason"><?php echo $this->lang->line('application_reason');?></label>
        <textarea id="reason" name="reason" class="textarea required form-control" style="height:100px"></textarea>

 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_send');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>