<?php $__env->startSection('header_scripts'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<div id="page-wrapper" ng-model="academia" ng-controller="instructions">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							
							<li><?php echo e($title); ?></li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
	<div class="panel panel-custom col-lg-12" >
					<div class="panel-heading">
						<h1><?php echo e(getPhrase('Instructions')); ?> <span class="pull-right text-italic"><?php echo e(getPhrase('please_read_the_instructions_carefully')); ?></span></h1>

					</div>
					<div class="panel-body instruction no-arrow">

						<div class="row">
							<div class="col-md-12">
								<h2><?php echo e(getPhrase('exam_name')); ?>:   <?php echo e($record->title); ?> </h2>
								<?php if($instruction_data==''): ?>	
								<h3><?php echo e(getPhrase('general_instructions')); ?>:</h3>
								<?php else: ?>
								<h3><?php echo e($instruction_title); ?>:</h3>
								<?php endif; ?>
								<?php if($instruction_data==''): ?>			
								<ol>
									<li>Total of <?php echo e($record->dueration); ?> minutes duration will be given to attempt all the questions.</li>
									<li>The clock has been set at the server and the countdown timer at the top right corner of your screen will display the time remaining for you to complete the exam. When the clock runs out the exam ends by default - you are not required to end or submit your exam.</li>
									<li>The question palette at the right of screen shows one of the following statuses of each of the questions numbered:</li>
								</ol>
								<?php else: ?> 
								<?php echo $instruction_data; ?>

								<?php endif; ?>

								<ul class="guide">
									<li>
										<span class="answer"><i class="mdi mdi-check"></i></span> You have answered the question.
									</li>
									<li>
										<span class="notanswer"><i class="mdi mdi-close"></i></span> You have not answered the question.
									</li>
									<li>
										<span class="marked"><i class="mdi mdi-eye"></i></span> You have answered the question but have marked the question for review.
									</li>
									<li>
										<span class="notvisited"><i class="mdi mdi-eye-off"></i></span> You have not visited the question yet.
									</li>
								</ul>

							</div>

						</div>


						<hr>
						<?php
						$paid_type =  false;
						if($record->is_paid && !isItemPurchased($record->id, 'exam'))	
						$paid_type = true;
						?>
						<div class="form-group row">
						<?php echo Form::open(array('url' => 'exams/student/start-exam/'.$record->slug, 'method' => 'POST')); ?>

							<div class="col-md-12">
							<?php if(!$paid_type): ?>	
								<input type="checkbox" name="option" id="free" checked="" ng-model="agreeTerms">
								<label for="free" > <span class="fa-stack checkbox-button"> <i class="mdi mdi-check active"></i> </span> The computer provided to me is in proper working condition. I have read and understood the instructions given above. </label>
								
								<br><span class="text-danger" ng-show="!agreeTerms"><?php echo e(getPhrase('please_accept_terms_and_conditions')); ?></span> 

								<?php endif; ?>
								<div class="text-center">
									<?php if($paid_type): ?>	
									<a href="<?php echo e(URL_PAYMENTS_CHECKOUT.'exam/'.$record->slug); ?>" class="btn button btn-lg btn-success"><i class="icon-credit-card"></i> <?php echo e(getPhrase('buy_now')); ?></a>	
									<?php else: ?>

									<button ng-if="agreeTerms" class="btn button btn-lg btn-success"><?php echo e(getPhrase('start_exam')); ?></button>
									<?php endif; ?>
								</div>

							</div>
					<?php echo Form::close(); ?>


						</div>


					</div>
				</div>
			</div>

		</div>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('footer_scripts'); ?>
  <script src="<?php echo e(JS); ?>angular.js"></script>
  <script>
 var app = angular.module('academia', []);
app.controller('instructions', function($scope, $http) {
	
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.examlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>