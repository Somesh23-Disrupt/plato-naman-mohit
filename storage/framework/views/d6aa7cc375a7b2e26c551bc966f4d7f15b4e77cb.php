<?php $__env->startSection('header_scripts'); ?>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 
							<li><i class="fa fa-home"></i> <a href="<?php echo e(URL_USERS_DASHBOARD); ?>"><?php echo e($title); ?></a></li>
						</ol>
					</div>
				</div>
			
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary dsPanel">
							<div class="panel-heading">
						 
								<h1><?php echo e($table_title); ?></h1>
							</div>
						  <div class="panel-body" >
							<table class="table table-striped table-bordered datatable" id="datatable" id="example" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo e(getPhrase('Student Name')); ?></th>
										<th><?php echo e(getPhrase('Section')); ?></th>
										<th><?php echo e(getPhrase('Obtained Marks')); ?></th>
										<th><?php echo e(getPhrase('Total Marks')); ?></th>
										<th><?php echo e(getPhrase('Result')); ?></th>
									</tr>
								</thead>
								<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
										<tr>
                                        <td><a href="<?php echo e(URL_RESULTS_VIEW_ANSWERS.$table->quiz_slug.'/'.$table->result_slug); ?>"><?php echo e(ucfirst(App\User::findOrFail($table->user_id)->name)); ?></a></td>
											<td><?php echo e(App\User::findOrFail($table->user_id)->section_name); ?></td>
										    <td><?php echo e($table->marks_obtained); ?></td>
										    <td><?php echo e($table->total_marks); ?></td>
										    <td><?php echo e($table->result); ?></td>
										</tr>
									
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
							</div>
						</div>
					</div>
					</div>
					
	
		<!-- /#page-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
	
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
		<script>
			$(document).ready( function () {
				$('#datatable').DataTable({
					dom: 'Bfrtip',
					buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
	
							],
					
				});
			});
		</script>
	 
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher.teacherlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>