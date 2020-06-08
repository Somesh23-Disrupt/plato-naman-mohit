<?php $__env->startSection('custom_div'); ?>

    <div ng-controller="prepareQuestions">

    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li><a href="<?php echo e(URL_LMS_SERIES); ?>"><?php echo e(getPhrase('lms_series')); ?></a></li>

							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>

						</ol>

					</div>

				</div>

					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

				<?php $settings = ($record) ? $settings : ''; ?>

				<div class="panel panel-custom" ng-init="initAngData(<?php echo e($settings); ?>);" >

					<div class="panel-heading">

						<div class="pull-right messages-buttons">

							<a href="<?php echo e(URL_LMS_SERIES); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>

						</div>

					<h1><?php echo e($title); ?>  </h1>

					</div>

					<div class="panel-body" >

					<?php $button_name = getPhrase('create'); ?>

					 		<div class="row">

							<fieldset class="form-group col-md-6">

								<?php echo e(Form::label('lms_categories', getphrase('select_subject'))); ?>




								<?php echo e(Form::select('lms_categories', $categories, null, ['class'=>'form-control', 'ng-model' => 'category_id',

								'placeholder' => 'Select', 'ng-change'=>'categoryChanged(category_id)' ])); ?>


							</fieldset>

						<?php $lmssettings = getSettings('lms');?>

							<fieldset class="form-group col-md-6">

								<?php echo e(Form::label('file_type', getphrase('file_type'))); ?>




								<?php echo e(Form::select('file_type', $lmssettings->content_types, null, ['class'=>'form-control', 'ng-model' => 'content_type',

								'placeholder' => getPhrase('Select')  ])); ?>


							</fieldset>



							





								<div class="col-md-12">

							<div ng-if="examSeries!=''" class="vertical-scroll" >



								<h4 ng-if="categoryItems.length>0" class="text-success"><?php echo e(getPhrase('total_items')); ?>: {{ categoryItems.length}} </h4>



								<table

								  class="table table-hover">



									<th><?php echo e(getPhrase('title')); ?></th>

									<th><?php echo e(getPhrase('code')); ?></th>

									<th><?php echo e(getPhrase('type')); ?></th>





									<th><?php echo e(getPhrase('action')); ?></th>



									<tr ng-repeat="item in categoryItems | filter : {content_type: content_type} | filter:search_term  track by $index">



										<td

										title="{{item.title}}" >

										{{item.title}}

										</td>

										<td>{{item.code}}</td>

										<td>{{item.content_type}}</td>

										</td>

										<td><a



										ng-click="addToBag(item);" class="btn btn-primary" ><?php echo e(getPhrase('add')); ?></a>



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

<?php echo $__env->make('lms.lmsseries.scripts.js-scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('custom_div_end'); ?>

 </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>