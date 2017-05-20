<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'AdminController@index')->name('admin.home');


///admin routes-----------------------------------

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/index','AdminController@showIndex')->name('admin.index');
    Route::get('/addProduct','ProductController@addProduct')->name('admin.addProduct');
    Route::post('/storeProduct','ProductController@store');
    Route::get('/productList','ProductController@showProducts')->name('Product.list');
    Route::get('/indivisualProduct/{id}','ProductController@showProductDetail');
    Route::get('/updateProduct/{id}','ProductController@updateProduct');
    Route::post('/updateProduct/{id}','ProductController@update');
    Route::get('/admin/allOrders','ProductController@orders')->name('admin.orders');
    Route::post('/admin/changeOrderStatus','ProductController@changeOrderStatus');
    Route::get('/admin/indivisualOrderDetail/{id}','ProductController@indivisualOrderDetail');
    Route::post('/admin/storeFile','ProductController@storeFile')->name('admin.store');
    Route::post('/admin/order/orderDiscussion','ProductController@storeOrderDiscussion');
    Route::get('/showLog/{id}','ProductController@logViewer');
    Route::post('/admin/assignEmployee','ProductController@employeeAssigner');
    Route::get('/admin/user/register','AdminController@showRegistrationForm');
    Route::post('/admin/user/register','AdminController@registerUser');
    Route::post('/admin/changePointDiscount','AdminController@pointManager');
    Route::post('/admin/addCatagory','AdminController@addCatagory')->name('admin.add.catagory');
    Route::get('/admin/employee/management','AdminController@employeeManagement')->name('admin.employee.management');
    Route::get('/admin/employee/update/{id}','AdminController@employeeUpdate');
    Route::post('/admin/employee/update/{id}','AdminController@Update');
    Route::post('/admin/deleteEmployee','AdminController@deleteEmployee');
    Route::post('/admin/deleteProduct','ProductController@deleteProduct');
    Route::post('/admin/addSlide','AdminController@addSlide');
    Route::get('/admin/deleteSlide/{id}','AdminController@deleteSlide');
    Route::get('/user/management','AdminController@showUsers')->name('admin.user.management');
    Route::post('/admin/sendmail/subscriber','AdminController@sendMail')->name('send.mail.subscriber');
    Route::post('/admin/setSize','AdminController@saveSize')->name('save.size');
    Route::get('/admin/create/order','AdminController@showOrderForm')->name('admin.create.order');
    Route::post('/admin/set/order','AdminController@setOrder');
    Route::get('/admin/new/tickets','AdminController@showNewTickets')->name('admin.new.tickets');
    Route::post('/admin/changeTicketStaus','AdminController@changeTicketStatus');
    Route::get('/admin/accepted/tickets','AdminController@showAcceptedTickets')->name('admin.accepted.tickets');
    Route::post('/admin/ticket/assignEmployee','AdminController@assignEmployeeToTicket');
    Route::post('/admin/ticket/sendMail','AdminController@sendTicketSolvationMail')->name('send.mail.ticketOwner');
    Route::get('/checkSize','AdminController@checkSize');
    Route::get('/checkCatagory','AdminController@checkCatagory');



});
Route::get('/employee/register','Auth\EmployeeRegisterController@showRegistrationForm')->name('employee.register');
Route::post('/employee/register','Auth\EmployeeRegisterController@register')->name('employee.register.submit');


///user routes---------------------------------
Route::group(['middleware' => ['web']], function () {
    Route::get('/login/facebook','Auth\LoginController@redirectToProvider');
    Route::get('/login/facebook/redirect','Auth\LoginController@handleProviderCallback');
});

Route::post('/searchItem','IndexController@itemFinder');
Route::post('/create/ticket','UserController@createTicket');
Route::get('/','IndexController@showIndex');
Route::get('/cart','IndexController@showCart')->name('user.cart');
Route::get('/productDetail/{id}','IndexController@showProductDetail');
Route::get('/user/catagoryProduct/{catagory}','IndexController@CatagoryWiseProduct');

Route::get('/account/settings','UserController@showAccountSettingsPage')->name('user.account.settings');
Route::post('/update/personalinfo/{id}','UserController@updatePersonalInfo');
Route::post('/update/password/{id}','UserController@changePassword');

Route::get('/addToWishlist/{id}','UserController@addToWishlist');
Route::get('/showWishList','UserController@showWishList')->name('user.wishList');
Route::get('/subscribe','UserController@subscriber')->name('user.subscribe');
Route::get('/subscribe','IndexController@subscriber')->name('unauth.user.subscribe');
Route::post('/removeWish','UserController@removeWish')->name('user.removeWish');

Route::get('/orderPlacementInfo/address','OrderController@showOrderPlacement');
Route::get('/orderPlacementInfo/checkOut','OrderController@showCheckOut');
Route::post('/checkOut','OrderController@confirmCheckout');
Route::get('/userOrderDetail','OrderController@showUserOrderDetail')->name('user.order');
Route::get('/orderPlacementInfo/payment','OrderController@showOrderPayment');
Route::get('/indivisualOrderDetail/{id}','OrderController@showIndivisualOrder');
Route::get('/indivisualOrderTrack/{id}','OrderController@showOrderTrack');


////Routes for employees

Route::get('/employee/login','Auth\EmployeeLoginController@showLoginForm')->name('employee.login');
Route::post('/employee/login','Auth\EmployeeLoginController@login')->name('employee.login.submit');
Route::get('/employee/dashboard','EmployeeController@showDashboard')->name('employee.index');
Route::get('/employee/allOrders','EmployeeController@showOrders')->name('employee.orders');
Route::get('employee/showLog/{id}','EmployeeController@logViewer');
Route::get('/employee/indivisualOrderDetail/{id}','EmployeeController@indivisualOrderDetail');
Route::post('/employee/changeOrderStatus','EmployeeController@changeOrderStatus');
Route::post('/employee/order/orderDiscussion','EmployeeController@storeOrderDiscussion');
Route::post('/employee/storeFile','EmployeeController@storeFile')->name('employee.store');
Route::post('/employee/addCatagory','EmployeeController@addCatagory')->name('employee.add.catagory');
Route::get('/employee/user/management','EmployeeController@showUsers')->name('employee.user.management');
Route::post('/employee/sendmail/subscriber','EmployeeController@sendMail')->name('employee.send.mail.subscriber');
Route::get('/employee/accepted/tickets','EmployeeController@showAcceptedTickets')->name('employee.accepted.tickets');
Route::post('/employee/changeTicketStaus','EmployeeController@changeTicketStatus');
Route::post('/employee/ticket/sendMail','EmployeeeController@sendTicketSolvationMail')->name('employee.send.mail.ticketOwner');

Route::group(['middleware' => 'auth:employee'], function () {
    Route::get('/employee/addProduct','ProductController@addProduct')->name('employee.addProduct');
    Route::post('/employee/storeProduct','ProductController@store');
    Route::get('/employee/productList','ProductController@showProducts')->name('employee.Product.list');
    Route::get('/employee/indivisualProduct/{id}','ProductController@showProductDetail');
    Route::get('/employee/updateProduct/{id}','ProductController@updateProduct');
    Route::post('/employee/updateProduct/{id}','ProductController@update');
    Route::get('/employee/user/register','Auth\CreateUserController@showRegistrationForm');
    Route::post('/employee/user/register','Auth\CreateUserController@register');
    Route::post('/employee/storeFile','ProductController@storeFile')->name('employee.store');
});


