<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Detailed information panel on a specific animal -->
            <div class="panel panel-info">
                <div class="panel-heading"><strong><h3><?php echo e($animal->name); ?></h3></strong></div>
                <div class="panel-body">
                    <p class="panel-text"><h4>Info:</h4></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p class="panel-text">Type: <?php echo e($animal->type); ?></p>
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Gender: <?php echo e($animal->gender); ?></p>
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Date of Birth: <?php echo e($animal->dateofbirth); ?></p>
                        </li>
                        <li class="list-group-item">
                            <?php if(!$animal->adopted): ?>
                                <p class="panel-text"><?php echo e($animal->name.' is available for adoption :D'); ?></p>
                            <?php else: ?>
                                <p class="panel-text"><?php echo e('Adopted by '); ?> <a href="<?php echo e(route('user',$user->id)); ?>"> <u><?php echo e($user->fname.' '.$user->lname); ?></u></a></p>
                            <?php endif; ?>
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Description: <br><?php echo e($animal->description); ?></p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- If the animal is not adopted a button linking a user to an adoption form -->
            <?php if($animal->adopted == 0): ?>
                <div class="panel panel-info">
                    <div class="panel-heading"> Would you like to adopt <?php echo e($animal->name); ?>?</div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="<?php echo e(URL::to('/').'/adoptionRequestForm/'.$animal->id); ?>">
                            Click here to fill out an adoption form for <?php echo e($animal->name); ?>!
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- All the images for the animal displayed here -->
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <img class="img-responsive img-rounded" src="<?php echo e('data:image/*;base64,'.$image->image); ?>" >
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- If the animal is not adopted a button linking a user to an adoption form -->
            <?php if($animal->adopted == 0 && count($images) > 1): ?>
                <div class="panel panel-info">
                    <div class="panel-heading"> Would you like to adopt <?php echo e($animal->name); ?>?</div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="<?php echo e(URL::to('/').'/adoptionRequestForm/'.$animal->id); ?>">
                            Click here to fill out an adoption form for <?php echo e($animal->name); ?>!
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>