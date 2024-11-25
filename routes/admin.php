<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminPendingController;
use App\Http\Controllers\AdminOrgController;
use App\Http\Controllers\certificationController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\HiringHistoryController;
use App\Http\Controllers\IssueCertController;
use App\Http\Controllers\LoadsController;
use App\Http\Controllers\LoadsImportController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\UserRecordsController;
use App\Http\Controllers\UserTerminationController;
use App\Models\certifications;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\excelfile;
use App\Models\HAUCert;
use App\Models\HiringInfo;
use App\Models\Loads;
use App\Models\LoadsImport;
use App\Models\semconfig;
use App\Models\Subjects;
use App\Models\tags;
use App\Models\temp_subjects;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Event\TestSuite\Loaded;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Runner\Baseline\Issue;

    function updated_date($date) { 
        $initial_d = explode(' ', $date); //initial date

        switch(explode('-', $initial_d[0])[1]){
            case 1:
                $month = 'January';
                break;
            case 2:
                $month = 'February';
                break;
            case 3:
                $month = 'March';
                break;
            case 4:
                $month = 'April';
                break;
            case 5:
                $month = 'May';
                break;
            case 6:
                $month = 'June';
                break;
            case 7:
                $month = 'July';
                break;
            case 8:
                $month = 'August';
                break;
            case 9:
                $month = 'September';
                break;
            case 10:
                $month = 'October';
                break;
            case 11:
                $month = 'November';
                break;
            case 12:
                $month = 'December';
                break;
        }
        
        return $month . ' ' . explode('-', $initial_d[0])[2] . ', ' . explode('-', $initial_d[0])[0];
        
    }


    Route::middleware(['admin'])->group(function() { 
        Route::get('admin/dashboard', function() {
             
            $fname = Employee::where('emp_id', Auth::user()->id)->value('emp_fname'); 
            return view('admin.dashboard')-> with(['fname'=> $fname]); 
        })->name('admin.dashboard');

            /************** SUBJECTS  *****************/
        Route::get('admin/subjects', function() {
            $user = Employee::where('emp_id', Auth::user()-> id)->get()-> first(); 
            $data = Subjects::all(); 


            return view('admin.subjects.subj')-> with(['data'=> $data, 'user'=> $user]);  
        })->name('admin.subjects'); 

        Route::get('admin/subjects/search_item', [SubjectsController::class, 'search'])->name('admin.subjects.search2');

        Route::get('admin/subjects/view-subject', [SubjectsController::class, 'view'])->name('admin.subjects.view');
        Route::get('admin/subjects/add-subject',[SubjectsController::class, 'add'])-> name('admin.subjects.add'); 

        Route::get('admin/subjects/delete', function() { 
            return view('admin.subjects.delete')->with([ 
                'subjects'=> Subjects::paginate(10)
            ]);
        })->name('admin.subjects.delete');

        Route::get('admin/subjects/load/{id}', function($id) { 
            return view('admin.subjects.load')->with([
                'subj'=> Subjects::where('subj_id', $id)->first()
            ]); 
        })->name('admin.subjects.load');

        Route::get('admin/subjects/load/{subj}/s',[SubjectsController::class, 'loadSearch'])->name('admin.subjects.loadsearch');

        Route::post('admin/subjects/loadtouser', [SubjectsController::class, 'load_to_user'])->name('admin.subjects.loadtouser');
        
        Route::delete('admin/subjects/destroy',[SubjectsController::class, 'delete'])->name('admin.subjects.destroy'); 

        
        Route::post('admin/subjects/add-subject/save', [SubjectsController::class, 'store'])-> name('admin.subjects.create'); 


        Route::get('admin/subjects/upload', function() { return view('admin.subjects.upload')->with(['imported'=>false]); })->name('admin.subjects.upload'); 
        Route::get('admin/subjects/upload/imports', function() { 
            return view('admin.subjects.popup')->with([
                'subjects'=> temp_subjects::paginate(10) 
            ]);
        })->name ('admin.subjects.popup') ;
        Route::post('admin/subjects/upload/load',[SubjectsController::class, 'import_file'])->name('admin.subjects.import'); 
        Route::post('admin/subjets/upload/save',[SubjectsController::class, 'load_file'])->name('admin.subjects.save');

        /********************* */


        /*************** TEACHING LOADS ****************/
        Route::get('admin/teaching-loads', function() { 
            return view('admin.loads.main');
        })-> name('admin.loads.db'); 

        Route::get('admin/teaching-loads/user', function() { 
            return view('admin.loads.loads');  
        })-> name('admin.loads'); 
 

        
        Route::get('admin/teaching-loads/search', function() { 
            $loads = Loads::latest()->where('added_by', Auth::user()->id)->take(10)-> get(); 
            return view('admin.loads.search')-> with(['loads'=> $loads]); 
        })-> name('admin.loads.search');

        Route::get('admin/teaching-loads/search/user', [LoadsController::class, 'load_search'])-> name('admin.loads.user.search'); 

        Route::get('admin/teaching-loads/batch', function() { 
            return view('admin.loads.batch')-> with(['subj'=>'', 'msg'=> '']); 
        })-> name('admin.loads.batch'); 

        Route::get('admin/teaching-loads/batch/s', [LoadsController::class, 'load_subject'])-> name('admin.loads.batch.subj'); 
        Route::get('admin/teaching-loads/batch/{id}/add-users', [LoadsController::class,'load_add'])-> name('admin.loads.batch.users'); 
        Route::get('admin/teaching-loads/load-user',[LoadsController::class, 'loaduser'])->name ('admin.loads.user');
        Route::get('admin/teaching-loads/add/load-subj',[LoadsController::class, 'loadsubj'])->name ('admin.loads.subj');
        Route::get('admin/teaching-loads/add', [LoadsController::class, 'add'])-> name('admin.loads.add'); 
        Route::get('admin/teaching-loads/loads/', [LoadsController::class, 'loadshow'])->name('admin.lbs');
        Route::get( 'admin/teaching-loads/loads/{id}' , [LoadsController::class, 'loadlbs'])->name('admin.lbs.view');


    


        Route::post('admin/teaching-loads/add/load', [LoadsController::class, 'store'])-> name('admin.loads.store'); 
        Route::delete('admin/teaching-loads/delete/{id}', [LoadsController::class, 'destroy'])->name('admin.loads.delete');
 



        ///BATCH UPLOAD - QUEUEING SYSTEM
        Route::post('admin/teaching-loads/batch/add-users', [LoadsController::class, 'addToQueue'])-> name('admin.queue.add'); 
        Route::delete('admin/teaching-loads/batch/add-users', [LoadsController::class, 'removeQueue'])-> name('admin.queue.remove'); 

        Route::post('admin/teaching-loads/batch-upload', [LoadsController::class, 'batchUpload'])-> name('admin.queue.upload'); 


        //////////IMPORTS/UPLOADING LOADS FEATURE
        Route::get('admin/teaching-loads/import', function() { 
            return view('admin.loads.import.upload')->with([ 
                'imported'=> false
            ]);
        })->name('admin.loads.upload'); 
        Route::get('admin/teaching-loads/imports', function() { 
            return view('admin.loads.import.imports')->with([
                'loads'=> LoadsImport::all()
            ]); 
        })->name('admin.loads.imports'); 
        Route::post('admin/teaching-loads/import', [LoadsImportController::class, 'import_file'])->name('admin.loads.import'); 
        Route::post('admin/teaching-loads/import/save', [LoadsImportController::class, 'upload_file'])->name('admin.loads.import.save'); 
    /********************* */


        /*************** RECORDS ****************/
        route::get('admin/records', function() { 
            return view('admin.records.dashboard'); 
        })->name('admin.records'); 

        /**************** RECORDS -- USER  *****/
        Route::get('admin/records/users', [UserRecordsController::class, 'index'])->name('admin.users');
        Route::get('admin/records/users/{id}', [UserRecordsController::class, 'view_user']) -> name('admin.users.view');
        Route::get('admin/records/users/{id}/edit', [UserRecordsController::class, 'edit_user']) -> name('admin.users.edit');
        Route::get('admin/records/user/filter/{type}', [UserRecordsController::class, 'filter'])-> name('admin.users.filter');

                    //termination of users
                    Route::put('admin/records/users/terminate/{id}', [UserTerminationController::class,'terminate'])->name('admin.users.terminate'); 
                    Route::put('admin/records/users/activate/{id}',[UserTerminationController::class, 'activate'])->name('admin.users.activate'); 
        
     /**************** RECORDS -- USER - HIRING HISTORY  *****/
     Route::get('admin/records/users/{id}/hiring/edit', [HiringHistoryController::class, 'loadHiring'])->name('admin.hiring'); 


     Route::put('admin.records/users/{id}/hiring/update', [HiringHistoryController::class, 'updateHiring'])->name('admin.hiring.save'); 


        /******************* APP CONFIGS */
        route::get('admin/registry', function() { 
            return view('admin.config.db'); 
        })->name('admin.registry'); 

        Route::get('admin/registry/departments/{id}', [DeptController::class, 'view_department'])->name('admin.dept.view'); 


        Route::get('admin/registry/departments', function(){
      
            $dept = Departments::orderBy('dept', 'asc') ->  paginate(10); 

            if(Departments::get()->count() != 0) { 
                // $updated = Departments::where('id' , 1)->first()-> value('updated_at');
                    $updated = Departments::orderBy('updated_at', 'desc')->first()->value('updated_at');
            } else {
                    $updated = now(); 
            }
            

  
            
            return view('admin.config.dept.departments')->with(['dept'=> $dept,
            'msg'=> session('msg'), 
            'u_at'=> updated_date($updated)]);
        })-> name ('admin.registry.dept') ; 

 
        Route::get('admin/registry/department/update/all', function() { 
         
            return view('admin.config.dept.update-all');
        })-> name('admin.registry.dept.edit.all'); 


        Route::get('admin/registry/department/files',[DeptController::class, 'load_list'])->name("admin.registry.dept.files");

        Route::get('admin/registry/department/files/dl/{file}', [DeptController::class, 'download_sheet'])->name('registry.dept.files.download'); 

        Route::get('admin/registry/department/files/dl_temp/{file}', [DeptController::class, 'download_template'])->name('registry.dept.files.download_temp'); 


        Route::get('admin/registry/department/search',[DeptController::class, 'search'])->name('admin.dept.search');


        Route::post('admin/registry/department/update/all', [DeptController::class, 'load_all_file'])-> name('admin.registry.dept.edit.all.load'); 

        Route::post('admin/registry/department/update/dept', [DeptController::class, 'load_dept_file'])->name('admin.registry.dept.edit.load');

        Route::post('admin/registry/department/update/all/save', [DeptController::class, 'update_all'])-> name('admin.registry.dept.edit.all.save');

        //individual editing of records
        Route::PUT('admin/registry/departments/{id}/edit', [DeptController::class, 'update_dept'])->name('admin.dept.update'); 

        Route::delete('admin/registry/departments/delete/{id}',[DeptController::class, 'destroy'])->name('admin.dept.delete'); 

    });


    ///app config - semesters 
    Route::get('admin/registry/semester',[SemesterController::class, 'index'])->name('admin.sem');

    Route::put('admin/registry/semester/update', [SemesterController::class, 'updateRegular'])->name('admin.sem.updatereg'); 

    Route::put('admin/registry/semester/update/tri', [SemesterController::class, 'updateTrimester'])->name('admin.sem.updatetri');

    

    /************
     * 
     * 
     * 
     * 

     * 
     * 
     */ 
    /**** USER ORGANIZATIONSSSS */
    Route::get('admin/records/organizations', [AdminOrgController::class, 'loadOrgs'])-> name('admin.orgs'); 
    Route::get('admin/records/organizations/{id}', [AdminOrgController::class, 'loadOrganization'])->name('admin.orgs.view'); 
    Route::get('admin/subjects/search/',[AdminOrgController::class, 'search'])->name('admin.orgs.search'); 
    

    Route::get('admin/users/search/',[UserRecordsController::class, 'search'])->name('admin.users.search'); 


    Route::delete('admin/records/organizations/destroy/{id}', [AdminOrgController::class, 'destroy'])->name('admin.orgs.destroy'); //individualdeleting

    Route::delete('admin/records/organizations/delete', [AdminOrgController::class, 'delete'])->name('admin.orgs.delete'); //batch deleting
    
    


    /******************** ISSUANCE OF CERTIFICATES ********************/
    
   Route::get('admin/certifications', function() { 
    $msg = '';
    if(session('msg')=='Batch issue')  { 
            $msg = 'Successfully issued certificates for all selected users!' ; 
    } 


    if(Auth::user()->role == 'Dean') { 

        $certs= HAUCert::where('issued_by', Auth::user()->user->department->dept)->get(); 
    } else { 
        $certs= HAUCert::where('created_by', Auth::user()->id)->get(); 
    }
    return view('admin.certs.dashboard')->with([ 
        'msg'=> $msg,
        'certs'=> $certs, 
        'depts'=> Departments::all()
    ]); 
   })-> name('admin.certs'); 
   Route::get('admin/certifications/issue/{id}', [IssueCertController::class, 'load_issue'])->name('admin.certs.load') ;

   Route::get('admin/certifications/view/{id}', function($id) { 
        return view('admin.certs.view')->with([ 
            'data'=>HAUCert::where('id',$id)->first(), 
            'certs'=> certifications::where('hau_cert', $id)->get() 
        ]);
   })->name('admin.certs.view'); 

   Route::post('admin/certifications/create', [IssueCertController::class, 'create_certification'])-> name('admin.certs.create'); 

   Route::post('admin/certifications/issue/{id}/p', [IssueCertController::class, 'issue_cert'])->name('admin.certs.issue') ;




 
?> 