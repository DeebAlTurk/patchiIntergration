<?php

use App\Http\Controllers\Admin\adminOrdersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
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
//    $pdf = PDF::loadView('pdfs.delivery');
//    return $pdf->download('pdfview.pdf');
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', ['orders' => Auth::user()->orders()->orderBy('created_at', 'desc')->get()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/orders', OrdersController::class);
});

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin'], function () {
    Route::get('/orders/export', [adminOrdersController::class, 'export'])->name('voyager.orders.export')->middleware('admin.user');
    Voyager::routes();
});
