<?php

use App\Http\Controllers\certificationController;
use App\Http\Controllers\EmploymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendingController; 
use App\Http\Controllers\FilingController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\TrainingsController;
use App\Models\Licenses;
use App\Models\tags;

use function Ramsey\Uuid\v1;

//filing application


Route::middleware('auth')->group(function () {
    Route::get('hau_ep/file-application/type', [FilingController::class, 'loadTypes']) -> name('portal.filing.type'); 

    Route::get('hau_ep/file-application/certification',[FilingController::class, 'loadCertification'])->name('portal.filing.certification');

    Route::get('hau_ep/file-applicaton/employment', function() { 
        return view('portal.pages.filing.employment');
    })-> name('portal.filing.employment');

    Route::get('hau_ep/file-application/license', function(){  

        return view('portal.pages.filing.license')->with([
            'license_types'=> tags::where('category', 'license_type')->get()
        ]); 
    })->name('portal.filing.license');

    Route::get('hau_ep/file-application/training', function()  {
        return view('portal.pages.filing.training')->with([ 
            'training_types'=> tags::where('category' ,'training_type')->get()
        ]);
    }) -> name('portal.filing.training'); 


    Route::get('hau_ep/file-application/success', [FilingController::class, 'loadSuccess'])-> name('portal.filing.success');


    //post methods
    Route::post('hau_ep/file-application/certification/add',[certificationController::class, 'store'])-> name('portal.filing.certification.add'); 
    Route::post('hau_ep/file-application/employment/add', [EmploymentController::class, 'store'])->name('portal.filing.employment.add');
    Route::post('hau_ep/file-application/license/add', [LicenseController::class, 'store'])-> name('portal.filing.license.add');

    Route::post('hau_ep/file-application/training/add', [TrainingsController::class, 'store'])-> name('portal.filing.training.add'); 



    //pending request 
    Route::get('hau_ep/pending-requests', [PendingController::class, 'create'])->name('portal.pending' ); 
    Route::get('hau_ep/pending-requests/{id}',[PendingController::class, 'viewInfo'])-> name('portal.pending.view');




    Route::delete('hau_ep/pending_requests/del/{id}',[PendingController::class, 'destroyRequest'])->name('portal.pending.delete'); 
    

}); 
?> 