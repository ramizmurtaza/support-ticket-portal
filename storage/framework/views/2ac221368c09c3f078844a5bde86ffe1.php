<?php $__env->startSection('title', 'Systems'); ?>
<?php $__env->startSection('page-title', 'Systems'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">Manage connected systems and their API keys.</p>
    <a href="<?php echo e(route('admin.systems.create')); ?>"
       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        + Add System
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">System ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">API Key</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $system): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($system->name); ?></td>
                    <td class="px-6 py-4">
                        <code class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded"><?php echo e($system->system_id); ?></code>
                    </td>
                    <td class="px-6 py-4">
                        <code class="text-xs text-gray-500 font-mono">****<?php echo e(substr($system->api_key, -4)); ?></code>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($system->is_active): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-400"><?php echo e($system->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="<?php echo e(route('admin.systems.edit', $system->id)); ?>"
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium">Edit</a>

                            <form method="POST" action="<?php echo e(route('admin.systems.regenerate', $system->id)); ?>"
                                  onsubmit="return confirm('Regenerate API key for <?php echo e($system->name); ?>? The old key will stop working immediately.')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                                    Regen Key
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No systems registered yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($systems->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-100">
            <?php echo e($systems->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ramizmurtaza/development/support/support-ticket-portal/resources/views/admin/systems/index.blade.php ENDPATH**/ ?>