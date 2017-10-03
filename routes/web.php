<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('users', 'UserController');
	Route::get('profile', 'UserController@profile');
	Route::get('teacher-section/{section_id}', 'UserController@teacherSection')->name('teacher.section');
	Route::get('students', 'UserController@index_student');
	Route::resource('section', 'SectionController');
	Route::post('add-section-exam', 'SectionController@storeExam')->name('teacher.exam');
	Route::post('update-section-exam', 'SectionController@updateExam')->name('teacher.exam.update');
	Route::get('show-section-exam/{exam_id}', 'SectionController@showExam')->name('teacher.exam.show');
	Route::delete('destroy-section-exam/{exam_id}', 'SectionController@destroyExam')->name('teacher.exam.destroy');
	Route::post('done-section-exam/', 'SectionController@doneExam')->name('teacher.exam.done');

	Route::resource('bus', 'BusController');	
	Route::resource('route', 'RouteController');	
	Route::post('/upload/file', 'SectionController@uploadFile');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
