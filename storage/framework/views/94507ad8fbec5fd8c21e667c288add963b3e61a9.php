<?php $contents = $series->getContents();
$active_class = '';
$active_class_id = 0;
$content_image_path = IMAGE_PATH_UPLOAD_LMS_DEFAULT;
if(isset($content) && $content)
{
   if(isset($content->id))
       $active_class_id = $content->id;
   if($content->image)
   $content_image_path = IMAGE_PATH_UPLOAD_LMS_CONTENTS.$content->image;

}

?>

<?php if($content): ?>
<div class="row">
   <div class="col-md-3"> <img src="<?php echo e($content_image_path); ?>" class="img-responsive center-block" alt=""> </div>
   <div class="col-md-8 col-md-offset-1">
       <div class="series-details">
           <h2><?php echo e($content->title); ?> </h2>

               <?php echo $content->description; ?>


       </div>
   </div>
</div>
<?php endif; ?>

<div class="clearfix">&nbsp;</div>
<ul class="lesson-list list-unstyled">
       <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

       <?php

           $active_class = '';
           if($active_class_id == $content->id)
               $active_class = ' active ';

           $url = '#';
           $type = 'File';

             $user = Auth::user();
            if($user->role_id == 6){

                 $children_ids  = App\User::where('parent_id',$user->id)->pluck('id')->toArray();

                 $is_paid  = [];
                 foreach ($children_ids as $key => $value) {

                    $is_paid[]  = App\Payment::isParentPurchased($item->id, 'lms', $value);
                 }
                 // dd($is_paid);
                 $paid_staus  = in_array('notpurchased', $is_paid);

                  $paid  = FALSE;
                 if($paid_staus)
                  $paid  = TRUE;

               }
               else{

                  $paid = ($item->is_paid && !isItemPurchased($item->id, 'lms')) ? TRUE : FALSE;
               }




           if($content->file_path) {
               switch($content->content_type)
               {
                   case 'file': $url = VALID_IS_PAID_TYPE.$series->slug.'/'.$content->slug;
                                $type = 'File';
                               break;
                   case 'image': $url = IMAGE_PATH_UPLOAD_LMS_CONTENTS.$content->slug;
                                   $type = 'Image';

                   case 'url': $url = $content->file_path;
                               $type = 'URL';
                               break;
                   case 'video_url':
                   case 'video':
                   case 'iframe':
                                   $url = URL_STUDENT_LMS_SERIES_VIEW.$series->slug.'/'.$content->slug;
                                   $type = 'Video';
                                   break;
                   case 'audio_url':
                   case 'audio':
                                   $url = URL_STUDENT_LMS_SERIES_VIEW.$series->slug.'/'.$content->slug;
                                   $type = 'Audio';
                                   break;
               }
           }


       ?>

        <?php if($paid) $url = '#'; ?>

       <li class="list-item <?php echo e($active_class); ?>">
       <?php if($content->content_type=='url'): ?>
       <a target="_blank" href="<?php echo e($url); ?>"
       <?php if($paid): ?>
           onclick="showMessage('Please buy this package to continue');"
       <?php endif; ?>
       ><?php echo e($content->title); ?>


       </a>
       <?php else: ?>
       <a href="<?php echo e($url); ?>"
       <?php if($paid): ?>
           onclick="showMessage('Please buy this package to continue');"
       <?php endif; ?>
       ><?php echo e($content->title); ?>


       </a>
       <?php endif; ?>
           <span class="buttons-right pull-right">
               <a href="javascript:void(0);"> <?php echo e($type); ?></a>

           </span> </li>
       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


   </ul>
