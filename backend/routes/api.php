<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CtaContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MethadologyController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnologyController;
use App\Models\ArticleCategory;
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
// Service
Route::get('/services', [ServiceController::class, 'getServices']);
Route::get('/services/by-name', [ServiceController::class, 'getServicesByName']);

// Service Page
Route::get('/service-pages', [ServiceController::class, 'getServicePages']);

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

// Product
Route::get('/products', [ProductController::class, 'getProduct']);

// Home
Route::get('home', [HomeController::class, 'getHome']);

// About
Route::get('/about', [AboutController::class, 'getAbout']);

// Blog
Route::get('/blog', [BlogController::class, 'getBlog']);

// Category
Route::get('/blog-category', [BlogCategoryController::class, 'getArticleCategory']);

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
