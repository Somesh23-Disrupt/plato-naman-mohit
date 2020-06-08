<?php $__env->startSection('header_scripts'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
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
				 				<h4 class="card-title"><?php echo e(App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',5)->count()); ?></h4>
								<a href="<?php echo e(URL_USERS); ?>"><?php echo e(getPhrase('Students')); ?></a>
				 			</div>
				 		</div>
				 	</div>
				 	<div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_USERS); ?>"><div class="state-icn bg-icon-info"><i class="fa fa-users"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\User::where('inst_id',auth()->user()->inst_id)->where('role_id',7)->count()); ?></h4>
								<a href="<?php echo e(URL_USERS); ?>"><?php echo e(getPhrase('teachers')); ?></a>
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
				 	</div> -->
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
				 				<a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>"><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\QuestionBank::get()->count()); ?></h4>
								<a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>"><?php echo e(getPhrase('questions')); ?></a>
				 			</div>
				 		</div>
					 </div> 
					 <div class="col-md-3 col-sm-6">
						<div class="media state-media box-ws">
							<div class="media-left">
								<a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>"><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
							</div>
							<div class="media-body">
								<h4 class="card-title"><?php echo e(App\User::select('section_name')->where('inst_id',Auth::user()->inst_id)->where('role_id',5)->distinct()->get()->count()); ?></h4>
							   <a href=""><?php echo e(getPhrase('section')); ?></a>
							</div>
						</div>
					</div> 
					
					<!-- <div class="col-md-3 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				<h4 class="card-title"><?php echo e(App\ExamTopper::where('percentage','>=',50)->count()); ?></h4>
								<a href=""><?php echo e(getPhrase('Topper Students')); ?></a>
				 			</div>
				 		</div>
				 	</div> -->
				 	
				 	
					 <div class="col-md-4 col-sm-6">
						<div class="media state-media box-ws">
							<div class="media-left">
								<div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div>
							</div>
							<div class="media-body">
								<h4 class="card-title"><?php echo e($tppforteach); ?></h4>
								<a><?php echo e(getPhrase('Average Pass Percentage')); ?></a>
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
		 
			<!-- /.container-fluid -->
 
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
			<div class="row">
			<div class="col-md-12">  				  
				<div class="panel panel-primary dsPanel">				   				    
				  <div class="panel-body" >
					<table class="table table-striped table-bordered"  id="example" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php echo e(getPhrase('Test Name')); ?></th>
								<th><?php echo e(getPhrase('Subject')); ?></th>
								<th><?php echo e(getPhrase('Section')); ?></th>
								<th><?php echo e(getPhrase('Test Teacher')); ?></th>
								<th><?php echo e(getPhrase('Test Conducted')); ?></th>
							</tr>
						</thead>
						<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<thead>
								<tr>
									<td><?php echo e(App\QuizCategory::find($table->category_id)->category); ?></td>
									<td><?php echo e($table->title); ?></td>
									<td><?php echo e(getPhrase('c')); ?></td>		
									<td><?php echo e(getPhrase('teacher')); ?></td>
									<td><?php echo e($table->start_date); ?></td>
								</tr>
							</thead>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</table>
					</div>
				</div>
			</div>
			</div>
			<div class="row">

				
				<div class="col-md-6 col-lg-4">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-bar-chart-o"></i><?php echo e($chart_heading); ?></div>
				    <div class="panel-body" >
						
						<?php $ids=[];?>
						<?php for($i=0; $i<count($chart_data); $i++): ?>
						<?php 
						$newid = 'myChart'.$i;
						$ids[] = $newid; ?>
						
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<canvas id="<?php echo e($newid); ?>" width="100" height="97"></canvas>
								</div>
							</div>
						</div>

						<?php endfor; ?>
				    </div>
				  </div>
				</div> 


				<!-- <div class="col-md-6 col-lg-4">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa  fa-line-chart"></i> <?php echo e(getPhrase('payment_monthly_statistics')); ?></div>
				    <div class="panel-body" >
				    	<canvas id="payments_monthly_chart" width="100" height="60"></canvas>
				    </div>
				  </div>
				</div> -->

				
 

 
				
	</div>
</div>
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
<script>
 $(document).ready(function() {
	 $('#example').DataTable();
 } );
 </script>
  
<script src="<?php echo e(themes('js/bootstrap-toggle.min.js')); ?>"></script>
	<script src="<?php echo e(themes('js/jquery.dataTables.min.js')); ?>"></script>
	<script src="<?php echo e(themes('js/dataTables.bootstrap.min.js')); ?>"></script>

<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>

 
 <?php echo $__env->make('common.chart', array($chart_data,'ids' =>$ids), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
 
 <script>
 $(document).ready(function() {
	 $('#example').DataTable();
 } );
 </script>
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>