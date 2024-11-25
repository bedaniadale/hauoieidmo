<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\orgs;
use Carbon\Carbon;

class OrgController extends Controller
{
    public function create() { 
        $uid = Auth::user()-> id; 
        $user = Employee::where('emp_id',$uid)-> get()-> first(); 
        $orgs = orgs::where('emp_id', $uid)-> orderBy('date_joined', 'asc')->get(); 
        return view('portal.pages.org.orgs')->with(['user'=> $user, 'orgs'=> $orgs]);
    }

    public function create_add(){
        
        return view('portal.pages.org.add');  with(['user'=> $userinfo]);
    }

    public function create_edit($user, $id) {
        $data = orgs::where('id', $id)->first(); 

        return view('portal.pages.org.edit')-> with(['org'=>$data ]); 
        
    }

    public function store(Request $request) { 

    
        $data = $request->validate([
            'org'=> 'string',
            'position'=> 'string', 
            'date_joined'=> 'date|nullable'
        ]); 


        $insert = orgs::create([
            'emp_id'=> Auth::user()-> id,  
            'org'=> $request-> org, 
            'position'=> $request->position, 
            'date_joined'=> Carbon::parse($request->date_joined)-> format('Y-m-d'),
            'added_by'=> Auth::user()-> id,
            'updated_at'=> now(), 
            'created_at'=> now()
        ]); 
        
        if(isset($insert)) { 
            return redirect()-> route('portal.org')->with(['msg'=> "New data created."]);  
        }

        }


        public function destroy(Request $request) { 
            
            $item = orgs::findOrFail($request->id); 

            
            $item->delete(); 
            
            if($item) { 
                return redirect()-> route('portal.org')-> with(['msg'=> 'Data deleted.']); 
            }
        }

        public function update(Request $request, $id) { 

            $data = orgs::where('id', $id)->first(); 
            $update = $data->update([ 
                'org'=> $request->org, 
                'position'=> $request->position, 
                'date_joined'=> $request-> date_joined, 
                'updated_at'=> now()
            ]); 

            if($update) { 
                return redirect()-> route('portal.org')-> with(['msg'=> 'Data successfully updated.']);
            }

            //else return to the edit page, with the same subj + error 

            

            

            

        }


     

        



}
