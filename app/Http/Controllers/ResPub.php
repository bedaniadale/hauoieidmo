<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\respub as ModelsRespub;
use App\Models\respub_entries;
use Dotenv\Repository\RepositoryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\View\View; 
use Illuminate\Support\Facades\Storage; 


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Str; 
use App\Models\requests; 

class ResPub extends Controller

{
    protected function generateId() { 
    
        do{
            $gen = Auth::user()->id .'rp' . Str::random(10);  

        }while(ModelsRespub::where('id', $gen)->exists()); 

        return $gen; 
    }




    protected function updateRequest($id,$title) { 
        $req = requests::findOrFail($id); 
        $req->title = $title; 
        $req->save(); 
        return true;
    }


      //functtion to add request to pendings
      protected function createRequest ($id, $emp, $date, $title) {
        $send_request = requests::insert([
            'id'=> $id, 
            'emp_id'=> $emp, 
            'title'=> $title, 
            'type'=> 'Research and Publication',
            'date_submitted'=> $date
        ]); 
        if($send_request) { 
            return true; 
        }

        return false; 
    }

 
    public function create () { 
        $userId = Auth::user()-> id;
        $research = ModelsRespub::where('emp_id', $userId)->where('type', 'Research')->get(); 
        $publication = ModelsRespub::where('emp_id', $userId)->where('type', 'Publication')->get(); 



        $rapproved = ModelsRespub::where('emp_id', $userId)->where('type', 'Research')->where('status', 'Approved')->get(); 
        $rpending = ModelsRespub::where('emp_id', $userId)->where('type', 'Research')->where('status', 'Pending')->get(); 
        $rtoreview = ModelsRespub::where('emp_id', $userId)->where('type', 'Research')->where('status', 'To-review')->get(); 


     

        
        $papproved = ModelsRespub::where('emp_id', $userId)->where('type', 'Publication')->where('status', 'Approved')->get(); 
        $ppending = ModelsRespub::where('emp_id', $userId)->where('type', 'Publication')->where('status', 'Pending')->get(); 
        $ptoreview = ModelsRespub::where('emp_id', $userId)->where('type', 'Publication')->where('status', 'To-review')->get(); 





        $publication = ModelsRespub::where('emp_id', $userId)-> where('type','Publication')->get(); 

        $approved = ModelsRespub::where('emp_id', $userId)->where('status', 'Approved')->get();         
        $pending = ModelsRespub::where('emp_id', $userId)->where('status', 'Pending')->get(); 
        $toreview = ModelsRespub::where('emp_id', $userId)->where('status', 'To-review')->get(); 


        return view('portal.pages.respub.main')->with([
            'user'=> Employee::where('emp_id', $userId)->first(), 
            'research'=> $research, 
            'publication'=> $publication,
            'approved'=> $approved, 
            'pending'=> $pending, 
            'toreview'=> $toreview,

            'rapproved'=> $rapproved,
            'rpending'=> $rpending, 
            'rtoreview'=> $rtoreview,

            'papproved'=> $papproved,
            'ppending'=> $ppending,
            'ptoreview'=> $ptoreview, 
            'count'=> requests::where('type', 'Research and Publication')-> get()-> count()
        ]);
    }

   


    public function createEdit($id) { 
        $data = ModelsRespub::where('id' ,$id)-> get()-> first(); 
   
        return view('portal.pages.respub.edit')->with([
            'user'=> Employee::where('emp_id', Auth::user()->id)->first(), 
            'data'=> $data
        ]);
    }


    public function viewItem($id) { 
        $data = ModelsRespub::where('id' ,$id)-> get()-> first(); 
        
        return view('portal.pages.respub.view')->with([
            'user'=>Employee::where('emp_id', Auth::user()->id)->first(), 
            'data'=> $data
        ]); 
    }


