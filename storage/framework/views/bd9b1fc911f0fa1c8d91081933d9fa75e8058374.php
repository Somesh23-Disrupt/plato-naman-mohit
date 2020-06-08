                       <?php    

                                    $image_path = PREFIX.(new App\ImageSettings())->

                                    getExamImagePath(); 



                                    ?>


                    <div class="questions questions-withno">

                            <span class="question-numbers">Q <?php echo e($question_number); ?>.</span>

                               <span class="language_l1">
                                

                                <?php echo $question->question; ?> 

                                  </span>
                               <?php if($question->question): ?>
                                    <span class="language_l2" style="display: none;"><?php echo $question->question_l2; ?>   </span> <br>
                                    <?php else: ?>
                                    <span class="language_l2" style="display: none;"><?php echo $question->question; ?>   </span> <br>
                                    <?php endif; ?>

  <div class="col-md-8 text-center">
  <?php if($question->question_type!='audio' && $question->question_type !='video'): ?>
  <?php if($question->question_file): ?>
  <img class="image " src="<?php echo e($image_path.$question->question_file); ?>" style="max-height:200px;">
  <?php endif; ?>
  <?php endif; ?>
  </div>

                            <small class="pull-right">

                                <strong><?php echo e(getPhrase('subject')); ?>:</strong> 

                                <?php echo e($subject->subject_title); ?>


                            </small>

                        </div>

                    <?php 
                    $meta = (object)$meta;
                   $question = $meta->question;
                    $time_spent = $meta->time_spent;

                    $timing_lable = 'label label-danger';
                    

                    if($question->time_to_spend > $time_spent->time_spent)

                    {

                        $timing_lable = 'label label-info';

                    }



                    ?>

                        <div class="answer-status-container">

                        <div class="row">

                            <div class="col-md-3">

                                <div class="question-status">

                                    <strong><?php echo e(getPhrase('time_limit')); ?>: </strong>

                                    <?php echo e(gmdate("H:i:s", $question->time_to_spend)); ?> 

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="question-status">

                                    <strong><?php echo e(getPhrase('time_taken')); ?>: </strong>

                                    <span class="<?php echo e($timing_lable); ?>"> <?php echo e(gmdate("H:i:s", $time_spent->time_spent)); ?> </span>

                                     

                                </div>

                            </div>

                       

                            

                        </div>

                        </div>

                        <hr>