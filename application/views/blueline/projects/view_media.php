<link href="<?php echo base_url()?>assets/blueline/css/plugins/video-js.css" rel="stylesheet">
 <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/pdfobject.js"></script>

          
       <div class="row">
       <div class="col-xs-12 col-sm-3">
	 	<div class="table-head"><?php echo $this->lang->line('application_media_details');?></div>
		<div class="subcont">
			<ul class="details">
				<li><span><?php echo $this->lang->line('media_application_name');?>:</span> <?php echo $media->name;?></li>
				<li><span><?php echo $this->lang->line('application_filename');?>:</span> <?php echo $media->filename;?></li>
				<!-- <li><span><?php echo $this->lang->line('application_phase');?>:</span> <?php echo $media->phase;?></li> -->
				<li><span><?php echo $this->lang->line('application_uploaded_by');?>:</span> <a class="label label-info"><?php if(isset($media->user->firstname)){ ?><?php echo $media->user->firstname;?> <?php echo $media->user->lastname;?><?php }else{ ?> <?php echo $media->client->firstname;?> <?php echo $media->client->lastname;?><?php } ?></a></li>
				<li><span><?php echo $this->lang->line('application_uploaded_on');?>:</span> <?php $unix = human_to_unix($media->date); echo date($core_settings->date_format, $unix); ?></li>
				<li><span><?php echo $this->lang->line('application_filename');?>:</span> <a href="<?php echo base_url()?>projects/download/<?php echo $media->id;?>" class="btn btn-xs btn-success"><i class="icon-download icon-white"></i> <?php echo $this->lang->line('application_download');?></a></li>
                
                
				<li><span><?php if(!empty($media->description)){ ?><?php echo $this->lang->line('media_application_description');?>: </span><?php echo $media->description;?></li><?php } ?>
			
            
            </ul>
			<br clear="both">
    	 </div>
    	 <br>
    	 <a class="btn btn-primary" href="<?php echo base_url()?><?php echo $backlink;?>"><i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('application_back_to_project');?></a>
    	 </div>
     
	 <div class="col-sm-9">
	 		 	
	 		<?php
				$type = explode('/', $media->type);
				switch($type[0]){
				case "image": ?>
					<div class="table-head"><?php echo $this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<div align="center">
						<img src="<?php echo base_url()?>files/media/<?php echo $media->savename;?>">
					</div>
					</div>
				<?php 
				break; 
				case "application":
					if($type[1] == "ogg" || $type[1] == "mp4" || $type[1]  == "webm"){ ?>
					<div class="table-head"><?php echo $this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<video id="video" class="video-js vjs-default-skin" controls
				  		preload="auto" width="100%" height="350" data-setup="{}">
				  		<source src="<?php echo base_url()?>files/media/<?php echo $media->savename;?>" type='video/<?php echo $type[1];?>'>
					</video>
					</div>
					<?php } 

					if($type[1] == "pdf"){ ?>
			        <div class="table-head"><h6><i class="icon-picture"></i><?php echo $this->lang->line('application_media_preview');?></h6></div>
			        <div class="subcont preview">
			        <script type='text/javascript'>

					  function embedPDF(){

					    var myPDF = new PDFObject({ 

					      url: '<?php echo base_url()?>/files/media/<?php echo $media->savename;?>'

					    }).embed('pdf-viewer'); 

					  }

					  window.onload = embedPDF;

					</script>
					<div id="pdf-viewer" style="height:600px; width:100%"></div>
			        
			        </div>
					<?php } 
			
			break;
			case "video":
					?>
					<div class="table-head"><?php echo $this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<video id="video" class="video-js vjs-default-skin" controls
				  		preload="auto" width="100%" height="350" data-setup="{}">
				  		<source src="<?php echo base_url()?>files/media/<?php echo $media->savename;?>" type='video/<?php echo $type[1];?>'>
					</video>
					</div>
					<?php 
			
			break;
			case "audio":
					?>
					<div class="table-head"><?php echo $this->lang->line('application_media_preview');?></div>
					<div class="subcont preview">
					<audio controls>
					  <source src="<?php echo base_url()?>files/media/<?php echo $media->savename;?>" type="audio/mpeg">
					</audio>
					</div>

					<?php 
			
			break;




			} ?>
			<br>



            <div class="table-head"><?php echo $this->lang->line('application_comments');?>
            <span class=" pull-right"><a class="btn btn-primary open-comment-box"><?php echo $this->lang->line('application_new_comment');?></a></span>
            </div>
            <div class="subcont" > 

<ul id="comments-ul" class="comments">
                      <li class="comment-item add-comment">
                      <?php   
                                $attributes = array('class' => 'ajaxform', 'id' => 'replyform', 'data-reload' => 'comments-ul');
                                echo form_open($form_action, $attributes); 
                                ?>
                     <!--  <div class="comment-pic">
                        <img class="img-circle tt" title="<?php echo $this->user->firstname?> <?php echo $this->user->lastname?>"  src="<?php echo get_user_pic($this->user->userpic, $this->user->email);?>">
                      
                      </div> -->
                      <div class="comment-content">

                            <p><small class="text-muted"><span class="comment-writer"><?php echo $this->user->firstname?> <?php echo $this->user->lastname?></span> <span class="datetime"><?php  echo date($core_settings->date_format.' '.$core_settings->date_time_format, time()); ?></span></small></p>
                            <input id="timestamp" type="hidden" name="datetime" value="<?php echo $datetime; ?>" />
                            <p><textarea class="input-block-level summernote" id="reply" name="message" placeholder="<?php echo $this->lang->line('application_write_message');?>..." required/></textarea></p>
                            <button id="send" name="send" class="btn btn-primary button-loader"><?php echo $this->lang->line('application_send');?></button>
                            <button id="cancel" name="cancel" class="btn btn-danger open-comment-box"><?php echo $this->lang->line('application_close');?></button>
                               
                      </div>
                       </form>
                      </li>

                       <li class="comment-item">
                       
                          <div class="comment-content">
                          <h5><?php echo $media->name;?> </h5>
                            <p><small class="text-muted"><?php echo $this->lang->line('application_uploaded_by');?> <?php if(isset($media->user->firstname)){ ?><?php echo $media->user->firstname;?> <?php echo $media->user->lastname;?><?php }else{ ?> <?php echo $media->client->firstname;?> <?php echo $media->client->lastname;?><?php } ?> <?php $unix = human_to_unix($media->date); echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></small></p>
                            <p><?php echo $media->description;?></p>
                          </div>
                      </li> 
<?php
			    $i = 0;
			    foreach ($media->messages as $value): 
			      $i = $i+1;
			  if($i == 1){ ?>
			  
			  <?php }
			  ?>	
                      <li class="comment-item">
                      
                      <div class="comment-content">
                            <p><small class="text-muted"><span class="comment-writer"><?php echo $value->from;?></span> <span class="datetime"><?php $unix = human_to_unix($value->datetime); echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix); ?></span></small></p>
                            <p><?php echo $value->text;?></p>
                      </div>
                      </li>
  <?php endforeach;?>
                      
         </ul>            




</div>




</div>
</div>



