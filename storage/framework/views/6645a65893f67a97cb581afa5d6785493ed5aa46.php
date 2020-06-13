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
					<?php $settings = getExamSettings(); ?>
					<?php if(count($categories)): ?>
						<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-md-3">
								<div class="library-item mouseover-box-shadow">
								<a href="<?php echo e(URL_STUDENT_EXAMS.$c->slug); ?>">
									<div class="item-image">
									<?php $image = $settings->defaultCategoryImage;
									if(isset($c->image) && $c->image!='')
										$image = $c->image;
									?>
										<img src="<?php echo e(PREFIX.$settings->categoryImagepath.$image); ?>" alt="">
									</div>
									<div class="item-details">
										<h3><?php echo e($c->category); ?></h3>
										<ul>
											<li><i class="icon-bookmark"></i> <?php echo e(count($c->quizzes()).' '.getPhrase('quizzes')); ?></li>
											<li><i class="icon-eye"></i> <?php echo e(getPhrase('view')); ?></li>
										</ul>
									
									</div>
								</a>
								</div>
							</div>
							 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
						Ooops...! <?php echo e(getPhrase('No_Categories_available')); ?>

						
						<a href="<?php echo e(URL_USERS_SETTINGS.Auth::user()->slug); ?>" ><?php echo e(getPhrase('click_here_to_change_your_preferences')); ?></a>
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