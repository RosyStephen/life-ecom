
 <!-- Scrollable modal -->
 <div class="offcanvas offcanvas-end" id="open-roleModal" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 id="modalTitle">Add Role</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
            <div class="modal-body">
                <form class="role_form" id="role_form">
                    <input type="hidden" name="roleId" id="roleId">
                    <div class="mb-3 row form-group">
                        <label for="name" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" name="name" id="name" placeholder="Enter name for the Role">
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label class="col-md-2 col-form-label">Permissions</label>
                        <div class="col-md-10">
                            <?php if($permissions->count() > 0): ?>
                                <div class="permissions-container">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox" value="<?php echo e($permission->id); ?>" name="permissions[]" id="permission-<?php echo e($permission->id); ?>">
                                            <label class="form-check-label" for="permission-<?php echo e($permission->id); ?>">
                                                <?php echo e($permission->name); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p>No permissions available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                <button type="button" class="btn btn-primary" id="submit_form">Save changes</button>
            </div>

</div><!-- /.modal -->
<?php /**PATH D:\servcer\htdocs\linkedin\life-ecom\resources\views/users/roles/form.blade.php ENDPATH**/ ?>