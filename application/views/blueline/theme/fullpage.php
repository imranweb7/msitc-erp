<?php 
/**
 * @file        Fullpage View
 * @author      Luxsys <support@luxsys-apps.com>
 * @copyright   By Luxsys (http://www.luxsys-apps.com)
 * @version     2.2.0
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META Http-Equiv="Cache-Control" Content="no-cache">
    <META Http-Equiv="Pragma" Content="no-cache">
    <META Http-Equiv="Expires" Content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <link rel="SHORTCUT ICON" href="<?php echo base_url()?>assets/blueline/img/favicon.ico"/>
    <title><?php echo $core_settings->company;?></title>

    <!-- Bootstrap core CSS and JS -->
    <link href="<?php echo base_url()?>assets/blueline/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url()?>assets/blueline/js/plugins/jquery-1.11.0.min.js"></script>


    <!-- Custom styles for this template -->
    <link href="<?php echo base_url()?>assets/blueline/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open+Sans:400italic,400,300,600,700:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/jquery-ui-1.10.3.custom.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/datepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/bootstrap-timepicker.css"/>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/colorpicker.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/refineslide.css"/>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/jquery-slider.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/summernote.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/chosen.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/dataTables.bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/xcharts.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/nprogress.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/jquery-labelauty.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/plugins/easy-pie-chart-style.css" />

    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/blueline.css?ver=<?php echo $core_settings->version;?>"/>
    
    <link href="<?php echo base_url()?>assets/blueline/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/ionicons.min.css" />

    
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/blueline/css/user.css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      html{
        height: 100%;
      }
      body {
        padding-bottom: 40px;
        height: 100%;
        /*background:#444;*/
      }  
    </style>
     
  <title><?php echo $core_settings->company;?></title>
 </head>
  <body>
  <div class="container">
  
  		<img class="fullpage-logo" src="<?php echo base_url()?><?php echo $core_settings->invoice_logo;?>" alt="<?php echo $core_settings->company;?>" />
     

    <div>
     <?php if($this->session->flashdata('message')) { $exp = explode(':', $this->session->flashdata('message'))?>
	    <div id="quotemessage" class="alert alert-success"><span><?php echo $exp[1]?></span></div>
	    <?php } ?>
<?php echo $yield?>
<br clear="all"/>
	</div>

</div>
    <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery-ui-1.10.3.custom.min.js"></script>
    
    <!-- Plugins -->
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/date-time/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/date-time/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/bootstrap-colorpicker.min.js"></script>
    
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.knob.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.autosize-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.inputlimiter.1.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.refineslide.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/summernote.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.nanoscroller.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jqBootstrapValidation.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/chart.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/nprogress.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery-labelauty.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/validator.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/timer.jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/jquery.easypiechart.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/velocity.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/plugins/velocity.ui.min.js"></script>


        <script type="text/javascript" src="<?php echo base_url()?>assets/blueline/js/blueline.js?ver=<?php echo $core_settings->version;?>"></script>

       


      <script type="text/javascript" charset="utf-8">
      
//Validation
  $("form").validator();

        $(document).ready(function(){ 

              $(".removehttp").change(function(e){
                $(this).val($(this).val().replace("http://",""));
              });

        });
    </script>

 </body>
</html>
