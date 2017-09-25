<div class="modal fade" tabindex="-1" id="routeModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="route-form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Route</h4>
        </div>
        <div class="modal-body">
          <small><i>Note: Coordinates(Latitude & Logitude) must be separated by comma and space.</i></small><br>
          <small><i>Example: 15.0390, 120.6809</i></small> <br>
          <div class="form-group" style="position: relative;">
            <label for="starting_position">Starting Position Name</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="starting_position" id="starting_position">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="starting_coordinates">Starting Coordinate</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="starting_coordinates" id="starting_coordinates">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="ending_position">Ending Position Name</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="ending_position" id="ending_position">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="ending_coordinates">Ending Coordinate</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="ending_coordinates" id="ending_coordinates">
          </div>
          <div class="form-group" style="position: relative;">
            <label for="color">Color Code</label>
            <input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="color" id="color">
          </div>
          <div class="form-group" style="position: relative;">
            <label>Bus Stop(s)</label>
            <a href="#" id="add-bus-stop" class="pull-right">Add Bus Stop</a>
          </div>
          <div class="bus-stop-container">
            <input type="hidden" value="1" id="bust-stop-counter">
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="submit-route" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
