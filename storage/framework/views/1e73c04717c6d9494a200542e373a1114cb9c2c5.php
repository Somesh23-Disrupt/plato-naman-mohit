 				
		 	<div class="panel-heading countdount-heading">
					<h2><?php echo e(getPhrase('it_includes').' '.$item->total_exams.' '.getPhrase('exams')); ?></h2>
				</div>
				<?php 
					$items_list = $item->itemsList();
				?>				
				<div class="panel-body">
					<ul class="offer-list">
					<?php $__currentLoopData = $items_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quizitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li>
						<i class="mdi mdi-star-circle"></i><h4><?php echo e($quizitem->title); ?></h4>
						<p><?php echo e($quizitem->total_questions.' '.getPhrase('questions')); ?>  </p>
						
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>