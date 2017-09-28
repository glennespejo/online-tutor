@extends('adminlte::page')

@section('title', 'Teachers')

@section('content_header')
    <h1>
        Teachers
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
                <button type="button" id="add_teacher" class="btn btn-success btn-sm pull-right">Add Teacher</button>
            </div>
            <!-- /.box-header -->
            <form role="form" method="post" action="">
                {{ csrf_field() }}
                <div class="box-body">
                  <table id="teacher_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Teacher ID</th>
                      <th>Name</th>
                      <th>Password</th>
                      <th class="no-sort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->where('role', 'teacher')->get())
                      @foreach($user->where('role', 'teacher')->get() as $key => $value)
                        <tr>
                          <td>{{$value->id}}</td>
                          <td>{{$value->name}}</td>
                          <td>{{$value->raw_password ? \Crypt::decrypt($value->raw_password) : ''}}</td>
                          <td>
                            {!!view('actions', ['itemID'=>$value->id])->render()!!}
                          </td>
                        </tr>
                      @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Teacher ID</th>
                      <th>Name</th>
                      <th>Password</th>
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
        $('#teacher_table').DataTable();
        var config = {!! $user->routeConfig() !!};
      </script>
      <script src="{{ asset('js/teacher.js')}}"></script>
    @endpush
@stop