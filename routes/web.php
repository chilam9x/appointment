<?php
Route::get('/', 'IndexController@index');

Route::get('appointment', 'IndexController@appointment');
Route::post('search-appointment', 'IndexController@searchAppointment');
Route::post('add-student', 'IndexController@postAddStudent');
Route::get('category-advisor/{id}', 'IndexController@getCategoryAdvisor');

Route::get('cancel-appointment', 'IndexController@cancelAppointment');
Route::post('cancel-appointment', 'IndexController@postCancelAppointment');
Route::post('check-student', 'IndexController@checkStudent');

Route::get('contact-us', 'Admin\ContactUsController@index');
Route::post('contact-us', 'Admin\ContactUsController@postCreate')->name('contact-us');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    
    Route::resource('appointments', 'Admin\AppointmentsController');
    Route::post('create-appointment', 'Admin\AppointmentsController@postCreate');
    Route::post('create-appointment', 'Admin\AppointmentsController@postCreate');

    Route::get('advisor', 'Admin\AdvisorController@index');
    Route::post('create-advisor', 'Admin\AdvisorController@postCreate');
    Route::post('edit-advisor', 'Admin\AdvisorController@postEdit');
    Route::post('delete-advisor', 'Admin\AdvisorController@postDelete');

    Route::get('category', 'Admin\CategoryController@index');
    Route::post('create-category', 'Admin\CategoryController@postCreate');
    Route::post('edit-category', 'Admin\CategoryController@postEdit');
    Route::post('delete-category', 'Admin\CategoryController@postDelete');

    Route::get('contact-us', 'Admin\ContactUsController@getContactUs')->name('admin.contact-us');

    Route::get('student', 'Admin\StudentController@index');
});
