<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employment;
use App\Models\requests;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Storage as AttributesStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class EmploymentController extends Controller
{

    protected function generate_id() { 
        do { 
            $gen = Auth::user()->id . Str::random(8); 
        } while(Employment::where('id', $gen)->exists()); 

        
        
        return $gen; 


    }


    public function update($id, Request $request) { 

        $request->validate([ 
            'company'=> 'string', 
            'position'=> 'string', 
            'date_hired'=> 'date', 
            'date_resigned'=> 'date', 
            'reason'=> 'string', 
        ]); 


        $item = Employment::findOrFail($request->id); 

        $item->update([
            'company'=> $request->company, 
            'position'=> $request->position, 
            'date_hired'=> $request->date_hired, 
            'date_resigned'=> $request->date_resigned, 
            'reason'=> $request->reason
        ]);


        $item->save();



     
        $path = 'employment/' . Auth::user()-> id. '/';
    

        //if there is a file, update the file
        if($request->file('attachment'))  { 

            $item_extension = explode('.', $item->attachment)[1];
            Storage::disk('public')->delete($path . $item->id . '.'. $item_extension);
            $filename = $id . '.' . $request->file('attachment')-> getClientOriginalExtension();  
            $request->file('attachment')->storeAs($path , $filename, 'public'); 
            $item->attachment = $request->file('attachment')-> getClientOriginalName(); 
            $item->save ();
        }


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


        return redirect()->route('portal.employment')->with([
            'msg'=>'Record has been successfully updated', 
        ]); 
    }

    public function store( Request $request) { 
       
        $request->validate([
            'company'=> 'string', 
            'position'=> 'string', 
            'date_hired'=> 'date', 
            'date_resigned'=> 'date', 
            'reason'=> 'string',
            'attachment' => 'file'
        ]);

        $new_id = $this -> generate_id();



        //create the directory
        $path = 'employment/' . Auth::user()->id; 
        if(!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        //upload the file 
        $fileName = $new_id . '.' . $request->file('attachment')->getClientOriginalExtension(); 
        $request->file('attachment')-> storeAs($path, $fileName, 'public');



          ///insert to the employment tabl
          Employment::create([
            'id'=> $new_id, 
            'emp_id'=> Auth::user()-> id, 
            'company'=> $request->company, 
            'position'=> $request-> position,
            'date_hired'=> Carbon::parse($request-> date_hired)-> format('Y-m-d'),
            'date_resigned'=> Carbon::parse($request-> date_resigned)-> format('Y-m-d'),
            'position'=> $request-> position,
            'reason'=> $request-> reason, 
            'status'=> 'Pending', 
            'attachment'=>$request->file('attachment')-> getClientOriginalName(),
            'updated_at'=> now(), 
            'created_at'=> now()
        ]); 



        // send a request to admin 
        DB::table('requests')->insert([
            'id'=> $new_id, 
            'emp_id'=> Auth::user()-> id, 
            'title'=> $request-> company . ' - ' . $request->position, 
            'type'=> 'Employment', 
            'date_submitted'=> now()
        ]);



        return redirect()->route('portal.filing.success');


    }


    public function destroy($id) {
        $req = Employment::findOrFail($id);  


        // if pending, we need to delete the request ticket
        if($req->status == 'Pending') {
            $req_ticket = requests::findOrFail($id); 
            $req_ticket->delete(); //delete the request ticket 
        }



       
        //delete the file 
        $fn = $id . '.' . explode('.' , $req->attachment)[1]; 
        $fp = 'employment/' . Auth::user()->id . '/' . $fn; 
        Storage::disk('public')->delete($fp);

        $req->delete (); 


        return redirect()->route('portal.employment')->with([ 
            'msg'=> 'Record has been deleted.'
        ]); 
    }


    public function resubmit($id) { 
        $item = Employment::findOrFail($id); 
        $item->update([ 
            'status'=> 'Pending' 
        ]);

        return redirect()-> route('portal.employment')-> with([ 
            'msg'=> 'The record has been successfully resubmitted and is now back in the pending requests. Thank you for your attention to this matter.'
        ]); 
    }
}
