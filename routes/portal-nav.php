<?php
use App\Models\acc_details;
use Illuminate\Support\Facades\Route;
use App\models\Employee; 
use App\models\emergency;
use App\Models\provincial_contact;
use App\Models\dependencies; 
use App\Models\tags; 



use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PortalController;
use App\Http\Controllers\PortalPages; 
use App\Http\Controllers\DependencyController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\FilingController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PendingController;  
use App\Http\Controllers\ResPub;
use App\Http\Controllers\TrainingsController;
use App\Models\Employment;
use App\Models\HiringHistory;
use App\Models\Licenses;
use App\Models\Loads;
use App\Models\orgs;
use App\Models\semconfig;
use App\Models\Trainings;
use League\Flysystem\PortableVisibilityGuard;

use Illuminate\Support\Str;



Route::middleware('auth')->group(function(){
    
    //Route for the Profile Page
    Route::get('/hau_ep/profile', function() {
        $userId = Auth::user()->id; 

        $userInfo = Employee::where('emp_id', $userId)->first();
 
        return view('portal.profile', ['data'=>$userInfo]); 
    })->name('portal.profile'); 

    
   /********************** DEPENDENCIES  */
    Route::get('/hau_ep/dependencies', [DependencyController::class, 'loadDependencies']
    )->name('portal.dependencies'); 
    Route::get('/hau_ep/dependencies/s',[DependencyController::class,  'searchDependency'])->name('portal.dependencies.search'); 
    Route::get('/hau_ep/dependencies/add',[DependencyController::class, 'loadAdd'])->name('portal.dependencies.add');
    Route::get('hau_ep/dependencies/edit/{id}', [DependencyController::class, 'loadEdit'])-> name('portal.dependencies.edit'); 

    Route::get('hau_ep/dependencies/view/{id}', [DependencyController::class, 'viewItem'])->name('portal.dependencies.view'); 
    
    Route::post('/hau_ep/dependencies/add',[DependencyController::class, 'addDependent'])-> name('portal.dependencies.addnew');
    
    Route::delete('/hau_ep/dependencies/del/{dep_id}', [DependencyController::class, 'destroy'])-> name('portal.dependencies.delete');
    Route::delete('/hau_ep/dependencies/del', [DependencyController::class, 'clearAll'])-> name('portal.dependencies.clear') ;
    
    Route::put('hau_ep/dependencies/update/{id}', [DependencyController::class, 'updateDependent'])->name('portal.dependencies.update'); 

    /*****************************************************/ 
     
    /*************************** EMPLOYMENTS *************/
    Route::get('hau_ep/employment-history', function() { 
        // $data = Employment::where('emp_id', Auth::user()-> id)->where('status','Approved') ->  get(); 

        $approved=  Employment::where([
            'emp_id'=> Auth::user()->id, 
            'status'=> 'Approved' 
        ])->get();

        $pending=  Employment::where([
            'emp_id'=> Auth::user()->id, 
            'status'=> 'Pending' 
        ])->get();

        $toreview=  Employment::where([
            'emp_id'=> Auth::user()->id, 
            'status'=> 'To-review' 
        ])->get();


        return view('portal.pages.employments.main')->with([
            'approved'=> $approved,
            'pending'=> $pending, 
            'toreview'=> $toreview, 
            'user'=> Employee::Where('emp_id', Auth::user()->id)->first() ,
            'msg' => Str::length(session('msg')) > 0 ? session('msg') : null,
        ]); 
    })-> name('portal.employment'); 

    Route::get('hau_ep/employment-history/edit/{id}', function($id) { 
        return view('portal.pages.employments.edit')->with([
            'data'=> Employment::where('id', $id)->first()
        ]);
    })->name('portal.employment.edit'); 

    Route::put('hau_ep/employment-history/update/{id}', [EmploymentController::class, 'update'])->name('portal.employment.update'); 

    Route::get('hau_ep/employment-history/{id}', function($id) { 
        $data = Employment::where('id', $id)->first(); 
        return view('portal.pages.employments.view') -> with(['data'=> $data ]); 
    })-> name('portal.employment.view');

    Route::patch('hau_ep/employment-history/resubmit/{id}', [EmploymentController::class, 'resubmit'])-> name('portal.employment.resubmit'); 

    Route::delete('hau_ep/employment-history/delete/{id}' , [EmploymentController::class, 'destroy'])->name('portal.employment.delete'); 




 

   /********************** RESEARCH AND PUBLICATIONS  */
    Route::get('hau_ep/research-and-publications', [ResPub::class, 'create'])-> name('portal.respub');
    Route::get('hau_ep/research-and-publications/researches', [ResPub::class, 'createResearch'])-> name('portal.respub.research'); 
    Route::get('hau_ep/research-and-publications/publications', [ResPub::class, 'createPublications'])-> name('portal.respub.publications'); 
    Route::get('hau_ep/research-and-publications/approved', [ResPub::class, 'createApproved'])-> name('portal.respub.approved');      
    Route::get('hau_ep/research-and-publications/pending', [ResPub::class, 'createPending'])-> name('portal.respub.pending'); 
    Route::get('hau_ep/research-and-publications/toreview', [ResPub::class, 'createToreview'])-> name('portal.respub.toreview'); 

    Route::get('hau_ep/research-and-publications/add-new', [ResPub::class, 'createType'])-> name('portal.respub.type'); 

    Route::get('hau_ep/research-and-publications/add-new/research',[ResPub::class, 'loadResearch'])-> name('portal.respub.add.research'); 
    Route::get('hau_ep/research-and-publications/add-new/publication',[ResPub::class, 'loadPublication']) -> name('portal.respub.add.publication'); 

    Route::get('hau_ep/research-and-publications/add-new/success', function() {return view('portal.pages.respub.success');})-> name('portal.respub.success'); 
    Route::get('hau_ep/research-and-publications/edit/success', function() {return view('portal.pages.respub.edit_success');})-> name('portal.respub.edit_success'); 

    Route::get('hau_ep/research-and-publications/view/{id}', [ResPub::class, 'viewItem'])->name('portal.respub.view'); 
    Route::get('hau_ep/research-and-publications/edit/{id}', [ResPub::class, 'createEdit'])->name('portal.respub.edit'); 

    Route::put('hau_ep/research-and-publications/edit/{id}',[ResPub::class, 'editItem' ])->name('portal.respub.update'); 

    Route::post('hau_ep/research-and-publications/add', [ResPub::class, 'store'])->name('portal.respub.add'); 


    Route::delete('hau_ep/research-and-publications/delete/{id}', [ResPub::class, 'destroy'])-> name('portal.respub.delete');  


    /*****************************************************/ 


    /************************* TEACHING LOADS */
    Route::get('hau_ep/teaching-loads', function() { 

     

        // Get the latest created record

        $reg_cs = semconfig::where('id',1)->first(); // Retrieves the current sem
        $tri_cs = semconfig::where('id',2)-> first ();
        $loads = Loads::where('emp_id', Auth::user()->id)-> get(); 
        $regular_loads = Loads::where('emp_id', Auth::user()->id)->where('sy', $reg_cs->current_sy)->where('semester', $reg_cs->current_sem)->get();
        $trisem_loads = Loads::where('emp_id', Auth::user()->id)-> where('sy', $tri_cs-> current_sy)->where('semester', $tri_cs->current_sem)->get(); 

        $sem_units= 0;
        if($regular_loads->count() > 0) { 

            foreach($regular_loads as $i) { 
                $sem_units+=$i->subject->units;
            }
        }


        $tri_units= 0;
        if($trisem_loads->count() > 0) { 

            foreach($trisem_loads as $i) { 
                $tri_units+=$i->subject->units;
            }
        }
        $user= Employee::where('emp_id', Auth::user()-> id)->get()-> first(); 
        return view('portal.loads')-> with(['loads'=> $loads, 'user'=> $user, 'regular_loads'=> $regular_loads, 'trisem_loads'=> $trisem_loads, 's_units'=> $sem_units, 't_units'=> $tri_units, 'sy'=> $reg_cs, 't_sy'=> $tri_cs]); 
    })-> name('portal.loads'); 

     


    /************************* ORGANIZATION MEMBERSHIPS */
    Route::get('hau_ep/organization-memberships',[OrgController::class, 'create'])-> name('portal.org'); 
    Route::get('hau_ep/organization-memberships/add', [OrgController::class, 'create_add'])-> name('portal.org.add');

    Route::get('hau_ep/organization-memberships/edit/{user}/{id}', [OrgController::class, 'create_edit']) -> name('portal.org.edit'); 

    Route::put('hau_ep/organization-memberships/update/{id}', [OrgController::class, 'update'])-> name('portal.org.update'); 
    Route::post('hau_ep/organization-memberships/store', [OrgController::class, 'store'])-> name('portal.org.store'); 
    Route::delete('hau_ep/organization-memberships/delete', [OrgController::class, 'destroy'])-> name('portal.org.delete'); 
    Route::delete('hau_ep/organization-memberships/clear', function() { 
        orgs::where('emp_id', Auth::user()->id)-> delete(); 
        return redirect()-> route('portal.org')-> with(['msg'=> "All records deleted."]);
    })-> name('portal.org.clear'); 
 
    /***************** LICENSES  **************/

    Route::get('hau_ep/licenses', function() { 
        return view('portal.pages.license.main')->with([
            "approved"=> Licenses::where('emp_id', Auth::user()->id)->where('status', 'Approved')->orderBy('date_obtained', 'desc')->get(),
            "pending" =>  Licenses::where('status', 'Pending')-> orderBy('date_obtained', 'desc')-> get(), 
            "toreview" => Licenses::where('status','To-review')->orderBy('date_obtained', 'desc') -> get()
        ]); 

    })->name('portal.license'); 

    Route::get('hau_ep/licenses/{id}', function($id) { 
        return view('portal.pages.license.view')->with([
            'data'=> Licenses::where('id', $id)->first()
        ]) ;
    })->name('portal.license.view');

    Route::get('hau_ep/license/edit/{id}', function($id) { 
        return view('portal.pages.license.edit')->with([ 
            'data' => Licenses::where('id', $id)-> first(),
            'license_types'=> tags::where('category', 'license_type')->get()

        ]);
    })->name('portal.license.edit'); 
    
    Route::put('hau_ep/license/update/{id}', [LicenseController::class, 'update'])->name ('portal.license.update');
    Route::delete('hau_ep/licenses/delete/{id}' , [LicenseController::class, 'destroy'])->name('portal.license.delete'); 
    Route::patch('hau_ep/licenses/resubmit/{id}', [LicenseController::class, 'resubmit'])->name('portal.license.resubmit'); 




    /*****
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    /*********   TRAININGS  ************************************/
 
    Route::get('hau_ep/trainings/', function() { 
        $approved = Trainings::where('emp_id', Auth::user()->id)->where('status', 'Approved')
        ->orderBy('created_at', 'asc')-> get(); 

        $pending = Trainings::where('emp_id', Auth::user()->id)->where('status', 'Pending')
        ->orderBy('created_at', 'asc')-> get(); 

        $toreview = Trainings::where('emp_id', Auth::user()->id)->where('status', 'To-review')
        ->orderBy('created_at', 'asc')-> get(); 

    
        $items = Trainings::where('emp_id', Auth::user()->id)-> get ();
        
        return view('portal.pages.trainings.main')->with([ 
            'user'=> Employee::where('emp_id' , Auth::user()->id)->first(), 
            'items'=> $items,
            'approved'=> $approved, 
            'pending'=> $pending, 
            'toreview' => $toreview
        ]);    
    })-> name('portal.training'); 

    Route::get('hau_ep/trainings/{id}', function($id) { 
        return view('portal.pages.trainings.view')->with([ 
            'data'=> Trainings::where ('id', $id)-> first()
        ]); 
    })->name('portal.training.view');

    Route::get('hau_ep/trainings/edit/{id}', function($id) { 
        return view ( 'portal.pages.trainings.edit')-> with([
            'training_types'=> tags::where('category', 'training_type')->get(),  
            'data'=> Trainings::where('id' ,$id)-> first() 
        ]);
    })-> name('portal.training.edit'); 


    Route::put('hau_ep/trainings/update/{id}', [TrainingsController::class, 'update'])-> name('portal.training.update'); 
    Route::delete('hau_ep/trainings/del/{id}', [TrainingsController::class, 'destroy'])-> name('portal.training.delete'); 

    Route::patch('hau_ep/trainings/resubmit/{id}',[TrainingsController::class, 'resubmit'])-> name('portal.training.resubmit'); 


      /*****
     * ff
     * 
     * 
     * 
     * 
     * 
     * 
     */
    /*********   HIRING HISTORY  ************************************/
    Route::get('hau_ep/hiring-history',function() { 
        return view('portal.pages.hiring.main')->with([ 
            'hirings'=> HiringHistory::where('emp_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
            'user'=> Employee::where('emp_id' , Auth::user()->id)->first()
        ]);
    })->name('portal.hiring');


}); 









?> 