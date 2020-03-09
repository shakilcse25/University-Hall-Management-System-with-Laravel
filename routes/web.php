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

Route::get('/', [
    'uses' => 'Homecontroller@index',
    'as' => 'dashboard'
]);


// Student Router
Route::get('/createstudent/{roomid}',[
    'uses' =>  'StudentController@create',
    'as' => 'create.student'
]);

Route::post('/storestudent', [
    'uses' => 'StudentController@store',
    'as' => 'store.student'
]);
Route::get('/viewstuedent', [
    'uses' => 'StudentController@index',
    'as' => 'view.student'
]);

Route::get('/editstuedent/{id}', [
    'uses' => 'StudentController@edit',
    'as' => 'edit.student'
]);

Route::post('/updatestudent/{id}', [
    'uses' => 'StudentController@update',
    'as' => 'update.student'
]);

Route::get('/deletestudent/{id}', [
    'uses' => 'StudentController@destroy',
    'as' => 'delete.student'
]);
Route::get('/vacentstudent/{id}', [
    'uses' => 'StudentController@vacent',
    'as' => 'vacent.student'
]);

Route::get('/fillstudentpage/{room_id}', [
    'uses' => 'StudentController@fillpage',
    'as' => 'fillpage.student'
]);

Route::get('/fillstudent/{id}/{room_id}', [
    'uses' => 'StudentController@fill',
    'as' => 'fill.student'
]);




// Room Router
Route::get('/viewroom', [
    'uses' => 'RoomController@index',
    'as' => 'view.room'
]);
Route::get('/createroom', [
    'uses' => 'RoomController@create',
    'as' => 'create.room'
]);
Route::post('/storeroom', [
    'uses' => 'RoomController@store',
    'as' => 'store.room'
]);
Route::post('/updateroom/{id}', [
    'uses' => 'RoomController@update',
    'as' => 'update.room'
]);
Route::get('/fillvacent', [
    'uses' => 'RoomController@showfillVacent',
    'as' => 'fill.vacent'
]);

// Meal Router
Route::get('/meal',[
    'uses' => 'mealController@index',
    'as' => 'view.meal'
]);
Route::post('/store_meal', [
    'uses' => 'mealController@store',
    'as' => 'store.meal'
]);

Route::get('/daily_meal/{id}', [
    'uses' => 'stuentmealController@edit',
    'as' => 'edit.student_meal'
]);
Route::get('/student_meal_api/{id}', [
    'uses' => 'stuentmealController@getmealApi',
    'as' => 'get.student_meal_api'
]);

Route::post('/upadate_daily_meal/{id}', [
    'uses' => 'stuentmealController@update',
    'as' => 'update.daily_meal'
]);

Route::post('/egg/{id}', [
    'uses' => 'stuentmealController@egg',
    'as' => 'update.egg'
]);

Route::get('/select_month_page', [
    'uses' => 'mealController@index',
    'as' => 'view.monthpage'
]);

Route::match(['get', 'POST'],'/select_monthlymeal', [
    'uses' => 'mealController@selectmonthmeal',
    'as' => 'select.month_meal_search'
]);

Route::get('/deletemeal/{id}', [
    'uses' => 'mealController@delmeal',
    'as' => 'delete.meal'
]);

Route::post('/meal_update/{id}', [
    'uses' => 'mealController@mealUpdate',
    'as' => 'meal.update'
]);



// Search Router
Route::post('/viewsearchstudent', [
    'uses' => 'StudentController@find',
    'as' => 'search.student'
]);

Route::match(['get','POST'],'/view_search_meal_student/{id}', [
    'uses' => 'mealController@findmealstudent',
    'as' => 'search.mealstudent',
    'name' => 'searchmealstudent'
]);





// Manage Fixed charge
Route::get('/init_setup', [
    'uses' => 'fixedController@index',
    'as' => 'init.setup'
]);

Route::post('/store', [
    'uses' => 'fixedController@store',
    'as' => 'store.seatcharge'
]);

// Monthly Cost
Route::get('/monthly_cost',[
    'uses' => 'monthlycostController@index',
    'as' => 'monthly.cost'
]);

Route::post('/monthly_create', [
    'uses' => 'monthlycostController@store',
    'as' => 'monthly.storecost'
]);
Route::post('/monthly_update/{id}', [
    'uses' => 'monthlycostController@update',
    'as' => 'monthly.updatecost'
]);

Route::get('/monthly_cost_student/{id}', [
    'uses' => 'monthlycostController@studenttable',
    'as' => 'monthly.coststudent'
]);

Route::get('/monthly_cost_studentApi/{id}', [
    'uses' => 'monthlycostController@studenttableApi',
    'as' => 'monthly.coststudentApi'
]);

Route::post('/monthly_cost_update/{id}', [
    'uses' => 'monthlycostController@monthlycostupdate',
    'as' => 'monthly.costupdate'
]);

Route::match(['get', 'POST'], '/search_monthly_meal_student', [
    'uses' => 'mealController@findmealsinglestudent',
    'as' => 'search.single_student_meal'
]);

Route::post('/add_stdtomonth', [
    'uses' => 'monthlycostController@addstdtomonth',
    'as' => 'addstd.month'
]);
Route::get('/delstdmonth/{id}', [
    'uses' => 'monthlycostController@destroy',
    'as' => 'delete.monthstudent'
]);

Route::get('/deletemonth/{id}', [
    'uses' => 'monthlycostController@delmonth',
    'as' => 'delete.month'
]);
Route::post('/credit_month/{id}',[
    'uses' => 'monthlycostController@credit',
    'as' => 'credit.month'
]);
Route::post('/debit_month/{id}', [
    'uses' => 'monthlycostController@debit',
    'as' => 'debit.month'
]);
Route::get('/viewtransaction', [
    'uses' => 'monthlycostController@viewtransaction',
    'as' => 'view.transaction'
]);


// Employee Router
Route::get('/manage_employee',[
    'uses' => 'employeeController@index',
    'as' => 'manage.employee'
]);
Route::post('/add_employee', [
    'uses' => 'employeeController@store',
    'as' => 'add.employee'
]);
Route::get('/empselect_month_page', [
    'uses' => 'employeeController@selectmonth',
    'as' => 'view.empmonthpage'
]);

Route::match(['get', 'POST'], '/empselect_monthlymeal', [
    'uses' => 'employeeController@empselectmonthmeal',
    'as' => 'select.empmonth_meal_search'
]);
Route::get('/emp_daily_meal/{id}', [
    'uses' => 'employeeController@edit',
    'as' => 'edit.emp_meal'
]);

Route::post('/upadate_empdaily_meal/{id}', [
    'uses' => 'employeeController@update',
    'as' => 'update.empdaily_meal'
]);


Route::post('/upadate_emp_information/{id}', [
    'uses' => 'employeeController@empupdateInformation',
    'as' => 'update.emp_infor'
]);

Route::GET('/del_emp/{id}', [
    'uses' => 'employeeController@destroy',
    'as' => 'delete.employee'
]);

// Setting
Route::get('/setting', [
    'uses' => 'HomeController@setting',
    'as' => 'setting'
]);

Route::post('/storedept', [
    'uses' => 'HomeController@storedept',
    'as' => 'store.dept'
]);
Route::post('/storebatch', [
    'uses' => 'HomeController@storebatch',
    'as' => 'store.batch'
]);

Route::get('/deletedept/{id}', [
    'uses' => 'HomeController@deletedept',
    'as' => 'delete.dept'
]);
Route::get('/deletebatch/{id}', [
    'uses' => 'HomeController@deletebatch',
    'as' => 'delete.batch'
]);






Auth::routes();


