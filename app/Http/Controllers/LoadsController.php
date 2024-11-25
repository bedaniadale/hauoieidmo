<?php

namespace App\Http\Controllers;

use App\Models\batch_queue;
use App\Models\Employee;
use App\Models\Loads;
use App\Models\Subjects;
use App\Models\tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use PhpParser\Internal\PrintableNewAnonClassNode;

class LoadsController extends Controller
{

    public function loadshow() { 
        return view('admin.loads.sub.main')->with([ 
        'subjects'=> Subjects::orderBy('subj_title', 'asc')->paginate(10) 
        ]); 
    }

    public function loadlbs($id) { 

        switch(Auth::user()->role){ 
            case'SuperAdmin': 
            case 'HR Admin': 
                $loads = Loads::where('subj_id', $id)->get(); 
                break; 
            default: 
                $loads = Loads::where('subj_id', $id)
                ->whereHas('user', function($q) { 
                    $q-> where('emp_dept', Auth::user()->user->emp_dept); 
                })->get(); 
        }
        return view('admin.loads.sub.view')->with([ 
            'subj'=> Subjects::where('subj_id', $id)->first(), 
            'loads'=> $loads
        ]);
    }

    


    public function loaduser(Request $request) { 
        $userinfo = Employee::where('emp_id', $request->id)-> first(); 

        $admin_dept = Employee::where('emp_id', Auth::user()-> id)-> first()-> emp_dept; 
        $user_dept = $userinfo -> emp_dept; 

        if(Auth::user()-> role != 'SuperAdmin' || Auth::user()->role != 'HR Admin') {
            if($admin_dept != $user_dept) { 
                return view('admin.loads.loads')-> with(['msg'=> "User not found..."]); 
            }
        }
        $loads = Loads::where('emp_id', $request-> id)-> get();

        return view('admin.loads.loads')->with(['userinfo'=>$userinfo,'loads'=> $loads]);
    }


    public function add(Request $request) { 
        $userinfo = Employee::where('emp_id' , $request->id)->get()->first(); 
        return view('admin.loads.add')-> with(['userinfo'=> $userinfo]); 

    }


    //for individual loading
    public function loadsubj(Request $request) { 
        
        $userinfo = Employee::where('emp_id' , $request->emp_id)->get()->first(); 
        $subj = Subjects::where('subj_code', $request->id)
        ->orWhere('subj_id', $request->id)->get()-> first(); 

        if($subj) { 
            return view('admin.loads.add')-> with(['userinfo'=> $userinfo, 'subj'=> $subj]);
        }

        return view('admin.loads.add')-> with(['userinfo'=>$userinfo, 'msg'=> 'Subject not found...']) ;
    }

    public function store(Request $request) { 
        $uid = $request-> id; 
        $subj = $request-> subj; 

        //check if the load exist already
        if(Loads::where('emp_id', $uid)-> where('subj_id',$subj)-> exists()) {

            $userinfo = Employee::where('emp_id' , $uid)->get()->first(); 
            $subject = Subjects::where('subj_code' ,$subj)->get()-> first(); 

            return view('admin.loads.add')-> with(['userinfo'=>$userinfo,'msg'=>"The selected unit/subject is already loaded for this teacher. Please choose another one or review the current load.", 'subj'=> $subject]);
        }
        

        $newload = Loads::create([
            'emp_id'=> $uid, 
            'subj_id'=> $subj, 
            'added_by'=> Auth::user()->id,
            'created_at'=> now(), 
            'updated_at'=> now()
        ]); 

        if($newload) { 
            $userinfo = Employee::where('emp_id' , $uid)->get()->first(); 
            $loads = Loads::where('emp_id', $uid)-> get();
            return view('admin.loads.main')-> with(['msg'=>'Subject was successfully loaded to user. ']);
        }
    }

    public function destroy(Request $request, $id) { 
        
        $data = Loads::where('id', $id)->get()-> first();  
        $data-> delete(); 
        $loads = Loads::where('emp_id', $request->emp_id)-> get();

        $user = Employee::where('emp_id' , $request->emp_id)->get()-> first(); 

        return view('admin.loads.search')-> with(['loads'=> $loads, 'userinfo'=> $user, 'msg'=> 'Subject/Unit was removed from the user.']);
         
    }


