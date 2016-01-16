<?php

$language = $this->input->cookie('language');
if (!isset($language))
{
  $language = $core_settings->language;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta name="Author" content="<?php echo  $core_settings->company?>"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="invoice.css" type="text/css" charset="utf-8" />
    <style type="text/css">
body{
  color: #61686d;
  font: 14px "open-sans", Helvetica, Arial, Verdana, sans-serif;
  font-weight: lighter;
  padding-bottom: 60px;
}

#page {
  background: #ffffff;
  width: 100%;
  margin: 0 auto;
  margin-top: 0px;
  display: block;
  /*padding: 40px 40px 50px 40px;
  position: relative;*/
  z-index: 0;
}

.headline {
  color: #4d5357;
  font-weight: lighter;
  font-size: 48px;
  margin: 20px 0 0 0;
}

.terms {
  width: 400px;
  margin: 0 0 40px 0;
  font-size: 12px;
  color: #a1a7ac;
  line-height: 180%;
}

.terms strong {
  font-size: 16px;
}

.recipient-address {
  padding-top: 60px;
  width: 200px;
}

.company-logo {
  right: 40px;
  top: 40px;
  float:right;
  max-height:70px;
}

.company-address {
  width: 200px;
  color: #a1a7ac;
  position: absolute;
  right: 0px;
  top:70px;
  text-align: right;
}

.status {
  position: absolute;
  top: -50px;
  left: -50px;
  text-indent: -5000px;
  width: 128px;
  height: 128px;
}

.Open {
  background-image: url(<?php echo base_url(); ?>assets/blueline/img/<?php echo $language;?>/status-open.png);
}

.Sent {
  background-image: url(<?php echo base_url(); ?>assets/blueline/img/<?php echo $language;?>/status-sent.png);
}

.Paid {
  background-image: url(<?php echo base_url(); ?>assets/blueline/img/<?php echo $language;?>/status-paid.png);
}

.Overdue {
  background-image: url(<?php echo base_url(); ?>assets/blueline/img/<?php echo $language;?>/status-overdue.png);
}

hr {
  clear: both;
  border: none;
  background: none;
  border-bottom: 1px solid #d6dde2;
}

.total-due {
  float: right;
  width: 250px;
  border: 1px solid #d6dde2;
  margin: 20px 0 40px 0;
  padding: 0;
  border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;
  text-align: right;
}

.total-heading {
  background: #e7ebee;
  color: #63676b;
  text-shadow: 0 1px 1px #ffffff;
  padding: 8px 20px 0 0;
  -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0px 0px 0px 1px rgba(255,255,255,0.5), 0 2px 2px rgba(0, 0, 0, 0.08);
  border-bottom: 1px solid #d6dde2;
}

.total-heading p, .total-amount p {
  margin: 0; padding: 0;
}

.total-amount {
  padding: 8px 20px 8px 0;
  color: #4d5357;
  font-size: 24px;
  margin:0;
}

table.tablesorter {
  width: 100%;
  text-align: left;
  border:0;
  margin: 0px 0 0 0;
  color: #a1a7ac;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
  margin: 0;
}
table.tablesorter thead tr.header {
  background: #e7ebee;
  color: #4d5357;
  text-shadow: 0 1px 1px #ffffff;
  padding-left: 20px;
  -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0px 0px 0px 1px rgba(255,255,255,0.5), 0 2px 2px rgba(0, 0, 0, 0.08);
  border-bottom: 1px solid #d6dde2;
}
table.tablesorter thead tr.header th{
  font-size: 11px;
  height:30px;
  border-bottom: 1px solid #d8dcdf;
  text-align: left;
  padding-left:10px;
  }
.round{
   border: 1px solid #d6dde2;
  border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px;
}
table.tablesorter tbody td {
  padding: 10px;
  vertical-align: top;
  font-size: 11px;
}
table.tablesorter tbody tr.even td {
  background: #f6f8f9;
}
.custom-terms {
  padding:20px 10px;
}
.sum{
  width:50%;
  padding:5px 10px;
}
.margin{
  padding:5px 10px;
  height:20px;
}

    </style>

</head>

<body>
<div><img src="<?php echo base_url(); ?><?php echo $core_settings->invoice_logo;?>" class="company-logo" /><div>
<div id="page">
  <div class="status <?php if($invoice->due_date <= date('Y-m-d') && $invoice->status != "Paid"){ echo "Overdue"; }else{ echo $invoice->status;} ?>">
  </div>
  <div>  
  <p class="recipient-address">
  <strong><?php echo $invoice->company->name;?></strong><br />
<?php if(isset($invoice->company->client->firstname)){ ?> <?php echo $invoice->company->client->firstname;?> <?php echo $invoice->company->client->lastname;?> <br><?php } ?>
<?php echo $invoice->company->address;?><br>
<?php echo $invoice->company->city;?><br>
<?php echo $invoice->company->zipcode;?>
<?php if($invoice->company->province != ""){?>
<br><?php echo $invoice->company->province;?>
<?php } ?>
<?php if($invoice->company->vat != ""){?>
<br><?php echo $this->lang->line('application_vat');?>: <?php echo $invoice->company->vat; ?>
      <?php } ?>
