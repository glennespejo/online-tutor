$(function () {
  
  var item_id;

  //Add 
  $("#add_teacher").on('click', function(){
    actionTeacher = 'store';
    $('#teacherModalForm').modal('show');
  });

  //Edit
  $(".content").on('click', '.edit.btn', function(){
    actionTeacher = 'edit';
    var id = $(this).data('id');
    item_id = id;
    $(this).getItemData(id);
  });

  //delete

  $(".content").on('click', '.delete.btn', function(){
    var id = $(this).data('id');
    $(this).deleteItem(id);
  });

  // Teacher Function
  $("#submit-teacher").on('click', function(){

    //Validate required fields
    var isValid = $("#teacher-form").parsley();
     if( !isValid.validate())
      return;

    if ( $('#confirm_password').val() !== $('#password').val()) {
      swal("Opps!", 'Password does not match the confirm password ', "error");
      return;
    }

    $(this).Teacher(actionTeacher,item_id);
  });

  if (config.hide_view !== 'undefined' && config.hide_view) {
      $(".view.btn").hide();
  }

});


(function($) {

  /**
   * Teacher
   */
  $.fn.Teacher = function(actionTeacher,item_id) {

    var viewTeacherModal = $('#teacherModalForm');

    var loader_image_bar_obj = $('.loader-image-bar');

    viewTeacherModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

    viewTeacherModal.find('.loader-image-bar').removeClass('hide');

    if(actionTeacher === 'store') {
      var url = config.store;
      var ACTION = "POST";
    } else {
      var url = config.update.replace('@id', item_id);
      var ACTION = "PUT";
    }

    $.ajax({
      data: $('#teacher-form').serialize(),
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

            showPopUpCampaignTagError("Unable to add teacher"); // generic error message
      },

      success: function (data) {
        $('.loader-image-bar').addClass('hide');
        // if data is a error specific message
        if (typeof data.error_message !== 'undefined' && data.error_message) {
          showPopUpCampaignTagError(data.error_message);
          return;
        }
        viewTeacherModal.find('.loader-image-bar').remove();
        reload();
        swal("Good job!", data.msg, "success");
      }
    });
  };

  $.fn.getItemData = function(id) {
    var route = config.show.replace('@id', id);
    $.ajax({
      data: {
        teacher_id: id,
      },
      url:  route,
      cache: false,
      type: 'GET',
      dataType: 'json',

      error: function (jqXHR, textStatus, errorThrown) {
        showPopUpCampaignTagError(errorThrown);
      },

      success: function (data) {
        $('#teacherModalForm').modal('show');
        $.each(data, function (index, value) {
          $("#" + index).val(value);
        });
      }
    });
  };
  $.fn.deleteItem = function(id) {

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
