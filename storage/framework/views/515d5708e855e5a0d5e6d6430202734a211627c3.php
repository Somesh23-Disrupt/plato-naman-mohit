<?php $__env->startSection('header_scripts'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">



							<li class="active"> <?php echo e($title); ?> </li>

						</ol>

					</div>

				</div>

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						<h1><?php echo e(getPhrase('result_for'). ' '.$title); ?></h1></div>

					<div class="panel-body">

							<div class="profile-details text-center">

							<div class="profile-img"><img src="<?php echo e(getProfilePath($user->image,'profile')); ?>" alt=""></div>

							<div class="aouther-school">

								<h2><?php echo e($user->name); ?></h2>

								<p><span><?php echo e($user->email); ?></span></p>



							</div>



						</div>

					
 

						<div class="panel-body">
							<div class="row">
								<div class="col-sm-4">
									<ul class="library-statistic">

							<li class="total-books">

								<?php echo e(getPhrase('score')); ?> <span><?php echo e($record->marks_obtained); ?> / <?php echo e($record->total_marks); ?></span>

							</li>

							<li class="total-journals">

								<?php echo e(getPhrase('percentage')); ?> <span><?php echo sprintf('%0.2f', $record->percentage); ?></span>

							</li>

							<li class="digital-items">

							<?php $grade_system = getSettings('general')->gradeSystem; ?>

								<?php echo e(getPhrase('result')); ?> <span><?php echo e(ucfirst($record->exam_status)); ?></span>

							</li>

						</ul>
								</div>
								<div class="col-sm-4">
									
						 <?php if(isset($marks_data)): ?>

	 						<div class="row">

						

							<?php $ids=[];?>

							<?php for($i=0; $i<count($marks_data); $i++): ?>

							<?php 

							$newid = 'myMarksChart'.$i;

							$mark_ids[] = $newid; ?>

							

							 

								<canvas id="<?php echo e($newid); ?>" width="100" height="60"></canvas>

							 



							<?php endfor; ?>

							</div>

						<?php endif; ?>

								</div>
								<div class="col-sm-4">
									<?php if(isset($time_data)): ?>

	 						<div class="row">

						

							<?php $ids=[];?>

							<?php for($i=0; $i<count($time_data); $i++): ?>

							<?php 

							$newid = 'myTimeChart'.$i;

							$time_ids[] = $newid; ?>

								<canvas id="<?php echo e($newid); ?>" width="100" height="60"></canvas>

							<?php endfor; ?>

							</div>

						<?php endif; ?>
								</div>
							</div>

						

				 


					<br/>
					 
					<div class="row">

						<div class="col-lg-12 text-center">

							<a onClick="setLocalItem('<?php echo e(URL_RESULTS_VIEW_ANSWERS.$quiz->slug.'/'.$record->slug); ?>')" href="javascript:void(0);" class="btn t btn-primary"><?php echo e(getPhrase('view_key')); ?></a>

						</div>

					</div>	
					 
					</div>





					</div>



				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

		<!-- /#page-wrapper -->

	</div>

	<!-- /#wrapper -->

	 

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>

   <script src="<?php echo e(JS); ?>chart-vue.js"></script>



<?php if(isset($marks_data)): ?>

	<?php echo $__env->make('common.chart', array('chart_data'=>$marks_data,'ids' => $mark_ids), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php endif; ?>

<?php if(isset($time_data)): ?>

	<?php echo $__env->make('common.chart', array('chart_data'=>$time_data,'ids' => $time_ids), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php endif; ?>

<script>
function setLocalItem(url) {
	localStorage.setItem('redirect_url',url);
	window.close();
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.examlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>