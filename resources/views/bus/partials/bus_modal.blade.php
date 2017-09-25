<div class="modal fade" tabindex="-1" id="busModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="bus-form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Bus</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="position: relative;">
            <label for="bus_number">Bus Number</label>
            <input type="number" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="bus_number" id="bus_number">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="plate_number">Plate Number</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="plate_number" id="plate_number">
          </div>
          <div class="form-group">
            <label for="route_id">Route</label>
            <select class="form-control" id="route_id" name="route_id">
              <option>Select Route</option>
              @foreach ($routes as $route)
                <option value="{{ $route->id }}">{{ $route->starting_position }} - {{ $route->ending_position }}</option>
              @endforeach ()
            </select>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="submit-bus" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
