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
							<li><a href="<?php echo e(url('/')); ?>"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>"><?php echo e(getPhrase('question_subjects')); ?></a></li>
							<li><a href="<?php echo e(URL_QUESTIONBAMK_IMPORT); ?>"><?php echo e(getPhrase('import_questions')); ?></a></li>
							<li><?php echo e($title); ?></li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="<?php echo e(URL_QUESTIONBANK_ADD_QUESTION.$subject->slug); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('create')); ?></a>
							 
						</div>
						<h1><?php echo e($title); ?></h1>
					</div>
					<div class="panel-body packages">
						<div class="table-responsive"> 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
								 
									<th><?php echo e(getPhrase('subject')); ?></th>
									<th><?php echo e(getPhrase('topic')); ?></th>
									<th><?php echo e(getPhrase('type')); ?></th>
									<th><?php echo e(getPhrase('question')); ?></th>
									<th><?php echo e(getPhrase('marks')); ?></th>
									<th><?php echo e(getPhrase('difficulty')); ?></th>
									<th><?php echo e(getPhrase('action')); ?></th>
								  
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
  
 <?php echo $__env->make('common.datatables', array('route'=>URL_QUESTIONBANK_GETQUESTION_LIST.$subject->slug, 'route_as_url' => 'TRUE'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 <?php echo $__env->make('common.deletescript', array('route'=>URL_QUESTIONBANK_DELETE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>