<?php $__env->startSection('header_scripts'); ?>

<link href="<?php echo e(CSS); ?>ajax-datatables.css" rel="stylesheet">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>





<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							 

							<li><?php echo e($title); ?></li>

						</ol>

					</div>

				</div>

								

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						 

						<h1><?php echo e($title.' '.getPhrase('of').' '.$user->name); ?></h1>

					</div>

					<div class="panel-body packages">

						<div class="table-responsive"> 

						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">

							<thead>

								<tr>

								 

									<th><?php echo e(getPhrase('title')); ?></th>

									<th><?php echo e(getPhrase('Teacher')); ?></th>

								 

									<th><?php echo e(getPhrase('marks')); ?></th>

								 	 

									<th><?php echo e(getPhrase('result')); ?></th>

									 

									<th><?php echo e(getPhrase('action')); ?></th>

								  

								</tr>

							</thead>

							 

						</table>

						</div>

						<div class="row">

							<div class="col-md-6 col-md-offset-3">

								<canvas id="myChart1" width="100" height="110"></canvas>

							</div>

						</div>

					</div>

				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

<?php $__env->stopSection(); ?>

 



<?php $__env->startSection('footer_scripts'); ?>

 <?php if(!$exam_record): ?>

 <?php echo $__env->make('common.datatables', array('route'=>URL_STUDENT_EXAM_GETATTEMPTS.$user->slug, 'route_as_url' => 'TRUE'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 <?php else: ?>

 <?php echo $__env->make('common.datatables', array('route'=>URL_STUDENT_EXAM_GETATTEMPTS.$user->slug.'/'.$exam_record->slug, 'route_as_url' => 'TRUE'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 <?php endif; ?>

 <?php echo $__env->make('common.chart', array($chart_data,'ids' => array('myChart1')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php $__env->stopSection(); ?>


<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>