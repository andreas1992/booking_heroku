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

use App\Task;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/tasks', 'TaskController@index');

Route::get('/tasks/newTask', 'TaskController@create');

Route::get('/tasks/{task}', 'TaskController@show')->name('show_task');

Route::POST('/tasks', 'TaskController@store');

Route::get('tasks/{task}/edit', 'TaskController@edit');

Route::PUT('/tasks/{task}','TaskController@update')->name('update');

Route::DELETE('/tasks/{task}', 'TaskController@destroy')->name('delete');

Route::get('/', function() {

	$string = file_get_contents('js/room.json');
	$rooms = json_decode($string, true);
	//dd($rooms);
	return view('welcome', compact('rooms'));
	
});
Route::get('ajax',function(){
   return view('message');
});
Route::post('/getmsg','AjaxController@index');

/*Route::get('/tasks', function () {
	$tasks = DB::table('tasks')->get();

	return view('tasks.index', compact('tasks'));
});*/

/*Route::get('/tasks/newTask', function() {
	return view('tasks/newTask');
});*/

/*Route::get('/tasks/editTask', function() {
	return view('tasks/editTask');
});*/


/**
 * Route::get('/tasks/{tasks}') Viser til URI-en, med wildcard {task} som henviser til et tall/id i tabellen.
 *//*
Route::get('/tasks/{task}', function ($id) {
	$task = DB::table('tasks')->find($id);

	return view('tasks.show', compact('task'));
})->name('show_task');*/


/*Route::get('/tasks/{task}/edit', function ($id) {
	$task = DB::table('tasks')->find($id);

	return view('tasks/editTask', compact('task'));
});*/

/*Route::POST('/tasks', function () {
	$task = new Task;

	$task->body = request('body');
	$task->save(); 

	return redirect('/tasks');
});*/