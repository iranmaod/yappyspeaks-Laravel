<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryDataController;
use App\Http\Controllers\BackgroundManagementController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DocusignController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [FrontController::class, 'index'])->name('index');



Route::get('/login', function () {
    if(Auth::user()){
        if(Auth::user()->role_as == 1){
            return redirect('admin');
        }
    }else{
        return view('auth.login');
    }
});

Route::get('docusign',[DocusignController::class, 'index'])->name('docusign');
Route::get('connect-docusign',[DocusignController::class, 'connectDocusign'])->name('connect.docusign');
Route::get('docusign/callback',[DocusignController::class,'callback'])->name('docusign.callback');
Route::get('sign-document',[DocusignController::class,'signDocument'])->name('docusign.sign');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Admin routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('admin', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/setting', [AdminController::class, 'setting'])->name('setting');
    Route::post('/admin/edit_setting', [AdminController::class, 'editSetting'])->name('settings.edit');

    Route::resource('category-data', CategoryDataController::class);

    Route::get('/category-data/add/{id?}', [CategoryDataController::class, 'addData'])->name('category-data.add');

    Route::get('/category/variations/{id?}', [CategoryDataController::class, 'viewVariations'])->name('category.variations');

    Route::get('/variations/import', [CategoryDataController::class, 'ImportVar'])->name('variations.import');
    Route::post('import', [CategoryDataController::class, 'Import'])->name('import');

    Route::resource('category', CategoryController::class);
    Route::get('/categories/{id?}', [CategoryController::class, 'index'])->name('categories.all');

    Route::resource('background', BackgroundManagementController::class);
    Route::get('backgrounds/{id?}', [BackgroundManagementController::class, 'viewBackgrounds'])->name('category.backgrounds');
    Route::get('/backgrounds/add/{id?}', [BackgroundManagementController::class, 'addBg'])->name('backgrounds.add');
});

Route::get('/{category_slug?}', [FrontController::class, 'catSlug'])->name('index.slug');



