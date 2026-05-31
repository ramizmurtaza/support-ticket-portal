<?php $__env->startSection('title', 'All Tickets'); ?>
<?php $__env->startSection('page-title', 'All Tickets'); ?>

<?php $__env->startSection('content'); ?>


<form method="GET" action="<?php echo e(route('admin.tickets.index')); ?>" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
        <select name="system_id" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Systems</option>
            <?php $__currentLoopData = $systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $system): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($system->system_id); ?>" <?php echo e(request('system_id') === $system->system_id ? 'selected' : ''); ?>>
                    <?php echo e($system->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="status" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Statuses</option>
            <?php $__currentLoopData = ['open', 'in_progress', 'waiting_client', 'resolved', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst(str_replace('_', ' ', $s))); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="priority" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Priorities</option>
            <?php $__currentLoopData = ['low', 'medium', 'high', 'critical']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p); ?>" <?php echo e(request('priority') === $p ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($p)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="type" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Types</option>
            <?php $__currentLoopData = ['bug', 'support', 'feature']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t); ?>" <?php echo e(request('type') === $t ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($t)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
               placeholder="Search title, ref, email..."
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:col-span-2 lg:col-span-1">

        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Apply
            </button>
            <a href="<?php echo e(route('admin.tickets.index')); ?>" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                Reset
            </a>
        </div>
    </div>
</form>


<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ref</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">System</th>
                <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Priority</th>
                <th class="hidden xl:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                <th class="hidden xl:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                    onclick="window.location='<?php echo e(route('admin.tickets.show', $ticket->id)); ?>'">
                    <td class="px-4 py-3">
                        <span class="font-mono text-xs text-gray-500"><?php echo e($ticket->reference_no); ?></span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm font-medium text-gray-900"><?php echo e(Str::limit($ticket->title, 50)); ?></span>
                    </td>
                    <td class="hidden md:table-cell px-4 py-3">
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">
                            <?php echo e($ticket->system?->name ?? $ticket->system_id); ?>

                        </span>
                    </td>
                    <td class="hidden lg:table-cell px-4 py-3">
                        <span class="text-xs text-gray-600"><?php echo e(ucfirst($ticket->type)); ?></span>
                    </td>
                    <td class="px-4 py-3">
                        <?php echo $__env->make('admin.partials.status-badge', ['status' => $ticket->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </td>
                    <td class="hidden lg:table-cell px-4 py-3">
                        <?php echo $__env->make('admin.partials.priority-badge', ['priority' => $ticket->priority], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </td>
                    <td class="hidden xl:table-cell px-4 py-3">
                        <span class="text-xs text-gray-500"><?php echo e($ticket->client_email); ?></span>
                    </td>
                    <td class="hidden xl:table-cell px-4 py-3">
                        <span class="text-xs text-gray-400"><?php echo e($ticket->created_at->format('M d, Y')); ?></span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="<?php echo e(route('admin.tickets.show', $ticket->id)); ?>"
                           onclick="event.stopPropagation()"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-sm text-gray-400">No tickets found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($tickets->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-100">
            <?php echo e($tickets->withQueryString()->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ramizmurtaza/development/support/support-ticket-portal/resources/views/admin/tickets/index.blade.php ENDPATH**/ ?>