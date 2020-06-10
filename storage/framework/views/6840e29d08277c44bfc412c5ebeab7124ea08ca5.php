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

<li><?php echo e($title); ?></li>
</ol>
</div>
</div>



    <!-- <div class="row">
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"><div class="state-icn bg-icon-info"><i class="fa fa-list-alt"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e(count(App\User::getUserSeleted('categories'))); ?></h4>
            <a href="<?php echo e(URL_STUDENT_EXAM_CATEGORIES); ?>"><?php echo e(getPhrase('quiz_categories')); ?></a>
          </div>
        </div>
      </div> -->
       

      <div class="col-md-12">  				  
        <div class="panel panel-primary dsPanel">				   				    
          <div class="panel-body" >
			<table class="table table-striped table-bordered datatable" id="datatable" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php echo e(getPhrase('Test Name')); ?></th>
						<th><?php echo e(getPhrase('Subject')); ?></th>
						<th><?php echo e(getPhrase('Total_Marks')); ?></th>
						<th><?php echo e(getPhrase('Scored Marks')); ?></th>
						<th><?php echo e(getPhrase('Percentage')); ?></th>
					</tr>
				</thead>
				<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				 
					<tr>
            <td><?php echo e(App\QuizCategory::find($table->category_id)->category); ?></td>
            <td><?php echo e($table->title); ?></td>
            <td><?php echo e($table->total_marks); ?></td>		
            <td><?php echo e($table->marks_obtained); ?></td>
            <td><?php echo e(round(($table->marks_obtained/$table->total_marks)*100,2)); ?></td>
					</tr>
			
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
			</div>
</div>
  
    

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
<?php echo $__env->make('layouts.parent.parentlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>