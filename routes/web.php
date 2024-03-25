<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/stream-offer', [App\Http\Controllers\WebrtcStreamingController::class, 'makeStreamOffer']);
Route::post('/stream-answer',  [App\Http\Controllers\WebrtcStreamingController::class, 'makeStreamAnswer']);

Route::get('zoom', [App\Http\Controllers\ZoomController::class, 'index'])->name('zoom.index');

Route::get('zoom/create', [App\Http\Controllers\ZoomController::class, 'create'])->name('zoom.create');
Route::post('zoom/save', [App\Http\Controllers\ZoomController::class, 'store'])->name('zoom.store');
// Route::post('zoom/save', [App\Http\Controllers\ZoomController::class, 'store'])->name('zoom.show');

require __DIR__ . '/auth.php';
