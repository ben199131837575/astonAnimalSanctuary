<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Search Filter</div>
          <div class="panel-body">
            <div class="card-body bg-light">
              <form method="GET" action="<?php echo e(route('animalSearch')); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="form-group row">
                    <label for="keywords" class="col-sm-4 col-form-label text-md-right"><?php echo e(__('Search')); ?></label>
                    <div class="col-md-6">
                        <input id="keywords" type="text" class="form-control" name="keywords" value="" placeholder="text search">
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
                          <option value="dob_desc"><?php echo e(__('Age (descending)')); ?></option>
                          <option value="dob_asc"><?php echo e(__('Age (ascending)')); ?></option>
                          <option value="created_at"><?php echo e(__('Newest available animals')); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            <?php echo e(__('Search')); ?>

                        </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <?php $__currentLoopData = $animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $animal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="panel panel-default">
                <div class="panel-heading">picture</div>


                <ul class="list-group list-group-flush">
                  <li class="list-group-item " >
                    <p class="card-text"><?php echo e('Name: '); ?><?php echo e($animal->name); ?></p>
                  </li>
                 <li class="list-group-item ">
                   <p class="card-text"><?php echo e('Type: '); ?><?php echo e($animal->type); ?></p>
                 </li>
                 <li class="list-group-item ">
                   <p class="card-text"><?php echo e('Date of Birth:  '); ?><?php echo e($animal->dateofbirth); ?></p>
                 </li>
                 <li class="list-group-item " >
                   <p class="card-text"><?php echo e('Available for adoption? '); ?><?php echo e($animal->adopted == 0 ? 'Yes' : 'No'); ?></p>
                 </li>
               </ul>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>