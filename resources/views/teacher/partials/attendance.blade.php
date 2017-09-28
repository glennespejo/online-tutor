<div class="box box-success">
<div class="box-header with-border">
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="attendance_table" class="table table-bordered table-hover">
      <thead>
      <tr>
      	<th>#</th>
        <th>Date</th>
        <th class="no-sort">Action</th>
      </tr>
      </thead>
      <tbody>
      
      </tbody>
      <tfoot>
      <tr>
      	<th>#</th>
        <th>Date</th>
        <th class="no-sort">Action</th>
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