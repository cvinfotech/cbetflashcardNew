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

Route::get('/', array('as' => 'index', 'uses' => 'HomeController@index'));
Route::post('contact', array('as' => 'contact', 'uses' => 'HomeController@contact'));
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');
Route::post('/toggle-favorite', 'DashboardController@toggleFavorite')->name('favorite.toggle');
Route::get('/all-favorites', 'DashboardController@allFavorites')->name('favorite.all');
Route::post('/add-spotted', 'DashboardController@addSpotted')->name('spotted.add');
Route::get('/all-spotteds', 'DashboardController@allSpotted')->name('spotteds.all');
Route::get('/add-custom-card', 'DashboardController@addCustomCard')->name('custom.card.add');
Route::post('/store-custom-card', 'DashboardController@storeCard')->name('custom.card.store');
Route::get('/custom-cards', 'DashboardController@customCards')->name('custom.cards');
Route::get('/account-setting', 'DashboardController@accountSetting')->name('account.setting');
Route::post('/account-setting', 'DashboardController@accountUpdate')->name('account.update');
Route::delete('/account-delete', 'DashboardController@deleteAccount')->name('account.delete');
Route::get('/payments', 'DashboardController@payments')->name('payments');

Route::get('/check-spotted', 'DashboardController@checkSpotted')->name('check.spotted');

Route::get('/subscribe/paypal', 'PaypalController@paypalRedirect')->name('paypal.redirect');
Route::get('/subscribe/paypal/return', 'PaypalController@paypalReturn')->name('paypal.return');
Route::get('/payment/failed', 'PaypalController@paypalFailed')->name('payment.failed');

Route::post('web-hook', 'HomeController@webhook');
Route::get('web-hookr/{status}', 'PaypalController@webhookr')->name('payment.success');

//Admin
Route::get('create_paypal_plan/{plan_id}', 'PaypalController@create_plan')->name('create.paypal.plan')->middleware('admin');
Route::get('delete_paypal_plan/{plan_id}', 'PaypalController@delete_plan')->name('delete.paypal.plan')->middleware('admin');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/add-card', 'AdminController@addCard')->name('card.add');
Route::post('/add-card', 'AdminController@storeCard')->name('card.store');
Route::get('/edit-card/{card_id}', 'AdminController@editCard')->name('card.edit');
Route::post('/edit-card', 'AdminController@updateCard')->name('card.update');
Route::delete('/delete-card', 'AdminController@deleteCard')->name('card.delete');
Route::get('/all-category', 'AdminController@allCategories')->name('category.all');
Route::get('/add-category', 'AdminController@addCategory')->name('category.add');
Route::post('/add-category', 'AdminController@storeCategory')->name('category.store');
Route::get('/edit-category/{category_id}', 'AdminController@editCategory')->name('category.edit');
Route::post('/edit-category', 'AdminController@updateCategory')->name('category.update');
Route::delete('/delete-category', 'AdminController@deleteCategory')->name('category.delete');

Route::get('/all-users', 'AdminController@allUsers')->name('users.all');
Route::get('/add-user', 'AdminController@addUser')->name('user.add');
Route::post('/add-user', 'AdminController@createUser')->name('user.create');
Route::delete('/delete-user', 'AdminController@deleteUser')->name('user.delete');
Route::get('/plans', 'AdminController@allPlans')->name('plans.all');
Route::delete('/delete-plan', 'AdminController@deletePlan')->name('plan.delete');
Route::post('/add-plan', 'AdminController@storePlan')->name('plan.store');
Route::post('/update-plan', 'AdminController@updatePlan')->name('plan.update');
Route::get('/admin/account', 'AdminController@account')->name('admin.account');
Route::post('/admin/account', 'AdminController@updateAccount')->name('admin.updateAccount');
