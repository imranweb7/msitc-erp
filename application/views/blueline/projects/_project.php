<?php
$attributes = array('class' => '', 'id' => '_project');
echo form_open_multipart($form_action, $attributes);
if(isset($project)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $project->id; ?>" />
<?php } ?>


<input type="hidden" name="reference" class="form-control" id="reference" value="<?php if(isset($project)){echo $project->reference;} else{ echo $core_settings->project_reference;} ?>" required/>

<input type="hidden" name="company_id" value="<?php echo $this->client->company->id; ?>" />

<div class="form-group">
    <label for="project_type_id"><?php echo $this->lang->line('application_project_type_id_select');?></label><br>
    <?php
    $options = array();
    foreach ($project_types as $value):
        $options[$value->id] = $value->name;
    endforeach;

    if(isset($project)){$project_type_id = $project->project_type_id;}else{$project_type_id = "0";}
    echo form_dropdown('project_type_id', $options, $project_type_id, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="form-group">
        <label for="client"><?php echo $this->lang->line('application_client');?></label><br>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($companies as $value):  
                $options[$value->id] = $value->name;
                endforeach;
        if(isset($project) && isset($project->company->id)){$client = $project->company->id;}else{$client = "";}
        echo form_dropdown('company_id', $options, $client, 'style="width:100%" class="chosen-select"');?>
        
</div>
<div class="form-group">
                        <label for="progress"><?php echo $this->lang->line('application_progress');?> <span id="progress-amount"><?php if(isset($project)){echo $project->progress;}else{echo "0";} ?></span> %</label>
                          <div class="slider-group">
                             <div id="slider-range"></div>
                          </div>
                          <input type="hidden" class="hidden" id="progress" name="progress" value="<?php if(isset($project)){echo $project->progress;}else{echo "0";} ?>">
</div>

<input type="hidden" name="progress_calc" value="<?php if(isset($project) && $project->progress_calc == "1"){ echo $project->progress_calc; } else { echo '0'; } ?>" />

<script>
    $(document).ready(function(){
        //slider config
        $( "#slider-range" ).slider({
            range: "min",
            min: 0,
            max: 100,
            <?php if(isset($project) && $project->progress_calc == "1"){ ?>disabled: true,<?php } ?>
            value: <?php if(isset($project)){echo $project->progress;}else{echo "0";} ?>,
            slide: function( event, ui ) {
                $( "#progress-amount" ).html( ui.value );
                $( "#progress" ).val( ui.value );
            }
        });
    });
</script>


<div class="form-group">
                          <label for="name"><?php echo $this->lang->line('application_name');?> *</label>
                          <input type="text" name="name" class="form-control" id="name"  value="<?php if(isset($project)){echo $project->name;} ?>" required/>
</div>

<div class="form-group">
    <label for="textfield"><?php echo $this->lang->line('application_description');?></label>
    <textarea class="input-block-level form-control"  id="textfield" name="description"><?php if(isset($project)){echo $project->description;} ?></textarea>
</div>

<div class="form-group">
    <label for="product_link"><?php echo $this->lang->line('application_link');?> *</label>
    <textarea class="input-block-level form-control" id="product_link" name="product_link" required><?php if(isset($project)){echo $project->product_link;} ?></textarea>
</div>

<div class="form-group">
    <label for="product_qty"><?php echo $this->lang->line('application_qty');?> *</label>
    <input type="number" name="product_qty" class="form-control" id="product_qty"  value="<?php if(isset($project)){echo $project->product_qty;} ?>" required/>
</div>

<div class="form-group">
    <label for="project_budget"><?php echo $this->lang->line('application_budget');?> *</label>

    <div class="input-group">
        <span class="input-group-addon"><?php echo $core_settings->currency; ?></span>
        <input type="text" name="project_budget" class="form-control" id="project_budget"  value="<?php if(isset($project)){echo $project->project_budget;} ?>" required/>
    </div>
</div>

<div class="form-group">
    <label for="custom_logo"><?php echo $this->lang->line('application_custom_logo');?></label><br>
    <?php
    $options = array();
    $options['1'] = 'Yes';
    $options['0'] = 'No';
    if(isset($project)){$custom_logo_selected = $project->custom_logo;}else{$custom_logo_selected = "1";}
    echo form_dropdown('custom_logo', $options, $custom_logo_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="form-group">
    <label for="custom_packaging"><?php echo $this->lang->line('application_custom_packaging');?></label><br>
    <?php
    $options = array();
    $options['1'] = 'Yes';
    $options['0'] = 'No';
    if(isset($project)){$custom_packaging_selected = $project->custom_packaging;}else{$custom_packaging_selected = "1";}
    echo form_dropdown('custom_packaging', $options, $custom_packaging_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="form-group">
    <label for="reference_photo"><?php echo $this->lang->line('application_reference_photo');?></label>
    <div>
        <input id="uploadFile" type="text" name="dummy" class="form-control uploadFile" placeholder="<?php if(isset($project->reference_photo)){ echo $project->reference_photo; }else{ echo "Choose File";} ?>" disabled="disabled" />
        <div class="fileUpload btn btn-primary">
            <span><i class="fa fa-upload"></i><span class="hidden-xs"> <?php echo $this->lang->line('application_select');?></span></span>
            <input id="uploadBtn" type="file" data-switcher="attachment_description" name="userfile" class="upload switcher" accept="capture=camera" />
        </div>
    </div>
</div>


<div class="form-group">
                          <label for="start"><?php echo $this->lang->line('application_start_date');?> *</label>
                          <input class="form-control datepicker" name="start" id="start" type="text" value="<?php if(isset($project)){echo $project->start;} ?>" data-date-format="yyyy-mm-dd" required/>
</div>
<div class="form-group">
                          <label for="end"><?php echo $this->lang->line('application_deadline');?> *</label>
                          <input class="form-control datepicker" name="end" id="end" type="text" value="<?php if(isset($project)){echo $project->end;} ?>" data-date-format="yyyy-mm-dd" required/>
</div>

<input type="hidden" name="phases" id="phases"  value="<?php if(isset($project)){echo $project->phases;}else{echo "Planning, Developing, Testing";} ?>" required/>
<input type="hidden" name="category" class="form-control typeahead" id="category"  value="<?php if(isset($project)){echo $project->category;} ?>"/>



        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
        <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>
