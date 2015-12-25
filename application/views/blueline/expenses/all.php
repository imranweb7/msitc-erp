	<div class="col-sm-12  col-md-12 main">  
    <div class="row tile-row">
    <?php $month2 = $month != 0 ? $month : date('m'); $year =  $year ? $year : date("Y")?>
      <div class="col-md-3 col-xs-6 tile"><div class="icon-frame hidden-xs"><i class="ion-ios-calendar-outline"></i> </div><h1> <?php if(isset($expenses_this_month)){echo $expenses_this_month;} ?> <span><?php echo $this->lang->line('application_expenses');?></span></h1><h2><?php echo $days_in_this_month == 12 ? $this->lang->line('application_in')." ".$year : $this->lang->line('application_in')." ".$this->lang->line('application_'.date("M", strtotime($year."-".$month2."-01"))); ?></h2></div>
      <div class="col-md-3 col-xs-6 tile"><div class="icon-frame secondary hidden-xs"><i class="ion-ios-cart"></i> </div><h1> <?php if($expenses_owed_this_month[0]->owed != ""){echo display_money(sprintf("%01.2f", round($expenses_owed_this_month[0]->owed, 2)));}else{ echo "0.00";} ?> </h1><h2><?php echo $this->lang->line('application_owed_in');?> <?php echo $days_in_this_month == 12 ? $year : $this->lang->line('application_'.date("M", strtotime($year."-".$month2."-01")));?></h2></div>
      <div class="col-md-6 col-xs-12 tile hidden-xs">
      <div style="width:97%; height: 93px;">
      <canvas id="tileChart" class="hidden-xs" width="auto" height="50"></canvas>
      </div>
      </div>
    
    </div>   
     <div class="row">
      <a href="<?php echo base_url()?>expenses/create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_create_expense');?></a>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php echo $year; ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y");?>/<?php echo $month?>"><?php echo date("Y");?></a></li>

                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y")-1;?>/<?php echo $month?>"><?php echo date("Y")-1;?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y")-2;?>/<?php echo $month?>"><?php echo date("Y")-2;?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y")-3;?>/<?php echo $month?>"><?php echo date("Y")-3;?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y")-4;?>/<?php echo $month?>"><?php echo date("Y")-4;?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo date("Y")-5;?>/<?php echo $month?>"><?php echo date("Y")-5;?></a></li>
          </ul>
      </div>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php echo $month != 0 ? $this->lang->line('application_'.date("M", strtotime("2015-".$month."-01"))) : $this->lang->line('application_all'); ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/0"><?php echo $this->lang->line('application_all');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/01"><?php echo $this->lang->line('application_Jan');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/02"><?php echo $this->lang->line('application_Feb');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/03"><?php echo $this->lang->line('application_Mar');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/04"><?php echo $this->lang->line('application_Apr');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/05"><?php echo $this->lang->line('application_May');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/06"><?php echo $this->lang->line('application_Jun');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/07"><?php echo $this->lang->line('application_Jul');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/08"><?php echo $this->lang->line('application_Aug');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/09"><?php echo $this->lang->line('application_Sep');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/10"><?php echo $this->lang->line('application_Oct');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/11"><?php echo $this->lang->line('application_Nov');?></a></li>
                    <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user_id?>/<?php echo $year?>/12"><?php echo $this->lang->line('application_Dec');?></a></li>

          </ul>
      </div>
      <div class="btn-group pull-right-responsive margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php if(isset($username)){echo $username->firstname.' '.$username->lastname;}else{echo $this->lang->line('application_show_expenses_from_agent');} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="<?php echo base_url()?>expenses/filter/0/<?php echo $year?>/<?php echo $month?>"><?php echo $this->lang->line('application_all');?></a></li>
            <?php foreach ($userlist as $user):?>
                  <li><a href="<?php echo base_url()?>expenses/filter/<?php echo $user->id?>/<?php echo $year?>/<?php echo $month?>"><?php echo $user->firstname.' '.$user->lastname?></a></li>
              <?php endforeach;?>
          </ul>
      </div>
    </div>  
      <div class="row">

         <div class="table-head"><?php echo $this->lang->line('application_expenses');?></div>
         <div class="table-div">
		<table class="data table noclick" id="expenses" rel="<?php echo base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
			<th width="30px" class="hidden-xs"><?php echo $this->lang->line('application_id');?></th>
      <th width="5px" class="no-sort"></th>
			<th ><?php echo $this->lang->line('application_description');?></th>
      <th class="hidden-xs"><?php echo $this->lang->line('application_category');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_date');?></th>
			<th class="hidden-xs"><?php echo $this->lang->line('application_value');?></th>
      <th class="hidden-xs"><?php echo $this->lang->line('application_balance');?></th>

			<th><?php echo $this->lang->line('application_action');?></th>
		</thead>
		<?php 
    $sum = 0;
    foreach ($expenses as $value):
      $sum = $sum+$value->value;
      ?>
		<tr id="<?php echo $value->id;?>" >
			<td class="hidden-xs"><?php echo $value->id;?></td>
      <td><?php if($value->attachment != ""){echo '<a href="'.base_url().'expenses/attachment/'.$value->id.'" style="color: #505458;"><i class="fa fa-paperclip tt" title="'.$value->attachment_description.'"></i></a>'; }?></td>
			<td><?php if(isset($value->description)){echo $value->description; }?></td>
      <td class="hidden-xs" ><span class="label label-info"><?php echo $value->category;?></span></td>
      <td class="hidden-xs"><span><?php $unix = human_to_unix($value->date.' 00:00'); echo '<span class="hidden">'.$unix.'</span> '; echo date($core_settings->date_format, $unix);?></span></td>
			<td class="hidden-xs minus "><span class="<?php if(isset($value->invoice->id)){echo 'plus tt" title="'.$this->lang->line("application_rebilled_on_invoice").' #'.$value->invoice->reference; }?>"><?php echo display_money(sprintf("%01.2f", round($value->value, 2)));?></span></td>
      <td class="hidden-xs bold"><?php echo display_money(sprintf("%01.2f", round($sum, 2)));?></td>


		
			<td class="option" width="8%">
				        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>expenses/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
				        <a href="<?php echo base_url()?>expenses/update/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
			</td>
		</tr>

		<?php endforeach;?>
	 	</table>


            </div>


      </div>

