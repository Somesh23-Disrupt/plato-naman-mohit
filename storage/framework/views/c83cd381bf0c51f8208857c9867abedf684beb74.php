<?php $__env->startSection('header_scripts'); ?>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
    
  

     $exam_id          = 0;
     $resume_exam_link = '';
     $series_slug      = 0;
     $pay_exam_slug    = '';
     $user             = Auth::user();
     $quiz_data        = null;
     $series_quiz_slug  = null;
     $series_exam_link  = null;
     $series_quiz_data  = null;

    if(session()->has('exam_id')){

      
       $my_time          = session()->get('active_time');
       $current_time     = time();

       $time1 = date("H:i", $my_time);
       $time2 = date("H:i", $current_time);
       $time3 = date("H:i",strtotime($time1." +1 minutes"));

       if( $time2 == $time1 || $time3 > $time2 ){
          
          $exam_id          = session()->get('exam_id');
          $quiz_data        = App\Quiz::where('id','=',$exam_id)->first();
          $is_purchased     = isItemPurchased($quiz_data->id,"exam",$user->id);


          if(!$is_purchased && $quiz_data->is_paid == 1 ){
             
             $pay_exam_slug   = $quiz_data->slug;

          }else{

             $resume_exam_link = URL_STUDENT_TAKE_EXAM.$quiz_data->slug;
          }


       }else{

           $exam_id          = 0;
           $resume_exam_link = '';
           $pay_exam_slug   = '';
       }

    }
    elseif ( session()->has('exam_series_slug') ) {
    
       
       $my_time          = session()->get('active_time');
       $current_time     = time();  
       
       $time1 = date("H:i", $my_time);
       $time2 = date("H:i", $current_time);
       $time3 = date("H:i",strtotime($time1." +1 minutes"));


       if( $time2 == $time1 || $time3 > $time2 ){
       
         $slug      = session()->get('exam_series_slug');
         $exam_series      = App\ExamSeries::where('slug', '=', $slug)->first();
         $is_purchased     = isItemPurchased($exam_series->id,"combo",$user->id);

         if( $is_purchased && session()->has('series_quiz_slug')){
           
            $series_quiz_slug      = session()->get('series_quiz_slug');
            $series_quiz_data      = App\Quiz::where('slug','=',$series_quiz_slug)->first();
            $series_exam_link      = URL_STUDENT_TAKE_EXAM.$series_quiz_slug;

         }else{
          
            $series_slug      = $slug;
         }

       }else{

           $series_slug      = 0;
       }

    }

    else{

      $exam_id  = 0;
      $resume_exam_link = '';
      $series_slug = 0;

    }



?>

<input type="hidden" name="resume_exam_id" id ="resume_exam_id" value="<?php echo e($exam_id); ?>">
<input type="hidden" name="resume_exam_link" id ="resume_exam_link" value="<?php echo e($resume_exam_link); ?>">
<input type="hidden" name="series_slug" id ="series_slug" value="<?php echo e($series_slug); ?>">
<input type="hidden" name="pay_exam_slug" id ="pay_exam_slug" value="<?php echo e($pay_exam_slug); ?>">
<input type="hidden" name="series_quiz_slug" id ="series_quiz_slug" value="<?php echo e($series_quiz_slug); ?>">
<input type="hidden" name="series_exam_link" id ="series_exam_link" value="<?php echo e($series_exam_link); ?>">





<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">

<li><?php echo e($title); ?></li>
</ol>
</div>
</div>


<?php if(session()->has('exam_id') && $quiz_data): ?>

   <?php if($is_purchased && $quiz_data->is_paid == 1 ): ?>

    <div class="alert alert-success">
      <strong><?php echo e(ucwords($quiz_data->title)); ?></strong> &nbsp;&nbsp; <a onclick="startMyExam()" href="javascript:void(0);" class="btn btn-primary btn-sm"><?php echo e(getPhrase('click_here_to_take_exam')); ?></a>
    </div> 

    <?php elseif( $quiz_data->is_paid == 0 ): ?>

      <div class="alert alert-success">
      <strong><?php echo e(ucwords($quiz_data->title)); ?></strong> &nbsp;&nbsp; <a onclick="startMyExam()" href="javascript:void(0);" class="btn btn-primary btn-sm"><?php echo e(getPhrase('click_here_to_take_exam')); ?></a>
    </div> 

    <?php endif; ?>

