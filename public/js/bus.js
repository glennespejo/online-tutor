$(function () {
  
  var item_id;

  //Add 
  $("#add_bus").on('click', function(){
    actionBus = 'store';
    $('#busModalForm').modal('show');
  });

  //Edit
  $(".content").on('click', '.edit.btn', function(){
    actionBus = 'edit';
    var id = $(this).data('id');
    item_id = id;
    $(this).getItemData(id);
  });

  //delete

  $(".content").on('click', '.delete.btn', function(){
    var id = $(this).data('id');
    $(this).deleteItem(id);
  });

  // Bus Function
  $("#submit-bus").on('click', function(){

    //Validate required fields
    var isValid = $("#bus-form").parsley();
     if( !isValid.validate())
      return;

    $(this).Bus(actionBus,item_id);
  });

});


(function($) {

  /**
   * Bus
   */
  $.fn.Bus = function(actionBus,item_id) {

    var viewBusModal = $('#busModalForm');

    var loader_image_bar_obj = $('.loader-image-bar');

    viewBusModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

    viewBusModal.find('.loader-image-bar').removeClass('hide');

    if(actionBus === 'store') {
      var url = config.store;
      var ACTION = "POST";
    } else {
      var url = config.update.replace('@id', item_id);
      var ACTION = "PUT";
    }

    $.ajax({
      data: $('#bus-form').serialize(),
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

            showPopUpCampaignTagError("Unable to add bus"); // generic error message
      },

      success: function (data) {
        $('.loader-image-bar').addClass('hide');
        // if data is a error specific message
        if (typeof data.error_message !== 'undefined' && data.error_message) {
          showPopUpCampaignTagError(data.error_message);
          return;
        }
        viewBusModal.find('.loader-image-bar').remove();
        reload();
        swal("Good job!", data.msg, "success");
      }
    });
  };

  $.fn.getItemData = function(id) {
    var route = config.show.replace('@id', id);
    $.ajax({
      data: {
        bus_id: id,
      },
      url:  route,
      cache: false,
      type: 'GET',
      dataType: 'json',

      error: function (jqXHR, textStatus, errorThrown) {
        showPopUpCampaignTagError(errorThrown);
      },

      success: function (data) {
        $('#busModalForm').modal('show');
        $.each(data, function (index, value) {
          $("#" + index).val(value);
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
  setTimeout(function(){ location.reload(); }, 1000);
}

function showPopUpCampaignTagError(message) {
  swal({
  title: "Oops! Something went wrong",
  text: message,
  icon: "error",
});
}
