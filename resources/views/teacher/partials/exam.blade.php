<div class="box box-success">
<div class="box-header with-border">
<button type="button" id="create_exam" class="btn btn-success btn-sm pull-right">Create Exam</button>
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="exam_table" class="table table-bordered table-hover">
      <thead>
      <tr>
      	<th>#</th>
        <th>Exam Name</th>
        <th>Date Created</th>
        <th class="no-sort">Action</th>
      </tr>
      </thead>
      <tbody>
      
      </tbody>
      <tfoot>
      <tr>
      	<th>#</th>
        <th>Exam Name</th>
        <th>Date Created</th>
        <th class="no-sort">Action</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@include('teacher.partials.exam_modal')
@push('js')
  <script type="text/javascript">
  	$('#exam_table').DataTable();
  	$("#create_exam").on('click', function(){
	    $('#ExamModalForm').modal('show');
    });
  </script>
@endpush