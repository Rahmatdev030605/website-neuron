<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\MethadologyController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\ToDoListController;
use App\Http\Controllers\JobQualificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Register\RegisterController;
use App\Models\About;

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
    return view('login.login');
})->name('login');

Route::get('/login', [AuthController::class, 'loginpage']);
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/adminpanel', [AuthController::class, 'adminpanel'])->name('adminpanel');
    Route::get('/refresh-token', [AuthController::class, 'refreshToken'])->name('refresh-token');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    // change password
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('post-change-password');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    // show career
    Route::get('/career', [CareerController::class, 'career'])->name('career');
    Route::get('/career', [CareerController::class, 'showcareer'])->name('career');
    Route::get('/show-career', [CareerController::class, 'showCareer'])->name('show-career');
    // delete skill in career
    Route::delete('/career/{career_id}/skill/{skill_id}', [CareerController::class, 'deleteSkill'])->name('delete-skill');
    // delete job plus value in career
    Route::delete('/career/{career_id}/plusValue/{plusvalue_id}', [CareerController::class, 'deletePlusValue'])->name('delete-plus-value');
    // edit job plus value in career
    Route::put('/careers/{career_id}/plusvalues/{plusvalue_id}', [CareerController::class, 'updatePlusValue'])->name('edit-plus-value');
    // edit skill in career
    Route::put('/careers/{career_id}/skills/{skill_id}', [CareerController::class, 'updateSkill'])->name('edit-skill');
    // Add career
    Route::get('/career/create', [CareerController::class, 'create'])->name('career-create');
    Route::post('/career/store', [CareerController::class, 'store'])->name('career-store');
    // Delete career
    Route::delete('/career/{id}', [CareerController::class, 'deletecareer'])->name('delete-career');
    // edit & update career
    Route::get('career/{id}/edit', [CareerController::class, 'edit'])->name('career-edit');
    Route::put('career/{id}/update', [CareerController::class, 'update'])->name('career-update');
    // add skiill blade edit
    Route::post('/career/{career_id}/add-skiill', [CareerController::class, 'addSkillEdit'])->name('career.add-skill');
    // add plus value blade edit
    Route::post('/career/{career_id}/add-plusValue', [CareerController::class, 'addPlusValueEdit'])->name('career.add-plusValue');
    // edit general job qualification
    Route::get('/career/jobQualification', [JobQualificationController::class, 'getJobQualification'])->name('career.get-jobQualification');
    // Route::get('/career/jobQualification', [JobQualificationController::class, 'showJobQualification'])->name('career.show-jobQualification');
    Route::delete('/career/jobQualification/delete/{id}', [JobQualificationController::class, 'deleteJobQualification'])->name('career.delete-jobQualification');
    Route::put('/career/jobQualification/{id}/update', [JobQualificationController::class, 'updateJobQualification'])->name('career.update-jobQualification');
    Route::get('/career/jobQualification/add', [JobQualificationController::class, 'addJobQualification'])->name('career.add-jobQualification');
    Route::post('/career/jobQualification/store', [JobQualificationController::class, 'storeJobQualification'])->name('career.store-jobQualification');
});

