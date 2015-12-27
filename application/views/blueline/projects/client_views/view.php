<div class="row">
              <div class="col-xs-12 col-sm-12">

  <div class="row tile-row tile-view">
      <div class="col-md-1 col-xs-3">
      <div class="percentage easyPieChart" data-percent="<?php echo $project->progress;?>"><span><?php echo $project->progress;?>%</span></div>
        
      </div>
      <div class="col-md-11 col-xs-9 smallscreen"> 
        <h1><span class="nobold">#<?php echo $core_settings->project_prefix;?><?php echo $project->reference;?></span> - <?php echo $project->name;?></h1>
         <p class="truncate description"><?php echo $project->description;?></p>
      </div>
    
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active hidden-xs"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_project_details');?></a></li>
          <li role="presentation" class="hidden-xs"><a href="#items-tab" aria-controls="items-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_items');?></a></li>
          <li role="presentation" class="hidden-xs"><a href="#media-tab" aria-controls="media-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_media');?></a></li>

       <?php if($invoice_access) { ?>
        <li role="presentation" class="hidden-xs"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_invoices');?></a></li>
       <?php } ?>
        <li role="presentation" class="hidden-xs"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_activities');?></a></li>
        
        <li role="presentation" class="dropdown visible-xs">
            <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><?php echo $this->lang->line('application_overview');?> <span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
              <li role="presentation" class="active"><a href="#projectdetails-tab" aria-controls="projectdetails-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_project_details');?></a></li>
                <li role="presentation"><a href="#items-tab" aria-controls="items-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_items');?></a></li>
              <li role="presentation"><a href="#media-tab" aria-controls="media-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_media');?></a></li>
             <?php if($invoice_access) { ?>
              <li role="presentation"><a href="#invoices-tab" aria-controls="invoices-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_invoices');?></a></li>
             <?php } ?>
              <li role="presentation"><a href="#activities-tab" aria-controls="activities-tab" role="tab" data-toggle="tab"><?php echo $this->lang->line('application_activities');?></a></li>
            </ul>
        </li>

        
        

        
      </ul>


    </div> 


              </div>
          </div>
   <div class="tab-content"> 

<div class="row tab-pane fade in active" role="tabpanel" id="projectdetails-tab">

       <div class="col-xs-12 col-sm-12">
            <div class="table-head"><?php echo $this->lang->line('application_project_details');?></div>

                <div class="subcont">
                  <ul class="details col-xs-12 col-sm-12 col-md-4">
                    <li><span><?php echo $this->lang->line('application_project_id');?>:</span> <?php echo $core_settings->project_prefix;?><?php echo $project->reference;?></li>
                    <li><span><?php echo $this->lang->line('application_project_type_id_select');?>:</span> <?php echo $project->project_type->name;?></li>
                    <li><span><?php echo $this->lang->line('application_client');?>:</span> <?php if(!isset($project->company->name)){ ?> <a href="#" class="label label-default"><?php echo $this->lang->line('application_no_client_assigned'); }else{ ?><a class="label label-success" href="#"><?php echo $project->company->name;} ?></a></li>
                    <li><span><?php echo $this->lang->line('application_assigned_to');?>:</span> <?php foreach ($project->project_has_workers as $workers):?> <a class="label label-info" style="padding: 2px 5px 3px;"><?php echo $workers->user->firstname." ".$workers->user->lastname;?></a><?php endforeach;?> </li>
        
                  </ul>
                  <ul class="details col-xs-12 col-sm-12 col-md-4"><span class="visible-xs divider"></span>
                    <li><span><?php echo $this->lang->line('application_start_date');?>:</span> <?php  $unix = human_to_unix($project->start.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
                    <li><span><?php echo $this->lang->line('application_deadline');?>:</span> <?php  $unix = human_to_unix($project->end.' 00:00'); echo date($core_settings->date_format, $unix);?></li>
                    <li><span><?php echo $this->lang->line('application_time_spent');?>:</span> <?php echo $time_spent;?> </li>
                    <li><span><?php echo $this->lang->line('application_created_on');?>:</span> <?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $project->datetime); ?></li>
                  </ul>

                    <ul class="details col-xs-12 col-sm-12 col-md-4"><span class="visible-xs divider"></span>
                        <li><span><?php echo $this->lang->line('application_qty');?>:</span> <?php echo $project->product_qty;?></li>
                        <li><span><?php echo $this->lang->line('application_budget');?>:</span> <?php echo $core_settings->currency.$project->project_budget;?></li>
                        <li><span><?php echo $this->lang->line('application_custom_logo');?>:</span> <?php if($project->custom_logo == "1") echo 'Yes'; else echo 'No'; ?></li>
                        <li><span><?php echo $this->lang->line('application_custom_packaging');?>:</span> <?php if($project->custom_packaging == "1") echo 'Yes'; else echo 'No'; ?></li>
                    </ul>


                  <br clear="both">
                </div>


               </div>


    <div class="col-xs-12 col-sm-9">
        <div class="table-head"><?php echo $this->lang->line('application_link');?></div>
        <div class="subcont">
            <ul class="details col-xs-12 col-sm-12 col-md-12">
                <li><?php echo $project->product_link;?></li>
            </ul>
            <br clear="both">
        </div>
    </div>



   <div class="col-xs-12 col-sm-3">
        <div class="table-head"><?php echo $this->lang->line('application_reference_photo');?></div>
        <div class="subcont" >
            <?php
            if(!empty($project->reference_photo)){
                ?>
                <img class="img-responsive" src="<?php echo base_url().'files/media/projects/references/'.$project->reference_photo;?>" />
                <?php
            }
            ?>
        </div>
    </div>

