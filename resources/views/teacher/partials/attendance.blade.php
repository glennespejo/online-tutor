<div class="box box-success">
<div class="box-header with-border">
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="attendance_table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>Student Name</th>
        <th>Date</th>
        <th>Time In</th>
      </tr>
      </thead>
      <tbody>
        @if($attendances)
        @foreach($attendances as $key => $value)
          <tr>
            <td>{{$value->student->name}}</td>
            <td>{{$value->date}}</td>
            <td>{{$value->created_at->toTimeString()}}</td>
          </tr>
        @endforeach
      @endif
      </tbody>
      <tfoot>
      <tr>
        <th>Student Name</th>
        <th>Date</th>
        <th>Time In</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@push('js')
  <script type="text/javascript">
  	$('#attendance_table').DataTable();
  </script>
@endpush