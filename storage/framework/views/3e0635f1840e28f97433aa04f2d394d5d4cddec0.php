<?php $__env->startSection('content'); ?><div id="page-wrapper">
<div class="container-fluid">
<!-- Page Heading -->
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">
<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
<?php if(checkRole(getUserGrade(2))): ?>
<li><a href="<?php echo e(URL_USERS); ?>"><?php echo e(getPhrase('users')); ?></a> </li>
<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>
<?php else: ?>
<li class="active"><?php echo e($title); ?></li>
<?php endif; ?>
</ol>
</div>
</div>
<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- /.row -->

<div class="panel panel-custom col-lg-6  col-lg-offset-3">
<div class="panel-heading">
<?php if(checkRole(getUserGrade(2))): ?> 
<div class="pull-right messages-buttons"><a href="<?php echo e(URL_USERS); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a></div>
<?php endif; ?>
<h1><?php echo e($title); ?>  </h1>
</div>

<div class="panel-body form-auth-style">
<?php $button_name = getPhrase('create'); ?>
<?php if($record): ?>
<?php $button_name = getPhrase('update'); ?>
<?php echo e(Form::model($record, 
array('url' => URL_USERS_EDIT.$record->slug, 
'method'=>'patch','novalidate'=>'','name'=>'formUsers ', 'files'=>'true' ))); ?>

<?php else: ?>
<?php echo Form::open(array('url' => URL_USERS_ADD, 'method' => 'POST', 'novalidate'=>'','name'=>'formUsers ', 'files'=>'true')); ?>

<?php endif; ?>

<?php if((checkRole(getUserGrade(2)))): ?>
    <?php echo $__env->make('users.form_elements', array('button_name'=> $button_name, 'record' => $record, 'sections' => $sections), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('users.form_elements', array('button_name'=> $button_name, 'record' => $record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php echo Form::close(); ?>

</div>
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
<?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 <script>
 	var file = document.getElementById('image_input');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'jpg':
        case 'jpeg':
        case 'png':

     
            break;
        default:
               alertify.error("<?php echo e(getPhrase('file_type_not_allowed')); ?>");
            this.value='';
    }
};
 </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>