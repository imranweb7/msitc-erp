<?php   
$attributes = array('class' => '', 'id' => '_queue');
echo form_open($form_action, $attributes); 
if(isset($ticket)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $ticket->id; ?>" />
<?php } ?>
  
<div class="form-group">
        <label for="queue"><?php echo $this->lang->line('application_queue');?></label>
        <?php $queuelist = array();
                 foreach ($queues as $queue):
                    $queuelist[$queue->id] = $queue->name;
                endforeach;
        echo form_dropdown('queue_id', $queuelist, $ticket->queue_id, 'style="width:100%" class="chosen-select"');?>
</div>    

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>