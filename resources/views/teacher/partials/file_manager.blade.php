<div class="box box-success">
<div class="box-header with-border">
<button type="button" id="upload_file" class="btn btn-success btn-sm pull-right">Upload file</button>
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="file_table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        <th>File Uploaded</th>
        <th>Download</th>
      </tr>
      </thead>
      <tbody>
      @if($files)
        @foreach($files as $key => $value)
          <tr>
            <td>{{$key +1 }}</td>
            <td>{{json_decode($value->value)->file_name}}</td>
            <td>{{$value->created_at->toDateTimeString()}}</td>
            <td><a href="{{json_decode($value->value)->file_destination}}" class="btn btn-xs" download>Download</a></td>
          </tr>
        @endforeach
      @endif
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>File Name</th>
        <th>File Uploaded</th>
        <th>Download</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@include('teacher.partials.file_upload_modal')
@push('js')
  <script type="text/javascript">
    $('#file_table').DataTable();
    $("#upload_file").on('click', function(){
	  	$('#file').val();
	    $('#fileModalForm').modal('show');
    });
  </script>
@endpush