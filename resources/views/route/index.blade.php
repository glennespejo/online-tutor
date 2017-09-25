@extends('adminlte::page')

@section('title', 'Routes')

@section('content_header')
    <h1>
        Routes
    </h1>
    <ol class="breadcrumb">
    </ol>
@stop

@push('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <!-- right column -->
        <div class="col-xs-12">
          <!-- general form elements disabled -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Route List</h3>
                <button type="button" id="add_route" class="btn btn-primary btn-sm pull-right">Add Route</button>
            </div>
            <!-- /.box-header -->
            <form role="form" method="post" action="">
                {{ csrf_field() }}
                <div class="box-body">
                  <table id="route_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Route number</th>
                      <th>Starting Position</th>
                      <th>Ending Position</th>
                      <th>Color Code</th>
                      <th class="no-sort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($route->all())
                      @foreach($route->all() as $key => $value)
                        <tr>
                          <td>{{$value->id}}</td>
                          <td>{{$value->starting_position}}</td>
                          <td>{{$value->ending_position}}</td>
                          <td bgcolor="{{$value->color}}"></td>
                          <td>
                            {!!view('actions', ['itemID'=>$value->id])->render()!!}
                          </td>
                        </tr>
                      @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Route number</th>
                      <th>Starting Position</th>
                      <th>Ending Position</th>
                      <th>Color Code</th>
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
    @include('route.partials.route_modal')
    @push('js')
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>  
      <script type="text/javascript">
        $('#color').colorpicker({});
        $('#route_table').DataTable();
        var config = {!! $route->routeConfig() !!};
        var counter = 1;
      </script>
      <script src="{{ asset('js/route.js')}}"></script>
    @endpush
@stop