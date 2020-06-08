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
					<?php if(count($categories)): ?>
						<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-md-3">
							 <a href="<?php echo e(URL_STUDENT_LMS_CATEGORIES_VIEW.$c->slug); ?>" class="library-item">
							 <?php 
							 $image = IMAGE_PATH_UPLOAD_LMS_DEFAULT;
							 if($c->image)
							 $image = IMAGE_PATH_UPLOAD_LMS_CATEGORIES.$c->image;?>
                                    <div class="item-image"> <img src="<?php echo e($image); ?>" alt=""> </div>
                                    <div class="item-details">
                                        <h3><?php echo e($c->category); ?></h3> </div>
                               </a>

							</div>
							 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
						Ooops...! <?php echo e(getPhrase('No_Categories_available')); ?>


						<a href="<?php echo e(URL_USERS_SETTINGS.$user->slug); ?>" ><?php echo e(getPhrase('click_here_to_change_your_preferences')); ?></a>
						<?php endif; ?>
							 
						</div>
						<?php if(count($categories)): ?>
						<?php echo $categories->links(); ?>

						<?php endif; ?>

					</div>
				</div>
			</div>
			
</div>
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>