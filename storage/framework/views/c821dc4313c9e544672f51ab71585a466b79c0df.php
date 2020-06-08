<!DOCTYPE html>

<html lang="en" dir="<?php echo e((App\Language::isDefaultLanuageRtl()) ? 'rtl' : 'ltr'); ?>">



<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="<?php echo e(getSetting('meta_description', 'seo_settings')); ?>">

	<meta name="keywords" content="<?php echo e(getSetting('meta_keywords', 'seo_settings')); ?>">

	 

	<link rel="icon" href="<?php echo e(IMAGE_PATH_SETTINGS.getSetting('site_favicon', 'site_settings')); ?>" type="image/x-icon" />

	<title><?php echo $__env->yieldContent('title'); ?> <?php echo e(isset($title) ? $title : getSetting('site_title','site_settings')); ?></title>

	<!-- Bootstrap Core CSS -->

	   <link href="<?php echo e(themes('css/bootstrap.min.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/sweetalert.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/sb-admin.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/custom-fonts.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('css/materialdesignicons.css')); ?>" rel="stylesheet">
	   <link href="<?php echo e(themes('font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
	 
	<link href="<?php echo e(themes('css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">
	
	<!-- Morris Charts CSS -->
	<link href="<?php echo e(themes('css/plugins/morris.css')); ?>" rel="stylesheet">

	 <?php
    $theme_color  = getThemeColor();
    ?>
    <?php if($theme_color == 'blueheader'): ?>      
	 <link href="<?php echo e(themes('css/theme-colors/header-blue.css')); ?>" rel="stylesheet">
    <?php elseif($theme_color == 'bluenavbar'): ?>	 
	 <link href="<?php echo e(themes('css/theme-colors/blue-sidebar.css')); ?>" rel="stylesheet">
    <?php elseif($theme_color == 'darkheader'): ?>	 
	 <link href="<?php echo e(themes('css/theme-colors/dark-header.css')); ?>" rel="stylesheet">
    <?php elseif($theme_color == 'darktheme'): ?>	 
	 <link href="<?php echo e(themes('css/theme-colors/dark-theme.css')); ?>" rel="stylesheet">
    <?php elseif($theme_color == 'whitecolor'): ?>	 
	 <link href="<?php echo e(themes('css/theme-colors/white-theme.css')); ?>" rel="stylesheet">]
	<?php endif; ?> 
	

	 <?php echo $__env->yieldContent('header_scripts'); ?>


</head>

<?php 

 $class = '';

 if(!isset($right_bar))

 	$class = 'no-right-sidebar';

$block_class = '';

if(isset($block_navigation))

	$block_class = 'non-clickable';

 ?>

<body ng-app="academia" >

	<div id="wrapper" class="<?php echo e($class); ?>">

		<!-- Navigation -->

		<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">

			<!-- Brand and toggle get grouped for better mobile display -->

			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

				<a class="navbar-brand" href="<?php echo e(PREFIX); ?>"><img src="<?php echo e(IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')); ?>" alt="<?php echo e(getSetting('site_title','site_settings')); ?>"></a>

			</div>

			<!-- Top Menu Items -->

			<ul class="nav navbar-right top-nav">

				<li>
				   <div class="dropdown-toggle top-profile-menu" data-toggle="dropdown">
					   <?php if(Auth::check()): ?>
					   <div class="username">
						   <h2><?php echo e(Auth::user()->inst_name); ?></h2>
					   </div>
					   <?php endif; ?>
				   </div>
			   </li>

				<li class="dropdown profile-menu">

					<div class="dropdown-toggle top-profile-menu" data-toggle="dropdown">

						<?php if(Auth::check()): ?>

						<div class="username">

							<h2><?php echo e(Auth::user()->name); ?></h2>

							 

						</div>

						<?php endif; ?>

						

						<div class="profile-img"> <img src="<?php echo e(getProfilePath(Auth::user()->image, 'thumb')); ?>" alt=""> </div>

						<div class="mdi mdi-menu-down"></div>

					</div>

					<ul class="dropdown-menu">

						<li>

							<a href="<?php echo e(URL_USER_DETAILS.Auth::user()->slug); ?>">
								
								<sapn><?php echo e(getPhrase('my_profile')); ?></sapn>

							</a>

						</li>

						 <li>

							<a href="<?php echo e(URL_USERS_CHANGE_PASSWORD.Auth::user()->slug); ?>">

								<sapn><?php echo e(getPhrase('change_password')); ?></sapn>

								</a>

						</li>
						
						 <li>

							<a href="<?php echo e(URL_USERS_SETTINGS.Auth::user()->slug); ?>">

								<sapn><?php echo e(getPhrase('settings')); ?></sapn>

								</a>

						</li>

						<li>

							<a href="<?php echo e(URL_FEEDBACK_SEND); ?>">

								<sapn><?php echo e(getPhrase('feedback')); ?></sapn>

							</a>

						</li>

						 

						<li>

							<a href="<?php echo e(URL_USERS_LOGOUT); ?>">

								<sapn><?php echo e(getPhrase('logout')); ?></sapn>

							</a>

						</li>

					</ul>

				</li>

			</ul>

			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

			<!-- /.navbar-collapse -->

		</nav>

		 <?php if(env('DEMO_MODE')): ?>
		<div class="alert alert-info demo-alert">
		&nbsp;&nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  			<strong><?php echo e(getPhrase('info')); ?>!</strong> CRUD <?php echo e(getPhrase('operations_are_disabled_in_demo_version')); ?>

		</div>
		<?php endif; ?>

		<aside class="left-sidebar">

			<div class="collapse navbar-collapse navbar-ex1-collapse">

				<ul class="nav navbar-nav side-nav">

					<li <?php echo e(isActive($active_class, 'dashboard')); ?>> 

						<a href="<?php echo e(PREFIX); ?>">

							<i class="fa fa-fw fa-window-maximize"></i> <?php echo e(getPhrase('dashboard')); ?> 

						</a> 

					</li>



					<!-- <li <?php echo e(isActive($active_class, 'children')); ?> > 



					<a data-toggle="collapse" data-target="#children"><i class="fa fa-fw fa-user-circle"></i>

					<?php echo e(getPhrase('children')); ?> </a> 

					

					<ul id="children" class="collapse sidemenu-dropdown">

						<li><a href="<?php echo e(URL_USERS_ADD); ?>"> <i class="fa fa-plus"></i><?php echo e(getPhrase('add')); ?></a></li>

						<li><a href="<?php echo e(URL_PARENT_CHILDREN); ?>"> <i class="fa fa-th"></i><?php echo e(getPhrase('list')); ?></a></li>

						

					</ul>



					</li>
 -->
