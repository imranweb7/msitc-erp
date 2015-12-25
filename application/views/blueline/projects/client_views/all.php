<div class="col-sm-13  col-md-12 main">    
     <div class="row">
         <a href="<?php echo base_url()?>cprojects/create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_new_project');?></a>

        <div class="btn-group pull-right margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if($last_uri != "cprojects"){echo $this->lang->line('application_'.$last_uri);}else{echo $this->lang->line('application_all');} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php foreach ($submenu as $name=>$value):?>
                  <li><a id="<?php $val_id = explode("/", $value); if(!is_numeric(end($val_id))){echo end($val_id);}else{$num = count($val_id)-2; echo $val_id[$num];} ?>" href="<?php echo site_url($value);?>"><?php echo $name?></a></li>
              <?php endforeach;?>
          </ul>
      </div>
    </div>  
      <div class="row">

         <div class="table-head"><?php echo $this->lang->line('application_projects');?></div>
         <div class="table-div">
         <table class="data table" id="cprojects" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
                <thead>
                  <tr>
                      <th width="20px" class="hidden-xs"><?php echo $this->lang->line('application_project_id');?></th>
                      <th class="hidden-xs" width="19px" class="no-sort sorting"></th>
                      <th><?php echo $this->lang->line('application_name');?></th>
                      <th class="hidden-xs"><?php echo $this->lang->line('application_qty');?></th>
                      <th class="hidden-xs"><?php echo $this->lang->line('application_budget');?></th>
                      <th class="hidden-xs"><?php echo $this->lang->line('application_start_date');?></th>
                      <th class="hidden-xs"><?php echo $this->lang->line('application_assign_to');?></th>
                  </tr></thead>
                
                <tbody>
                <?php foreach ($project as $value):

          ?>
                <tr id="<?php echo $value->id;?>">
                  <td class="hidden-xs"><?php echo $core_settings->project_prefix;?><?php echo $value->reference;?></td>
                  <td class="hidden-xs">

                    <div class="circular-bar tt" title="<?php echo $value->progress;?>%">
                      <input type="hidden" class="dial" data-fgColor="<?php if($value->progress== "100"){ ?>#43AC6E<?php }else{ ?>#11A7DB<?php } ?>" data-width="19" data-height="19" data-bgColor="#e6eaed"  value="<?php echo $value->progress;?>" >

                      </div>
       
                </td>
                  <td onclick=""><?php echo $value->name;?></td>
                    <td class="hidden-xs"><span class="hidden-xs label label-chilled"><?php echo $value->product_qty; ?></span></td>
                    <td class="hidden-xs"><span class="hidden-xs label label-important"><?php echo $core_settings->currency.$value->project_budget;?></span></td>
                    <td class="hidden-xs"><span class="hidden-xs label label-success"><?php $unix = human_to_unix($value->start.' 00:00'); echo date($core_settings->date_format, $unix); ?></span></td>
                  <td class="hidden-xs">
                    <?php foreach ($value->project_has_workers as $workers): if(!empty($workers->user_id)):?>
                    <?php
                     
                          $image = get_user_pic($workers->user->userpic, $workers->user->email);
                         
                                
                      ?>
                      <img class="img-circle tt" src="<?php echo $image;?>" title="<?php echo $workers->user->firstname.' '.$workers->user->lastname;?>" height="19px"><span class="hidden"><?php echo $workers->user->firstname.' '.$workers->user->lastname;?></span>
                    
                    <?php endif; endforeach;?>
                  </td>
               
                </tr>
          
            <?php endforeach;?>
                
               

              </tbody>
            </table>
            </div>

      </div>
<script>
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
                "thickness":.25,                 
                'dynamicDraw': true,                
                "displayInput":false
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
  