$(function () {

  $('#add-bus-stop').on('click', function () {

    $('.bus-stop-container').append(
      '<div class="form-group" style="position: relative;">'+
        '<label>Bus Stop Name '+ counter +'</label>'+
        '<input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="route_stop_name[]">'+
      '</div>'+
      '<div class="form-group" style="position: relative;">'+
        '<label>Bus Stop Coordinate</label>'+
        '<input type="text" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="coordinates[]">'+
      '</div>'
    );

    counter++;

  });
  
  var item_id;

  //Add 
  $("#add_route").on('click', function(){
    actionRoute = 'store';
    $('#routeModalForm').modal('show');
  });

  //Edit
  $(".content").on('click', '.edit.btn', function(){
    actionRoute = 'edit';
    var id = $(this).data('id');
    item_id = id;
    $(this).getItemData(id);
  });

  //delete

  $(".content").on('click', '.delete.btn', function(){
    var id = $(this).data('id');
    $(this).deleteItem(id);
  });

  // Route Function
  $("#submit-route").on('click', function(){

    //Validate required fields
    var isValid = $("#route-form").parsley();
     if( !isValid.validate())
      return;

    $(this).Route(actionRoute,item_id);
  });

});


(function($) {

  /**
   * Route
   */
  $.fn.Route = function(actionRoute,item_id) {

    var viewRouteModal = $('#routeModalForm');

    var loader_image_bar_obj = $('.loader-image-bar');

    viewRouteModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

    viewRouteModal.find('.loader-image-bar').removeClass('hide');

    if(actionRoute === 'store') {
      var url = config.store;
      var ACTION = "POST";
    } else {
      var url = config.update.replace('@id', item_id);
      var ACTION = "PUT";
    }

    $.ajax({
      data: $('#route-form').serialize(),
      url:  url,
      cache: false,
      type: ACTION,
      dataType: 'json',

      error: function (jqXHR, textStatus, errorThrown) {
        $('.loader-image-bar').addClass('hide');
        if (textStatus != 'error')
              return;

            if (errorThrown == 'Unprocessable Entity'){

              var responseJSON = jqXHR.responseJSON;

              try {
                showPopUpCampaignTagError(responseJSON[Object.keys(responseJSON)[0]][0]);
                return;
              } catch (e) {
                // do nothing
              }
            }

            showPopUpCampaignTagError("Unable to add route"); // generic error message
      },

      success: function (data) {
        $('.loader-image-bar').addClass('hide');
        // if data is a error specific message
        if (typeof data.error_message !== 'undefined' && data.error_message) {
          showPopUpCampaignTagError(data.error_message);
          return;
        }
        viewRouteModal.find('.loader-image-bar').remove();
        reload();
        swal("Good job!", data.msg, "success");
      }
    });
  };

  $.fn.getItemData = function(id) {
    var route = config.show.replace('@id', id);
    $.ajax({
      data: {
        route_id: id,
      },
      url:  route,
      cache: false,
      type: 'GET',
      dataType: 'json',

      error: function (jqXHR, textStatus, errorThrown) {
        showPopUpCampaignTagError(errorThrown);
      },

      success: function (data) {
        $('#routeModalForm').modal('show');
        $.each(data, function (index, value) {
          if (index == 'route_stops') {
            $.each(value, function (stop_index, stop_value) {
              $('.bus-stop-container').append(
                '<div class="form-group" style="position: relative;">'+
                  '<label>Bus Stop Name '+ stop_value.order +'</label>'+
                  '<input type="text" value="'+ stop_value.route_stop_name +'" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="route_stop_name[]">'+
                '</div>'+
                '<div class="form-group" style="position: relative;">'+
                  '<label>Bus Stop Coordinate</label>'+
                  '<input type="text" value="'+ stop_value.coordinates +'" class="form-control" data-parsley-required="true" data-parsley-trigger="keyup" name="coordinates[]">'+
                '</div>'
              );
              counter++;
            });
          } else {
            $("#" + index).val(value);  
          }
          
        });
      }
    });
  };
  $.fn.deleteItem = function(id) {

    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this imaginary file!",
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
              showPopUpCampaignTagError(errorThrown);
            },

            success: function (data) {
              // if data is a error specific message
              if (typeof data.error_message !== 'undefined' && data.error_message) {
                showPopUpCampaignTagError(data.error_message);
                return;
              }
              reload();
              swal("Deleted!", data.msg, "success");
            }
          });

      } else {
        swal("Cancelled", "Your Data is safe :)", "error");
      }
    });
  };
})(jQuery);

function reload() {
  //setTimeout(function(){ location.reload(); }, 1000);
}

function showPopUpCampaignTagError(message) {
  swal({
  title: "Oops! Something went wrong",
  text: message,
  icon: "error",
});
}
