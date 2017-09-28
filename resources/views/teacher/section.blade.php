@extends('adminlte::page')

@section('title', 'Section')

@section('content_header')
    <h1>
        {{$section->section_name . '(' . $section->section_code . ')'}}
    </h1>
    <ol class="breadcrumb">
    </ol>
@stop

@section('content')
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#students" data-toggle="tab">Students</a></li>
              <li><a href="#attendance" data-toggle="tab">Attendance</a></li>
              <li><a href="#file_manager" data-toggle="tab">File Transfer</a></li>
              <li><a href="#exams" data-toggle="tab">Exams</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="students">
                <!-- Students -->
                @include('teacher.partials.students')
                <!--/. Students  -->
              </div>
              <div class="tab-pane" id="attendance">
                <!-- Attendance -->
                @include('teacher.partials.attendance')
                <!--/. Attendance  -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="file_manager">
                <!-- Files Manager -->
                @include('teacher.partials.file_manager')
                <!--/. Files Manager-->
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="exams">
                <!-- Exam -->
                @include('teacher.partials.exam')
                <!--/. Exam-->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
    
    @push('js')
      <script type="text/javascript">
        var config = {!! $section_routeConfig !!};
        function showErrorMessage(message) {
          swal({
            title: "Oops! Something went wrong",
            text: message,
            icon: "error",
          });
        }

        function reload() {
          setTimeout(function(){ location.reload(); }, 1000);
        }
      </script>
    @endpush
@stop