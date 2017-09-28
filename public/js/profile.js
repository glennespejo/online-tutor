$(function () {
  
  var item_id;

  //Add 
  $("#create_section").on('click', function(){
  	$('#section_name').val();
    actionSection = 'store';
    $('#sectionModalForm').modal('show');
  });

  //Edit
  $(".content").on('click', '.edit.btn', function(){
    actionSection = 'edit';
    var id = $(this).data('id');
    item_id = id;
    $(this).getItemData(id);
  });

  //Edit
  $(".content").on('click', '.view.btn', function(){
  	var id = $(this).data('id');
   	window.location.href = config.teacher_section.replace('@id', id);
  });

  //delete

  $(".content").on('click', '.delete.btn', function(){
    var id = $(this).data('id');
    $(this).deleteItem(id);
  });

  // Section Function
  $("#submit-section").on('click', function(){

    //Validate required fields
    var isValid = $("#section-form").parsley();
     if( !isValid.validate())
      return;

    $(this).Section(actionSection,item_id);
  });

});


(function($) {

  /**
   * Section
   */
  $.fn.Section = function(actionSection,item_id) {

    var viewSectionModal = $('#sectionModalForm');

    var loader_image_bar_obj = $('.loader-image-bar');

    viewSectionModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

    viewSectionModal.find('.loader-image-bar').removeClass('hide');

    if(actionSection === 'store') {
      var url = config.store;
      var ACTION = "POST";
    } else {
      var url = config.update.replace('@id', item_id);
      var ACTION = "PUT";
    }

    $.ajax({
      data: $('#section-form').serialize(),
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
                showErrorMessage(responseJSON[Object.keys(responseJSON)[0]][0]);
                return;
              } catch (e) {
                // do nothing
              }
            }

            showErrorMessage("Unable to add section"); // generic error message
      },

      success: function (data) {
        $('.loader-image-bar').addClass('hide');
        // if data is a error specific message
        if (typeof data.error_message !== 'undefined' && data.error_message) {
          showErrorMessage(data.error_message);
          return;
        }
        viewSectionModal.find('.loader-image-bar').remove();
        reload();
        swal("Good job!", data.msg, "success");
      }
    });
  };

  $.fn.getItemData = function(id) {
    var route = config.show.replace('@id', id);
    $.ajax({
      data: {
        section_id: id,
      },
      url:  route,
      cache: false,
      type: 'GET',
      dataType: 'json',

      error: function (jqXHR, textStatus, errorThrown) {
        showErrorMessage(errorThrown);
      },

      success: function (data) {
        $('#sectionModalForm').modal('show');
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
              showErrorMessage(errorThrown);
            },

            success: function (data) {
              // if data is a error specific message
              if (typeof data.error_message !== 'undefined' && data.error_message) {
                showErrorMessage(data.error_message);
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

function showErrorMessage(message) {
  swal({
  title: "Oops! Something went wrong",
  text: message,
  icon: "error",
});
}
