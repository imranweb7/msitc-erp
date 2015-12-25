<div class="col-sm-12  col-md-12 main">  
	<div id="options" class="row">
			<a href="<?php echo base_url()?>quotations/cupdate/<?php echo $quotation->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_edit_quotation');?></a>

		
</div>

		<div class="row">
			<div class="span12">
				<div class="table-head"><?php echo $this->lang->line('application_quotation_details');?></div>
				<div class="subcont">
					<ul class="details">
						<li><span><?php echo $this->lang->line('application_quotation');?>:</span> <?php if(isset($quotation->customquote->name)){echo $quotation->customquote->name;}else{ echo "-";};?></li>
						<li class="<?php echo $quotation->status;?>"><span><?php echo $this->lang->line('application_status');?>:</span> <a class="label <?php if($quotation->status == "New"){echo "label-important";}elseif($quotation->status == "Accepted"){ echo "label-success";}elseif($quotation->status == "Reviewed"){ echo "label-warning";} ?>"><?php echo $this->lang->line('application_'.$quotation->status);?></a></li>
						<li><span><?php echo $this->lang->line('application_worker');?>:</span> <?php if(isset($quotation->user->firstname)){echo $quotation->user->firstname; echo " ".$quotation->user->lastname;}else{echo "-";}?></li>
						<li><span><?php echo $this->lang->line('application_date');?>:</span> <?php  $unix = human_to_unix($quotation->date); echo date('jS F Y H:i', $unix);?></li>
					</ul>
				</div>
			</div>

	</div>
			<br/>
			<div class="row">
		<div class="table-head"><?php echo $this->lang->line('application_answers');?></div>
		<div class="subcont">
		<ul class="details">
			<li><?php echo $quotation->form;?></li>
		</ul>
			</div>
			</div>

	 		
	</div>