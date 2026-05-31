<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Open Tickets</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1"><?php echo e($open); ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">In Progress</p>
        <p class="text-3xl font-bold text-blue-600 mt-1"><?php echo e($inProgress); ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Resolved Today</p>
        <p class="text-3xl font-bold text-green-600 mt-1"><?php echo e($resolvedToday); ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Waiting Client</p>
        <p class="text-3xl font-bold text-gray-600 mt-1"><?php echo e($waiting); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Tickets by System</h3>
        <?php $__empty_1 = true; $__currentLoopData = $bySsystem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $system): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $pct = $system->tickets_count > 0 ? min(100, $system->tickets_count) : 0; ?>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-700"><?php echo e($system->name); ?></span>
                    <span class="text-sm text-gray-500"><?php echo e($system->tickets_count); ?></span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($pct); ?>%"></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-400">No systems yet.</p>
        <?php endif; ?>
    </div>

    
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-800">Recent Tickets</h3>
        </div>
        <div class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.tickets.show', $ticket->id)); ?>"
                   class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="font-mono text-xs text-gray-400 flex-shrink-0"><?php echo e($ticket->reference_no); ?></span>
                        <span class="text-sm font-medium text-gray-800 truncate"><?php echo e($ticket->title); ?></span>
                        <?php if($ticket->system): ?>
                            <span class="hidden sm:inline text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded flex-shrink-0"><?php echo e($ticket->system->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                        <?php echo $__env->make('admin.partials.status-badge', ['status' => $ticket->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <span class="hidden sm:inline text-xs text-gray-400"><?php echo e($ticket->created_at->diffForHumans()); ?></span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-8 text-center text-sm text-gray-400">No tickets yet.</div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ramizmurtaza/development/support/support-ticket-portal/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>