</div>


       <div class="row tab-pane fade" role="tabpanel" id="items-tab">
           <div class="col-xs-12 col-sm-12">
               <div class="table-head"><?php echo $this->lang->line('application_item');?> <span class=" pull-right"><a href="<?php echo base_url()?>projects/order/<?php echo $project->id;?>/create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_order');?></a></span></div>
               <div class="table-div min-height-410">
                   <table id="item-list" class="table data-item-list" rel="<?php echo base_url()?>cprojects/item/<?php echo $project->id;?>" cellspacing="0" cellpadding="0">
                       <thead>
                       <tr>
                           <th><?php echo $this->lang->line('item_application_name');?></th>
                           <th class="hidden-xs"><?php echo $this->lang->line('item_application_sku');?></th>
                           <th class="hidden-xs"><?php echo $this->lang->line('item_application_cost');?></th>
                           <th><?php echo $this->lang->line('application_action');?></th>
                       </tr></thead>

                       <tbody>
                       <?php $count = 0; foreach ($project->project_has_items as $value):  $count = $count+1;?>

                           <tr id="<?php echo $value->id;?>">
                               <td onclick=""><?php echo $value->name;?></td>
                               <td class="hidden-xs"><?php echo $value->sku;?></td>
                               <td class="hidden-xs"><?php echo $core_settings->currency.$value->cost;?></td>
                               <td class="option " width="10%">
                                   <a href="<?php echo base_url()?>cprojects/item/<?php echo $project->id;?>/view/<?php echo $value->id;?>" class="btn-option view_project_item" data-toggle="mainmodal"><i class="fa fa-file-o"></i></a>
                               </td>

                           </tr>

                       <?php endforeach;?>

                       </tbody>

                   </table>
                   <?php if($count == 0) { ?>
                       <div class="no-items">
                           <i class="fa fa-item"></i><br>
                           No items have been added yet!
                       </div>
                   <?php } ?>
               </div>
           </div>
       </div>

<div class="row tab-pane fade" role="tabpanel" id="media-tab">
<div class="col-xs-12 col-sm-12">
 <div class="table-head"><?php echo $this->lang->line('application_media');?> <span class=" pull-right"><a href="<?php echo base_url()?>cprojects/media/<?php echo $project->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_add_media');?></a></span></div>
