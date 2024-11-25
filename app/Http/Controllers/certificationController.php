<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\requests;

use App\Models\certifications;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Carbon; 
use App\Models\certifications_entries;
use App\Models\Employee;
use Carbon\TranslatorStrongTypeInterface;
use Illuminate\Support\Str; 

class certificationController extends Controller
{   
    


    protected function updateRequest($id,$title) { 
        DB::table('requests')->where('id', $id)->update(['title' => $title]);
        return true;
    }
    //helper methods
    protected function createRequest($id, $emp, $date, $title, $type)
    {
        $send_request = DB::table('requests')->insert([
            'id' => $id,
            'emp_id' => $emp,
            'title' => $title,
            'type' => $type,
            'date_submitted' => $date
        ]);
        if ($send_request) {
            return true;
        }

        return false;
    }

    ///generate a submission ID 
    protected function generateID()
    {
        do{  
            $id = Auth::user()->id . 'cert' . Str::random(8);
        }while(certifications::where('id', $id)->exists()); 

        return $id; 
    }


    //resubmit a entry
    public function resubmit(Request $request, $id) { 
       

        $uid = Auth::user()-> id; 
     

        $di = Carbon::parse($request->date_issued)-> format('Y-m-d'); //date issued
        $dv = Carbon::parse($request-> cert_validity)-> format('Y-m-d');  //date validity 

        $dt = Carbon::parse(now()) -> format('Y-m-d'); 
       
        $att_name = $request->file('attachment')-> getClientOriginalName(); 

        DB::table('certifications')-> where('id', $id)-> update([
            'cert_title'=>$request-> input('cert_title'),
            'cert_type'=> $request->input('cert_type'), 
            'duration'=> $request->input('duration'),
            'role' => $request->input( 'role'),
            'date_issued'=> $di, 
            'cert_validity'=> $dv,  
            'updated_at'=> now(),
            'attachment'=> $att_name,
            'status'=> 'Pending'
           
        ]);
        
    

        if($request->hasFile('attachment')) { 
            $path = 'certifications/' . $uid;
            $filename = $id . '.'  . $request-> file('attachment')-> getClientOriginalExtension(); 
            $filePath = $request->file('attachment')->storeAs($path, $filename, 'public'); 
            $req_update = DB::table('requests')-> where('id',$id)-> update([
                "title"=>$request-> cert_title, 
                "date_submitted"=>   $dt 
            ]); 
                
                return redirect()->route('portal.filing.success');
            
            }
        
    }


    //CRUD functions 
    public function create()
    {

        $user= Employee::where('emp_id', Auth::user()-> id)->first (); 
        $data = certifications::where('emp_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $approved = certifications::where('emp_id', Auth::user()->id)->where('status', 'Approved')->orderBy('created_at', 'desc')->get(); 

        $pending = certifications::where('emp_id', Auth::user()->id)->where('status', 'Pending')->orderBy('created_at', 'desc')->get(); 

        $toreview = certifications::where('emp_id', Auth::user()->id)->where('status', 'To-review')->orderBy('created_at', 'desc')->get(); 

        return view('portal.pages.certifications.certs')->with([
            'items'=>$data,
            'approved'=>$approved, 
            'pending'=> $pending,
            'toreview'=> $toreview,
            'user'=> $user


        ]);
    }

    public function edit($id) { 
        $data= certifications::where('id', $id)-> get()-> first(); 
        return view('portal.pages.certifications.edit')-> with('data',$data); 
    }

    public function update(Request $request, $id) { 

        $date_issued = Carbon::parse($request->date_issued)-> format('Y-m-d'); 
        $validity = Carbon::parse($request-> cert_validity)-> format('Y-m-d'); 

        $request-> merge([ 
            'date_issued'=> $date_issued, 
            'cert_validity'=> $validity 
        ]);

        $validatedData = $request-> validate([ 
            'cert_title'=> 'string', 
            'duration'=> 'string', 
            'cert_type'=> 'string', 
            'role'=> 'string'
        ]);
        
        $data = certifications::findOrFail($id); 
        
        if ($data->update($validatedData)) { 
            $update_request = $this-> updateRequest($id, $request->cert_title); 
            if($update_request) { 
                return redirect()->route('portal.certifications')-> with(['msg'=> 'Details successfully  edited.']); 

            }
        }

    }

    public function store(Request $request)
    {


        $userId = Auth::user()->id;

        $now = now();
        $submission_id = $this->generateID();


        //set a path 
        $path = 'certifications/' . $userId;



        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }



        //generate a file name that will be save on the storage disk 
        $file_name = $submission_id . '.' . $request->file('attachment')->getClientOriginalExtension();
        $filePath = $request->file('attachment')->storeAs($path, $file_name, 'public');

        
        if ($filePath) {
            certifications::insert([
                'id' => $submission_id,
                'emp_id' => $userId,
                'attachment' => $request->file('attachment')->getClientOriginalName(),
                'date_issued' => $request->date_issued,
                'file_path' => $path . '/' . $file_name,
                'issued_by'=> $request-> issued_by, 
                'duration' => $request->duration,
                'cert_title' => $request->cert_title,
                'cert_validity' => $request->cert_validity,
                'cert_type' => $request->cert_type,
                'role' => $request->role,
                'status' => 'Pending',
                'created_at' => $now,
                'updated_at' => $now
            ]);

            

         
                $create_request = $this->createRequest($submission_id, $userId, $now, $request->cert_title, 'Certification');

                if ($create_request) {
        
                        return redirect()->route('portal.filing.success');
                   
                }
            
        }
    }


    public function loadResubmit($id) { 
        $data = certifications::where('id', $id)->get()-> first() ;
        return view('portal.pages.certifications.resubmit')-> with(['data'=>$data]);
        
    }

    public function destroy($id)
    {

    
        //if page == true, you were from the certification page
        $cert = certifications::findOrFail($id);


        //delete file from storage -> to free storage from unnecessary links 
        Storage::disk('public')->delete($cert->file_path);

        $delete = $cert->delete();

        if ($delete) {
            $del_req = requests::findOrFail($id);
            if($del_req){ 
                if ($del_req->delete()) {
                   
               
                    return redirect()->route('portal.certifications');
                  
                    
                }

            } else { 
                session(['msg' => 'Certification was deleted.']);
               
                return redirect()->route('portal.certifications');
            }
        }
    }

    //page loader

    public function viewItem($id)
    {
        $data = certifications::where('id', $id)->get()->first();
        return view('portal.pages.certifications.view')->with('data', $data);
    }

}
