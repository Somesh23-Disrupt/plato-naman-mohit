<?php if($quiz->has_language): ?> 

         <?php $l = $quiz->language(); ?>
         <?php if($l): ?>
           <span>
            
            <select 
                  id="selected_language" 
                  onchange="languageChanged(this.value)" 
                  class="form-control st-selection">
              <option value="language_l1">English</option>
              
             <option value="language_l2"><?php echo e($quiz->language_name); ?></option>

            </select>
           </span>
          <?php endif; ?>
          
      <?php endif; ?>
     