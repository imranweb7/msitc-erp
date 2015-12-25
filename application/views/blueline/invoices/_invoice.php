<?php   
$attributes = array('class' => '', 'id' => '_invoices');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($invoice)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $invoice->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<input id="status" name="status" type="hidden" value="Open"> 
 <div class="form-group">
        <label for="reference"><?php echo $this->lang->line('application_reference_id');?> *</label>
        <?php if(!empty($core_settings->invoice_prefix)){ ?>
       <div class="input-group"> <div class="input-group-addon"><?php echo $core_settings->invoice_prefix;?></div> <?php } ?>
        <input id="reference" type="text" name="reference" class="form-control"  value="<?php if(isset($invoice)){echo $invoice->reference;} else{ echo $core_settings->invoice_reference; } ?>" />
        <?php if(!empty($core_settings->invoice_prefix)){ ?> </div><?php } ?>
 </div>
 <div class="form-group">
        <label for="client"><?php echo $this->lang->line('application_client');?></label>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($companies as $value):  
                $options[$value->id] = $value->name;
                $projects[$value->id] = $value->projects;
                endforeach;
        if(isset($invoice)){$client = $invoice->company_id; $project = $invoice->project_id;}else{$client = ""; $project = "";}
        echo form_dropdown('company_id', $options, $client, 'style="width:100%" data-destination="getProjects" class="chosen-select getProjects"');?>
 </div> 

  <div class="form-group">
        <label for="project"><?php echo $this->lang->line('application_projects');?></label>
        <select name="project_id" id="getProjects" style="width:100%" class="chosen-select">
            <option value="0">-</option>
            <?php foreach ($companies as $comp): ?>
                <optgroup label="<?php echo $comp->name?>" id="optID_<?php echo $comp->id?>" <?php if($client != $comp->id){ ?>disabled="disabled"<?php } ?>>
                  <?php foreach ($comp->projects as $pro): ?>
                    <option value="<?php echo $pro->id?>" <?php if($project == $pro->id){ ?>selected="selected"<?php } ?>><?php echo $pro->name?></option>
                    <?php endforeach; ?>
                </optgroup>
           <?php endforeach; ?>
        </select>

 </div> 

<?php if(isset($invoice)){ ?>
 <div class="form-group">
        <label for="status"><?php echo $this->lang->line('application_status');?></label>
        <?php $options = array(
                  'Open'  => $this->lang->line('application_Open'),
                  'Sent'    => $this->lang->line('application_Sent'),
                  'Paid' => $this->lang->line('application_Paid'),
                  'PartiallyPaid' => $this->lang->line('application_PartiallyPaid'),
                  'Canceled' => $this->lang->line('application_Canceled'),

                );
                echo form_dropdown('status', $options, $invoice->status, 'style="width:100%" class="chosen-select"'); ?>

 </div>
<?php } ?>
<?php if(isset($invoice)){ if($invoice->status == "Paid"){ ?>
 <div class="form-group">
        <label for="paid_date"><?php echo $this->lang->line('application_payment_date');?></label>
        <input id="paid_date" type="text" name="paid_date" class="datepicker form-control" value="<?php if(isset($invoice)){echo $invoice->paid_date;} ?>"  required/>
 </div>
 <?php }} ?>
 <div class="form-group">
        <label for="issue_date"><?php echo $this->lang->line('application_issue_date');?></label>
        <input id="issue_date" type="text" name="issue_date" class="datepicker form-control" value="<?php if(isset($invoice)){echo $invoice->issue_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="due_date"><?php echo $this->lang->line('application_due_date');?></label>
        <input id="due_date" type="text" name="due_date" class="required datepicker form-control" value="<?php if(isset($invoice)){echo $invoice->due_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="currency"><?php echo $this->lang->line('application_currency');?></label>
        <input id="currency" type="text" name="currency" class="required form-control" value="<?php if(isset($invoice)){ echo $invoice->currency; }else { echo $core_settings->currency; } ?>" required/>
 </div>
 <div class="form-group">
        <label for="currency"><?php echo $this->lang->line('application_discount');?></label>
        <input class="form-control" name="discount" id="appendedInput" type="text" value="<?php if(isset($invoice)){ echo $invoice->discount;} ?>"/>
 </div>
 <div class="form-group">
        <label for="terms"><?php echo $this->lang->line('application_terms');?></label>
        <textarea id="terms" name="terms" class="textarea required summernote-modal form-control" style="height:100px"><?php if(isset($invoice)){echo $invoice->terms;}else{ echo $core_settings->invoice_terms; }?></textarea>
 </div>
  <div class="form-group">
        <label for="terms"><?php echo $this->lang->line('application_custom_tax');?></label>
        <input class="form-control" name="tax" type="text" value="<?php if(isset($invoice)){ echo $invoice->tax;}else{echo $core_settings->tax;} ?>" />
 </div>
    <div class="form-group">
        <label for="terms"><?php echo $this->lang->line('application_second_tax');?></label>
        <input class="form-control" name="second_tax" type="text" value="<?php if(isset($invoice)){ echo $invoice->second_tax;} ?>"/>
 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>