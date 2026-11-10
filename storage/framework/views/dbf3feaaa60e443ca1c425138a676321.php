<?php $__env->startSection('title', 'Demo Users — RoofingFollowFlow'); ?>

<?php $__env->startSection('content'); ?>
<section class="wrap section" style="padding-top:3rem;">
    <div class="eyebrow">Try it now</div>
    <h1>Demo users & roles</h1>
    <p class="lede">All demo passwords are <strong>password</strong>. Admin panel: <a href="/admin">/admin</a></p>
</section>

<section class="wrap section">
    <table>
        <thead>
            <tr>
                <th>Role</th>
                <th>Email</th>
                <th>Password</th>
                <th>Access</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Admin</td><td>admin@roofingfollowflow.test</td><td>password</td><td>Full platform</td></tr>
            <tr><td>Owner</td><td>owner@roofingfollowflow.test</td><td>password</td><td>Approvals & escalations</td></tr>
            <tr><td>Staff</td><td>staff@roofingfollowflow.test</td><td>password</td><td>Leads & follow-ups</td></tr>
            <tr><td>Technician</td><td>tech@roofingfollowflow.test</td><td>password</td><td>Jobs & field view</td></tr>
            <tr><td>Customer</td><td>customer@roofingfollowflow.test</td><td>password</td><td>Portal / demo stakeholder</td></tr>
        </tbody>
    </table>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/public/demo.blade.php ENDPATH**/ ?>