<div class="table-div min-height-410">
 <table id="media" class="table data-media" rel="<?php echo base_url()?>cprojects/media/<?php echo $project->id;?>" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
                    <th  class="hidden"></th>
          <th><?php echo $this->lang->line('media_application_name');?></th>
          <th class="hidden-xs"><?php echo $this->lang->line('application_filename');?></th>
          <th class="hidden-xs"><?php echo $this->lang->line('application_phase');?></th>
          <th class="hidden-xs"><i class="fa fa-download"></i></th>
          </tr></thead>
        
        <tbody>
        <?php foreach ($project->project_has_files as $value):?>

        <tr id="<?php echo $value->id;?>">
          <td class="hidden"><?php echo human_to_unix($value->date);?></td>
          <td onclick=""><?php echo $value->name;?></td>
          <td class="hidden-xs truncate" style="max-width: 80px;"><?php echo $value->filename;?></td>
          <td class="hidden-xs"><?php echo $value->phase;?></td>
          <td class="hidden-xs"><span class="label label-info tt" title="<?php echo $this->lang->line('application_download_counter');?>" ><?php echo $value->download_counter;?></span></td>
          
        </tr>

        <?php endforeach;?>
        
        
        
        </tbody></table>
        <?php if(!$project->project_has_files) { ?>
        <div class="no-files">  
            <i class="fa fa-cloud-upload"></i><br>
            No files have been uploaded yet!
        </div>
         <?php } ?>
        </div>
</div>
</div>

<?php if($invoice_access) { ?>
<div class="row tab-pane fade" role="tabpanel" id="invoices-tab">
 <div class="col-xs-12 col-sm-12">
 <div class="table-head"><?php echo $this->lang->line('application_invoices');?> <span class=" pull-right"></span></div>
<div class="table-div">
 <table class="data table" id="cinvoices" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
    <thead>
      <th width="70px" class="hidden-xs"><?php echo $this->lang->line('application_invoice_id');?></th>
      <th><?php echo $this->lang->line('application_client');?></th>
      <th class="hidden-xs"><?php echo $this->lang->line('application_issue_date');?></th>
      <th class="hidden-xs"><?php echo $this->lang->line('application_due_date');?></th>
      <th><?php echo $this->lang->line('application_status');?></th>
    </thead>
    <?php foreach ($project_has_invoices as $value):?>

    <tr id="<?php echo $value->id;?>" >
      <td class="hidden-xs" onclick=""><?php echo $core_settings->invoice_prefix;?><?php echo $value->reference;?></td>
      <td onclick=""><span class="label label-info"><?php if(isset($value->company->name)){echo $value->company->name; }?></span></td>
      <td class="hidden-xs"><span><?php $unix = human_to_unix($value->issue_date.' 00:00'); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format, $unix);?></span></td>
      <td class="hidden-xs"><span class="label <?php if($value->status == "Paid"){echo 'label-success';} if($value->due_date <= date('Y-m-d') && $value->status != "Paid"){ echo 'label-important tt" title="'.$this->lang->line('application_overdue'); } ?>"><?php $unix = human_to_unix($value->due_date.' 00:00'); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format, $unix);?></span> <span class="hidden"><?php echo $unix;?></span></td>
      <td onclick=""><span class="label <?php $unix = human_to_unix($value->sent_date.' 00:00'); if($value->status == "Paid"){echo 'label-success';}elseif($value->status == "Sent"){ echo 'label-warning tt" title="'.date($core_settings->date_format, $unix);} ?>"><?php echo $this->lang->line('application_'.$value->status);?></span></td>
    </tr>

    <?php endforeach;?>
    </table>
        <?php if(!$project_has_invoices) { ?>
        <div class="no-files">  
            <i class="fa fa-file-text"></i><br>
            
            <?php echo $this->lang->line('application_no_invoices_yet');?>
        </div>
         <?php } ?>
        </div>
  </div>             


</div>
<?php } ?>



<div class="row tab-pane fade" role="tabpanel" id="activities-tab">
<div class="col-xs-12 col-sm-12">
            <div class="table-head"><?php echo $this->lang->line('application_activities');?>
            <span class=" pull-right"><a class="btn btn-primary open-comment-box"><?php echo $this->lang->line('application_new_comment');?></a></span>
            </div>
            <div class="subcont" > 

