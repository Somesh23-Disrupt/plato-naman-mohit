 

<?php $__env->startSection('header_scripts'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>





<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li><a href="<?php echo e(URL_STUDENT_ANALYSIS_BY_EXAM.$user->slug); ?>"><?php echo e(getPhrase('analysis')); ?></i></a> </li>

							<li><?php echo e($title); ?></li>

						</ol>

					</div>

				</div>

								

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						 

						<h1><?php echo e($title.' '.getPhrase('of').' '.$user->name .' '.getPhrase('in').' '.$exam_record->title.' '.getPhrase('exam')); ?></h1>

					</div>



					<div class="panel-body packages">

					<ul class="nav nav-tabs add-student-tabs">

							<li class="active"><a data-toggle="tab" href="#academic_details"><?php echo e(getPhrase('marks')); ?></a></li>

							<li><a data-toggle="tab" href="#personal_details"><?php echo e(getPhrase('time')); ?></a></li>

							 

					</ul>

					<div class="tab-content tab-content-style">

							<div id="academic_details" class="tab-pane fade in active">

						<div class="table-responsive"> 

						<table class="table table-striped table-bordered  " cellspacing="0" width="100%">

							<thead>

								<tr>

								 

									<th><?php echo e(getPhrase('title')); ?></th>

									<th><?php echo e(getPhrase('correct')); ?></th>

									<th><?php echo e(getPhrase('wrong')); ?></th>

									<th><?php echo e(getPhrase('not_answered')); ?></th>

									<th><?php echo e(getPhrase('total')); ?></th>

									 

									

								</tr>

							</thead>

							 <?php 



							 foreach($subjects_display as  $r) { 

							 	$r = (object)$r;

							 	?>

							 	<tr>

							 		<td><?php echo e($r->subject_name); ?></td>

							 		<td><?php echo e($r->correct_answers); ?></td>

							 		<td><?php echo e($r->wrong_answers); ?></td>

							 		<td><?php echo e($r->not_answered); ?></td>

							 		<td><?php echo e($r->correct_answers+$r->wrong_answers+$r->not_answered); ?></td>

							 	</tr>

							 	<?php } ?>

						</table>

						</div>



						<div class="row">

					

						<?php $ids=[];?>

						<?php for($i=0; $i<count($chart_data); $i++): ?>

						<?php 

						$newid = 'myChart'.$i;

						$ids[] = $newid; ?>

						

						<div class="col-lg-6">

							<canvas id="<?php echo e($newid); ?>" width="50%" height="30"></canvas>

						</div>



						<?php endfor; ?>

						</div>

 						</div>

 					 	<div id="personal_details" class="tab-pane fade">

									<div class="table-responsive"> 

						<table class="table table-striped table-bordered  " cellspacing="0" width="100%">

							<thead>

								<tr>

								 

									<th><?php echo e(getPhrase('title')); ?></th>

									<th><?php echo e(getPhrase('spent_on_correct')); ?></th>

									<th><?php echo e(getPhrase('spent_on_wrong')); ?></th>

									<th><?php echo e(getPhrase('total_time')); ?></th>

									<th><?php echo e(getPhrase('spent_time')); ?></th>

									 

									

								</tr>

							</thead>

							<?php 

						 

							$sanalysis = json_decode($quizresult->subject_analysis);

						 

							foreach($sanalysis as  $r) { 

							 	$r = (object)$r;

							  

							 	?>

							 	<tr>

							 		<td><?php echo e(App\Subject::getName($r->subject_id)); ?></td>

							 		<td><?php echo e(getTimeFromSeconds($r->time_spent_correct_answers)); ?></td>

							 		<td><?php echo e(getTimeFromSeconds($r->time_spent_wrong_answers)); ?></td>

							 		<td><?php echo e(getTimeFromSeconds($r->time_to_spend)); ?></td>

							 		<td> <?php echo e(getTimeFromSeconds($r->time_spent)); ?> </td>

							 	</tr>

							<?php } ?>

						</table>

						</div>

							<?php if(isset($time_data)): ?>

 						<div class="row">

					 <h4> <?php echo e(getPhrase('time_is_shown_in_seconds')); ?></h4>

						<?php

						 

						 $timeids=[];?>

						<?php for($i=0; $i<count($time_data); $i++): ?>

						<?php 

						$newid = 'myTimeChart'.$i;

						$timeids[] = $newid; ?>

						

						<div class="col-lg-4 ">

							<canvas id="<?php echo e($newid); ?>" width="100" height="110"></canvas>

						</div>



						<?php endfor; ?>

						</div>

						<?php endif; ?>

 					 </div>

 					 </div>

					</div>

				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

<?php $__env->stopSection(); ?>

 



<?php $__env->startSection('footer_scripts'); ?>

 

 <?php echo $__env->make('common.chart', array($chart_data,'ids' => $ids), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php if(isset($time_data)): ?>

	<?php echo $__env->make('common.chart', array('chart_data'=>$time_data,'ids' => $timeids), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>