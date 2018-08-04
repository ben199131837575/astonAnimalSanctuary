<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Animal
                </div>
                <div class="panel-body" >
                    <div class="card-body bg-light">

                        <!-- Form for adding new animals -->
                        <form method="POST" action="<?php echo e(route('addNewAnimal')); ?>" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Animal Name:')); ?></label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="name" required>
                                    <?php if($errors->has('name')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Animal Type')); ?></label>
                                <div class="col-md-6">
                                    <select id="type" name="type" class="form-control" required>
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
                                <label for="gender" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Gender')); ?></label>
                                <div class="col-md-6">
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" selected disabled hidden><?php echo e(''); ?></option>
                                        <option value="male"><?php echo e(__('Male')); ?></option>
                                        <option value="female"><?php echo e(__('Female')); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dateofbirth" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Date of Birth:')); ?></label>
                                <div class="col-md-6">
                                    <input id="dateofbirth" type="date" class="form-control" name="dateofbirth" value="<?php echo e(old('dateofbirth')); ?>" placeholder="dateofbirth" required>
                                </div>
                                <?php if($errors->has('dateofbirth')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('dateofbirth')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Animal Description:')); ?></label>
                                <div class="col-md-6">
                                    <textarea id="description" type="date" class="form-control" name="description" value="<?php echo e(old('description')); ?>" placeholder="description" required></textarea>
                                    <?php if($errors->has('description')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('description')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image_upload" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Select Images to upload:')); ?></label>
                                <div class="col-md-6">
                                    <input id="image_upload" type="file" name="image_upload[]" accept="image/*" multiple required>
                                    <?php if($errors->has('image_upload')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('image_upload')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Add Animal')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End of new animal form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>