<ul id="comments-ul" class="comments">
                      <li class="comment-item add-comment">
                      <?php   
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'comments-ul');
                                echo form_open('cprojects/activity/'.$project->id.'/add', $attributes); 
                                ?>
                      <div class="comment-pic">
                        <img class="img-circle tt" title="<?php echo $this->client->firstname?> <?php echo $this->client->lastname?>"  src="<?php echo get_user_pic($this->client->userpic, $this->client->email);?>">
                      
                      </div>
                      <div class="comment-content">
                          <h5><input type="text" name="subject" class="form-control" id="subject" placeholder="<?php echo $this->lang->line('application_subject');?>..." required/></h5>
                            <p><small class="text-muted"><span class="comment-writer"><?php echo $this->client->firstname?> <?php echo $this->client->lastname?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, time()); ?></span></small></p>
                            <p><textarea class="input-block-level summernote" id="reply" name="message" placeholder="<?php echo $this->lang->line('application_write_message');?>..." required/></textarea></p>
                            <button id="send" name="send" class="btn btn-primary button-loader"><?php echo $this->lang->line('application_send');?></button>
                            <button id="cancel" name="cancel" class="btn btn-danger open-comment-box"><?php echo $this->lang->line('application_close');?></button>
                               
                      </div>
                       </form>
                      </li>
<?php foreach ($project->project_has_activities as $value):?>
                      <?php 
                      $writer = FALSE;
                      if ($value->user_id != 0) { 
                          $writer = $value->user->firstname." ".$value->user->lastname;
                          $image = get_user_pic($value->user->userpic, $value->user->email);
                          }else{
                          $writer = $value->client->firstname." ".$value->client->lastname;
                          $image = get_user_pic($value->client->userpic, $value->client->email);
                                
                      }?>
                      <li class="comment-item">
                      <div class="comment-pic">
                        <?php if ($writer != FALSE) {  ?>
                        <img class="img-circle tt" title="<?php echo $writer?>"  src="<?php echo $image?>">
                        <?php }else{?> <i class="fa fa-rocket"></i> <?php } ?>
                      </div>
                      <div class="comment-content">
                          <h5><?php echo $value->subject;?></h5>
                            <p><small class="text-muted"><span class="comment-writer"><?php echo $writer?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $value->datetime); ?></span></small></p>
                            <p><?php echo $value->message;?></p>
                      </div>
                      </li>
  <?php endforeach;?>
                      <li class="comment-item">
                        <div class="comment-pic"><i class="fa fa-bolt"></i></div>
                          <div class="comment-content">
                          <h5><?php echo $this->lang->line('application_project_created');?></h5>
                            <p><small class="text-muted"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, $project->datetime); ?></small></p>
                            <p><?php echo $this->lang->line('application_project_has_been_created');?></p>
                          </div>
                      </li>  
         </ul>            




</div>
</div>
</div>
<style type="text/css">

.circular-bar{
  text-align: center;

  margin:10px 20px;
}
  .circular-bar-content{
    margin-bottom: 70px;
    margin-top: -100px;
    text-align: center;
  }
    .circular-bar-content strong{
      display: block;
      font-weight: 400;
      @include font-size(18,24);
    }
    .circular-bar-content label, .circular-bar-content span{
      display: block;
      font-weight: 400;
      font-size: 18px;
      color: #505458;
      @include font-size(15,20);
    }


</style>
 <script type="text/javascript">  
  $(document).ready(function(){ 


$('.dial').each(function () { 

          var elm = $(this);
          var color = elm.attr("data-fgColor");  
          var perc = elm.attr("value");  
 
          elm.knob({ 
               'value': 0, 
                'min':0,
                'max':100,
                "skin":"tron",
                "readOnly":true,
                "thickness":.13,                 
                'dynamicDraw': true,                
                "displayInput":false,

          });

          $({value: 0}).animate({ value: perc }, {
              duration: 1000,
              easing: 'swing',
              progress: function () {                  elm.val(Math.ceil(this.value)).trigger('change')
              }
          });

          //circular progress bar color
          $(this).append(function() {
              elm.parent().parent().find('.circular-bar-content').css('color',color);
              elm.parent().parent().find('.circular-bar-content label').text(perc+'%');
          });

          });
   
 });

</script> 
  
  

