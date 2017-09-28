<div class="modal fade" tabindex="-1" id="teacherModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="teacher-form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Teacher</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="position: relative;">
            <label for="name">Teacher Name</label>
            <input type="name" class="form-control" placeholder="Enter Teacher Name" data-parsley-required="true" data-parsley-trigger="keyup" name="name" id="name">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="name">Email</label>
            <input type="email" class="form-control" placeholder="Enter Teacher Email" data-parsley-required="true" data-parsley-trigger="keyup" name="email" id="email">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="password">Password</label>
            <input type="password" class="form-control" placeholder="Password" data-parsley-required="true" data-parsley-trigger="keyup" name="password" id="password">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Confirm Password" data-parsley-required="true" data-parsley-trigger="keyup" name="confirm_password" id="confirm_password">
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="submit-teacher" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
