<div class="row">
<div class="col-sm-12  col-md-12">  
	
			<a href="<?php echo base_url()?>quotations/update/<?php echo $quotation->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_edit_quotation');?></a>
			<?php if(empty($client)){ ?><a href="<?php echo base_url()?>quotations/create_client/<?php echo $quotation->id;?>" class="btn btn-primary" data-toggle="mainmodal"> <?php echo $this->lang->line('application_quotation_add_client');?></a><?php } ?>
		
</div>
</div>
		<div class="row">
			<div class="col-md-6">
				<div class="table-head"><?php echo $this->lang->line('application_quotation_details');?></div>
				<div class="subcont">
					<ul class="details">
						<li class="<?php echo $quotation->status;?>"><span><?php echo $this->lang->line('application_status');?>:</span> <a class="label <?php if($quotation->status == "New"){echo "label-important";}elseif($quotation->status == "Accepted"){ echo "label-success";}elseif($quotation->status == "Reviewed"){ echo "label-warning";} ?>"><?php echo $this->lang->line('application_'.$quotation->status);?></a></li>
						<li><span><?php echo $this->lang->line('application_worker');?>:</span> <?php if(isset($quotation->user->fullname)){echo $quotation->user->fullname;}else{echo "-";}?></li>
						<li><span><?php echo $this->lang->line('application_date');?>:</span> <?php  $unix = human_to_unix($quotation->date); echo date('jS F Y H:i', $unix);?></li>
					</ul>
				</div>
			</div>
			<div class="col-md-6">
				<div class="table-head"><?php echo $this->lang->line('application_personal_info');?></div>
					<div class="subcont">
						<ul class="details">
							<li><span><?php echo $this->lang->line('quotation_question_7');?>:</span> <?php if(empty($quotation->company)){ echo "-"; }else {echo $quotation->company; }?></li>
							<li><span><?php echo $this->lang->line('quotation_question_8');?>:</span> <?php echo $quotation->fullname;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_9');?>:</span> <?php echo $quotation->email;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_10');?>:</span> <?php echo $quotation->phone;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_11');?>:</span> <?php echo $quotation->address;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_12');?>:</span> <?php echo $quotation->city;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_13');?>:</span> <?php echo $quotation->zip;?></li>
							<li><span><?php echo $this->lang->line('quotation_question_14');?>:</span> <?php echo $quotation->country;?></li>
						</ul>
					</div>
				</div>
	</div>
			
<div class="row">
<div class="col-sm-12  col-md-12"> 
		<div class="table-head"><?php echo $this->lang->line('application_answers');?></div>
		<div class="table-div">
			<div class="question"><?php echo $this->lang->line('quotation_question_1');?></div> <div class="answer"><?php echo $this->lang->line('quotation_question_1_aw_'.$quotation->q1);?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_2');?></div> <div class="answer"><?php echo $this->lang->line('quotation_question_2_aw_'.$quotation->q2);?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_3');?></div> <div class="answer"><?php echo $this->lang->line('quotation_question_3_aw_'.$quotation->q3);?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_4');?></div> <div class="answer"><?php if(isset($quotation->q4)){echo $quotation->q4;}else{echo "-";};?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_5');?></div> <div class="answer"><?php if(isset($quotation->q5)){echo $quotation->q5;}else{echo "-";};?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_6');?></div> <div class="answer"><?php echo $this->lang->line('quotation_question_6_aw_'.$quotation->q6);?></div>
			<div class="question"><?php echo $this->lang->line('quotation_question_15');?></div> <div class="answer"><?php echo $quotation->comment;?></div>
		</ul>
			</div>
			</div>

	</div> 		
	</div>
</div>