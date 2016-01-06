<div class="table-div min-height-410">
    <table id="media" class="table data-media" rel="<?php echo base_url()?>projects/media/<?php echo $project->id;?>" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th  class="hidden"></th>
            <th><?php echo $this->lang->line('media_application_name');?></th>
            <th class="hidden-xs"><?php echo $this->lang->line('application_media_preview');?></th>
            <th class="hidden-xs"><?php echo $this->lang->line('application_phase');?></th>
            <th class="hidden-xs"><i class="fa fa-download"></i></th>
            <th><?php echo $this->lang->line('application_action');?></th>
        </tr></thead>

        <tbody>
        <?php foreach ($files as $value):?>

            <tr id="<?php echo $value->id;?>">
                <td class="hidden"><?php echo human_to_unix($value->date);?></td>
                <td onclick=""><?php echo $value->name;?></td>
                <td class="hidden-xs">

                    <div class="media_preview">
                        <?php
                        $type = explode('/', $value->type);
                        switch($type[0]){
                            case "image": ?>
                                <img src="<?php echo base_url()?>files/media/<?php echo $value->savename;?>">
                                <?php
                                break;
                            case "application":
                                if($type[1] == "ogg" || $type[1] == "mp4" || $type[1]  == "webm"){ ?>
                                    <i class="fa fa-file-video-o"></i>
                                <?php }

                                if($type[1] == "pdf"){ ?>
                                    <i class="fa fa-file-pdf-o"></i>
                                <?php }

                                break;
                            case "video":
                                ?>
                                <i class="fa fa-file-video-o"></i>
                                <?php

                                break;
                            case "audio":
                                ?>
                                <i class="fa fa-file-audio-o"></i>
                                <?php

                                break;

                        } ?>
                    </div>

                </td>
                <td class="hidden-xs"><?php echo $value->phase;?></td>
                <td class="hidden-xs"><span class="label label-info tt" title="<?php echo $this->lang->line('application_download_counter');?>" ><?php echo $value->download_counter;?></span></td>
                <td class="option " width="10%">
                    <button type="button" class="btn-option btn-xs po_confirm_delete" data-alert-title="<b><?php echo $this->lang->line('application_really_delete');?></b>" data-error-content="<span class='btn btn-danger'>..</span>" data-success-content="<a class='btn btn-success po_delete_confirmed' data-reload='<?php echo base_url()?>projects/view/<?php echo $project->id;?>' href='<?php echo base_url()?>projects/media/<?php echo $project->id;?>/delete/<?php echo $value->id;?>'><?php echo $this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close' data-dismiss='modal'><?php echo $this->lang->line('application_no');?></button>"><i class="fa fa-times"></i></button></span>
                    <a href="<?php echo base_url()?>projects/media/<?php echo $project->id;?>/update/<?php echo $value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="fa fa-cog"></i></a>
                </td>

            </tr>

        <?php endforeach;?>



        </tbody></table>
    <?php if(empty($files)) { ?>
        <div class="no-files">
            <i class="fa fa-cloud-upload"></i><br>
            No files have been uploaded yet!
        </div>
    <?php } ?>
</div>