<?php
$attributes = array('class' => '', 'id' => '_projecttype');
echo form_open($form_action, $attributes);
if(isset($project_type)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $project_type->id; ?>" />
<?php } ?>


<div class="form-group">
    <label for="name"><?php echo $this->lang->line('application_project_type_name');?> *</label>
    <input type="text" name="name" class="form-control" id="name"  value="<?php if(isset($project_type)){echo $project_type->name;} ?>" required/>
</div>

<div class="form-group">
    <label for="textfield"><?php echo $this->lang->line('application_project_type_description');?></label>
    <textarea class="input-block-level form-control"  id="textfield" name="description"><?php if(isset($project_type)){echo $project_type->description;} ?></textarea>
</div>

<div class="form-group">
    <label for="inactive"><?php echo $this->lang->line('application_project_type_status');?></label><br>
    <?php
    $options = array();
    $options['0'] = 'Yes';
    $options['1'] = 'No';
    if(isset($project_type)){$project_type_status_selected = $project_type->inactive;}else{$project_type_status_selected = "0";}
    echo form_dropdown('inactive', $options, $project_type_status_selected, 'style="width:100%" class="chosen-select"');?>

</div>

<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?php echo $this->lang->line('application_save');?>"/>
    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
</div>

<?php echo form_close(); ?>
