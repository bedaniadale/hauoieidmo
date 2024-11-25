<?php

use App\Models\acc_details;
use Illuminate\Support\Facades\Route;
use App\Models\Employee; 
use App\Models\emergency;
use App\Models\provincial_contact;
use App\Models\dependencies; 
use App\Models\tags; 



use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PortalController;
use App\Http\Controllers\UpdatesController;
use League\Flysystem\PortableVisibilityGuard;
Route::middleware('auth')->group(function () {
    ///// ROUTES FOR THE UPDATE DETAILS IN THE PORTAL 
    Route::put('/hau_ep/profile/update/personal-data/{id}', [PortalController::class, 'updatePersonal'])-> name('portal.personal-data'); 
    Route::put('/hau_ep/profile/update/contact-information/{id}', [PortalController::class, 'updateContact'])-> name('portal.contact-information'); 
    Route::put('/hau_ep/profile/update/provincial-contact/{id}',
    [PortalController::class, 'updateProvincial'])-> name('portal.provincial-contact');
    Route::put('/hau_ep/profile/update/accounting-details/{id}',[PortalController::class, 'updateAccounting'])-> name('portal.accounting-details');
    Route::put('/hau_ep/profile/update/emergency/{id}',
    [PortalController::class, 'updateEmergency'])-> name ('portal.emergency');
    

    //ROUTE FOR UPDATING OF THE PROFILE PICTURE
    Route::put('/profile/update/change-picture/{id}', [UpdatesController::class, 'updatePic'])-> name('update-pic'); 




});
?> 
