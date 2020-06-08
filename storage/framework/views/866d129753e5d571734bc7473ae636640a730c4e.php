 
<?php 

	$video_src = $content->file_path;

	if($content->content_type=='video')

    $video_src = IMAGE_PATH_UPLOAD_LMS_CONTENTS.$content->file_path;

?>

<div class="series-video text-center">

<?php if($content->content_type=='video' || $content->content_type=='video_url' || $content->content_type=='audio'): ?>

 

     <video id="my-video" class="video-js vjs-big-play-centered" autoplay controls preload="auto" width="300" height="264"

          poster="" data-setup='{"aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>

            <source src="<?php echo e($video_src); ?>" type='video/mp4'>

            

            <p class="vjs-no-js">

              To view this video please enable JavaScript, and consider upgrading to a web browser that

              <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>

            </p>

    </video>

<?php elseif($content->content_type=='iframe'): ?>

   <?php if(preg_match('/iframe/',$video_src)): ?>

      <?php echo $video_src; ?>

   <?php else: ?> 

      <iframe width="100%" height="560" src="<?php echo e($video_src); ?>" frameborder="0" allowfullscreen>
      </iframe>

   <?php endif; ?>



<?php endif; ?>



</div>

                            

 