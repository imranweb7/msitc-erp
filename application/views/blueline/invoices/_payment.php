<?php   
$attributes = array('class' => '', 'id' => '_partial');
echo form_open($form_action, $attributes); 
?>

<input id="invoice_id" type="hidden" name="invoice_id" value="<?php echo $invoice->id;?>" />
<?php if(isset($payment)){?>
<input id="id" type="hidden" name="id" value="<?php echo $payment->id;?>" />
<?php } ?>

 <div class="form-group">
        <label for="name"><?php echo $this->lang->line('application_reference_id');?></label>
        <input id="name" name="reference" type="text" class="required form-control"  value="<?php if(isset($payment)){ echo $payment->reference; }else{ echo $invoice->reference."00".$payment_reference; }?>" />
 </div>
 <div class="form-group">
        <label for="value"><?php echo $this->lang->line('application_value');?> *</label>
        <input id="value" type="text" name="amount" class="required form-control number"  value="<?php if(isset($payment)){ echo $payment->amount; }else{ echo $sumRest; }?>" required/>
 </div>
 <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('application_date');?> *</label>
                          <input class="form-control datepicker" name="date" id="date" type="text" value="<?php if(isset($payment)){ echo $payment->date; }else{  echo date('Y-m-d', time()); }?>" data-date-format="yyyy-mm-dd" required/>
</div>
<div class="form-group">
        <label for="client"><?php echo $this->lang->line('application_client');?></label><br>
        <?php $options = array();
                $options['cash'] = $this->lang->line('application_cash');
                $options['credit_card'] = $this->lang->line('application_credit_card');
                $options['paypal'] = $this->lang->line('application_paypal');
                $options['bank_transfer'] = $this->lang->line('application_bank_transfer');

                
                if(isset($payment)){ $select = $payment->type; }else{ $select = "cash"; }
        echo form_dropdown('type', $options, 'cash', 'style="width:100%" class="chosen-select"');?>
        
</div>
 <div class="form-group">
                        <label for="textfield"><?php echo $this->lang->line('application_description');?></label>
                        <textarea class="input-block-level form-control"  id="textfield" name="notes"><?php if(isset($payment)){echo $payment->notes;} ?></textarea>
</div>


        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>