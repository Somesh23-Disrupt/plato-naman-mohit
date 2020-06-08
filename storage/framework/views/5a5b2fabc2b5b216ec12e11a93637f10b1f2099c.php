 
 <?php $__env->startSection('header_scripts'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i> </a> </li>
							<?php if(checkRole(getUserGrade(2))): ?>
							<li><a href="<?php echo e(URL_USERS); ?>"><?php echo e(getPhrase('users')); ?></a> </li>
							<?php endif; ?>
							<?php if(checkRole(getUserGrade(7))): ?>
							<li><a href="<?php echo e(URL_PARENT_CHILDREN); ?>"><?php echo e(getPhrase('users')); ?></a> </li>
							<?php endif; ?>

							<li><a href="javascript:void(0);"><?php echo e($title); ?></a> </li>
						</ol>
					</div>
				
				</div>

				<div class="panel panel-custom">
				 	


					<div class="panel-body">
						
				
						
						<div class="row">
               <div class="col-md-12">
                        



						<div class="row">
							<div class="col-lg-12">

						<div class="col-lg-6">			
						<div class="profile-details">
							<div class="profile-img"><img align="left" src="<?php echo e(getProfilePath($record->image,'profile')); ?>" alt="<?php echo e($record->name); ?>">
							</div>

							<div class="aouther-school" text-align="center">
								<h2><?php echo e($record->name); ?></h2>
								<p><?php echo e($record->email); ?></p>
							</div>

						</div>
						</div>


						<div class="col-lg-6">
						<table class="table table-bordered table-hover">
							<caption><h5>Personal Details</h5></caption>

							<tr>
								<td><strong>Institute</strong></td>
								<td><?php echo e($record->inst_name); ?></td>
							</tr>
							<tr>
								<td><strong>Class</strong></td>
								<td><?php echo e($record->section_name); ?></td>
							</tr>
							<tr>
								<td><strong>Phone</strong></td>
								<td><?php echo e($record->phone); ?></td>
							</tr>
							<tr>
								<td><strong>Gender</strong></td>
								<td><?php echo e($record->gender); ?></td>
							</tr>

							<tr>
								<td><strong>Date of Birth</strong></td>
								<td><?php echo e($record->dob); ?></td>
							</tr>

							
						</table>
						</div>	

						</div>
						</div>


               	<div class="row">
               <div class="col-md-6 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_STUDENT_EXAM_ATTEMPTS.$record->slug); ?>"><div class="state-icn bg-icon-info"><i class="fa fa-history"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				
								<a href="<?php echo e(URL_STUDENT_EXAM_ATTEMPTS.$record->slug); ?>"><?php echo e(getPhrase('exam_history')); ?></a>
				 			</div>
				 		</div>
				 	</div>

				 	<div class="col-md-6 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_STUDENT_ANALYSIS_BY_EXAM.$record->slug); ?>"><div class="state-icn bg-icon-success"><i class="fa fa-flag"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				
								<a href="<?php echo e(URL_STUDENT_ANALYSIS_BY_EXAM.$record->slug); ?>"><?php echo e(getPhrase('by_exam')); ?></a>
				 			</div>
				 		</div>
				 	</div>


				 	 	<div class="col-md-6 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_STUDENT_ANALYSIS_SUBJECT.$record->slug); ?>"><div class="state-icn bg-icon-purple"><i class="fa fa-key"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				
								<a href="<?php echo e(URL_STUDENT_ANALYSIS_SUBJECT.$record->slug); ?>"><?php echo e(getPhrase('by_subject')); ?></a>
				 			</div>
				 		</div>
				 	</div>


				 	<!-- <div class="col-md-6 col-sm-6">
				 		<div class="media state-media box-ws">
				 			<div class="media-left">
				 				<a href="<?php echo e(URL_PAYMENTS_LIST.$record->slug); ?>">
							<div class="state-icn bg-icon-pink"><i class="fa fa-credit-card"></i></div></a>
				 			</div>
				 			<div class="media-body">
				 				
								<a href="<?php echo e(URL_PAYMENTS_LIST.$record->slug); ?>"><?php echo e(getPhrase('subscriptions')); ?></a>
				 			</div>
				 		</div>
				 	</div> -->

				
                  </div>
            
           </div>

			

 
	
	
	 

						 
						</div>
						 
 
					</div>
				</div>
				</div>
			<!-- /.container-fluid -->
</div>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('footer_scripts'); ?>
 

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>