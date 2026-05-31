<?php $__env->startSection('title', 'Add System'); ?>
<?php $__env->startSection('page-title', 'Add New System'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="<?php echo e(route('admin.systems.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">System Name</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="e.g. Evexia HIS">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-6">
                <label for="system_id" class="block text-sm font-medium text-gray-700 mb-1">
                    System ID <span class="text-gray-400 font-normal">(slug format, e.g. evexia-his)</span>
                </label>
                <input type="text" id="system_id" name="system_id" value="<?php echo e(old('system_id')); ?>" required
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono <?php $__errorArgs = ['system_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="evexia-his"
                       pattern="[a-z0-9_-]+"
                       title="Lowercase letters, numbers, hyphens and underscores only">
                <?php $__errorArgs = ['system_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-xs text-gray-400 mt-1">Lowercase letters, numbers, hyphens and underscores only. Cannot be changed later.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Create System
                </button>
                <a href="<?php echo e(route('admin.systems.index')); ?>"
                   class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ramizmurtaza/development/support/support-ticket-portal/resources/views/admin/systems/create.blade.php ENDPATH**/ ?>