
 <?php 
$attributes = array('class' => '', 'id' => 'payment-form');
echo form_open($form_action, $attributes); 
?>
<input type="hidden" name="invoice_id" value="<?php echo  $invoices->id;?>">
        

        <div class="payment-help"><?php echo $this->lang->line('application_you_can_pay_with');?>: Mastercard, Visa, American Express, JCB, Discover, Diners Club.</div>

        <div class="form-group">
        <label><?php echo $this->lang->line('application_card_number');?></label>
        <input type="number" size="20" autocomplete="off" name="x_card_num" class="form-control card-number input-medium" required>
        <span class="help-block"><?php echo $this->lang->line('application_enter_without_spaces');?></span>
        </div>

        <div class="form-group">
        <label>CVC</label>
        <input type="text" size="4" autocomplete="off" name="x_card_code" class="form-control card-cvc input-mini" required>
        
        </div>
        <div class="form-group">
        <label><?php echo $this->lang->line('application_expiration');?> (MM/YY)</label>
        <div class="row">
              <div class="col-xs-3 col-md-2">
                <input type="number" name="x_card_month" size="2" min="1" max="12" class="form-control card-expiry-month" required>
              </div>
              <div class="col-xs-1 col-md-1" style="line-height: 35px; text-align: center; font-size: 19px; width: 30px;">
                <span> / </span>
              </div>
              <div class="col-xs-4 col-md-2">
                <input type="number" name="x_card_year" size="2" min="10" max="99" class="form-control card-expiry-year" required>
              </div>
        </div>
        </div>

        <div class="form-group">
        <span class="help-block"><b><?php echo $this->lang->line('application_your_credit_card_will_be_charged_for');?> <?php echo display_money(sprintf("%01.2f", round($invoices->sum-$invoices->paid, 2))); ?> <?php echo $settings->authorize_currency;?></b></span>
        </div>
        
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="submitBtn"><?php echo $this->lang->line('application_send');?></button>
        <a class="btn" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>