</p>


   <p class="company-address">
    <?php echo $core_settings->company;?><br>
    <?php echo $core_settings->invoice_contact;?><br>
    <?php echo $core_settings->invoice_address;?><br>
    <?php echo $core_settings->invoice_city;?><br>
    <?php echo $core_settings->invoice_tel;?><br>
  </p> 
</div>

  <span class="headline"><?php echo $this->lang->line('application_invoice');?> <?php echo $core_settings->invoice_prefix;?><?php echo $invoice->reference;?></span>
  <p class="terms"><strong><?php echo date($core_settings->date_format, human_to_unix($invoice->issue_date.' 00:00:00'));?></strong><br/>
  <?php echo $this->lang->line('application_due_date');?> <?php echo date($core_settings->date_format, human_to_unix($invoice->due_date.' 00:00:00'));?></p>
  


    <div class="round"> 
    <table id="table" class="tablesorter" cellspacing="0"> 
  <thead> 
  <tr class="header"> 
    <th><?php echo $this->lang->line('application_item');?></th>
    <th><?php echo $this->lang->line('application_description');?></th>
    <th width="8%"><?php echo $this->lang->line('application_hrs_qty');?></th>
    <th width="12%"><?php echo $this->lang->line('application_unit_price');?></th>
    <th width="12%"><?php echo $this->lang->line('application_sub_total');?></th>
  </tr> 
  </thead> 
  <tbody> 
  <?php $i = 0; $sum = 0; $row=false; ?>
    <?php

    if($invoice->invoice_type == 'Shipment'){
      $item_type = 'invoice_has_shipping_items';
    }else{
      $item_type = 'invoice_has_items';
    }

    $invoice_item = $invoice->$item_type;

    foreach ($items as $value):?>
    <tr <?php if($row){?>class="even"<?php } ?>>
      <td><?php if(!empty($value->name)){echo $value->name;}else{ echo $invoice_item[$i]->name; }?></td>
      <td><?php echo  str_replace("&lt;br&gt;", "<br>", $invoice_item[$i]->description);?></td>
      <td align="center"><?php echo $invoice_item[$i]->amount;?></td>
      <td><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->value));?></td>
      <td><?php echo display_money(sprintf("%01.2f",$invoice_item[$i]->amount*$invoice_item[$i]->value));?></td>
    </tr>
    <?php $sum = $sum+$invoice_item[$i]->amount*$invoice_item[$i]->value; $i++; if($row){$row=false;}else{$row=true;}?>
    
    <?php endforeach;
    if(empty($items)){ echo "<tr><td colspan='5'>".$this->lang->line('application_no_items_yet')."</td></tr>";}
    if(substr($invoice->discount, -1) == "%"){ $discount = sprintf("%01.2f", round(($sum/100)*substr($invoice->discount, 0, -1), 2)); }
    else{$discount = $invoice->discount;}
    $sum = $sum-$discount;
    $presum = $sum;

    if($invoice->tax != ""){
      $tax_value = $invoice->tax;
    }else{
      $tax_value = $core_settings->tax;
    }

    $tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
    $sum = sprintf("%01.2f", round($sum+$tax, 2));
    ?>
    
  </tbody> 
  </table> 
    </div> 
  
  <div class="total-due">
     <?php if ($invoice->discount != 0 || $tax_value != "0"){ ?>
        <table width="100%">
          <?php if ($invoice->discount != 0): ?>
        <tr >
          <td align="left" class="margin"><?php echo $this->lang->line('application_discount');?></td>
          <td align="right" style="padding-right:20px">- <?php echo display_money($invoice->discount);?></td>
        </tr> 
        <?php endif ?>
        <tr >
          <td align="left" class="margin"><?php echo $this->lang->line('application_total');?></td>
          <td align="right" style="padding-right:20px"><?php echo display_money($presum);?></td>
        </tr> 
       <?php if($tax_value != "0"){ ?>
        <tr>
          <td align="left" class="margin"><?php echo $this->lang->line('application_tax');?> (<?php echo  $tax_value?>%)</td>
          <td align="right" style="padding-right:20px"><?php echo display_money($tax)?></td>
        </tr>
        <?php } ?>
        <?php if($invoice->paid > "0"){ ?>
        <tr>
          <td align="left" class="margin"><?php echo $this->lang->line('application_payments_received');?></td>
          <td align="right" style="padding-right:20px"><?php echo display_money($invoice->paid, $invoice->currency)?></td>
        </tr>
        <?php } ?>
         
        </table>
    <?php } ?>
    <div class="total-amount total-heading"><p><?php echo display_money($sum-$invoice->paid, $invoice->currency);?></p></div>
  </div>
  <div class="custom-terms">
  <?php echo $invoice->terms; ?>
  </div>
</div>

<script type='text/php'>
        if ( isset($pdf) ) { 
          $font = Font_Metrics::get_font('helvetica', 'normal');
          $size = 9;
          $y = $pdf->get_height() - 24;
          $x = $pdf->get_width() - 15 - Font_Metrics::get_text_width('1/1', $font, $size);
          $pdf->page_text($x, $y, '{PAGE_NUM}/{PAGE_COUNT}', $font, $size);
        } 
      </script>

</body>
</html>
