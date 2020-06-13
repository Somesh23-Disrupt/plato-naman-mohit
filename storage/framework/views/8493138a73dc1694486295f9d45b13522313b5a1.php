<?php $__env->startSection('header_scripts'); ?>
<link href="<?php echo e(CSS); ?>ajax-datatables.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li><a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"> <?php echo e(getPhrase('exam_categories')); ?> </a> </li>

							<li><?php echo e($title); ?></li>
						</ol>
					</div>
				</div>

				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">


						<h1><?php echo e($title); ?></h1>
					</div>
					<div class="panel-body packages">
						<div>
						  <?php
						  		$user = Auth::user();
						  		 $interested_categories      = null;
						        if($user->settings)
						        {
						          $interested_categories =  json_decode($user->settings)->user_preferences;
						        }

						  ?>

						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(getPhrase('title')); ?></th>
									<th><?php echo e(getPhrase('duration')); ?></th>
									<th><?php echo e(getPhrase('category')); ?></th>
									<th><?php echo e(getPhrase('total_marks')); ?></th>
									<th><?php echo e(getPhrase('total_questions')); ?></th>
									<th><?php echo e(getPhrase('action')); ?></th>

								</tr>
							</thead>

						</table>

						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>
  <?php if($category): ?>
	 <?php echo $__env->make('common.datatables', array('route'=>URL_STUDENT_QUIZ_GETLIST.$category->slug, 'route_as_url' => TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php else: ?>
	 <?php echo $__env->make('common.datatables', array('route'=>URL_STUDENT_QUIZ_GETLIST_ALL, 'route_as_url' => TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endif; ?>
	 <?php echo $__env->make('common.deletescript', array('route'=>URL_QUIZ_DELETE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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