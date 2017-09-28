<div class="box box-success">
<div class="box-header with-border">
<button type="button" id="upload_file" class="btn btn-success btn-sm pull-right">Upload file</button>
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="section_table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        <th>File Uploaded</th>
      </tr>
      </thead>
      <tbody>
      
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>File Name</th>
        <th>File Uploaded</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@include('teacher.partials.file_upload_modal')
@push('js')
  <script type="text/javascript">
  	$("#upload_file").on('click', function(){
	  	$('#file').val();
	    $('#fileModalForm').modal('show');
	});
  </script>
@endpush