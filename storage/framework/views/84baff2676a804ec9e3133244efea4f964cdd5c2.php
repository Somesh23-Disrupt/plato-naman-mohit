<?php
 
    $answers = json_decode($question->answers);

    $i=1;
   
 ?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 select-answer select-option">

    <div style="margin-left: 15px;color:black;">
        <p><span class="language_l1" ><?php echo $question->second_question; ?></span></p>
         <?php if($question->right_question_file): ?>
            <img src="<?php echo e($image_path.$question->right_question_file); ?>" >
            <?php endif; ?>
      </div>

    <ul class="row list-style-none">
    
     <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <?php if(isset($answer->option_value)): ?>
       <li class="col-md-12">
       <?php $rand_no = mt_rand(1,1000000); ?>
            <input  id="<?php echo e($answer->option_value); ?>_<?php echo e($rand_no); ?>" value="<?php echo e($i++); ?>" name="<?php echo e($question->id); ?>[]" type="checkbox" style="display: inline; margin-right: 12px;">
           
                <label for="<?php echo e($answer->option_value); ?>_<?php echo e($rand_no); ?>">
                   
                     <span class="language_l1"><?php echo $answer->option_value; ?></span>
                     <?php if(isset($answer->optionl2_value)): ?>
                <span class="language_l2" style="display: none;"><?php echo $answer->optionl2_value; ?></span>
                 <?php else: ?>
                <span class="language_l2" style="display: none;"><?php echo $answer->option_value; ?></span>
                <?php endif; ?>
                </label>
            </input>
             <?php if($answer->has_file): ?>
            <img src="<?php echo e($image_path.$answer->file_name); ?>" >
            <?php endif; ?>
        </li>  
        <?php endif; ?>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    

      

    </ul>
      
</div>
