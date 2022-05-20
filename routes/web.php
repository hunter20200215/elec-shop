<?php

use App\Http\Controllers\Backend\AttributesController;
use App\Http\Controllers\Backend\AttributeValuesController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\ImagesController;
use App\Http\Controllers\Backend\ModelImageController;
use App\Http\Controllers\Backend\OrdersController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Frontend\HomeController as FrontHomeController ;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::middleware('verified')->group(function () {
        Route::prefix('admin')->namespace('Backend')->name('admin.')->group(function () {

            Route::middleware('permission:access-admin')->group(function () {
                Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
                Route::get('/', function () {
                    return redirect()->route('admin.dashboard');
                });
            });

            Route::middleware('permission:manage-users')->group(function () {
                Route::prefix('users')->name('users.')->group(function () {
                    Route::get('/', [UsersController::class, 'index'])->name('index');
                    Route::get('create', [UsersController::class, 'create'])->name('create');
                    Route::post('create', [UsersController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [UsersController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [UsersController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [UsersController::class, 'destroy'])->name('destroy');
                });
            });

            Route::middleware('permission:manage-roles')->group(function () {
                Route::prefix('roles')->name('roles.')->group(function () {
                    Route::get('/', [RolesController::class, 'index'])->name('index');
                    Route::get('create', [RolesController::class, 'create'])->name('create');
                    Route::post('create', [RolesController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [RolesController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [RolesController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [RolesController::class, 'destroy'])->name('destroy');
                });
            });

            Route::middleware('permission:manage-permissions')->group(function () {
                Route::prefix('permissions')->name('permissions.')->group(function () {
                    Route::get('/', [PermissionsController::class, 'index'])->name('index');
                    Route::get('create', [PermissionsController::class, 'create'])->name('create');
                    Route::post('create', [PermissionsController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [PermissionsController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [PermissionsController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [PermissionsController::class, 'destroy'])->name('destroy');
                });
            });

            Route::middleware('permission:manage-categories')->group(function () {
                Route::prefix('categories')->name('categories.')->group(function () {
                    Route::get('/', [CategoriesController::class, 'index'])->name('index');
                    Route::get('create', [CategoriesController::class, 'create'])->name('create');
                    Route::post('create', [CategoriesController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [CategoriesController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
                });
            });


            Route::middleware('permission:manage-attributes')->group(function () {
                Route::prefix('attributes')->name('attributes.')->group(function () {
                    Route::get('/', [AttributesController::class, 'index'])->name('index');
                    Route::get('create', [AttributesController::class, 'create'])->name('create');
                    Route::post('create', [AttributesController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [AttributesController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [AttributesController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [AttributesController::class, 'destroy'])->name('destroy');
                });
            });

            Route::middleware('permission:manage-attribute-values')->group(function () {
                Route::prefix('attribute/{attribute_id}/attribute-values')->name('attribute_values.')->group(function () {
                    Route::get('/', [AttributeValuesController::class, 'index'])->name('index');
                    Route::get('create', [AttributeValuesController::class, 'create'])->name('create');
                    Route::post('create', [AttributeValuesController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [AttributeValuesController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [AttributeValuesController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [AttributeValuesController::class, 'destroy'])->name('destroy');
                });
            });

            Route::middleware('permission:manage-products')->group(function () {
                Route::prefix('products')->name('products.')->group(function () {
                    Route::get('/', [ProductsController::class, 'index'])->name('index');
                    Route::get('stockroom', [ProductsController::class, 'products_stockroom'])->name('stockroom');
                    Route::get('create', [ProductsController::class, 'create'])->name('create');
                    Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('edit');
                    Route::post('edit/{id}', [ProductsController::class, 'update'])->name('update');
                    Route::post('destroy/{id}', [ProductsController::class, 'destroy'])->name('destroy');
                    Route::post('copy/{id}', [ProductsController::class, 'copy'])->name('copy');
                });
            });

            Route::middleware('permission:manage-pages')->group(function () {
                Route::prefix('pages')->name('pages.')->group(function () {
                    Route::get('/', [PagesController::class, 'index'])->name('index');
                    Route::get('create', [PagesController::class, 'create'])->name('create');
                    Route::post('create', [PagesController::class, 'store'])->name('store');
                    Route::get('edit/{page}', [PagesController::class, 'edit'])->name('edit');
                    Route::post('edit/{page}', [PagesController::class, 'update'])->name('update');
                    Route::post('destroy/{page}', [PagesController::class, 'destroy'])->name('destroy');
                    Route::post('background-image/upload', [PagesController::class, 'change_background_image'])->name('change_background_image');
                });
            });

            Route::middleware('permission:manage-orders')->group(function () {
                Route::prefix('orders')->name('orders.')->group(function () {
                    Route::get('/', [OrdersController::class, 'index'])->name('index');
                    Route::post('destroy/{id}', [OrdersController::class, 'destroy'])->name('destroy');
                    Route::post('status/change', [OrdersController::class, 'change_status'])->name('change_status');
                });
            });

            Route::middleware('permission:manage-media')->group(function () {
                Route::prefix('media')->name('media.')->group(function () {
                    Route::get('/', [ImagesController::class, 'index'])->name('index');
                    Route::get('gallery', [ImagesController::class, 'load_gallery'])->name('gallery');

                    Route::prefix('images')->name('images.')->group(function () {
                        Route::post('upload', [ImagesController::class, 'store'])->name('store');
                        Route::get('destroy/{id}', [ImagesController::class, 'destroy'])->name('destroy');
                        Route::get('get-images', [ImagesController::class, 'get_images'])->name('get_images');
                        Route::get('load', [ImagesController::class, 'load_by_ids'])->name('load');
                    });

                    Route::prefix('model-images')->name('model_images.')->group(function () {
                        Route::post('store', [ModelImageController::class , 'store'])->name('store');
                        Route::get('destroy', [ModelImageController::class, 'destroy'])->name('destroy');
                    });
                });
            });

            Route::middleware('permission:manage-settings')->group(function () {
                Route::prefix('settings')->name('settings.')->group(function () {
                    Route::get('/', [SettingsController::class, 'index'])->name('index');
                    Route::post('/', [SettingsController::class, 'update'])->name('update');
                    Route::post('/logo-upload', [SettingsController::class, 'logo_upload'])->name('logo_upload');
                });
            });
        });
    });
});

require __DIR__.'/auth.php';

Route::namespace('Frontend')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::middleware('verified')->group(function () {
            Route::name('payments.')->group(function () {
                Route::post('handle-payment', [PaymentController::class, 'handle_payment'])->name('pay');
                Route::get('cancel-payment', [PaymentController::class, 'cancel_payment'])->name('cancel');
                Route::get('post-payment', [PaymentController::class, 'post_payment'])->name('post_payment');
                Route::get('payment-success', [PaymentController::class, 'payment_success'])->name('success');
                Route::get('payment-error', [PaymentController::class, 'payment_success'])->name('error');
            });

            Route::get('my-account', [FrontHomeController::class, 'my_account'])->name('my_account');
            Route::post('my-account', [FrontHomeController::class, 'update_my_account'])->name('update_my_account');
            Route::get('my-orders', [FrontHomeController::class, 'my_orders'])->name('my_orders');
        });
    });


    Route::get('/', [FrontHomeController::class, 'index'])->name('index');
    Route::get('/trending', [FrontHomeController::class, 'index'])->name('trending');

    Route::get('cart', [CartController::class, 'index'])->name('cart');

    Route::name('cart.')->prefix('cart')->group(function () {
        Route::name('items.')->prefix('items')->group(function () {
            Route::post('add', [CartController::class, 'add_item'])->name('add');
            Route::post('remove', [CartController::class, 'remove_item'])->name('remove');
            Route::post('change-quantity', [CartController::class, 'change_item_quantity'])->name('change_quantity');
            Route::post('render', [CartController::class, 'render_logged_out_cart'])->name('render');
        });
    });

    Route::get('unsubscribe', [FrontHomeController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('unsubscribe', [FrontHomeController::class, 'unsubscribe_post']);
    /*Route::get('about-us', [FrontHomeController::class, 'about_us'])->name('about_us');*/
    Route::get('contact-us', [FrontHomeController::class, 'contact_us'])->name('contact_us');
    Route::post('contact-us', [FrontHomeController::class, 'contact_us_post']);
    Route::get('{page:slug}', [FrontHomeController::class, 'page'])->name('page');
    Route::get('product/{product:id}/{slug}', [FrontHomeController::class, 'product'])->name('product');
});

