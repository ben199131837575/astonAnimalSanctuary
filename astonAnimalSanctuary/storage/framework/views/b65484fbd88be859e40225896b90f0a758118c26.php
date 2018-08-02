<?php $__env->startSection('content'); ?>

<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <!-- User information panel -->
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>User ID: [ <?php echo e($user->id); ?> ]</strong></div>
                    <div class="panel-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Name:</strong><?php echo e($user->fname.' '.$user->lname); ?></p>
                            </li>
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Email:</strong><?php echo e($user->email); ?></p>
                            </li>
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Staff?</strong><?php echo e(($user->staff ? 'Yes' : 'No')); ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End of user information panel -->
                
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(!count($users)): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">No results found!</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>