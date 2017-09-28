<div class="box box-success">
<div class="box-header with-border">
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="student_table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>Student Name</th>
      </tr>
      </thead>
      <tbody>
      	@if($students)
	      @foreach($students as $key => $value)
	        <tr>
	          <td>{{$key +1}}</td>
	          <td>{{$value->student->name}}</td>
	        </tr>
	      @endforeach
	    @endif
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Student Name</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@push('js')
  <script type="text/javascript">
  	$('#student_table').DataTable();
  </script>
@endpush