<!-- 					<li <?php echo e(isActive($active_class, 'analysis')); ?> > 

					<a href="<?php echo e(URL_PARENT_ANALYSIS_FOR_STUDENTS); ?>"> 
					<i class="fa fa-fw fa-bar-chart" aria-hidden="true"></i>

					<?php echo e(getPhrase('analysis')); ?> </a> 

					</li>

					<li <?php echo e(isActive($active_class, 'exams')); ?> > 



					<a data-toggle="collapse" data-target="#exams"><i class="fa fa-fw fa-desktop" ></i> 

					<?php echo e(getPhrase('exams')); ?> </a> 

					

					<ul id="exams" class="collapse sidemenu-dropdown">

						<li><a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"> <i class="fa fa-random"></i><?php echo e(getPhrase('categories')); ?></a></li>

						<li><a href="<?php echo e(URL_STUDENT_EXAM_SERIES_LIST); ?>"> <i class="fa fa-list-ol"></i><?php echo e(getPhrase('exam_series')); ?></a></li>

						

					</ul>



					</li>

					<li <?php echo e(isActive($active_class, 'lms')); ?> > 



					<a data-toggle="collapse" data-target="#lms"><i class="fa fa-fw fa-tv" ></i> 

					LMS </a> 

					

					<ul id="lms" class="collapse sidemenu-dropdown">

							<li><a href="<?php echo e(URL_STUDENT_LMS_CATEGORIES); ?>"> <i class="fa fa-random"></i><?php echo e(getPhrase('categories')); ?></a></li>

							 

							<li><a href="<?php echo e(URL_STUDENT_LMS_SERIES); ?>"> <i class="fa fa-list-ol"></i><?php echo e(getPhrase('series')); ?></a></li>

					</ul>

					</li>
				

					<li <?php echo e(isActive($active_class, 'subscriptions')); ?> > 
					<a  href="<?php echo e(URL_PAYMENTS_LIST.Auth::user()->slug); ?>"><i class="fa fa-fw fa-ticket" ></i> 
					<?php echo e(getPhrase('subscriptions')); ?> </a> 
					</li>

 -->

					<li <?php echo e(isActive($active_class, 'notifications')); ?> > 

						<a href="<?php echo e(URL_NOTIFICATIONS); ?>" ><i class="fa fa-fw fa-bell" aria-hidden="true"></i> 

					<?php echo e(getPhrase('notifications')); ?> </a> 

					

					</li>

				 	<li <?php echo e(isActive($active_class, 'feedback')); ?> > 
						<a href="<?php echo e(URL_FEEDBACK_SEND); ?>" ><i class="fa fa-fw fa-commenting" ></i> 
					<?php echo e(getPhrase('feedback')); ?> </a> 
					
					</li>



					<li <?php echo e(isActive($active_class, 'faqs')); ?> > 

					<a href='<?php echo e(URL_FAQS_all); ?>'><i class="fa fa-fw fa-question"></i> 
					<?php echo e(getPhrase('faqs')); ?> </a> 
					</li>
					<li <?php echo e(isActive($active_class, 'children')); ?> >

						<a data-toggle="collapse" data-target="#children"><i class="fa fa-fw fa-user-circle"></i>
	
						Children </a>
	
	
							
						<ul id="children" class="collapse sidemenu-dropdown">
							<?php for($i = 0; $i < count($slugs); $i++): ?>
								<li><a href="<?php echo e(URL_PARENT_ANALYSIS_FOR_STUDENTS.'/'.$slugs[$i]); ?>"> <i class="fa fa-fw fa-user-circle"></i><?php echo e(getPhrase(App\User::where('slug',$slugs[$i])->first()->name)); ?></a></li>
							<?php endfor; ?>
						</ul>
	
					</li>
	
	

					 

					 

				</ul>

			</div>

		</aside>

		<?php if(isset($right_bar)): ?>

			

		<aside class="right-sidebar" id="rightSidebar">

			<button class="sidebat-toggle" id="sidebarToggle" href='javascript:'><i class="mdi mdi-menu"></i></button>

			<div class="panel panel-right-sidebar">

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
	

	

	 <?php echo $__env->yieldContent('footer_scripts'); ?>



	<?php echo $__env->make('errors.formMessages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 	
	<?php echo getSetting('google_analytics', 'seo_settings'); ?>

</body>



</html>
