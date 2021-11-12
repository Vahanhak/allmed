<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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

    if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'operator') {
        return redirect('/operator');
    }
    elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'doctor') {
        return redirect('/dashboard/doctor');
    }
    elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'nurse') {
        return redirect('/nurse');
    }
    elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'admin') {
        return redirect('/admin');
    }

    return view('login');
});

Route::get('/logout', function () {
    unset($_COOKIE['user_id']);
    unset($_COOKIE['user_role']);
    setcookie('user_id', null, -1);
    setcookie('user_role', null, -1);
    return redirect('/');
});

Route::any('/login', [MemberController::class, 'login']);
Route::get('/edit/{id}', [MemberController::class, 'edit']);
Route::post('/edit/{id}', [MemberController::class, 'update']);
Route::get('/admin', [MemberController::class, 'index']);
Route::get('/nurse/{c?}', [MemberController::class, 'nurse']);
Route::any('/doctor/{id?}', [MemberController::class, 'doctor']);
Route::get('/history', [MemberController::class, 'history']);
Route::post('/history/month', [MemberController::class, 'history_month']);
Route::post('/history/day', [MemberController::class, 'history_day']);
Route::any('/dashboard/doctor', [MemberController::class, 'dashboard']);
Route::get('/operator/add/route/sheet', [MemberController::class, 'add_route_sheet']);
Route::get('/operator/edit/route/sheet/{id}', [MemberController::class, 'edit_route_sheet']);
Route::post('/operator/edit/route/sheet/{id}', [MemberController::class, 'edit_route_sheet_update']);
Route::post('/operator/add/route/sheet', [MemberController::class, 'add_route_sheet_form']);
Route::get('/operator/route/sheet/{c?}', [MemberController::class, 'route_sheet']);
Route::get('/operator/{c?}', [MemberController::class, 'operator']);
Route::post('/export-file', [MemberController::class, 'exportFile'])->name('export-file');
Route::get('/ajax/application_management', [MemberController::class, 'application_management']);
Route::post('/ajax/application_status', [MemberController::class, 'application_status']);
Route::post('/ajax/application_statuses', [MemberController::class, 'application_statuses']);