    public function store(Request $request) { 
      

        $userId = Auth::user()-> id; 

        $date_published = Carbon::parse($request->date_published)->format('Y-m-d');

    

        //generate a unique id for the entry 
        $generateID = $this->generateId(); 
    

        $path = 'respub/' . Auth::user()->id; 
        


        //create the user folder if the directory for the user doesn't exist
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

    
       
        //uploading it in the storage disk
        $save_name= $generateID . '.' . $request->file('attachment')-> getClientOriginalExtension(); 
        $filePath = $request->file('attachment')->storeAs($path, $save_name, 'public');
        $now = now();
        if($filePath) { 
            $insert_sql = ModelsRespub::insert([
                'id'=> $generateID, 
                'emp_id'=> $userId,
                'type'=> $request-> type, 
                'title'=> $request-> title, 
                'description'=>$request->description, 
                'file_path'=> 'respub/' . Auth::user()->id . '/' . $save_name,
                
                'attachment'=> $request->file('attachment')->getClientOriginalName(), 
                'date_published'=> $date_published,
                'status'=> 'Pending', 
                'created_at'=> $now, 
                'updated_at'=> $now 
            ]); 
    
           
            $create_req = $this-> createRequest($generateID, $userId, $now, $request->title); 
                
            if($create_req) { 
                return redirect()-> route('portal.respub.success'); 
            }
        }

      
    }


    public function editItem(Request $request, $id) { 
  
        $date_published = Carbon::parse($request-> date_published)->format('Y-m-d' );
    



        $validatedData = $request-> validate([
            "title"=> 'string', 
            "description"=> 'string', 
            "date_published"=> 'date'
         
        ]); 
      
        $data = ModelsRespub::findOrFail($id); 
        
        $data->update([ 
            'title'=> $request->title, 
            'description'=> $request->description, 
            'date_published'=> $request->date_published 
        ]); 

    
        
        if($this-> updateRequest($id, $request-> title))  { 
            return redirect()-> route('portal.respub')->with(['msg'=> 'Selected Record was updated.']); 

        }
    }


    public function createType() { 
        return view('portal.pages.respub.type');
    }


    public function loadResearch(){ 
        return view('portal.pages.respub.research')->with(['user'=>Employee::where('emp_id', Auth::user()->id)->first()]); 
    }

    public function loadPublication() { 
        return view('portal.pages.respub.pub')->with([
            'user'=> Employee::where('emp_id', Auth::user()->id)->first() 

        ]); 
    }

    

    public function destroy($id) { 
         

      
        //delete the entry
        $respub = ModelsRespub::findOrFail($id);
   
        $filepath = $respub->file_path; 
        $respub->delete();

        //delete the request
        if(requests::where('id' ,$id)->exists()) { 
            requests::destroy([$id]); 
        }
        


        //delete the file 
        Storage::disk('public')->delete($respub->file_path);

        session(['msg'=> 'The record was deleted.']);
        return redirect()-> route('portal.respub');

           
            
    }
  

    


    public function loadResubmit($id) { 
        $data= ModelsRespub::where('id',$id)->get()-> first(); 
        $user = Employee::where('emp_id', Auth::user() -> id)->first();

        return view('portal.pages.respub.resubmit')-> with(['data'=> $data, 'user'=> $user]); 
    }
    
    public function resubmit(Request $request, $id) { 
        $uid = Auth::user()->id; 
        $dp = Carbon::parse($request->date_published)->format('Y-m-d'); // Date published
        $dt = Carbon::parse(now())->format('Y-m-d'); // Date today
        $att_name = $request->file('attachment')->getClientOriginalName(); 
    
        // Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date_published' => 'required|date',
            'attachment' => 'required|file',
        ]);
    
        // Update the record in the tbl_respub table
        ModelsRespub::where('id', $id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date_published' => $dp,
            'updated_at' => now(), 
            'attachment' => $att_name,
            'status' => 'Pending'
        ]);
    
        // Handle file upload
        if ($request->hasFile('attachment')) { 
            $path = 'respub/' . $uid;
            $filename = $id . '.' . $request->file('attachment')->getClientOriginalExtension(); 
            $request->file('attachment')->storeAs($path, $filename, 'public'); 
    
            // Update the title in the requests table (if necessary)
            requests::where('id', $id)->update([
                "title" => $validatedData['title'], 
                "date_submitted" => $dt 
                
            ]);
        }
    
        return redirect()->route('portal.respub.success');
    }
    

}
