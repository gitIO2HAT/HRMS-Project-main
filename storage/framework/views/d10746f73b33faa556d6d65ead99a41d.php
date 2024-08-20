<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-white text-center rounded-3  p-4">
                        <?php
                        $counter = 1;
                        $counters = 1;
                        ?>
                        <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="col-12">
                            <div class="bg-white rounded h-100 p-4">
                                <h5 class="text-dark">Announcement Board</h5>
                                <div class="d-flex justify-content-end align-items-end">
                                    <div>
                                        <a class="m-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <i class="fas fa-plus" style="color: #1c9445;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Start</th>
                                                <th scope="col">End</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $getAnn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announce): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th class="border-bottom border-white" scope="row"><?php echo e($counter++); ?></th>
                                                <td class="border-bottom border-white"><?php echo e($announce->title); ?></td>
                                                <td class="border-bottom border-white"><?php echo e(date('Y, M d - h:i A',
                                                    strtotime($announce->scheduled_date))); ?></td>
                                                <td class="border-bottom border-white"><?php echo e(date('Y, M d - h:i A',
                                                    strtotime($announce->scheduled_end))); ?></td>
                                                <td class="border-bottom border-white">
                                                    <?php if($announce->scheduled_date > $currentDateTime): ?>
                                                    <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-warning"></i> Ongoing</span>

                                                    <?php elseif($announce->scheduled_date <= $currentDateTime && $announce->scheduled_end >= $currentDateTime): ?>
                                                    <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-danger"></i> In Progress</span>
                                                        <?php endif; ?>
                                                </td>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                    <?php echo e($getAnn->onEachSide(1)->links()); ?>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-white text-center rounded-3  p-4">

                        <div class="col-12">
                            <div class="bg-white rounded h-100 p-4">
                                <h5 class="text-dark">Announcement Board Completed</h5>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Scheduled Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $getCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announce): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th class="border-bottom border-white" scope="row"><?php echo e($counters++); ?>

                                                </th>
                                                <td class="border-bottom border-white"><?php echo e($announce->title); ?></td>
                                                <td class="border-bottom border-white"><?php echo e(date('Y, M d - h:i A',
                                                    strtotime($announce->scheduled_date))); ?></td>
                                                <td class="border-bottom border-white">
                                                    <?php if($announce->scheduled_end < $currentDateTime): ?>
                                                    <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-success"></i> Completed</span>
                                                     <?php endif; ?> </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <?php echo e($getCompleted->onEachSide(1)->links()); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="row g-4">
                                <div class=" pt-4 px-4 ">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-xl-12 rounded">
                                            <div class="bg-white rounded-2 p-4">
                                                <form action="" method="post" class="form-container">
                                                    <?php echo csrf_field(); ?>
                                                    <div class=" row g-4">
                                                        <div class="modal-content text-end">


                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="col-sm-8 col-xl-8 modal-content">

                                                            <h2 class="text-start  p-2 text-dark border-bottom border-success">
                                                                Create
                                                                Announcement</h2>
                                                            <div class="form-group">
                                                                <label class="text-dark" for="title">Title</label>
                                                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                                                                <label class="text-dark" for="scheduled_date">Start</label>
                                                                <input type="datetime-local" name="scheduled_date" class="form-control" id="scheduled_date">

                                                                <label class="text-dark" for="scheduled_end">End</label>
                                                                <input type="datetime-local" name="scheduled_end" class="form-control" id="scheduled_end" min="" onchange="setMinEndTime()">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="text-dark" for="description">Description</label>
                                                                <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Enter Description"></textarea>
                                                                <button type="submit" class="btn btn-success btn-block save_btn mt-1">Send</button>
                                                            </div>
                                                        </div>
                                                        <div class="modal-content col-sm-4 col-xl-4 border-start border-light">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Employees</th>
                                                                        <!-- Add more table headers if needed -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="">
                                                                                <img class="rounded-circle me-lg-2" src="<?php echo e(asset('public/accountprofile/' . $user->profile_pic)); ?>" alt="" style="width: 40px; height: 40px;">
                                                                                <input type="checkbox" name="selected_users[]" value="<?php echo e($user->id); ?>" class="form-check-input" style="display: none;">
                                                                            </div>
                                                                        </td>
                                                                        <td><?php echo e($user->name); ?> <?php echo e($user->lastname); ?></td>
                                                                        <!-- Add more table cells for other user attributes if needed -->
                                                                    </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('javascript'); ?>
<script>
    $(document).ready(function() {
        var pusher = new Pusher('686df23863c2ae8a4b8', {
            cluster: 'clust'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            let pending = parseInt($('#' + data.from).html());
            if (!isNaN(pending)) {
                $('#' + data.from).html(data.pending);
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/superadmin/announcement/announcement.blade.php ENDPATH**/ ?>