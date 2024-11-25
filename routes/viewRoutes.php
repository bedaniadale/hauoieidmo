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
use App\Http\Controllers\ProfileController; 

use League\Flysystem\PortableVisibilityGuard;

//ALL OF THE REDIRECTION/VIEWS/NAVIGATION GOES HERE



    /*** VIEWS FOR THE EDITING OF THE PROFILE (EMPLOYEE PORTAL) */
Route::middleware('auth')->group(function () {
    //route for personal data
    Route::get('/hau_ep/profile/edit/personal-data', function() { 
        $gender_tags = tags::where('category', 'gender')-> get(); 
    
        return view('portal.profile-edit.edit')->with([
            'gender_tags'=> $gender_tags,
            'data'=> Employee::where('emp_id', Auth::user()->id)->first()
        ]);
    })-> name('portal.profile-edit-pd');
    
    //route for contact information
    Route::get('/hau_ep/profile/edit/contact-information',function() { 
        $data = Employee::where('emp_id',Auth::user()-> id)->first(); 
        return view('portal.profile-edit.edit')->with(['data'=> $data]);
    })-> name('portal.profile-edit-ci'); 
    
    //route for provincial contact
    Route::get('/hau_ep/profile/edit/provincial-contact', function() { 
        $data = Employee::where('emp_id', Auth::user()-> id)->first(); 

        return view('portal.profile-edit.edit')->with(['data'=> $data]); 
    })-> name('portal.profile-edit-pc');
    
    Route::get('/hau_ep/profile/edit/emergency',function() { 
        return view('portal.profile-edit.edit')->with([ 
            'data'=> Employee::where('emp_id', Auth::user()->id)->first()
        ]); 
    })-> name('portal.profile-edit-ei'); 
    
    Route::get('/hau_ep/profile/edit/accounting-details', function() { 
        $data = Employee::where('emp_id', Auth::user()-> id)->first(); 
        return view('portal.profile-edit.edit')->with(['data'=>$data]); 
    })-> name('portal.profile-edit-ad'); 




    /**** VIEW FOR THE PAGES OF SETTINGS */

    Route::get('profile/change-profile-picture', [ProfileController::class, 'changepic'])-> name('profile.changepic');


});

?> 
