<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="<?php echo e(URL_SUBJECTS); ?>"><?php echo e(getPhrase('subjects')); ?></a> </li>
							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>
						</ol>
					</div>
				</div>
					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<!-- /.row -->

				<div class="panel panel-custom col-lg-6 col-lg-offset-3">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="<?php echo e(URL_SUBJECTS); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>
						</div>
					<h1><?php echo e($title); ?>  </h1>
					</div>
					<div class="panel-body  form-auth-style" id="app">
					<?php $button_name = getPhrase('create'); ?>
					<?php if($record): ?>
					 <?php $button_name = getPhrase('update'); ?>
						<?php echo e(Form::model($record,
						array('url' => URL_SUBJECTS_EDIT.'/'. $record->slug,
						'method'=>'patch', 'name'=>'formSubjects ', 'novalidate'=>''))); ?>

					<?php else: ?>
						<?php echo Form::open(array('url' => URL_SUBJECTS_ADD, 'method' => 'POST', 'name'=>'formSubjects ', 'novalidate'=>'')); ?>

					<?php endif; ?>

					 <?php echo $__env->make('mastersettings.subjects.form_elements',
					 array('button_name'=> $button_name),
					 array('sections'=> $sections), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

					<?php echo Form::close(); ?>



					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>
 <script>
 /**
  * This method validates the maximum and pass marks of a given subject
  * @return  {[type]} [description]
  */
 function validateMarks()
 {
 	$passmarks = $('#pass_marks');
 	$maxmarks = $('#maximum_marks');
 	maximum_marks = parseInt($maxmarks.val(),10);
 	pass_marks = parseInt($passmarks.val(),10);

 	//Check if Maximum Mark is a valid integer greater than 0
 	if(isNaN(maximum_marks) || maximum_marks <= 0){
 		alert('<?php echo e(getPhrase("please_enter_valid_maximum_marks")); ?>');
 		$maxmarks.val(0);
 		return;
 	}
 	//Check if Pass Mark is a valid integer greater than 0
 	if(isNaN(pass_marks)){
 		alert('<?php echo e(getPhrase("please_enter_valid_pass_marks")); ?>');
 		$passmarks.val(0);
 		return;
 	}

 	//Compare the Maximum mark and Pass mark and give tha appropriate message
 	if(pass_marks > maximum_marks)
 	{
 		alert('<?php echo e(getPhrase("pass_marks_cannot_be_greater_than_maximum_marks")); ?>');
 		$passmarks.val(0);
 	}

 }

 </script>
  <?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
 <?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>