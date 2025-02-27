<!-- Scrollable modal -->
<div class="offcanvas offcanvas-end" id="open-userModal" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 id="modalTitle">Add User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
            <div class="modal-body">
                <form class="user_form" id="user_form">
                    <input type="hidden" name="userId" id="userId">
                    <div class="mb-3 row form-group">
                        <label for="name" class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" name="name" id="name" placeholder="Enter name for the User">
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="email" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" name="email" id="email" placeholder="Enter Email for the User">
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="role" class="col-md-2 col-form-label">Role</label>
                        <div class="col-md-10">
                            @if($roles->count() > 0)
                            <select class="form-control " name="role" id="role">
                                <option value="admin">Select Role</option>

                                @foreach ($roles as $role )
                                <option class="role-select" value="{{$role->id}}">{{$role->name}}</option>

                                @endforeach

                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="password" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" value="" name="password" id="password" placeholder="Enter Password for the User">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                <button type="button" class="btn btn-primary" id="submit_form">Save changes</button>
            </div>

</div><!-- /.modal -->



<!-- Scrollable modal -->
<div class="offcanvas offcanvas-end" id="open-passwordModal" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 id="modalTitle">Confim Password</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
            <div class="modal-body">
                <form class="password_change_form" id="password_change_form">

                    <div class="mb-3 row form-group">
                        <label for="old_password" class="col-md-4 col-form-label">Old Password</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="" name="old_password" id="old_password" placeholder="Enter Old Password">
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="new_password" class="col-md-4 col-form-label">New Password</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="" name="password" id="new_password" placeholder="Enter New Password">
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="password_confirmation" class="col-md-4 col-form-label">Confirm Password</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="" name="password_confirmation" id="password_confirmation" placeholder="Enter confirm Password">
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                <button type="button" class="btn btn-primary" id="submit_form">Save changes</button>
            </div>

</div><!-- /.modal -->

