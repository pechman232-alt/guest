
<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'km'], true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::get('/', [GuestController::class, 'dashboard'])->name('dashboard');

Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
Route::get('/guests/create', [GuestController::class, 'create'])->name('guests.create');
Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
Route::get('/guests/{guest}', [GuestController::class, 'show'])->name('guests.show');
Route::get('/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');

Route::post('/guests/{guest}/checkin', [GuestController::class, 'checkin'])->name('guests.checkin');
Route::delete('/guests/{guest}/checkin', [GuestController::class, 'undoCheckin'])->name('guests.checkin.undo');

Route::get('/reports', [GuestController::class, 'reports'])->name('reports.index');
Route::get('/reports/export.csv', [GuestController::class, 'exportCsv'])->name('reports.csv');
