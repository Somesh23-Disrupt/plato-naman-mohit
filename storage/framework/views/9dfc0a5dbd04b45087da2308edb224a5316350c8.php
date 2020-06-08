<?php $__env->startSection('content'); ?>



<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->

               <div class="row">

					<div class="col-lg-12">

                        <ol class="breadcrumb">

                            <li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

                            <li> <a href="<?php echo e(URL_STUDENT_EXAM_SERIES_LIST); ?>"><?php echo e(getPhrase('exam_series')); ?> </a> </li>

                            <li class="active"> <?php echo e($title); ?> </li>

                        </ol>

                    </div>

				</div>

                <div class="panel panel-custom">
 

                    <div class="panel-body">

                        <?php if(!$content_record): ?>

                        <div class="row">
                        
                        <?php $image_path = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
                    $image_path_thumb = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
                    if($item->image)
                    {
                        $image_path = IMAGE_PATH_UPLOAD_SERIES.$item->image;
                        $image_path_thumb = IMAGE_PATH_UPLOAD_SERIES_THUMB.$item->image;
                    }
                    ?>

                            <div class="col-md-3"> <img src="<?php echo e($image_path); ?>" class="img-responsive center-block" alt=""> </div>

                            <div class="col-md-8 col-md-offset-1">

                                <div class="series-details">

                                    <h2><?php echo e($item->title); ?> </h2>



                                    	<?php echo $item->description; ?>

                                    
                                    <?php if($item->is_paid && !isItemPurchased($item->id, 'combo')): ?>

                                    <div class="buttons text-left">

                                        <a href="<?php echo e(URL_PAYMENTS_CHECKOUT.'combo/'.$item->slug); ?>" class="btn btn-dark text-uppercase"><?php echo e(getPhrase('buy_now')); ?></a>

                                    </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        

                        <?php endif; ?>

                        <hr>

                      

                       <?php echo $__env->make('student.exams.series.series-items', array('series'=>$item, 'content'=>$content_record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



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
<script>
function showInstructions(url) {
  width = screen.availWidth;
  height = screen.availHeight;
  window.open(url,'_blank',"height="+height+",width="+width+", toolbar=no, top=0,left=0,location=no,menubar=no, directories=no, status=no, menubar=no, scrollbars=yes,resizable=no");

    runner();
}

function runner()
{
    url = localStorage.getItem('redirect_url');
    if(url) {
      localStorage.clear();
       window.location = url;
    }
    setTimeout(function() {
          runner();
    }, 500);

}
</script>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>