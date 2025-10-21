use App\Http\Controllers\AllowanceController;

Route::get('/allowance', [AllowanceController::class, 'index'])->name('allowance.index');
