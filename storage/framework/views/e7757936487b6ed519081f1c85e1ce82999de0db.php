<?php $__env->startSection('content'); ?>

<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
               <div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
							<li> <a href="<?php echo e(URL_STUDENT_LMS_SERIES); ?>"><?php echo e(getPhrase('learning_management_series')); ?> </a> </li>
							<li class="active"> <?php echo e($title); ?> </li>
						</ol>
					</div>
				</div>
                <div class="panel panel-custom">
                
                    <div class="panel-body">
 
                        <?php if(!$content_record): ?>

                        <div class="row">
                        <?php 
                             $image = IMAGE_PATH_UPLOAD_LMS_DEFAULT;
                             if($item->image)
                             $image = IMAGE_PATH_UPLOAD_LMS_SERIES.$item->image;
                         ?>

                            <div class="col-md-3"> <img src="<?php echo e($image); ?>" class="img-responsive center-block" alt=""> </div>
                            <div class="col-md-8 col-md-offset-1">
                                <div class="series-details">
                                    <h2><?php echo e($item->title); ?> </h2>

                                    	<?php echo $item->description; ?>

                                    <?php if($item->is_paid && !isItemPurchased($item->id, 'lms')): ?>
                                    <div class="buttons text-left">
                                        <a href="<?php echo e(URL_PAYMENTS_CHECKOUT.'lms/'.$item->slug); ?>" class="btn btn-dark text-uppercase"><?php echo e(getPhrase('buy_now')); ?></a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php elseif($content_record->content_type == 'video' || $content_record->content_type == 'iframe' || $content_record->content_type == 'video_url'): ?>

                            <?php echo $__env->make('student.lms.series-video-player', array('series'=>$item, 'content' => $content_record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <?php elseif($content_record->content_type == 'audio' || $content_record->content_type == 'audio_url'): ?>
                            <?php echo $__env->make('student.lms.series-audio-player', array('series'=>$item, 'content' => $content_record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                        <hr>

                       <?php echo $__env->make('student.lms.series-items', array('series'=>$item, 'content'=>$content_record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>

<?php if($content_record): ?>
    <?php if($content_record->content_type == 'video' || $content_record->content_type == 'video_url'): ?>
        <?php echo $__env->make('common.video-scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

<?php endif; ?>
<?php echo $__env->make('common.custom-message-alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>