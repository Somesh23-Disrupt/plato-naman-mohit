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

						<div class="pull-right messages-buttons">
							<a href="<?php echo e(URL_MEETINGS_ADD); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('create')); ?></a>
						</div>

						<h1><?php echo e($title); ?></h1>
					</div>
					<div class="panel-body packages">
						<div>
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(getPhrase('title')); ?></th>
									<th><?php echo e(getPhrase('meeting_id')); ?></th>
									<?php if(!checkRole(['student'])): ?>
									<th><?php echo e(getPhrase('section')); ?></th>
									<?php endif; ?>
									<th><?php echo e(getPhrase('start_date')); ?></th>
									<th><?php echo e(getPhrase('end_date')); ?></th>
									<?php if(!checkRole(['student'])): ?>
									<th><?php echo e(getPhrase('action')); ?></th>
									<?php endif; ?>
								</tr>
							</thead>

						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>

 <?php echo $__env->make('common.datatables', array('route'=>URL_MEETINGS_GETLIST, 'route_as_url' => TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 <?php echo $__env->make('common.deletescript', array('route'=>URL_MEETINGS_DELETE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>