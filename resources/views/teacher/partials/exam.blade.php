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
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      @if($exams)
        @foreach($exams as $key => $value)
          <tr>
            <td>{{$key +1 }}</td>
            <td>{{json_decode($value->value)->exam_name}}</td>
            <td>
              {!!view('action_exam', ['itemID'=>$value->id])->render()!!}
            </td>
          </tr>
        @endforeach
      @endif
      </tbody>
      <tfoot>
      <tr>
      	<th>#</th>
        <th>Exam Name</th>
        <th>Action</th>
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


    //add exam
  	$("#create_exam").on('click', function(){
      actionExam = 'store';
      $('#question_div').html('');
      $('#question_div_1').show();
      $('#add_question').show();
      $("#exam_form :input").attr("disabled", false);
      $('#submit-exam').show();
      document.getElementById("exam_form").reset();
	    $('#ExamModalForm').modal('show');
    });

    //Edit
    $(".content").on('click', '.edit.btn', function(){
      actionExam = 'edit';
      $('#question_div').html('');
      $('#add_question').show();
      var id = $(this).data('id');
      item_id = id;
      getItemData(id, 'edit');
      $("#exam_form :input").attr("disabled", false);
      $('#submit-exam').show();
    });

    //view
    $(".content").on('click', '.view.btn', function(){
      $('#question_div').html('');
      $('#add_question').hide();
      actionExam = 'edit';
      var id = $(this).data('id');
      item_id = id;
      getItemData(id, 'view');
      $("#exam_form :input").attr("disabled", true);
      $('#submit-exam').hide();
    });


    $('#submit-exam').on('click', function () {

      if(actionExam == 'store') {
        var isValid = $("#question_div_1").parsley();
        if( !isValid.validate()) {
          return;
        }
        var url = config.store_exam;
      } else {
        var isValid = $("#question_div").parsley();
        if( !isValid.validate()) {
          return;
        }
        var url = config.update_exam;
      }

      var viewSectionModal = $('#ExamModalForm');

      var loader_image_bar_obj = $('.loader-image-bar');

      viewSectionModal.find('.modal-content').append(loader_image_bar_obj[0].outerHTML);

      viewSectionModal.find('.loader-image-bar').removeClass('hide');


      $.ajax({
        data: $('#exam_form').serialize(),
        url:  url,
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

              showErrorMessage("Unable to add exam"); // generic error message
        },

        success: function (data) {
          $('.loader-image-bar').addClass('hide');
          // if data is a error specific message
          if (typeof data.error_message !== 'undefined' && data.error_message) {
            showErrorMessage(data.error_message);
            return;
          }
          viewSectionModal.find('.loader-image-bar').remove();
          //reload();
          swal("Good job!", data.msg, "success");
        }
      });
    });

    var counter = 2;
    $('#add_question').on('click', function () {
      add_question(counter);
      counter++;
    });

    function getItemData(id, action) {
      var route = config.show_exam.replace('@id', id);
      $.ajax({
        data: {
          exam_id: id,
        },
        url:  route,
        cache: false,
        type: 'GET',
        dataType: 'json',

        error: function (jqXHR, textStatus, errorThrown) {
          showErrorMessage(errorThrown);
        },

        success: function (data) {
          $('#question_div_1').hide();
          $('#ExamModalForm').modal('show');
          $('#exam_name').val(data.exam.exam_name);
          $('#status').val(data.exam.status);
          $('#question_div').append('<input type="hidden" name="exam_id" value="'+data.exam_id+'">')
          $.each( data.exam.question, function (index, question) {
            add_question(index, question, data.exam.choice[index], data.exam.answer[index],action)
          });
        }
      });
    };

    function add_question (count, question = '', choice = '', answer = '', action = 'edit')
    {
      var choice_a = '';
      var choice_b = '';
      var choice_c = '';
      var answer_a = 'checked';
      var answer_b = '';
      var answer_c = '';

      if (choice) {
        choice_a = choice[0];
        choice_b = choice[1];
        choice_c = choice[2];
      }

      if (answer) {
        if(answer == 'A')
          answer_a = 'checked';
        if(answer == 'B')
          answer_b = 'checked';
        if(answer == 'C')
          answer_c = 'checked';
      }

      var disabled = action === 'view' ? 'disabled' : '';

      $('#question_div').append(
        '<div id="question_div_'+count+'">'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-1 control-label">Q:</label>'+
              '<div class="col-sm-11">'+
                '<input type="text" class="form-control" value="'+question+'" '+disabled+' name="question['+count+']" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Question">'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">A.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" value="'+choice_a+'" '+disabled+' name="choice['+count+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="radio" '+answer_a+' name="answer['+count+'][]"  '+disabled+' value="A" title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">B.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" value="'+choice_b+'"  '+disabled+'  name="choice['+count+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="radio" '+answer_b+' name="answer['+count+'][]" '+disabled+' value="B" title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label style="padding-right: 0px;" class="col-sm-2 control-label">C.</label>'+
              '<div class="col-sm-10">'+
                '<div class="input-group input-group-sm">'+
                  '<input type="text" class="form-control" value="'+choice_c+'" '+disabled+' name="choice['+count+'][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">'+
                      '<span class="input-group-btn" style="padding-left: 10px;">'+
                        '<input type="radio" '+answer_c+' name="answer['+count+'][]" '+disabled+' value="C"  title="answer">'+
                      '</span>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'
      );
    }
  </script>
@endpush