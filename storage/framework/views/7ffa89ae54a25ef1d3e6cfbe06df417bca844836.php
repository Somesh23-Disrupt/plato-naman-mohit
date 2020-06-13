<!DOCTYPE html>

<html lang="en" dir="<?php echo e((App\Language::isDefaultLanuageRtl()) ? 'rtl' : 'ltr'); ?>">



<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="<?php echo e(getSetting('meta_description', 'seo_settings')); ?>">

	<meta name="keywords" content="<?php echo e(getSetting('meta_keywords', 'seo_settings')); ?>">

	 	<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">


	<link rel="icon" href="<?php echo e(IMAGE_PATH_SETTINGS.getSetting('site_favicon', 'site_settings')); ?>" type="image/x-icon" />

	<title><?php echo $__env->yieldContent('title'); ?> <?php echo e(isset($title) ? $title : getSetting('site_title','site_settings')); ?></title>

	<!-- Bootstrap Core CSS -->

 <?php echo $__env->yieldContent('header_scripts'); ?>


       <link href="<?php echo e(themes('css/bootstrap.min.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/sweetalert.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/exam.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/custom-fonts.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/materialdesignicons.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
	 
		<link href="<?php echo e(themes('css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">
	
	<!-- Morris Charts CSS -->
	<link href="<?php echo e(themes('css/plugins/morris.css')); ?>" rel="stylesheet">


</head>





<body ng-app="academia">

	

 <?php echo $__env->yieldContent('custom_div'); ?>

 <?php 

 $class = '';

 if(!isset($right_bar))

 	$class = 'no-right-sidebar';

$block_class = '';

if(isset($block_navigation))

	$block_class = 'non-clickable';

 ?>

	<div id="wrapper" class="<?php echo e($class); ?>">

		<!-- Navigation -->

		<nav role="navigation">
			
		

			<!-- Brand and toggle get grouped for better mobile display -->

			
			<!-- Top Menu Items -->

			

			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

			<!-- /.navbar-collapse -->

		</nav>

		 

		
		<?php if(isset($right_bar)): ?>

			

		<aside class="right-sidebar" id="rightSidebar">

			<button class="sidebat-toggle" id="sidebarToggle" href='javascript:'><i class="mdi mdi-menu"></i></button>

			<?php $right_bar_class_value = ''; 

			if(isset($right_bar_class))

				$right_bar_class_value = $right_bar_class;

			?>

			<div class="panel panel-right-sidebar <?php echo e($right_bar_class_value); ?>">

			<?php $data = '';

			if(isset($right_bar_data))

				$data = $right_bar_data;

			?>

				<?php echo $__env->make($right_bar_path, array('data' => $data), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			</div>

		</aside>

		

	<?php endif; ?>

		<?php echo $__env->yieldContent('content'); ?>

	</div>

	<!-- /#wrapper -->

	<!-- jQuery -->

	<script src="<?php echo e(themes('js/jquery-1.12.1.min.js')); ?>"></script>
	<script src="<?php echo e(themes('js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(themes('js/main.js')); ?>"></script>
	<script src="<?php echo e(themes('js/sweetalert-dev.js')); ?>"></script>
	<script src="<?php echo e(themes('js/mousetrap.js')); ?>"></script>

	<script>
		window.history.forward();


function noBack() { window.history.forward(); }

 function checkKeyCode(evt)
    {

        var evt = (evt) ? evt : ((evt) ? evt : null);
    	console.log(evt.keyCode);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if(
        	evt.keyCode == 123 //F12
        	|| evt.keyCode==116 
        	|| evt.keyCode==82 || evt.keyCode==9 || evt.keyCode==18 || evt.keyCode==17 
        	|| evt.keyCode == 44 //PRNT SCR
        	)
        {
            evt.keyCode=0;
            return false
        }
        else if(evt.keyCode==8)
        {
            evt.keyCode=0;
            return false
        }

    }
    document.onkeydown=checkKeyCode;
	</script>


<SCRIPT TYPE="text/javascript"> 

var message="Sorry, right-click has been disabled"; 

function clickIE() {if (document.all) {(message);return false;}} 
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) { 
if (e.which==2||e.which==3) {(message);return false;}}} 
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;} 
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;} 
document.oncontextmenu=new Function("return false") 

</SCRIPT> 

<SCRIPT TYPE="text/javascript"> 


	function disableselect(e){
	return false
	} 
	function reEnable(){
	return true
	} 
	//if IE4+
	document.onselectstart=new Function ("return false") 
	//if NS6
	if (window.sidebar){
	document.onmousedown=disableselect
	document.onclick=reEnable
	}

</SCRIPT>

<script>
Mousetrap.bind(['ctrl+s', 'ctrl+p', 'ctrl+w', 'ctrl+u'], function(e) {
    if (e.preventDefault) {
        e.preventDefault();
    } else {
        // internet explorer
        e.returnValue = false;
    }
});	
</script>

<script language="JavaScript">
        function fullScreen() {
            var el = document.documentElement
            , rfs = // for newer Webkit and Firefox
               el.requestFullScreen
            || el.webkitRequestFullScreen
            || el.mozRequestFullScreen
            || el.msRequestFullScreen
            ;
            if(typeof rfs!="undefined" && rfs){
              rfs.call(el);
            } else if(typeof window.ActiveXObject!="undefined"){
              // for Internet Explorer
              var wscript = new ActiveXObject("WScript.Shell");
              if (wscript!=null) {
                 wscript.SendKeys("{F11}");
              }
            }

        }
        // End -->
    </script>
    
    <script>
            var csrfToken = $('[name="csrf_token"]').attr('content');

            setInterval(refreshToken, 600000); // 1 hour 

            function refreshToken(){
                $.get('refresh-csrf').done(function(data){
                    csrfToken = data; // the new token
                });
            }

            setInterval(refreshToken, 600000); // 1 hour 

        </script>

	

	<?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	

	<?php echo $__env->yieldContent('footer_scripts'); ?>

	<?php echo $__env->make('errors.formMessages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<?php echo $__env->yieldContent('custom_div_end'); ?>
	<?php echo getSetting('google_analytics', 'seo_settings'); ?>

</body>



</html>