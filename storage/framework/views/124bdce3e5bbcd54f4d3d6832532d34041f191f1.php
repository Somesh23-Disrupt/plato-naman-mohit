 <?php $__env->startSection('custom_div'); ?>

 <div ng-controller="prepareQuestions">

 <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div id="page-wrapper">

			<div class="container-fluid" ng-init="recordData(<?php echo e($record->is_paid); ?>);">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li><a href="<?php echo e(URL_EXAM_SERIES); ?>"><?php echo e(getPhrase('exam_series')); ?></a></li>

							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>

						</ol>

					</div>

				</div>

					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

				<?php $settings = ($record) ? $settings : ''; ?>

				<div class="panel panel-custom" ng-init="initAngData(<?php echo e($settings); ?>);" >

					<div class="panel-heading">

						<div class="pull-right messages-buttons">

							<a href="<?php echo e(URL_EXAM_SERIES); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>

						</div>

					<h1><?php echo e($title); ?>  </h1>

					</div>

					<div class="panel-body" >


               

					<?php $button_name = getPhrase('create'); ?>

					 		<div class="row">

							<fieldset class="form-group col-md-6">

								<?php echo e(Form::label('exam_categories', getphrase('exam_categories'))); ?>


								<span class="text-red">*</span>

								<?php echo e(Form::select('exam_categories', $exam_categories, null, ['class'=>'form-control', 'ng-model' => 'category_id', 

								'placeholder' => 'Select', 

								'ng-change'=>'categoryChanged(category_id)' ])); ?>


							</fieldset>


								 

								<div class="col-md-12">

							<div ng-if="examSeries!=''" class="vertical-scroll" >

						

								<h4 ng-if="categoryExams.length>0" class="text-success"><?php echo e(getPhrase('total_exams')); ?>: {{ categoryExams.length}} </h4>



								<table  

								  class="table table-hover">

  									 

									<th><?php echo e(getPhrase('exam_name')); ?></th>

									<th><?php echo e(getPhrase('duration')); ?></th>

									<th><?php echo e(getPhrase('marks')); ?></th>

									<th><?php echo e(getPhrase('questions')); ?></th>	

									<th><?php echo e(getPhrase('action')); ?></th>	
 

									<tr ng-repeat="exam in categoryExams  track by $index">

										 

										<td 

										title="{{exam.title}}" >

										{{exam.title}}

										</td>

										<td>{{exam.dueration}}</td>

										<td>{{exam.total_marks}}</td>

										<td>{{exam.total_questions}}</td>

										<td><a 

										 

										ng-click="addQuestion(exam);" class="btn btn-primary" ><?php echo e(getPhrase('add')); ?></a>

									  		

										  </td>

										

									</tr>

								</table>

								</div>	

							



					 			</div>

					 			 



					 		</div>

					 

					</div>



				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

<?php echo $__env->make('exams.examseries.scripts.js-scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

 

<?php $__env->startSection('custom_div_end'); ?>

 </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>