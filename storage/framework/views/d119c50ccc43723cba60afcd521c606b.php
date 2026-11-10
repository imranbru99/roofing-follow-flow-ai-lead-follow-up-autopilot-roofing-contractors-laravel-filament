<?php $__env->startSection('title', 'RoofingFollowFlow — AI Lead Follow-Up Autopilot for Roofing Contractors'); ?>
<?php $__env->startSection('meta_description', 'Generate and send consent-aware follow-ups, escalate qualified replies, and run service requests, technicians, and job tickets.'); ?>

<?php $__env->startSection('content'); ?>
<section class="wrap hero">
    <div>
        <div class="eyebrow">Roofing Contractors · Sales Ops</div>
        <h1>RoofingFollowFlow</h1>
        <p class="lede">Consent-aware AI follow-up autopilot for roofing contractors. Intake leads, draft messages, require human approval, escalate hot replies, and keep every action in an audit log.</p>
        <div class="cta-row">
            <a class="btn btn-primary" href="/admin">Open Admin Panel</a>
            <a class="btn btn-secondary" href="<?php echo e(route('features')); ?>">Explore Modules</a>
        </div>
    </div>
    <div class="panel">
        <h3>MVP Autopilot Loop</h3>
        <ul>
            <li>1) Intake trigger from service request or web lead</li>
            <li>2) AI drafts consent-aware follow-up</li>
            <li>3) Human approval gate</li>
            <li>4) Send + immutable audit log</li>
            <li>5) Hot replies escalate to staff</li>
        </ul>
    </div>
</section>

<section class="wrap section">
    <h2>Built for field-service roofing sales</h2>
    <p class="lede">Operate on service requests, licensed technicians, and job tickets while messaging stays compliance-aware.</p>
    <div class="grid" style="margin-top:1.2rem;">
        <div class="card"><h3>Consent locks</h3><p>No SMS/email send without active consent evidence.</p></div>
        <div class="card"><h3>Human-in-the-loop</h3><p>AI drafts; owners/staff approve before send.</p></div>
        <div class="card"><h3>Field sync</h3><p>Tickets and technicians stay connected to hot leads.</p></div>
        <div class="card"><h3>Module toggles</h3><p>Enable only the workflows your shop needs.</p></div>
    </div>
</section>

<section class="wrap section">
    <h2>Core modules online</h2>
    <div class="grid" style="margin-top:1.2rem;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules->where('enabled', true)->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <span class="pill on">ON</span>
                <h3><?php echo e($module['label']); ?></h3>
                <p><?php echo e($module['description']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/public/home.blade.php ENDPATH**/ ?>