    //for batch loading
    public function load_subject(Request $request) { 
        $data=  Subjects::where('subj_code', $request->subj_code)
        ->orWhere('subj_id', $request-> subj_code)
        ->get()-> first(); 

        if ($data) { 
            return view('admin.loads.batch')-> with(['subj'=> $data]); 
        } 

        return view('admin.loads.batch')-> with(['msg'=> 'Subject not found..']); 
        
    }

    public function load_add($id) { 
        $subj = Subjects::where('subj_code', $id)-> get()-> first(); 
        $sems = tags::where('category', 'semester')->get(); 
    

        return view('admin.loads.batch2')-> with(['subj'=> $subj, 'msg'=>'', 'semesters'=> $sems ]);
    }

    public function addToQueue(Request $request) { 
        $uid = $request-> emp_id; 

         //to load the current subject
         $subj = Subjects::where('subj_code', $request-> subj_code)-> get()-> first(); 



        //validate if the user is in the employee list
        if(!(Employee::where('emp_id', $uid)-> exists())) { 
            $queue = batch_queue::all();  
            return view('admin.loads.batch2')->with(['msg'=> 'User not found...', 'subj'=>$subj, 'queue'=> $queue]);
        }

       

        //check if the user is already in the queue
        if(batch_queue::where('emp_id', $uid)->exists()) { 
            $queue = batch_queue::all(); 
            return view('admin.loads.batch2')->with(['msg'=> 'User already in the list.', 'subj'=>$subj, 'queue'=> $queue]);
        }

        //insert to the database
        batch_queue::create([
            'emp_id'=> $uid, 
            'updated_at'=> now(), 
            'created_at'=> now()
        ]); 


        //get the updated queue
        $queue = batch_queue::all();

        return view('admin.loads.batch2')-> with(['msg'=> '', 'subj'=> $subj, 'queue'=> $queue]); 




    }



    public function removeQueue(Request $request) { 
        
        $data = batch_queue::where('emp_id', $request->id)->get()-> first(); 
        
        $data-> delete(); 
                   
        $subj = Subjects::where('subj_code', $request-> subj_code)-> get()-> first(); 

        $queue = batch_queue::all(); 

        return view('admin.loads.batch2')-> with(['msg'=> '', 'subj'=> $subj, 'queue'=> $queue]); 


    }

    public function batchUpload(Request $request) {
        $queuedUsers = json_decode($request->input('queued_users'), true); // Decode the JSON string into an array
        $subject = Subjects::where('subj_code', $request->subj_code)->first(); 
 
        
        $sy = $request->sy_start . '-' . $request->sy_end; 
      


            foreach($queuedUsers as $item) { 
                $queue_list = explode('-', $item); 
                $class_code = $queue_list[0] ;
                $emp_id = $queue_list[1]; 

                if(!(Loads::where('emp_id', $emp_id)
                ->where('class_code', $class_code)
                ->where('sy', $sy)
                ->where('semester' , $request->sem)
                ->exists())) {
                    Loads::create([
                        'emp_id'=> $emp_id, 
                        'subj_id'=> $subject->subj_id,
                        'class_code'=> $class_code, 
                        'added_by'=> Auth::user()-> id,
                        'sy'=> $sy, 
                        'semester'=> $request->sem,
                        'created_at'=> now(), 
                        'updated_at'=> now()
                    ]); 
                }
              
            }

        return view('admin.loads.main')-> with(['msg'=>'Batch upload successful.']);

    }


    public function load_search(Request $request) { 
    
        if(!Employee::where('emp_id', $request->id )->exists()){ 
            return view('admin.loads.search')-> with(['errormsg'=> 'User not found..']);
        }
        $uid = $request->id; 
        switch(Auth::user()->role) { 

            case 'SuperAdmin': 
                $result= Employee::where('emp_id', $uid)-> first(); 
                break; 
                
            case 'HR Admin': 
                $admin_dept = Employee::where('emp_id', Auth::user()->id)->first()->emp_dept; 
            
                $search_dept = Employee::where('emp_id', $uid)->first()->emp_dept; 
    
                if($admin_dept !== $search_dept) { 
                    return view('admin.loads.search')-> with(['errormsg'=> 'You do not have permission to view or modify this record.']);
                }
                $result = Employee::where('emp_id', $uid)-> first(); 
                break;
                    
        }
                 

        $loads = Loads::where('emp_id', $uid)-> get(); 
        return view('admin.loads.search')-> with(['userinfo'=> $result, 'loads'=> $loads]);  
    }
}
