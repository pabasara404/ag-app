<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{vue_capture?}', function() {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');

// routes/web.php

Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

//Route::post('/password/reset', [PasswordResetController::class, 'reset'])
//    ->name('password.update');
