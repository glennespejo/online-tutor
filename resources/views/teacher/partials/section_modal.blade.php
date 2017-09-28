<div class="modal fade" tabindex="-1" id="sectionModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="section-form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Section</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="position: relative;">
            <label for="section_name">Section Name</label>
            <input type="name" class="form-control" placeholder="Enter Section Name" data-parsley-required="true" data-parsley-trigger="keyup" name="section_name" id="section_name">
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="submit-section" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