// hanya untuk user dengan role superadmin
Route::middleware(['auth', 'superadmin'])->group(function () {

    // show produk
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/product', [ProductController::class, 'showproduct'])->name('product');
    Route::get('/show-product', [ProductController::class, 'showProduct'])->name('show-product');

    // show methadology
    Route::get('/methadology', [MethadologyController::class, 'methadology'])->name('methadology');
    Route::get('/methadology', [MethadologyController::class, 'methadologyshow'])->name('methadology');
    Route::get('/show-methadology', [MethadologyController::class, 'showMethadology'])->name('show-methadology');
    // delete methadology
    Route::delete('/methadology/{id}', [MethadologyController::class, 'deleteMethadology'])->name('delete-methadology');
    // Add methadology
    Route::get('/methadology/create', [MethadologyController::class, 'create'])->name('create-methadology');
    Route::post('/methadology/store', [MethadologyController::class, 'store'])->name('store-methadology');
    // edit & update methadology
    Route::get('methadology/{id}/edit', [MethadologyController::class, 'edit'])->name('methadology-edit');
    Route::put('methadology/{id}/update', [MethadologyController::class, 'update'])->name('methadology-update');
    // show service
    Route::get('/service', [ServiceController::class, 'service'])->name('service');
    Route::get('/service', [ServiceController::class, 'showservice'])->name('service');
    Route::get('/show-service', [ServiceController::class, 'showService'])->name('show-service');
    // Delete service
    Route::delete('/service/{id}', [ServiceController::class, 'deleteService'])->name('delete-service');
    // Add Service
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service-create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service-store');
    // edit & update portofolio
    Route::get('service/{id}/edit', [ServiceController::class, 'edit'])->name('service-edit');
    Route::put('service/{id}/update', [ServiceController::class, 'update'])->name('service-update');
    // add keyfeature blade edit
    Route::post('/service/{services_id}/add-keyFeature', [ServiceController::class, 'addKeyFeatureEdit'])->name('keyfeature.add-deliverable');
    // delete keyfeature in portofolio
    Route::delete('/service/{services_id}/key-feature/{keyfeature_id}', [ServiceController::class, 'deleteKeyFeature'])->name('delete-keyFeature');

    // show blog
    Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
    Route::get('/blog', [BlogController::class, 'showblog'])->name('blog');
    Route::get('/show-blog', [BlogController::class, 'showBlog'])->name('show-blog');

    // show blog category
    Route::get('/blog-categories', [BlogCategoryController::class, 'blogcategories'])->name('blog-categories');
    Route::get('/blog-categories', [BlogCategoryController::class, 'blogcategoriesshow'])->name('blog-categories');
    Route::get('/show-blog-categories', [BlogCategoryController::class, 'blogCategoriesShow'])->name('show-blog-categories');
    // Add blog category
    Route::get('/blog-categories/create', [BlogCategoryController::class, 'create'])->name('create-blog-categories');
    Route::post('/blog-categories/store', [BlogCategoryController::class, 'store'])->name('store-blog-categories');
    // delete blog category
    Route::delete('/blog-category/{id}', [BlogCategoryController::class, 'deleteBlogCategory'])->name('delete-blog-categories');
    // edit & update blog category
    Route::get('blog-categories/{id}/edit', [BlogCategoryController::class, 'edit'])->name('blog-categories-edit');
    Route::put('blog-categories/{id}/update', [BlogCategoryController::class, 'update'])->name('blog-categories-update');
    // delete blog
    Route::delete('/blog/{id}', [BlogController::class, 'deleteBlog'])->name('delete-blog');
    // Add blog
    Route::get('/blog/create', [BlogController::class, 'create'])->name('create-blog');
    Route::post('/blog/store', [BlogController::class, 'store'])->name('store-blog');
    // View blog
    Route::get('/blog/{id}', [BlogController::class, 'viewBlog'])->name('view-blog');
    // edit & update blog
    Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blog-edit');
    Route::put('blog/{id}/update', [BlogController::class, 'update'])->name('blog-update');
    // edit & update product
    Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('product-edit');
    Route::put('product/{id}/update', [ProductController::class, 'update'])->name('product-update');
    // delete produk
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
    // Add Product
    Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product-store');
    // show portofolio
    Route::get('/portofolio', [PortofolioController::class, 'portofolio'])->name('portofolio');
    Route::get('/portofolio', [PortofolioController::class, 'showportofolio'])->name('portofolio');
    Route::get('/show-portofolio', [PortofolioController::class, 'showPortofolio'])->name('show-portofolio');
    // Delete portofolio
    Route::delete('/portofolio/{id}', [PortofolioController::class, 'deletePortofolio'])->name('delete-portofolio');
    // Add Portofolio
    Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio-create');
    Route::post('/portofolio/store', [PortofolioController::class, 'store'])->name('portofolio-store');
    // edit & update portofolio
    Route::get('portofolio/{id}/edit', [PortofolioController::class, 'edit'])->name('portofolio-edit');
    Route::put('portofolio/{id}/update', [PortofolioController::class, 'update'])->name('portofolio-update');
    // // User show
    // Route::get('/user', [UserController::class, 'user'])->name('user');
    // Route::get('/user', [UserController::class, 'showuser'])->name('user');
    // Route::get('/show-user', [UserController::class, 'showUser'])->name('show-user');
    // Route::delete('/user/{id}', [UserController::class, 'deleteUser'])->name('delete-user');
    // // edit & update data user
    // Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    // // Register
    // Route::get('/register', [RegisterController::class, 'registerpage'])->name('register');
    // Route::post('/postregister', [RegisterController::class, 'postregister'])->name('postregister');

    // show all pages
    Route::get('/pages', [PagesController::class, 'pagesShow'])->name('pages');
    // edit & update home page
    Route::get('/page/home', [PagesController::class, 'previewHome'])->name('preview-home');
    Route::put('/page/home/edit/{id}', [PagesController::class, 'editHome'])->name('edit-home');
    // edit & update about page
    Route::get('/page/about', [PagesController::class, 'previewAbout'])->name('preview-about');
    Route::put('/page/about/edit/{id}', [PagesController::class, 'editAbout'])->name('edit-about');
    // edit & update service page
    Route::get('/page/service', [PagesController::class, 'previewService'])->name('service-pages.index');
    Route::put('/page/service/edit/{id}', [PagesController::class, 'editService'])->name('page-settings.update');

    // show partner
    Route::get('/partner', [PartnerController::class, 'showPartner'])->name('partner');
    // store partner
    Route::post('/partner/store', [PartnerController::class, 'storePartner'])->name('partner-store');
    // edit and update partner
    Route::put('/partner/{id}/update', [PartnerController::class, 'updatePartner'])->name('partner-update');
    // delete partner
    Route::delete('/partner/{id}/delete', [PartnerController::class, 'deletePartner'])->name('partner-delete');

    // Show Todo List
    Route::get('/adminpanel/todolist', [ToDoListController::class, 'getToDoList'])->name('todolist.index');
    // add & store todo list
    Route::get('/adminpanel/todolist/create', [ToDoListController::class, 'addToDoList'])->name('adminpanel.todolist.create');
    Route::post('/adminpanel/todolist/store', [ToDoListController::class, 'storeToDoList'])->name('adminpanel.todolist.store');
    // edit & update todo list
    Route::put('/adminpanel/todolist/{todolist}', [ToDoListController::class, 'updateToDoList'])->name('adminpanel.todolist.update');
    Route::get('/adminpanel/todolist/{todolist}/edit', [ToDoListController::class, 'editToDoList'])->name('adminpanel.todolist.edit');
    // delete todo list
    Route::delete('/adminpanel/todolist/{todolist}', [ToDoListController::class, 'deleteToDoList'])->name('adminpanel.todolist.destroy');
});


Route::middleware(['auth', 'admin'])->group(function () {

    // User show
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/user', [UserController::class, 'showuser'])->name('user');
    Route::get('/show-user', [UserController::class, 'showUser'])->name('show-user');
    Route::delete('/user/{id}', [UserController::class, 'deleteUser'])->name('delete-user');
    // edit & update data user
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    // Register
    Route::get('/register', [RegisterController::class, 'registerpage'])->name('register');
    Route::post('/postregister', [RegisterController::class, 'postregister'])->name('postregister');
});
