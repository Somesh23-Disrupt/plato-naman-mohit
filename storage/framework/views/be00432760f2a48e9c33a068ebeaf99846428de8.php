 <?php  $contents = $series->itemsList();   ?>
 <ul class="lesson-list list-unstyled clearfix">
        <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
        <?php 
            $url = URL_STUDENT_TAKE_EXAM.$content->slug;
            $paid = ($item->is_paid && !isItemPurchased($item->id, 'combo')) ? TRUE : FALSE;
        ?>
             <?php $role = getRoleData(Auth::user()->role_id); ?>
         <?php if($paid) $url = '#'; ?>
        <li class="list-item">
        <a 

        href="javascript:void(0);" 
        <?php if($paid): ?>
            onclick="showMessage('Please buy this package to continue');" 
        <?php else: ?>
           <?php if($role=='student'): ?>
            onclick="showInstructions('<?php echo e($url); ?>');" 
           <?php endif; ?>
        <?php endif; ?>
        >
        <?php echo e($content->title); ?>   
        </a>  
            <span class="buttons-right pull-right">
       
                <?php if($role!='parent'): ?>

                <a  
                href="javascript:void(0);" 
                 <?php if($paid): ?>
                    onclick="showMessage('Please buy this package to continue');" 
                <?php else: ?>

                    onclick="showInstructions('<?php echo e($url); ?>');" 
                <?php endif; ?>
                > 
                <?php echo e(getPhrase('take_exam')); ?>

                </a>
                <?php else: ?>
                <a 
                <?php if($role!='parent'): ?>
                href="<?php echo e($url); ?>"
                <?php endif; ?>
                > <?php echo e($content->dueration); ?> <?php echo e(getPhrase('minutes')); ?></a>
                <?php endif; ?>

             

            </span> </li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul>