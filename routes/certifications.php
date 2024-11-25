<?php

use App\Http\Controllers\certificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendingController; 
use App\Http\Controllers\FilingController;
use App\Models\certifications;
Route::middleware('auth')->group(function(){
    
//filing application
Route::get('hau_ep/certifications',[certificationController::class, 'create'])->name('portal.certifications'); 
Route::get('hau_ep/certifications/approved',[certificationController::class, 'createApproved'])->name('portal.certifications.approved'); 
Route::get('hau_ep/certifications/pending',[certificationController::class, 'createPending'])-> name('portal.certifications.pending'); 
Route::get('hau_ep/certifications/to-review',[certificationController::class, 'createToreview'])-> name('portal.certifications.toreview'); 
Route::get('hau_ep/certifications/{id}',[certificationController::class, 'viewItem'])->name('portal.certifications.view'); 

Route::get('hau_ep/certifications/resubmit/{id}', [ certificationController::class,'loadResubmit'])-> name('portal.certifications.resubmit'); 


Route::get('hau_ep/certifications/edit/{id}', [certificationController::class, 'edit'])-> name('portal.certifications.edit'); 
Route::post('hau_ep/certifications/submit/{id}', [certificationController::class, 'resubmit'])-> name('portal.certifications.resub'); 


Route::put('hau_ep/certifications/update/{id}', [certificationController::class, 'update'])-> name('portal.certifications.update');



Route::delete('hau_ep/certifications/del/{id}',[certificationController::class, 'destroy'])-> name('portal.certifications.delete'); 


});
?> 