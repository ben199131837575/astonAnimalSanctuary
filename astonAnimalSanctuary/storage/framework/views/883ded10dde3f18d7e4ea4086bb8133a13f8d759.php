<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Adoption request buttons for filtering bewtween all, pending, accepeted, denied -->
            <?php if(Auth::user() && Auth::user()->staff && !$personal ): ?>
                <br>
                <div class="btn-group" role="group">
                    <a class="btn btn-primary" type="button" href="<?php echo e(route('adoptionRequests', 'all')); ?>">
                        All
                    </a>
                    <a class="btn btn-primary" type="button" href="<?php echo e(route('adoptionRequests', 'pending')); ?>">
                        Pending
                    </a>
                    <a class="btn btn-danger" type="button" href="<?php echo e(route('adoptionRequests', 'denied')); ?>">
                        Denied
                    </a>
                    <a class="btn btn-success" type="button" href="<?php echo e(route('adoptionRequests', 'accepted')); ?>">
                        Accepted
                    </a>
                </div>
            <?php endif; ?>
            <!-- End of Adoption request buttons -->

            <!-- Adoption Requests - listing -->
            <h3> <?php echo e(ucwords($type)); ?> Requests: </h3><br>
            <?php $__currentLoopData = $adoptionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adoptionRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($adoptionRequest->type == 'accepted'): ?>
                    <div class="panel panel-success">
                <?php elseif($adoptionRequest->type == 'denied'): ?>
                    <div class="panel panel-danger">
                <?php else: ?>
                    <div class="panel panel-primary">
                <?php endif; ?>
                <div class="panel-heading"><h4><strong>Adoption Request ID: [ <?php echo e($adoptionRequest->id); ?> ]</strong><h4></div>
                <div class="panel-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p class="panel-text"><strong>Reason for wanting to adopt animal:</strong><br><?php echo e($adoptionRequest->reason); ?></p>
                        </li>
                        <?php if($adoptionRequest->other_animals): ?>
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Other animals owned:</strong><br><?php echo e($adoptionRequest->other_animals); ?></p>
                            </li>
                        <?php endif; ?>
                        <li class="list-group-item">
                            <p class="panel-text"><strong>Request State:</strong><br><?php echo e($adoptionRequest->type); ?></p>
                        </li>

                        <br>

                        <!-- User information section of adoption requests -->
                        <?php if($users): ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($user->id == $adoptionRequest->userid): ?>
                                    <p class="panel-text"><strong>User ID: [ <?php echo e($user->id); ?> ]</strong></p>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Name: </strong><?php echo e($user->fname.' '.$user->lname); ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Email: </strong><?php echo e($user->email); ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Staff? </strong><?php echo e(($user->staff ? 'Yes' : 'No')); ?></p>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <!-- End of User information -->

                        <!-- Animal information section of adoption requests -->
                        <br>
                        <?php $__currentLoopData = $animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $animal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($animal->id == $adoptionRequest->animalid): ?>
                                <p class="panel-text"><strong>Animal ID: [ <?php echo e($animal->id); ?> ]</strong></p>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Name: </strong><?php echo e($animal->name); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Date of Birth: </strong><?php echo e($animal->dateofbirth); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Type: </strong><?php echo e($animal->type); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Gender: </strong><?php echo e($animal->gender); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <a class="btn btn-primary btn-lg btn-block" href="<?php echo e(route('animal',$adoptionRequest->animalid)); ?>">
                                        See more about <?php echo e($animal->name); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- End of Animal information -->

                        <!-- Button with link to the animal specific an adoption request -->
                        <?php if($adoptionRequest->userid != Auth::user()->id && Auth::user()->staff): ?>
                            <li class="list-group-item">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-success" type="button" href="<?php echo e(route('denyOrAccept', ['accept',$adoptionRequest->id])); ?>">
                                        Accept
                                    </a>
                                    <a class="btn btn-danger" type="button" href="<?php echo e(route('denyOrAccept','deny/'.$adoptionRequest->id)); ?>">
                                        Deny
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <br><br><br><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- End of Adoption Requests - listing -->

        </div>
    </div>
</div>

<?php if(!count($adoptionRequests)): ?>
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