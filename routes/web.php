<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UpdatesController;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
}) -> name ('home');






Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        $userInfo = Employee::where('emp_id' ,Auth::user()->id)->first(); 
        return view('dashboard')-> with(['userInfo'=> $userInfo]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/profile-update.php';
require __DIR__.'/portal-nav.php'; 
require __DIR__.'/viewRoutes.php'; 
require __DIR__.'/requests.php';
require __DIR__.'/certifications.php';  
require __DIR__.'/admin.php'; 
require __DIR__.'/admin_pendings.php'; 
require __DIR__.'/respub-route.php'; 

//temp
require __DIR__.'/temp.php'; 