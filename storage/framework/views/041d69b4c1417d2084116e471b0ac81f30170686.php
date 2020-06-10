<?php $__env->startSection('header_scripts'); ?>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sectiondetails'); ?>
<li <?php echo e(isActive($active_class, 'section')); ?>>

    <a data-toggle="collapse" data-target="#section"><i class="fa fa-fw fa-tv" ></i>
    Sections </a>
		<ul id="section" class="collapse sidemenu-dropdown">
			<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			
		
				<li><a href="<?php echo e(URL_SECDETAILS.'/'.$section); ?>"> <i class="fa fa-fw fa-random"></i><?php echo e(App\User::select(['section_name'])->where('section_id',$section)->first()->section_name); ?></a></li>
				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 
							<li><i class="fa fa-home"></i> <?php echo e($title); ?></li>
						</ol>
					</div>
				</div>

				 <div class="row">
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_USERS); ?>"><div class="state-icn bg-icon-info"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
								 <h4 class="card-title"><?php echo e(App\User::where('inst_id',getUserWithSlug()->inst_id)->where('role_id',5)
								 ->where('section_name',getUserWithSlug()->section_name)
								 ->count()); ?></h4>
								<a href="<?php echo e(URL_USERS); ?>"><?php echo e(getPhrase('Students')); ?></a>
				 			</div>
				 		</div>
				 	</div>
					<!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_QUIZ_CATEGORIES); ?>"><div class="state-icn bg-icon-pink"><i class="fa fa-list-alt"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\QuizCategory::get()->count()); ?></h4>
								<a href="<?php echo e(URL_QUIZ_CATEGORIES); ?>"><?php echo e(getPhrase('quiz_categories')); ?></a>
				 			</div>
				 		</div>
				 	</div>
				 	 -->
				 	 <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_QUIZZES); ?>"><div class="state-icn bg-icon-purple"><i class="fa fa-desktop"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\Quiz::get()->count()); ?></h4>
								<a href="<?php echo e(URL_QUIZZES); ?>"><?php echo e(getPhrase('quizzes')); ?></a>
				 			</div>
				 		</div>
				 	</div>
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_SUBJECTS); ?>"><div class="state-icn bg-icon-success"><i class="fa fa-book"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\Subject::get()->count()); ?></h4>
								<a href="<?php echo e(URL_SUBJECTS); ?>"><?php echo e(getPhrase('subjects')); ?></a>
				 			</div>
				 		</div>
				 	</div>


				 	 <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<div class="state-icn bg-icon-purple"><i class="fa fa-list"></i></div>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e($tppforteach); ?></h4>
								<a><?php echo e(getPhrase('total_pass_percent')); ?></a>
				 			</div>
				 		</div>
				 	</div>
					 

				 	 <!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_SUBSCRIBED_USERS); ?>"><div class="state-icn bg-icon-blue"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\UserSubscription::get()->count()); ?></h4>
								<a href="<?php echo e(URL_SUBSCRIBED_USERS); ?>"><?php echo e(getPhrase('subscribed_users')); ?></a>
				 			</div>
				 		</div>
				 	</div>

				 		 <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_THEMES_LIST); ?>"><div class="state-icn bg-icon-pink"><i class="fa fa-fw fa-th-large" ></i> </div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\SiteTheme::get()->count()); ?></h4>
								<a href="<?php echo e(URL_THEMES_LIST); ?>"><?php echo e(getPhrase('themes')); ?></a>
				 			</div>
				 		</div>
				 	</div>
 -->
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary dsPanel">
						  <div class="panel-body" >
							<table class="table table-striped table-bordered datatable" id="datatable" id="example" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo e(getPhrase('Test Name')); ?></th>
										<th><?php echo e(getPhrase('Subject')); ?></th>
										<th><?php echo e(getPhrase('Total Marks')); ?></th>
										<th><?php echo e(getPhrase('Avg Marks')); ?></th>
										<th><?php echo e(getPhrase('pass_student')); ?></th>
									</tr>
								</thead>
								<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
										<tr>
											<td><?php echo e(App\QuizCategory::find($table->category_id)->category); ?></td>
											<td><?php echo e($table->title); ?></td>
											<?php $id=App\QuizCategory::find($table->category_id)->section_id ?>
											<td><?php echo e($table->total_marks); ?></td>
											<td><?php echo e($table->avgmarks); ?></td>
											<td><?php echo e($table->tp); ?></td>
										</tr>
									
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
							</div>
						</div>
					</div>
					</div>
					
			<!-- /.container-fluid -->
 <!-- <div class="row"> -->

 	<!-- <div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-pie-chart"></i> <?php echo e(getPhrase('quizzes_usage')); ?></div>
				    <div class="panel-body" >
				    	<canvas id="demanding_quizzes" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div>
				
				
				<div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-pie-chart"></i> <?php echo e(getPhrase('paid_quizzes_usage')); ?></div>
				    <div class="panel-body" >
				    	<canvas id="demanding_paid_quizzes" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div>
			</div> -->
			<!--  <div class="row">

				<div class="col-md-6 col-lg-5">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-bar-chart-o"></i> <?php echo e(getPhrase('Avg_Score')); ?></div>
				    <div class="panel-body" >
				    	<canvas id="payments_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> 
				

				<div class="col-md-6 col-lg-4">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa  fa-line-chart"></i> <?php echo e(getPhrase('payment_monthly_statistics')); ?></div>
				    <div class="panel-body" >
				    	<canvas id="payments_monthly_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> -->
								
				<div class="row">

				<?php $ids=[];?>
				<?php for($i=0; $i<count($chart_data); $i++): ?>
				<?php 
				$newid = 'myChart'.$i;
				$ids[] = $newid; ?>

				<div class="col-md-6">  				  
					<div class="panel panel-primary dsPanel">				   				    
						<div class="panel-body" >
						<canvas id="<?php echo e($newid); ?>" width="100" height="60"></canvas>					
						</div>				
					</div>				
				</div>

				<?php endfor; ?>	
							
				</div>

				
 

 
				
	</div>
</div>
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
	<?php echo $__env->make('common.chart', array($chart_data,'ids' =>$ids,'scale'=>TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
		<script>
			$(document).ready( function () {
				$('#datatable').DataTable({
					dom: 'Bfrtip',
					buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
	
							],
					
				});
			});
		</script>
	 
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher.teacherlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>