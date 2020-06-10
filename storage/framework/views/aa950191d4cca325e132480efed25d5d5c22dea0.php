<?php $__env->startSection('content'); ?>

<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 
							<li><?php echo e($title); ?></li>
						</ol>
					</div>
				</div>
				 <div class="row">
			
	<?php $data=App\User::getUserSeleted('quizzes');
		// dd($data);
		?>
	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
	
	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"><div class="state-icn bg-icon-info"><i class="fa fa-list-alt"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title"><?php echo e(count($dat['lmscats'])-1); ?></h4>
				<a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"><?php echo e(getPhrase('lms_categories_for_').getPhrase($dat['lmscats']['name'])); ?></a>
 			</div>
 		</div>
	 </div> 
	 <div class="col-md-4 col-sm-6">
		<div class="media state-media box-ws">
			<div class="media-left">
				<div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
			</div>
			<div class="media-body">
				<h4 class="card-title"><?php echo e($dat['quiz']['quiz']); ?></h4>
			   <?php echo e(getPhrase('quizzes_for_').getPhrase($dat['quiz']['name'])); ?></a>
			</div>
		</div>
	</div>    
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php $__currentLoopData = $examattends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examattend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
	
	 <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e($examattend['atemp']); ?></h4>
            <?php echo e(getPhrase('Exam Attended By ').getPhrase($examattend['name'])); ?>

          </div>
        </div>
      </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php $__currentLoopData = $tnps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tnp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
	
	 <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e($tnp['per']); ?></h4>
            <?php echo e(getPhrase('Average Pass Percentage for ').getPhrase($tnp['name'])); ?>

          </div>
        </div>
      </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	 <!-- <div class="col-md-3 col-sm-6">
		<div class="media state-media box-ws">
		<div class="media-left">
			<a href="<?php echo e(URL_SUBJECTS); ?>"><div class="state-icn bg-icon-success"><i class="fa fa-book"></i></div></a>
		</div>
		<div class="media-body">
			<h4 class="card-title"><?php echo e(App\Subject::get()->count()); ?></h4>
			<a href="<?php echo e(URL_SUBJECTS); ?>"><?php echo e(getPhrase('subjects')); ?></a>
		</div>
		</div>
	</div> -->
	

 	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<a href="<?php echo e(URL_PARENT_CHILDREN); ?>"><div class="state-icn bg-icon-purple"><i class="fa fa-user-circle"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title"><?php echo e(App\User::where('parent_id', '=', $user->id)->get()->count()); ?></h4>
				<a href="<?php echo e(URL_PARENT_CHILDREN); ?>"><?php echo e(getPhrase('children')); ?></a>
 			</div>
 		</div>
 	</div>
	<?php for($i=0; $i<count($childs_names);$i++): ?>
	<div class="col-md-4 col-sm-6">
 		<div class="media state-media box-ws">
 			<div class="media-left">
 				<div class="state-icn bg-icon-purple"><i class="fa fa-user-circle"></i></div></a>
 			</div>
 			<div class="media-body">
 				<h4 class="card-title"><?php echo e($childs_totals[$i]); ?></h4>
				<?php echo e(getPhrase('avg_score_of ').getPhrase($childs_names[$i])); ?>

 			</div>
 		</div>
 	</div>
 	<?php endfor; ?>
	 

				 
				</div>
				
<div class="row">

<?php $ids=[];?>
<?php for($i=0; $i<count($chart_data); $i++): ?>
<?php 
$newid = 'myChart'.$i;
$ids[] = $newid; ?>

<div class="col-md-6">  				  
	<div class="panel panel-primary dsPanel">				   				    
		<div class="panel-body" >
		<canvas id="<?php echo e($newid); ?>" width="100" height="60"></canvas>					
   		</div>				
    </div>				
 </div>

<?php endfor; ?>	
 			
</div>

			</div>
			<!-- /.container-fluid -->
</div>
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
	<?php echo $__env->make('common.chart', array($chart_data,'ids' =>$ids,'scale'=>TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.parent.parentlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>