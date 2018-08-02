<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id=search_filter>

                <!-- Adoption Request Form -->
                <div class="panel-heading">Adoption Request</div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route('postAdoptionRequest')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group row">
                            <label for="reason" class="col-sm-8 col-form-label text-md-right">
                                <?php echo e(__('Briefly describe your reason for wanting to adopt this animal:')); ?>

                            </label>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <textarea id="reason" type="text" class="form-control" name="reason" required>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="other_animals" class="col-sm-8 col-form-label text-md-right">
                                        <?php echo e(__('Do you own any other animals? If so, what animals do you own?:')); ?>

                            </label>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <textarea id="other_animals" type="text" class="resize form-control" name="other_animals">
                                </textarea>
                            </div>
                        </div>

                        <input type="text" name="animalid" value="<?php echo e($animalid); ?>" hidden>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                <?php echo e(__('Post Request')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of Adoption Request Form --> 
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>