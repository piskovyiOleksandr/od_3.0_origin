<?php

//print_r($big_cities ?? '');
//echo $_SESSION['big-city'];

?>

<!DOCTYPE html>

<html lang="en">

<head>
	<?php echo $__env->make('layout-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="">
	<div class="header-open-close"><div class="icons menu-icon"></div></div>

	<?php echo $__env->make('layout-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->yieldContent('content'); ?>

	<?php echo $__env->make('layout-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

<script src="<?php echo e(asset('/public/js/jquery.3.6.0.js')); ?>" type="text/javascript" defer></script>
<script src="<?php echo e(asset('/public/js/libs.js')); ?>" type="text/javascript" defer></script>
<script src="<?php echo e(asset('/public/js/app.js')); ?>" type="text/javascript" defer></script>
<script src="https://assets.topsrcs.com/js/script_tpsrcuid.js" type="text/javascript" defer></script>


<?php echo $__env->yieldContent('script'); ?>

</html><?php /**PATH /home/alexandr/web/od-dev.topsrcs.com/public_html/resources/views/layout.blade.php ENDPATH**/ ?>