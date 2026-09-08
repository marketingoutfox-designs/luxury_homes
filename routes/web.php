<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'home'])->name('home');
Route::get('/about-us', [PublicSiteController::class, 'about'])->name('about');
Route::get('/our-works', [PublicSiteController::class, 'works'])->name('works');
Route::get('/our-works/{project:slug}', [PublicSiteController::class, 'project'])->name('project');
Route::get('/services', [PublicSiteController::class, 'services'])->name('services');
Route::get('/contact-us', [PublicSiteController::class, 'contact'])->name('contact');
Route::post('/contact-us', [PublicSiteController::class, 'storeLead'])->name('leads.store');

Route::redirect('/login', '/admin/login')->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/project-categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/project-categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/project-categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/project-categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/project-categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/project-categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');

    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');

    Route::get('/content', [AdminController::class, 'contents'])->name('contents');
    Route::get('/content/create', [AdminController::class, 'createContent'])->name('contents.create');
    Route::post('/content', [AdminController::class, 'storeContent'])->name('contents.store');
    Route::get('/content/{content}/edit', [AdminController::class, 'editContent'])->name('contents.edit');
    Route::put('/content/{content}', [AdminController::class, 'updateContent'])->name('contents.update');
    Route::delete('/content/{content}', [AdminController::class, 'destroyContent'])->name('contents.destroy');

    Route::get('/leads', [AdminController::class, 'leads'])->name('leads');
    Route::get('/leads/{lead}/edit', [AdminController::class, 'editLead'])->name('leads.edit');
    Route::put('/leads/{lead}', [AdminController::class, 'updateLead'])->name('leads.update');
    Route::delete('/leads/{lead}', [AdminController::class, 'destroyLead'])->name('leads.destroy');
});
