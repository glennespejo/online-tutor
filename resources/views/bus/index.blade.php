@extends('adminlte::page')

@section('title', 'Buses')

@section('content_header')
    <h1>
        Buses
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
              <h3 class="box-title">Bus List</h3>
                <button type="button" id="add_bus" class="btn btn-primary btn-sm pull-right">Add Bus</button>
            </div>
            <!-- /.box-header -->
            <form role="form" method="post" action="">
                {{ csrf_field() }}
                <div class="box-body">
                  <table id="bus_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Bus number</th>
                      <th>Plate number</th>
                      <th>Current Route</th>
                      <th class="no-sort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($bus->all())
                      @foreach($bus->all() as $key => $value)
                        <tr>
                          <td>{{$value->bus_number}}</td>
                          <td>{{$value->plate_number}}</td>
                          <td>{{@$value->routes->starting_position . ' - ' . @$value->routes->ending_position}}</td>
                          <td>
                            {!!view('actions', ['itemID'=>$value->id])->render()!!}
                          </td>
                        </tr>
                      @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Bus number</th>
                      <th>Plate number</th>
                      <th>Current Route</th>
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
    @include('bus.partials.bus_modal')
    @push('js')
      <script type="text/javascript">
        $('#bus_table').DataTable();
        var config = {!! $bus->routeConfig() !!};
      </script>
      <script src="{{ asset('js/bus.js')}}"></script>
    @endpush
@stop