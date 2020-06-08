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
					<?php //$settings = getExamSettings(); 
					?>
					<?php if(count($series)): ?>
						<?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-md-3">
								<div class="library-item mouseover-box-shadow">
								<div class="">
									<div class="item-image">
									<?php if($c->is_paid): ?>
									<div class="label-primary label-band"><?php echo e(getPhrase('premium')); ?></div>
									<?php else: ?>
									<div class="label-danger  label-band"><?php echo e(getPhrase('free')); ?></div>
									<?php endif; ?>	

									<?php $image = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
									if(isset($c->image) && $c->image!='')
										$image = IMAGE_PATH_UPLOAD_SERIES.$c->image;
									?>
										<img src="<?php echo e($image); ?>" alt="<?php echo e($c->title); ?>">
										
										<div class="hover-content"> 
										<div class="buttons">
											<a href="<?php echo e(URL_STUDENT_EXAM_SERIES_VIEW_ITEM.$c->slug); ?>" class="btn btn-primary"><?php echo e(getPhrase('view_more')); ?></a> 
											</div>
										</div>
										
									</div>
									<div class="item-details">
										<h3><?php echo e($c->title); ?></h3>
										<div class="quiz-short-discription">
										<?php echo $c->short_description; ?>

										</div>
										<ul>
											<li><i class="icon-bookmark"></i> <?php echo e($c->total_exams.' '.getPhrase('quizzes')); ?></li>
											<li><i class="icon-eye"></i> <?php echo e($c->total_questions.' '.getPhrase('questions')); ?></li>
										</ul>
									
									</div>
								</div>
								</div>
							</div>
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