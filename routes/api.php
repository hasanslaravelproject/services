<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserOrdersController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\MeasureUnitController;
use App\Http\Controllers\Api\UserPackagesController;
use App\Http\Controllers\Api\UserProductsController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\PackageUsersController;
use App\Http\Controllers\Api\ProductUsersController;
use App\Http\Controllers\Api\UserCompaniesController;
use App\Http\Controllers\Api\ProductOrdersController;
use App\Http\Controllers\Api\RawProductStockController;
use App\Http\Controllers\Api\CompanyPackagesController;
use App\Http\Controllers\Api\PackageProductsController;
use App\Http\Controllers\Api\OrderDeliveriesController;
use App\Http\Controllers\Api\ServiceCompaniesController;
use App\Http\Controllers\Api\CategoryProductsController;
use App\Http\Controllers\Api\IngredientProductsController;
use App\Http\Controllers\Api\ProductProductionsController;
use App\Http\Controllers\Api\ProductIngredientsController;
use App\Http\Controllers\Api\FinishedProductStockController;
use App\Http\Controllers\Api\ProductionDeliveriesController;
use App\Http\Controllers\Api\MeasureUnitIngredientsController;
use App\Http\Controllers\Api\IngredientRawProductStocksController;
use App\Http\Controllers\Api\ProductionFinishedProductStocksController;
use App\Http\Controllers\Api\FinishedProductStockFinishedProductStocksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Orders
        Route::get('/users/{user}/orders', [
            UserOrdersController::class,
            'index',
        ])->name('users.orders.index');
        Route::post('/users/{user}/orders', [
            UserOrdersController::class,
            'store',
        ])->name('users.orders.store');

        // User Packages
        Route::get('/users/{user}/packages', [
            UserPackagesController::class,
            'index',
        ])->name('users.packages.index');
        Route::post('/users/{user}/packages/{package}', [
            UserPackagesController::class,
            'store',
        ])->name('users.packages.store');
        Route::delete('/users/{user}/packages/{package}', [
            UserPackagesController::class,
            'destroy',
        ])->name('users.packages.destroy');

        // User Products
        Route::get('/users/{user}/products', [
            UserProductsController::class,
            'index',
        ])->name('users.products.index');
        Route::post('/users/{user}/products/{product}', [
            UserProductsController::class,
            'store',
        ])->name('users.products.store');
        Route::delete('/users/{user}/products/{product}', [
            UserProductsController::class,
            'destroy',
        ])->name('users.products.destroy');

        // User Companies
        Route::get('/users/{user}/companies', [
            UserCompaniesController::class,
            'index',
        ])->name('users.companies.index');
        Route::post('/users/{user}/companies/{company}', [
            UserCompaniesController::class,
            'store',
        ])->name('users.companies.store');
        Route::delete('/users/{user}/companies/{company}', [
            UserCompaniesController::class,
            'destroy',
        ])->name('users.companies.destroy');

        Route::apiResource('deliveries', DeliveryController::class);

        Route::apiResource('measure-units', MeasureUnitController::class);

        // MeasureUnit Ingredients
        Route::get('/measure-units/{measureUnit}/ingredients', [
            MeasureUnitIngredientsController::class,
            'index',
        ])->name('measure-units.ingredients.index');
        Route::post('/measure-units/{measureUnit}/ingredients', [
            MeasureUnitIngredientsController::class,
            'store',
        ])->name('measure-units.ingredients.store');

        Route::apiResource(
            'finished-product-stocks',
            FinishedProductStockController::class
        );

        // FinishedProductStock Finished Product Stocks
        Route::get(
            '/finished-product-stocks/{finishedProductStock}/finished-product-stocks',
            [
                FinishedProductStockFinishedProductStocksController::class,
                'index',
            ]
        )->name('finished-product-stocks.finished-product-stocks.index');
        Route::post(
            '/finished-product-stocks/{finishedProductStock}/finished-product-stocks',
            [
                FinishedProductStockFinishedProductStocksController::class,
                'store',
            ]
        )->name('finished-product-stocks.finished-product-stocks.store');

        Route::apiResource('productions', ProductionController::class);

        // Production Finished Product Stocks
        Route::get('/productions/{production}/finished-product-stocks', [
            ProductionFinishedProductStocksController::class,
            'index',
        ])->name('productions.finished-product-stocks.index');
        Route::post('/productions/{production}/finished-product-stocks', [
            ProductionFinishedProductStocksController::class,
            'store',
        ])->name('productions.finished-product-stocks.store');

        // Production Deliveries
        Route::get('/productions/{production}/deliveries', [
            ProductionDeliveriesController::class,
            'index',
        ])->name('productions.deliveries.index');
        Route::post('/productions/{production}/deliveries', [
            ProductionDeliveriesController::class,
            'store',
        ])->name('productions.deliveries.store');

        Route::apiResource(
            'raw-product-stocks',
            RawProductStockController::class
        );

        Route::apiResource('ingredients', IngredientController::class);

        // Ingredient Raw Product Stocks
        Route::get('/ingredients/{ingredient}/raw-product-stocks', [
            IngredientRawProductStocksController::class,
            'index',
        ])->name('ingredients.raw-product-stocks.index');
        Route::post('/ingredients/{ingredient}/raw-product-stocks', [
            IngredientRawProductStocksController::class,
            'store',
        ])->name('ingredients.raw-product-stocks.store');

        // Ingredient Products
        Route::get('/ingredients/{ingredient}/products', [
            IngredientProductsController::class,
            'index',
        ])->name('ingredients.products.index');
        Route::post('/ingredients/{ingredient}/products/{product}', [
            IngredientProductsController::class,
            'store',
        ])->name('ingredients.products.store');
        Route::delete('/ingredients/{ingredient}/products/{product}', [
            IngredientProductsController::class,
            'destroy',
        ])->name('ingredients.products.destroy');

        Route::apiResource('companies', CompanyController::class);

        // Company Packages
        Route::get('/companies/{company}/packages', [
            CompanyPackagesController::class,
            'index',
        ])->name('companies.packages.index');
        Route::post('/companies/{company}/packages', [
            CompanyPackagesController::class,
            'store',
        ])->name('companies.packages.store');

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users/{user}', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');
        Route::delete('/companies/{company}/users/{user}', [
            CompanyUsersController::class,
            'destroy',
        ])->name('companies.users.destroy');

        Route::apiResource('services', ServiceController::class);

        // Service Companies
        Route::get('/services/{service}/companies', [
            ServiceCompaniesController::class,
            'index',
        ])->name('services.companies.index');
        Route::post('/services/{service}/companies', [
            ServiceCompaniesController::class,
            'store',
        ])->name('services.companies.store');

        Route::apiResource('packages', PackageController::class);

        // Package Products
        Route::get('/packages/{package}/products', [
            PackageProductsController::class,
            'index',
        ])->name('packages.products.index');
        Route::post('/packages/{package}/products', [
            PackageProductsController::class,
            'store',
        ])->name('packages.products.store');

        // Package Users
        Route::get('/packages/{package}/users', [
            PackageUsersController::class,
            'index',
        ])->name('packages.users.index');
        Route::post('/packages/{package}/users/{user}', [
            PackageUsersController::class,
            'store',
        ])->name('packages.users.store');
        Route::delete('/packages/{package}/users/{user}', [
            PackageUsersController::class,
            'destroy',
        ])->name('packages.users.destroy');

        Route::apiResource('categories', CategoryController::class);

        // Category Products
        Route::get('/categories/{category}/products', [
            CategoryProductsController::class,
            'index',
        ])->name('categories.products.index');
        Route::post('/categories/{category}/products', [
            CategoryProductsController::class,
            'store',
        ])->name('categories.products.store');

        Route::apiResource('products', ProductController::class);

        // Product Productions
        Route::get('/products/{product}/productions', [
            ProductProductionsController::class,
            'index',
        ])->name('products.productions.index');
        Route::post('/products/{product}/productions', [
            ProductProductionsController::class,
            'store',
        ])->name('products.productions.store');

        // Product Orders
        Route::get('/products/{product}/orders', [
            ProductOrdersController::class,
            'index',
        ])->name('products.orders.index');
        Route::post('/products/{product}/orders', [
            ProductOrdersController::class,
            'store',
        ])->name('products.orders.store');

        // Product Ingredients
        Route::get('/products/{product}/ingredients', [
            ProductIngredientsController::class,
            'index',
        ])->name('products.ingredients.index');
        Route::post('/products/{product}/ingredients/{ingredient}', [
            ProductIngredientsController::class,
            'store',
        ])->name('products.ingredients.store');
        Route::delete('/products/{product}/ingredients/{ingredient}', [
            ProductIngredientsController::class,
            'destroy',
        ])->name('products.ingredients.destroy');

        // Product Users
        Route::get('/products/{product}/users', [
            ProductUsersController::class,
            'index',
        ])->name('products.users.index');
        Route::post('/products/{product}/users/{user}', [
            ProductUsersController::class,
            'store',
        ])->name('products.users.store');
        Route::delete('/products/{product}/users/{user}', [
            ProductUsersController::class,
            'destroy',
        ])->name('products.users.destroy');

        Route::apiResource('orders', OrderController::class);

        // Order Deliveries
        Route::get('/orders/{order}/deliveries', [
            OrderDeliveriesController::class,
            'index',
        ])->name('orders.deliveries.index');
        Route::post('/orders/{order}/deliveries', [
            OrderDeliveriesController::class,
            'store',
        ])->name('orders.deliveries.store');
    });
