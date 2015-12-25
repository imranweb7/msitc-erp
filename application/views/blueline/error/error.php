<div class="col-sm-12  col-md-12 main"> 
		<div class="row">
			<a href="<?php echo base_url()?><?php echo $return_link;?>" class="btn btn-primary"><?php echo $this->lang->line('application_back');?></a>
		</div>
		<div class="row">
		<div class="table-head" style="    box-shadow: 0px -2px 0px 0px #ED5564 inset;"> ERROR</div>
		<div class="table-div" style="padding:20px">
		<p>The following error occourd after checking your credit card details:</p>
		<h5><?php echo $message;?></h5>
	</div>