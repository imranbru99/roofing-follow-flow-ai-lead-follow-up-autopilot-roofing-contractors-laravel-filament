<?php $__env->startSection('title', 'Features & Modules — RoofingFollowFlow'); ?>
<?php $__env->startSection('meta_description', 'Toggleable modules for lead follow-up, consent, escalations, technicians, job tickets, AI hub, attendance, PDF, integrations.'); ?>

<?php $__env->startSection('content'); ?>
<section class="wrap section" style="padding-top:3rem;">
    <div class="eyebrow">Everything included</div>
    <h1 style="max-width:20ch;">Features & modular capabilities</h1>
    <p class="lede">RoofingFollowFlow ships with every relevant module. Core sales and field modules start ON; niche integrations can stay OFF until your contractor enables them.</p>
</section>

<section class="wrap section">
    <div class="grid">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <span class="pill <?php echo e($module['enabled'] ? 'on' : 'off'); ?>"><?php echo e($module['enabled'] ? 'ON' : 'OFF'); ?><?php echo e($module['core'] ? ' · CORE' : ''); ?></span>
                <h3><?php echo e($module['label']); ?></h3>
                <p><?php echo e($module['description']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>

<section class="wrap section">
    <h2>Integrations roadmap</h2>
    <div class="grid" style="margin-top:1rem;">
        <div class="card"><h3>Jobber</h3><p>Sync clients and jobs when the Jobber module is enabled.</p></div>
        <div class="card"><h3>ServiceTitan</h3><p>Pull schedules and push tickets for larger shops.</p></div>
        <div class="card"><h3>QuickBooks</h3><p>Connect estimate-to-invoice handoff for finance.</p></div>
        <div class="card"><h3>Google Calendar</h3><p>Book estimate windows directly for owners/staff.</p></div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/public/features.blade.php ENDPATH**/ ?>