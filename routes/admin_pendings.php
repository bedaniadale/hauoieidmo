<?php

use App\Http\Controllers\Admin\AdminPendingController;
use App\Http\Controllers\certificationController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PendingController;
use Illuminate\Support\Facades\Route;



Route::middleware(['admin'])->group(function() { 

        ////view certifications

        Route::get('admin/pendings', [AdminPendingController::class, 'loadPending'])->name('admin.pendings');


        Route::get('admin/review/{id}',[AdminPendingController::class, 'reviewItem'])->name('admin.pendings.view'); 



        //search bar
        Route::get('admin/pendings/search',[AdminPendingController::class, 'search'])-> name('admin.pendings.search');
        Route::get('admin/pendings/user',[PendingController::class, 'search'])-> name('admin.pendings.search2');

        Route::get('admin/pendings/search/id/',[AdminPendingController::class, 'loadSearch'])-> name('admin.pendings.loadsearch');


        //approving items
        Route::patch('admin/pendings/{id}/approve', [AdminPendingController::class, 'approveItem'])->name('admin.pendings.approved'); 


        //toreview items
        Route::patch('admin/pendings/{id}/toreview', [AdminPendingController::class, 'toreviewItem'])-> name('admin.pendings.toreview'); 
        

        });
?> 