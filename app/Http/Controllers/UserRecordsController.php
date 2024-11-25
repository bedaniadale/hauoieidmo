<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\dependencies;
use App\Models\Employee;
use App\Models\Employee_Login;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecordsController extends Controller
{


    //search
    public function search(Request $request) { 

        $query = $request->get('query'); 

        Switch(Auth::user()->role) { 
            case 'SuperAdmin': 
            case 'HR Admin': 
                $data = Employee::where('emp_id','LIKE', "%{$query}%")
                ->orWhere('emp_fname', 'LIKE' , "%{$query}%")
                ->orWhere('emp_mname', 'LIKE' , "%{$query}%")
                ->orWhere('emp_lname', 'LIKE' , "%{$query}%")
                ->orderBy('emp_lname', 'asc')
                ->get(); 
                break; 

            default: 
                $data = Employee::where('emp_dept',Auth::user()->user->emp_dept)
                ->where(function($q) use  ($query) { 
                    $q->where('emp_id','LIKE', "%{$query}%")
                    ->orWhere('emp_fname', 'LIKE' , "%{$query}%")
                    ->orWhere('emp_mname', 'LIKE' , "%{$query}%")
                    ->orWhere('emp_lname', 'LIKE' , "%{$query}%");
                })->orderBy('emp_lname','asc')->get() ;
                break; 
        }

        

        return response()->json($data); 
    }




    protected function fetch(){ 
        switch(Auth::user()->role) { 
            case 'SuperAdmin': 
            case 'HR Admin': 
                $data = Employee::orderBy('emp_lname', 'asc')-> paginate(6); 
                $d2 = Employee::all(); 
                $count = $d2->count(); 
                break; 
            default:
                $data = Employee::where('emp_dept' , Auth::user()-> emp_dept)-> orderBy('emp_lname' , 'asc')-> paginate(6); 
            
                $d2 = Employee::where('emp_dept' , Auth::user()->  emp_dept)-> get();  
                $count = $d2->count(); 
                break; 

        }

        
        
        return [$data, $count]; 

    }

    public function filter($type, Request $request) { 
        $depts= Departments::orderBy('dept', 'asc')->get(); 
        if($type == 'dept'){
            
           
            $selected_dept = Departments::where('code', $request->dept) -> first();
         
            $total = Employee::where('emp_dept', $request->dept)->orderBy('emp_lname','asc')->get(); 
            $count = $total->count(); 

         
            
            $users = Employee::where('emp_dept', $request->dept)->orderBy('emp_lname','asc')-> paginate($count); 

            
            return view('admin.records.users.all')-> with([
                'users'=> $users, 
            
                'count'=> $count, 
                'depts'=>$depts, 
                'dept'=> $selected_dept->dept]);

        } 
        

    }

    public function index() { 
        $data = $this->fetch(); 
        $depts= Departments::orderBy('dept', 'asc')->get(); 
        

        return view('admin.records.users.all')-> with(['users'=> $data[0] , 'count'=> $data[1], 'depts'=> $depts]); 
    }

    public function view_user($id) { 
        $data = Employee::where('emp_id', $id)-> first(); 
        $dep = dependencies::where('emp_id',$id)->get(); 

        
        if(Departments::where('code', $data->emp_dept)->exists()){ 
            $hasdep = true ; 
        } else { 
            $hasdep = false ; 
        }
       
        
        return view('admin.records.users.view-user')-> with([
            'dep'=> $hasdep,
            'data'=> $data,
            'dependencies'=> $dep
        ]); 
    }

    public function edit_user($id) {
        $data = Employee::where('emp_id', $id)-> first(); 
        $dep = dependencies::where('emp_id',$id)->get(); 

        
        if(Departments::where('code', $data->emp_dept)->exists()){ 
            $hasdep = true ; 
        } else { 
            $hasdep = false ; 
        }
       
        
        return view('admin.records.users.edit-info')-> with([
            'dep'=> $hasdep,
            'data'=> $data,
            'dependencies'=> $dep
        ]); 
    }

    

}
