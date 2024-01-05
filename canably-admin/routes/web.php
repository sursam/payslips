<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great !
|
*/

Route::get('/testhome', function () {
    return "dsjchjaschjascacja";
});


/* Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register')->middleware('hasInvitation');
Route::post('admin/register', 'Auth\RegisterController@register')->name('admin.register.post'); */
// Route::get('/admin/login', function () {
//     return redirect()->route('login');
// })->middleware(['guest:web']);

// URL::forceScheme('https');

