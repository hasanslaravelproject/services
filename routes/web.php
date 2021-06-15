<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\MeasureUnitController;
use App\Http\Controllers\PackageTypeController;
use App\Http\Controllers\RawProductStockController;
use App\Http\Controllers\FinishedProductStockController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource('deliveries', DeliveryController::class);
        Route::resource('measure-units', MeasureUnitController::class);
        Route::resource(
            'finished-product-stocks',
            FinishedProductStockController::class
        );
        Route::resource('productions', ProductionController::class);
        Route::resource('raw-product-stocks', RawProductStockController::class);
        Route::resource('ingredients', IngredientController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('package-types', PackageTypeController::class);
        Route::resource('packages', PackageController::class);
        Route::get('show/package',[PackageController::class,'showPackage'])->name('show.package');
        Route::get('package/{id}',[PackageController::class,'checkout'])->name('package.checkout');
        Route::post('buy/package/',[PackageController::class,'buyPackage'])->name('buy.package');
            Route::get('settings', [SettingController::class,'index'])->name('setting');
            Route::put('stripe/settings', [SettingController::class,'saveStripeCredentials'])->name('stripe.setting');
    
    Route::get('transactions', [
        TransactionController::class,
        'index',
    ])->name('transactions.index');
    Route::post('transactions', [
        TransactionController::class,
        'store',
    ])->name('transactions.store');
    Route::get('transactions/create', [
        TransactionController::class,
        'create',
    ])->name('transactions.create');
    Route::get('transactions/{transaction}', [
        TransactionController::class,
        'show',
    ])->name('transactions.show');
    Route::get('transactions/{transaction}/edit', [
        TransactionController::class,
        'edit',
    ])->name('transactions.edit');
    Route::put('transactions/{transaction}', [
        TransactionController::class,
        'update',
    ])->name('transactions.update');
    Route::delete('transactions/{transaction}', [
        TransactionController::class,
        'destroy',
    ])->name('transactions.destroy');

    Route::get('abc', [
        TransactionController::class,
        'abc',
    ])->name('transactions.abc');

    });
