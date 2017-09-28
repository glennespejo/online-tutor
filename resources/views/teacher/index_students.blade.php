@extends('adminlte::page')

@section('title', 'Students')

@section('content_header')
    <h1>
        Students
    </h1>
    <ol class="breadcrumb">
    </ol>
@stop

@section('content')
    <div class="row">
        <!-- right column -->
        <div class="col-xs-12">
          <!-- general form elements disabled -->
          <div class="box box-success">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">Bus List</h3> -->
            </div>
            <!-- /.box-header -->
            <form role="form" method="post" action="">
                {{ csrf_field() }}
                <div class="box-body">
                  <table id="student_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th class="no-sort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->where('role', 'student')->get())
                      @foreach($user->where('role', 'user')->get() as $key => $value)
                        <tr>
                          <td>{{$value->id}}</td>
                          <td>{{$value->name}}</td>
                          <td>{!!view('actions', ['itemID'=>$value->id])->render()!!}</td>
                        </tr>
                      @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th class="no-sort">Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>

              </form>
              <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    @include('teacher.partials.teacher_modal')
    @push('js')
      <script type="text/javascript">
        $('#student_table').DataTable();

        var config = {!! $user->routeConfig() !!};

        if (config.hide_edit !== 'undefined' && config.hide_edit) {
            $(".edit.btn").hide();
        }

        $(".content").on('click', '.delete.btn', function(){
          var id = $(this).data('id');
          swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var route = config.destroy.replace('@id', id);
                $.ajax({
                  url:  route,
                  cache: false,
                  type: 'DELETE',
                  dataType: 'json',

                  error: function (jqXHR, textStatus, errorThrown) {
                    swal("Opps!", errorThrown, "error");
                  },

                  success: function (data) {
                    // if data is a error specific message
                    if (typeof data.error_message !== 'undefined' && data.error_message) {
                      swal("Opps!", data.error_message, "error");
                      return;
                    }
                    // setTimeout(function(){ location.reload(); }, 1000);
                    swal("Deleted!", data.msg, "success");
                  }
                });

            } else {
              swal("Cancelled", "Your Data is safe :)", "error");
            }
          });
        });
      </script>
    @endpush
@stop