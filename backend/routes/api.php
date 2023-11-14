<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CtaContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MethadologyController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnologyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//! SERVIES
Route::get('/service', [ServiceController::class, 'service'])->name('service');
Route::get('/service', [ServiceController::class, 'showservice'])->name('service');
Route::get('/show-service', [ServiceController::class, 'showService'])->name('show-service');
//add service
Route::get('/service/create', [ServiceController::class, 'create'])->name('service-create');
//edit service
Route::get('service/{id}/edit', [ServiceController::class, 'edit'])->name('service-edit');

//! CAREER
// show career
Route::get('/career', [CareerController::class, 'career'])->name('career');
Route::get('/career', [CareerController::class, 'showcareer'])->name('career');
Route::get('/show-career', [CareerController::class, 'showCareer'])->name('show-career');
// Add career
Route::get('/career/create', [CareerController::class, 'create'])->name('career-create');
// edit & update career
Route::get('career/{id}/edit', [CareerController::class, 'edit'])->name('career-edit');



        Route::get('/career/{id}/edit', [CareerController::class, 'edit'])->name('career-edit');
        Route::get('/career/jobQualification', [JobQualificationController::class, 'getJobQualification'])->name('career.get-jobQualification');
        Route::get('/career/jobQualification/add', [JobQualificationController::class, 'addJobQualification'])->name('career.add-jobQualification');
        Route::get('/pages', [PagesController::class, 'pagesShow'])->name('pages');
        Route::get('/page/about', [PagesController::class, 'previewAbout'])->name('preview-about');
        Route::get('/page/home', [PagesController::class, 'previewHome'])->name('preview-home');
        Route::get('/page/service', [PagesController::class, 'previewService'])->name('service-pages.index');
        Route::get('/adminpanel/todolist', [ToDoListController::class, 'getToDoList'])->name('todolist.index');
        Route::get('/adminpanel/todolist/{todolist}/edit', [ToDoListController::class, 'editToDoList'])->name('adminpanel.todolist.edit');
        Route::get('/user', [UserController::class, 'user'])->name('user');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/register', [RegisterController::class, 'registerpage'])->name('register');







// Service Page
Route::get('/service-pages', [ServiceController::class, 'getServicePages']);

// Top Service
Route::get('/top-services', [ServiceController::class, 'getTopServices']);

// Start Year End Year Portfolio
Route::get('/start-end-year', [PortofolioController::class, 'getStartEndYear']);

// Portofolio
Route::get('/portofolio', [PortofolioController::class, 'getPortofolio']);

// Success Portofolio
Route::get('/success-portofolio', [PortofolioController::class, 'getSuccessPortofolio']);

// latest portofolio
Route::get('/portofolios/latest', [PortofolioController::class, 'getLatestPortfolios']);

// Detail portofolio
Route::get('/portofolio/{id}', [PortofolioController::class, 'getPortfolioById']);

// Methodology
Route::get('/methodology', [MethadologyController::class, 'getMethadology']);
Route::get('/methodology/by-category', [MethadologyController::class, 'getMethadologyByCategory']);

// Technology
Route::get('/technologies/by-category', [TechnologyController::class, 'getTechnologiesByCategory']);
Route::get('/technologies', [TechnologyController::class, 'getTechnologies']);

// Product
Route::get('/products', [ProductController::class, 'getProduct']);

// Home
Route::get('home', [HomeController::class, 'getHome']);

// CTA_Contact
Route::get('/cta-contacts', [CtaContactController::class, 'getCtaContacts']);

// About
Route::get('/about', [AboutController::class, 'getAbout']);

// Blog
Route::get('/blog', [BlogController::class, 'getBlog']);

// Detail Blog
Route::get('/blog/{id}', [BlogController::class, 'getBlogById']);

// Blog page
Route::get('/blog-pages', [BlogController::class, 'getBlogPages']);

//Latest Blog
Route::get('/blog-latest', [BlogController::class, 'getLatestBlog']);

// Career Page
Route::get('/career-page', [CareerController::class, 'getCareerPage']);

// Career
Route::get('/career', [CareerController::class, 'getCareer']);
