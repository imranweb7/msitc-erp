
<?php 
$attributes = array('class' => '', 'id' => '_quotation');
echo form_open($form_action, $attributes); 
?>
<style type="text/css">	
	input.labelauty + label {
		width: 100%;
	}
	.table-div {
		padding:15px;
	}
</style>
<div class="table-head"><?php echo $quotation->name;?></div>
	<div class="table-div">	
		<?php echo $fields;?>
	<div class="bottom">
		<input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('quotation_save');?>"/>
	</div>
<input type="hidden" id="tfields" name="tfields" value=""/>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">

var xResultString = '';

$('.control-label').each(function(){
  xResultString += $.trim($(this).html()+"||");
 })
$('#tfields').val(xResultString);
</script>