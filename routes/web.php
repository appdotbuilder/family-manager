<?php

use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    if (auth()->check()) {
        // Show family dashboard for authenticated users
        $families = auth()->user()->families()
            ->with(['members', 'creator'])
            ->withCount('members')
            ->latest()
            ->get();

        return Inertia::render('dashboard', [
            'families' => $families
        ]);
    }
    
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $families = auth()->user()->families()
            ->with(['members', 'creator'])
            ->withCount('members')
            ->latest()
            ->get();

        return Inertia::render('dashboard', [
            'families' => $families
        ]);
    })->name('dashboard');

    // Family management routes
    Route::resource('families', FamilyController::class);
    
    // Family member routes (nested under family)
    Route::resource('families.members', FamilyMemberController::class, [
        'as' => 'family-members'
    ]);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
