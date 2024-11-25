<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\dependencies;
use App\Models\Employee;
use App\Models\Employee_Login;
use Illuminate\Http\Request;



class UserTerminationController extends Controller
{

    //edit terminated status
    public function terminate($id) { 
        $user = Employee_Login::findOrFail($id); 
        $user->update([ 
            'terminated'=> 1 
        ]); 

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
            'dependencies'=> $dep,
            'msg'=>'User account terminated successfully. They will no longer have access to their account.' 
        ]); 

    }

    public function activate($id) { 

        $user = Employee_Login::findOrFail($id); 
        $user->update([ 
            'terminated'=> 0 
        ]); 


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
            'dependencies'=> $dep,
            'msg'=>'The account has been successfully restored and is now active.' 
        ]); 

    }

  

}
