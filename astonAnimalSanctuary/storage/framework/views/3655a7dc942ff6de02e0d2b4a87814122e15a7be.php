<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Button for collapsing and expanding search filter form -->
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#search_filter" aria-expanded="false" aria-controls="search_filter">
                Search Filter <span class="caret"></span>
            </button><br><br>

            <div class="panel panel-default accordion-body <?php echo e(($errors->isEmpty() ? 'collapse' : '')); ?>" id=search_filter>
                <div class="panel-body" >
                    <div class="card-body bg-light">

                        <!-- Search Filter form -->
                        <form method="GET" action="<?php echo e(route('animalSearch')); ?>">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group row">
                                <label for="keywords" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Search')); ?></label>
                                <div class="col-md-6">
                                    <input id="keywords" type="text" class="form-control" value="<?php echo e(old('keywords')); ?>" name="keywords" value="" placeholder="text search">
                                    <?php if($errors->has('keywords')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('keywords')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Animal Type')); ?></label>
                                <div class="col-md-6">
                                    <select id="type" name="type" class="form-control">
                                        <option value="" selected disabled hidden><?php echo e(''); ?></option>
                                        <option value="dog"><?php echo e(__('Dog')); ?></option>
                                        <option value="cat"><?php echo e(__('Cat')); ?></option>
                                        <option value="aquatic"><?php echo e(__('Aquatic')); ?></option>
                                        <option value="reptile"><?php echo e(__('Reptile')); ?></option>
                                        <option value="bird"><?php echo e(__('Bird')); ?></option>
                                        <option value="other"><?php echo e(__('Other')); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="orderby" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Order By')); ?></label>
                                <div class="col-md-6">
                                    <select id="orderby" name="orderby" class="form-control">
                                        <option value="" selected disabled hidden><?php echo e(''); ?></option>
                                        <optgroup label="Animal Age">
                                            <option value="age_asc"><?php echo e(__('Youngest to Oldest')); ?></option>
                                            <option value="age_desc"><?php echo e(__('Oldest to Youngest')); ?></option>
                                        </optgroup>
                                        <optgroup label="Time posted">
                                            <option value="newest"><?php echo e(__('Recent')); ?></option>
                                            <option value="oldest"><?php echo e(__('Old')); ?></option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <!-- Toggles for staff to give them the abilty to see adopted animals,
                             that would, otherwise, be hidden -->
                            <?php if(Auth::user() && Auth::user()->staff): ?>
                                <div class="form-group row">
                                    <label for="show_adopted" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Include Adopted')); ?></label>
                                    <div class="col-md-6">
                                        <input type="radio" id="show_adopted" name="adoption" value="show_adopted">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="only_show_adopted" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Only Include Adopted')); ?></label>
                                    <div class="col-md-6">
                                        <input type="radio" id="only_show_adopted" name="adoption" value="only_show_adopted">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Search')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End of Search filter form -->

                    </div>
                </div>
            </div>

            <!-- Simple animal information - contained in link to point to more info -->
            <?php $__currentLoopData = $animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $animal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a name="anchor<?php echo e($animal->id); ?>" href="<?php echo e(URL::to('/')); ?>/animal/<?php echo e($animal->id); ?>" style="text-decoration:none !important; color: black; text-decoration:none;">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <!-- Finds images relating to specific animal -->
                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($animal->id == $image->animalid): ?>
                                    <li class="list-group-item">
                                        <img class="img-responsive img-rounded" src="<?php echo e('data:image/*;base64,'.$image->image); ?>">
                                    </li>
                                <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item " >
                                    <p class="panel-text"><?php echo e('Name: '); ?><?php echo e($animal->name); ?></p>
                                </li>
                                <li class="list-group-item ">
                                    <p class="panel-text"><?php echo e('Type: '); ?><?php echo e($animal->type); ?></p>
                                </li>
                                <li class="list-group-item ">
                                    <p class="panel-text"><?php echo e('Date of Birth:  '); ?><?php echo e($animal->dateofbirth); ?></p>
                                </li>

                                <!-- If animal is adopted the name of the user who adopted this animal is displayed -->
                                <li class="list-group-item ">
                                    <?php if(!$animal->adopted): ?>
                                        <p class="panel-text"><?php echo e($animal->name.' is available for adoption :D'); ?></p>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($user->id == $animal->userid): ?>
                                                <p class="panel-text"><?php echo e('Adopted by '); ?> <?php echo e($user->fname.' '.$user->lname); ?></p>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- End of animal information -->

        </div>
    </div>
</div>

<?php if(!count($animals)): ?>
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