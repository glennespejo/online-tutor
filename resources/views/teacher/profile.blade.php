@extends('adminlte::page')

@section('title', 'Teacher | Sections')

@section('content_header')
    <h1>
        Sections
    </h1>
    <ol class="breadcrumb">
    </ol>
@stop

@section('content')
    <div class="row">
        <!-- right column -->
        <div class="col-xs-12">
          <!-- general form elements disabled -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <button type="button" id="create_section" class="btn btn-primary btn-sm pull-right">Create Section</button>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <table id="section_table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Section Code</th>
                    <th>Section Name</th>
                    <th class="no-sort">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($section->where('teacher_id', \Auth::id())->get())
                    @foreach($section->where('teacher_id', \Auth::id())->get() as $key => $value)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$value->section_code}}</td>
                        <td>{{$value->section_name}}</td>
                        <td>{!!view('actions', ['itemID'=>$value->id])->render()!!}</td>
                      </tr>
                    @endforeach
                  @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Section Code</th>
                    <th>Section Name</th>
                    <th class="no-sort">Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>

              <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    @include('teacher.partials.section_modal')
    @push('js')
      <script type="text/javascript">
        $('#section_table').DataTable();
        var config = {!! $section->routeConfig() !!};
      </script>
      <script src="{{ asset('js/profile.js')}}"></script>
    @endpush
@stop