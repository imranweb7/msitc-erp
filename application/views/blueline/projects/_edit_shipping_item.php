<?php   
$attributes = array('class' => 'dynamic-pre-form', 'data-reload' => 'shipping-item-list', 'id' => '_shipping_item');
echo form_open_multipart($form_action, $attributes);
$public = "0";
?>

<input id="id" type="hidden" name="id" value="<?php echo $item->id; ?>" />


    <div class="form-group">
        <label for="shipping_method"><?php echo $this->lang->line('application_select_shipping_method');?></label><br>
        <?php
        $options = array();
        $method_found = false;
        foreach ($shipping_methods as $value):
            $options[$value->name] = $value->name;

            if(isset($item)){
                if($value->name == $item->shipping_method){
                    $method_found = true;
                }
            }
        endforeach;

        if(isset($item)){
            $shipping_method_selected = $item->shipping_method;

            if(!$method_found){
                $options[$shipping_method_selected] = $shipping_method_selected;
            }
        }else{
            $shipping_method_selected = "";
        }
        echo form_dropdown('shipping_method', $options, $shipping_method_selected, 'style="width:100%" class="chosen-select"');?>

    </div>


<div class="form-group">
        <label for="name"><?php echo $this->lang->line('shipping_item_application_name');?></label>
        <input id="name" name="name" type="text" class="required form-control"  value="<?php if(isset($item)){ echo $item->name; } ?>"  required/>
</div>

    <div class="form-group">
        <label for="shipping_available_inventory"><?php echo $this->lang->line('shipping_item_application_available_inventory');?> *</label>
        <input id="shipping_available_inventory" type="number" name="shipping_available_inventory" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_available_inventory;} ?>" />
    </div>

    <div class="form-group">
        <label for="shipping_box_size_length"><?php echo $this->lang->line('shipping_item_application_box_size_length');?> *</label>
        <input id="shipping_box_size_length" type="text" name="shipping_box_size_length" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_box_size_length;} ?>" />
    </div>

    <div class="form-group">
        <label for="shipping_box_size_width"><?php echo $this->lang->line('shipping_item_application_box_size_width');?> *</label>
        <input id="shipping_box_size_width" type="text" name="shipping_box_size_width" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_box_size_width;} ?>" />
    </div>

    <div class="form-group">
        <label for="shipping_box_size_height"><?php echo $this->lang->line('shipping_item_application_box_size_height');?> *</label>
        <input id="shipping_box_size_height" type="text" name="shipping_box_size_height" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_box_size_height;} ?>" />
    </div>

    <div class="form-group">
        <label for="shipping_box_size_weight"><?php echo $this->lang->line('shipping_item_application_box_size_weight');?> *</label>
        <input id="shipping_box_size_weight" type="text" name="shipping_box_size_weight" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_box_size_weight;} ?>" />
    </div>

    <div class="form-group">
        <label for="shipping_pcs_in_carton"><?php echo $this->lang->line('shipping_item_application_pcs_in_carton');?> *</label>
        <input id="shipping_pcs_in_carton" type="number" name="shipping_pcs_in_carton" class="form-control resetvalue item-new" value="<?php if(isset($item)){echo $item->shipping_pcs_in_carton;} ?>" />
    </div>


<div class="form-group">
        <label for="inactive"><?php echo $this->lang->line('application_status');?></label>
    <?php
    $options = array();
    $options['0'] = 'Active';
    $options['1'] = 'Inactive';
    if(isset($item)){$status_selected = $item->inactive;}else{$status_selected = "0";}
    echo form_dropdown('inactive', $options, $status_selected, 'style="width:100%" class="chosen-select"');?>
</div>


<div class="form-group">
    <label for="cost"><?php echo $this->lang->line('shipping_item_application_handling_fee');?> *</label>
    <div class="input-group">
        <span class="input-group-addon"><?php echo $core_settings->currency; ?></span>
        <input id="cost" type="text" name="cost" class="form-control resetvalue" value="<?php if(isset($item)){echo $item->cost;} ?>"  required/>
    </div>
</div>


        <div class="modal-footer">
          <?php if(isset($item)){ ?>
            <a href="<?php echo base_url()?>projects/item/<?php echo $item->project_id;?>/shippingItemDelete/<?php echo $item->id;?>" class="btn btn-danger pull-left button-loader" ><?php echo $this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('application_close');?></a>
        <i class="fa fa-spinner fa-spin" id="showloader" style="display:none"></i>
        <?php } ?>
        <button name="send" class="btn btn-primary form-valid-send"><?php echo $this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>