<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel <?php echo e($message['panelColour']); ?>">
                <div class="panel-heading">
                    <h4><?php echo e($message['heading']); ?></h4>
                </div>
                <div class="panel-body">
                    <?php echo e($message['body']); ?>

                    <?php if($message['button']): ?>
                        <a class="btn <?php echo e($message['buttonColour']); ?> btn-lg btn-block" href="<?php echo e($message['buttonLink']); ?>">
                            <?php echo e($message['buttonText']); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>