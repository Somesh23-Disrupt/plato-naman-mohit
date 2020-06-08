<?php $__env->startSection('content'); ?>



<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li class="active"> <?php echo e($title); ?> </li>

						</ol>

					</div>

				</div>

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						<h1><?php echo e($title); ?></h1>

					</div>

					<div class="panel-body packages">

						 

						<div class="row library-items">

					<?php $settings = getSettings('lms'); ?>

					<?php if(count($series)): ?>

					<?php $entry_count = 0;?>

						<?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						

						<?php if($c->total_items): ?>

							

							<div class="col-md-3">

								<div class="library-item mouseover-box-shadow">

								<div class="">

									<div class="item-image">

									<?php if($c->is_paid): ?>

									<div class="label-primary label-band"><?php echo e(getPhrase('premium')); ?></div>

									<?php else: ?>

									<div class="label-danger  label-band"><?php echo e(getPhrase('free')); ?></div>

									<?php endif; ?>	



									<?php $image = $settings->defaultCategoryImage;

									if(isset($c->image) && $c->image!='')

										$image = $c->image;

									?>

										<img src="<?php echo e(IMAGE_PATH_UPLOAD_LMS_SERIES.$image); ?>" alt="<?php echo e($c->title); ?>">

										

										<div class="hover-content"> 

										<div class="buttons">

											<a href="<?php echo e(URL_STUDENT_LMS_SERIES_VIEW.$c->slug); ?>" class="btn btn-primary"><?php echo e(getPhrase('view_more')); ?></a> 

										 

											</div>

										</div>

										

									</div>

									<div class="item-details">

										<h3><?php echo e($c->title); ?></h3>

										<div class="quiz-short-discription">

										<?php echo $c->short_description; ?>


										</div>

										<ul>

											<li><i class="icon-bookmark"></i> <?php echo e($c->total_items.' '.getPhrase('items')); ?></li>

										</ul>

									

									</div>

								</div>

								</div>

							</div>

							 

							 

							

							<?php endif; ?>



							 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php else: ?> 

							Ooops...! <?php echo e(getPhrase('No_series_available')); ?>




						<a href="<?php echo e(URL_USERS_SETTINGS.$user->slug); ?>" ><?php echo e(getPhrase('click_here_to_change_your_preferences')); ?></a>

							<?php endif; ?>



						</div>

						<?php if(count($series)): ?>

						<?php echo $series->links(); ?>


						<?php endif; ?>

					</div>

				</div>

			</div>

			

</div>

		<!-- /#page-wrapper -->



<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>