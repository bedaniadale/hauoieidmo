<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Employee;
use App\Models\HiringHistory;
use App\Models\HiringInfo;
use App\Models\tags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class HiringHistoryController extends Controller
{

    public function loadHiring($id) { 
        $this->verifyAccount($id); 
        switch(session('hiringsuccess')) { 
            case true: 
                $edited = true; 
                break; 
            default:    
               $edited = false;
               break; 
        } 
         
        return view('admin.records.users.hiring') ->with([
            'user'=> HiringInfo::where('emp_id', $id)->first(),
             
            'dept'=>  Departments::all(),
            'position'=> tags::where('category','emp_category' ) ->get(),
            'nontenured'=> tags::where('category', 'non_tenured')->get(),
            'tenure'=> tags::where('category', 'tenure')->get() ,
            'nature'=> tags::where('category', 'emp_status')->get(),
            'emp_type'=> [''],
            'successmsg'=>$edited
        ]); 
    }
    public function generateId($id) { 
        do { 
            $uid = $id . '-h-' . Str::random(8); 
        }while (HiringHistory::where('id', $uid)->exists()); 

        return $uid; 
    }

    public function verifyAccount($uid) { 
        if(!(HiringInfo::where('emp_id', $uid)->exists())){ 
            HiringInfo::create([ 
                'emp_id'=> $uid
            ]); 
        } 
    }
    public function updateHiring(Request $request, $id ) { 

        $this->verifyAccount($id);

       
        $dept = Departments::where('dept', $request->department)->first() ; 

        //$request->validate([])
        $logitem = [
            Carbon::parse(now())->format('Y-m-d'),  
            $request->position, 
            $dept->code,
            $request->nature,
            $request->tenure,
        ]; 
        
        switch($logitem[1]) { 
            case 'FACULTY':     
                $div = 'ACADEMIC'; 
                break; 
            default: 
                $div = 'NON-ACADEMIC'; 
                break; 
        } 

  

        $user = HiringInfo::findOrFail($id);  

        $user->update([ 
            'emp_position'=> $logitem[1],
       
            'emp_nature'=> $logitem[3], 
            'emp_tenure'=> $logitem[4], 
            'division'=> $div
        ]); 

        $user->user->update([ 
            'emp_dept'=> $logitem[2]
        ]);

        if($logitem[4]=='NON-TENURED') { 
            $user->update([ 
                'non_tenured'=> $request->nontenured 
            ]); 
        } else { 
            $user->update([ 
                'non_tenured'=> ''
            ]); 
        }

     
        
        
        //add to hiring history
        $this->logHiring($id, $logitem); 
        
        session(['hiringsuccess'=> true]); 
        return redirect()->route('admin.hiring', $id); 

        //return redirect()->route() 



    } 

    public function logHiring($id, $arr) { 

        switch($arr[1]) { 
            case 'FACULTY':     
                $div = 'ACADEMIC'; 
                break; 
            default: 
                $div = 'NON-ACADEMIC'; 
                break; 
        } 

        $dept = Departments::where('code', $arr[2])->first(); 
         
        HiringHistory::create([ 
            'id'=> $this-> generateId($id), 
            'emp_id'=> $id, 
            'date'=> $arr[0] ,
            'position'=> $arr[1],
            'division'=> $div, 
            'department'=>$dept->dept, 
            'nature'=> $arr[3]  
        ]); 

    }
} 