<?php endif; ?>

<?php if(session()->has('series_quiz_slug') &&  $series_exam_link ): ?>
   

     <div class="alert alert-success">
      <strong><?php echo e(ucwords($series_quiz_data->title)); ?></strong> &nbsp;&nbsp; <a onclick="startMySeriesExam()" href="javascript:void(0);" class="btn btn-primary btn-sm"><?php echo e(getPhrase('click_here_to_take_exam')); ?></a>
    </div> 

<?php endif; ?>


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
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="<?php echo e(URL_STUDENT_EXAM_ALL); ?>"><div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e(App\User::getUserSeleted('quizzes')); ?></h4>
            <a href="<?php echo e(URL_STUDENT_EXAM_ALL); ?>"><?php echo e(getPhrase('quizzes')); ?></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="<?php echo e(URL_STUDENT_EXAM_ALL); ?>"><div class="state-icn bg-icon-pink"><i class="fa fa-desktop"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e($examattend); ?></h4>
            <a href="<?php echo e(URL_STUDENT_EXAM_ALL); ?>"><?php echo e(getPhrase('exam_attended')); ?></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="<?php echo e(URL_STUDENT_LMS_CATEGORIES); ?>"><div class="state-icn bg-icon-purple"><i class="fa fa-tv"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e(App\User::getUserSeleted('lms_categories')>0?App\User::getUserSeleted('lms_categories')-1:0); ?></h4>
            <a href="<?php echo e(URL_STUDENT_LMS_CATEGORIES); ?>">LMS <?php echo e(getPhrase('categories')); ?></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href="<?php echo e(URL_SUBJECTS); ?>"><div class="state-icn bg-icon-success"><i class="fa fa-book"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e(App\Subject::get()->count()); ?></h4>
            <a href="<?php echo e(URL_SUBJECTS); ?>"><?php echo e(getPhrase('subjects')); ?></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e($tnps['per']); ?></h4>
            <a><?php echo e(getPhrase('average pass percentage')); ?></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="media state-media box-ws">
          <div class="media-left">
            <a href=""><div class="state-icn bg-icon-orange"><i class="fa fa-question-circle"></i></div></a>
          </div>
          <div class="media-body">
            <h4 class="card-title"><?php echo e(round($avgscore,2)); ?></h4>
            <a><?php echo e(getPhrase('average Score in All quizzes')); ?></a>
          </div>
        </div>
      </div>

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
 

<script>
  
window.onload =function() {

	  var exam_id        = $('#resume_exam_id').val();
	  exam_link          = $('#resume_exam_link').val();
	  series_exam_link   = $('#series_exam_link').val();
	  var series_slug    = $('#series_slug').val();
	  var pay_exam_slug  = $('#pay_exam_slug').val();

	  if ( series_exam_link ){
	      showInstructions(series_exam_link);
	  } 
	  else if (pay_exam_slug){
	    window.location.href = "<?php echo e(URL_PAYMENTS_CHECKOUT.'exam/'); ?>"+pay_exam_slug; 
	  }
	  else if(series_slug != 0){
	    window.location.href = "<?php echo e(URL_PAYMENTS_CHECKOUT.'combo/'); ?>"+series_slug; 
	  }
	 
	  else if(exam_id > 0){
	    showInstructions(exam_link);
	  }
}


function startMyExam(){
  showInstructions(exam_link);
}    

function startMySeriesExam(){
  showInstructions(series_exam_link);
}    



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
<?php echo $__env->make('layouts.student.studentlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>