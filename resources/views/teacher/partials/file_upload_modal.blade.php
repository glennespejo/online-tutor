<div class="modal fade" tabindex="-1" id="fileModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="file-form" method="post" action="{{url('/upload/file')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header">
          <input type="hidden" name="section_code" value="{{$section->section_code}}">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Upload File</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="position: relative;">
            <label for="section_name">File Name</label>
            <input type="name" class="form-control" placeholder="File Name" data-parsley-required="true" data-parsley-trigger="keyup" name="file_name" id="file_name">
          </div>
          <div class="form-group" style="position: relative;">
            <input type="file" name="file" id="file">
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" id="upload-file" class="btn btn-p">Upload</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
