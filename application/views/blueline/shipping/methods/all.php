<div class="col-sm-12  col-md-12 main">
    <div class="row">
        <a href="<?php echo base_url()?>shippingmethods/create" class="btn btn-primary" data-toggle="mainmodal"><?php echo $this->lang->line('application_add_new_shipping_method');?></a>
    </div>
    <div class="row">
        <div class="table-head"> <?php echo $this->lang->line('application_shippingmethods');?></div>
        <div class="table-div">
            <table class="data table" id="project_types" rel="<?php echo base_url()?>shippingmethods" cellspacing="0" cellpadding="0">
                <thead>

                <th class="hidden-xs" style="width:70px"><?php echo $this->lang->line('application_shipping_method_id');?></th>
                <th><?php echo $this->lang->line('application_shipping_method_title');?></th>
                <th><?php echo $this->lang->line('application_shipping_method_status');?></th>
                <th><?php echo $this->lang->line('application_action');?></th>
                </thead>

                <?php foreach ($shipping_methods as $value):?>

                    <tr  id="<?php echo $value->id;?>" ><td class="hidden-xs" style="width:70px"><?php echo $value->id;?></td>

                        <td><span class="label label-info"><?php if(isset($value->name)){echo $value->name;} else{echo '-'; }?></span></td>

                        <td><?php if($value->inactive == "0") echo '<span class="label label-success">Active</span>'; else echo '<span class="label label-important">Inactive</span>'; ?></td>

                        <td class="option" width="8%">
                            <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?php echo base_url()?>shippingmethods/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?php echo $this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?php echo $value->id;?>'>" data-original-title="<b><?php echo $this->lang->line('application_really_delete');?></b>"><i class="fa fa-times"></i></button>
                            <a href="<?php echo base_url()?>shippingmethods/update/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
            <br clear="all">

        </div>