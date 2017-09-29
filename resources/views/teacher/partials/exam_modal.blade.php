<div class="modal fade" tabindex="-1" id="ExamModalForm" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Exam</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="exam_form">
        <input type="hidden" name="section_id" value="{{ $section->id }}">
        <div class="box-body" id="question_div">
          <div class="form-group">
            <a href="#" id="add_question" class="pull-right">Add Question</a>
          </div>
          <div class="form-group">
            <label style="padding-right: 0px;" class="col-sm-3 control-label">Exam Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="exam_name" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Exam Name">
            </div>
          </div>
          <div id="question_div_1">
            <div class="form-group">
              <label style="padding-right: 0px;" class="col-sm-1 control-label">Q:</label>
              <div class="col-sm-11">
                <input type="text" class="form-control" name="question[1]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Question">
              </div>
            </div>
            <div class="form-group">
              <label style="padding-right: 0px;" class="col-sm-2 control-label">A.</label>
              <div class="col-sm-10">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" name="choice[1][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">
                      <span class="input-group-btn" style="padding-left: 10px;">
                        <input type="checkbox" name="answer[1][]" value="Yes" title="answer">
                      </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label style="padding-right: 0px;" class="col-sm-2 control-label">B.</label>
              <div class="col-sm-10">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" name="choice[1][]" data-parsley-required="true" data-parsley-trigger="keyup" placeholder="Choice">
                      <span class="input-group-btn" style="padding-left: 10px;">
                        <input type="checkbox" name="answer[1][]" value="Yes" title="answer">
                      </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label style="padding-right: 0px;" class="col-sm-2 control-label">C.</label>
              <div class="col-sm-10">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" name="choice[1][]" data-parsley-required="true" data-parsley-trigger="keyup"placeholder="Choice">
                      <span class="input-group-btn" style="padding-left: 10px;">
                        <input type="checkbox" name="answer[1][]" value="Yes"  title="answer">
                      </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
              <label style="padding-right: 0px;" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>  
              </div>
            </div>
        </div>
        <!-- /.box-footer -->
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="submit-exam" class="btn btn-p">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
