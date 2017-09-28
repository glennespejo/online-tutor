@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>
        Teachers
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
              <li class="active"><a href="#attendance" data-toggle="tab">Attendance</a></li>
              <li><a href="#file_manager" data-toggle="tab">File Manager</a></li>
              <li><a href="#exams" data-toggle="tab">Exams</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="attendance">
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
      <script src="{{ asset('js/profile.js')}}"></script>
    @endpush
@stop