<script>
$(document).ready(function(){ 

//chartjs

var ctx = $("#tileChart").get(0).getContext("2d");

<?php
                           
                                $days = array();
                                $data = ""; 
                                $labels = "";
                                foreach ($expenses_due_this_month_graph as $value) {
                                  $days[$value->date] = $value->owed;

                                  
                                }
                                $i = 1;
                                while ($i <= $days_in_this_month) {
                                
                                  $selected_day = $days_in_this_month == 12 ? $i : $year.'-'.$month2.'-'.$i;
                                
                                
                                  $y = 0;
                                    if(isset($days[$selected_day])){ $y = $days[$selected_day];}
                                     
                                    $d = date_parse_from_format("Y-m-d", $selected_day);

                                   $labels .= $days_in_this_month == 12 ? '"'.$selected_day.'",' : '"'.$d["day"].'",';
                                   $data .= '"'.sprintf("%01.2f", round($y, 2)).'",';

                                     $i++; } ?>

var data = {
    labels: [<?php echo $labels?>],
    datasets: [
        {
            label: "First dataset",
            fillColor: "rgba(50, 211, 218,0.2)",
            strokeColor: " #33C3DA",
            pointColor: "#33D2DA",
            pointStrokeColor: "rgba(50, 211, 218,1)",
            pointHighlightFill: "rgba(50, 211, 218,0.9)",
            pointHighlightStroke: "rgba(50, 211, 218,1)",
            data: [<?php echo $data;?>]
        }
        
    ]
};

var options = {

    scaleShowVerticalLines: false,

    tooltipTemplate: "<%= value %>"

};
 var tileChart = new Chart(ctx).Line(data, options);




                        //xChart 
                          var tt = document.createElement('div'),
                            leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
                            topOffset = -32;
                          tt.className = 'ex-tooltip';
                          document.body.appendChild(tt);

                          var data = {
                            "xScale": "time",
                            "yScale": "linear",
                            "yMin": 0,
                            
                            "main": [
                               
                              {
                                "className": ".invoice_chart_closed",
                                "data": [

                                <?php
                                $days = array(); 

                                foreach ($expenses_due_this_month_graph as $value) {
                                  $days[$value->date] = $value->owed;

                                  
                                }
                                $i = 1;
                                while ($i <= $days_in_this_month) {
                                
                                  $selected_day = $days_in_this_month == 12 ? $i : $year.'-'.$month2.'-'.$i;
                                
                                
                                  $y = 0;
                                    if(isset($days[$selected_day])){ $y = $days[$selected_day];}
                                      ?>{
                                    
                                    "x": <?php echo $days_in_this_month == 12 ? '"2015-'.$selected_day.'-01"' : '"'.$selected_day.'"'; ?>,
                                    "y": <?php echo sprintf("%01.2f", round($y, 2)); ?>
                                  },
                                  <?php $i++; } ?>
                                  
                                ] 



                              }
                            ]
                          };
                          var opts = {
                            "dataFormatX": function (x) { return d3.time.format('%Y-%m-%d').parse(x); },
                            "tickFormatX": function (x) { return d3.time.format('<?php echo $days_in_this_month == 12 ? "%m" : "%d"; ?>')(x); },
                            "mouseover": function (d, i) {
                              var pos = $(this).offset();
                              var lineclass = $(this).parent().attr("class");
                              lineclass = lineclass.split(" ");
                              
                              if( lineclass[2] == "invoice_chart_closed"){
                                var linename = "";
                              }else{
                                var linename = "<?php echo $this->lang->line('application_paid');?>";
                              }
                              $(tt).text(d.y + ' ' +linename)
                                .css({top: topOffset + pos.top, left: pos.left + leftOffset})
                                .show();
                            },
                            "mouseout": function (x) {
                              $(tt).hide();
                            },
                            "tickHintY": 5,
                            <?php echo $days_in_this_month == 12 ? '"tickHintX": 12,' : ""; ?>
                            "paddingLeft":20,
                            "paddingTop":5,
                             
                          };
                          if($("#invoice_line_chart").length != 0) {
                          var myChart = new xChart('line-dotted', data, '#invoice_line_chart', opts);
                          }
                          //xChart End
});
</script>