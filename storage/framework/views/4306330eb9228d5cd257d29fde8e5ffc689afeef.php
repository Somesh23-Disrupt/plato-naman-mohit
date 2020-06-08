 <?php echo $__env->make('system-emails.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
 <div class="row">
    <div class="col-lg-12" style="margin:65px 0px;">
    <h5 class="text-center" style="font-size:20px;font-weight:600;"><?php echo e(getPhrase('exam_result')); ?></h5>
  </div>
  </div>
   
   <div class="row">
    <div class="col-lg-12">
      <p style="font-size:20px;margin:11px 0;">Dear <?php echo e($username); ?>, </p>
      <p style="font-size:20px;margin:11px 0;">Greetings,</p>
  <p style="font-size:20px;margin:11px 0;">You are <?php echo e(ucfirst($staus)); ?>ed in <?php echo e($exam_name); ?> exam, conducted on <?php echo e($test_date); ?> and you got <?php echo e($percentage); ?>% percentage</p><br>
  
  

<p style="font-size:20px;margin:11px 0;">Sincerely, </p>
<p style="font-size:20px;margin:11px 0;">Customer Support Services</p>

  </div>
   </div>

<?php echo $__env->make('system-emails.disclaimer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


