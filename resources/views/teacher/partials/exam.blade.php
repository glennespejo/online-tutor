<div class="box box-success">
<div class="box-header with-border">
<button type="button" id="create_exam" class="btn btn-success btn-sm pull-right">Create Exam</button>
</div>
<!-- /.box-header -->
  <div class="box-body">
    <table id="exam_table" class="table table-bordered table-hover">
      <thead>
      <tr>
      	<th>#</th>
        <th>Exam Name</th>
      </tr>
      </thead>
      <tbody>
      @if($exams)
        @foreach($exams as $key => $value)
          <tr>
            <td>{{$key +1 }}</td>
            <td>{{json_decode($value->value)->exam_name}}</td>
          </tr>
        @endforeach
      @endif
      </tbody>
      <tfoot>
      <tr>
      	<th>#</th>
        <th>Exam Name</th>
      </tr>
      </tfoot>
    </table>
  </div>

  <!-- /.box-footer -->
</div>
@include('teacher.partials.exam_modal')
@push('js')
  <script type="text/javascript">
  	$('#exam_table').DataTable();

  	$("#create_exam").on('click', function(){
      document.getElementById("exam_form").reset();
	    $('#ExamModalForm').modal('show');
    });

    $('#submit-exam').on('click', function () {
      var isValid = $("#exam_form").parsley();
      if( !isValid.validate())
        return;

      var viewSectionModal = $('#ExamModalForm');

      var loader_image_bar_obj = $('.loader-image-bar');

      viewSectionModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

      viewSectionModal.find('.loader-image-bar').removeClass('hide');

      console.log(config.store_exam);
      $.ajax({
        data: $('#exam_form').serialize(),
        url:  config.store_exam,
        cache: false,
        type: 'post',
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
    });

    var counter = 2;
    $('#add_question').on('click', function () {
      $('#question_div').append(
        '<div id="question_div_'+counter+'">'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-1 control-label">Q:</label>'+
              '<div class="col-sm-11">'+
                '<input type="text" class="form-control" name="question['+counter+']" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Question">'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">A.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" name="choice['+counter+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="checkbox" name="answer['+counter+'][]" value="Yes" title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">B.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" name="choice['+counter+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="checkbox" name="answer['+counter+'][]" value="Yes" title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">C.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" name="choice['+counter+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="checkbox" name="answer['+counter+'][]" value="Yes"  title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'
      )
      counter++;
    });
  </script>
@endpush