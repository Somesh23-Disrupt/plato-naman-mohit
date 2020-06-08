
                   
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <ul class="optional-questions ">
                                        <?php 
                                        $options = json_decode($question->answers); 
                                        $correct_answers = $question->correct_answers;
                                        $index = 1;
                                      
                                        foreach ($options as $option) {
                                            $correct_answer_class = '';
                                           
                                            if($correct_answers == $index) {
                                                $correct_answer_class = 'correct-answer';
                                            }

                                            $submitted_value = '';
                                            
                                                 if($user_answers && count($user_answers))  {
                                                    
                                                    if($user_answers[0] == $index)
                                                        $submitted_value = 'checked';
                                                }
                                            
                                           
                                        ?>
                                        <li class="col-md-6 <?php echo e($correct_answer_class); ?> answer_radio">
                                            <input type="radio" name="option" id="radio1" disabled <?php echo e($submitted_value); ?>>
                                            <label for="radio1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> 
                                                <span class="language_l1"><?php echo $option->option_value; ?></span>
                                                 <?php if(isset($option->optionl2_value)): ?>
                                                <span class="language_l2" style="display: none;"><?php echo $option->optionl2_value; ?></span>
                                                <?php else: ?>

                                                 <span class="language_l2" style="display: none;"><?php echo $option->option_value; ?></span>

                                                <?php endif; ?>
                                                 </label>
                                        </li>
                                         <?php  $index++;
                                                } ?>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    