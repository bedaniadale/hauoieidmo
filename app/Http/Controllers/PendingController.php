<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 
use Illuminate\Support\Facades\Auth;

//import models here
use App\Models\respub as modelrespub; 
use App\Models\requests; 
use App\Models\certifications;
use App\Models\Employee;
use GuzzleHttp\Psr7\Query;

class PendingController extends Controller
{

    protected function delete_certification($id) { 
       
        $item = certifications::findOrFail($id);
        $delete = $item->delete();

        if ($delete) {
            $del_req = requests::findOrFail($id);
            if ($del_req->delete()) {
           
                return true; 
                
            }
        }
    } 

    protected function delete_respub($id) { 

        $item = modelrespub::findOrFail($id);
        $delete = $item->delete();

        if ($delete) {
            $del_req = requests::findOrFail($id);
            if ($del_req->delete()) {
           
                return true; 
                
            }
        }
    }

    function create():View {
        $pendings = requests::where('emp_id', Auth::user()->id)
        ->where(function($query) {
            $query->whereHas('certifications', function($subQuery) {
                $subQuery->where('status', 'Pending');
            })
            ->orWhereHas('modelrespub', function($subQuery) {
                $subQuery->where('status', 'Pending');
            })
            ->orWhereHas('employment', function($subQuery) { 
                $subQuery -> where('status' , 'Pending');
            })
            ;
        })
        ->orderBy('type', 'asc')
        ->get();


        $certifications = requests::where('emp_id', Auth::user()->id)
        ->where(function($query) { 
            $query->whereHas('certifications', function($sq) { 
                $sq->where('status', 'Pending'); 
            });
        })
        ->orderBy('date_submitted', 'desc')->get(); 


        $respubs = requests::where('emp_id', Auth::user()->id)
        ->where(function($query) { 
            $query->whereHas('modelrespub', function($sq) { 
                $sq->where('status', 'Pending'); 
            });
        })->orderBy('date_submitted', 'desc')->get(); 

        $employments = requests::where('emp_id', Auth::user()->id)
        ->where(function($q){ 
            $q->whereHas('employment', function($sq) { 
                $sq->where('status' ,'Pending'); 
            }); 
        })->orderBy('date_submitted', 'desc')->get(); 
        

        $licenses = requests::where('emp_id', Auth::user()->id) 
        ->where(function($q){
            $q->whereHas('license', function($sq){ 
                $sq->where('status', 'Pending');
            });
        })->orderBy('date_submitted' ,'desc')->get();

        $trainings = requests::where('emp_id' ,Auth::user()-> id) 
        ->where(function($q) { 
            $q->whereHas('training', function($sq) { 
                $sq->where ('status','Pending'); 
            }); 
        })->orderBy('date_submitted', 'desc')-> get(); 


        
        return view('portal.pages.filing.pending-requests')->with([
            'user'=> Employee::where('emp_id', Auth::user()->id)->first(),
            'pendings'=> $pendings, 
            'certifications'=> $certifications,
            'respubs'=> $respubs,
            'employments'=> $employments,
            'trainings'=> $trainings, 
            'licenses'=>$licenses
        ]);

    }

    function viewInfo($id) { 
        $info = requests::where('id', $id)->get()->first(); 
  
        switch($info->type) { 
            case 'Research and Publication': 
                return redirect()->route('portal.respub.view', ['id'=> $id]); 
                
            case 'Certification': 
                return redirect()->route('portal.certifications.view' , ['id'=> $id]); 
            
            case 'Employment': 
                return redirect()->route('portal.employment.view', ['id'=> $id]);

        } 
          
        
    }

function destroyRequest($id) { 
        $info = requests::where('id', $id)->get()->first(); 
    
  
        switch($info->type) { 

            case 'Certification': 
                if($this->delete_certification($id)) { 
                    session(['msg' => 'Certification was deleted.']);
                    return redirect()->route('portal.pending.certification');
                }
            case 'Research and Publication': 
                if($this->delete_respub($id)) { 
                    session(['msg' => 'Research/publication was deleted.']);
                    return redirect()->route('portal.pending.respub');

                }

        } 
    }





    public function search(Request $request) {
        $emp_dept = Employee::where('emp_id', Auth::user()->id)->value('emp_dept'); 
        $query = $request->get('query');


        switch(Auth::user()-> role){ 
            //if the role is super admin, search results will not be filtered
            case 'SuperAdmin': 
                $emp = Employee::where('emp_id', 'LIKE', "%{$query}%")
                ->orWhere('emp_fname', 'LIKE', "%{$query}%")
                ->orWhere('emp_mname', 'LIKE', "%{$query}%")
                ->orWhere('emp_lname', 'LIKE', "%{$query}%")
                ->get();

                break; 
            case 'HR Admin': 
                $emp = Employee::where('emp_dept', $emp_dept)
                -> where(function($subQuery) use ($query){ 
                    $subQuery->where('emp_id', 'LIKE', "%{$query}%")
                    ->orWhere('emp_fname', 'LIKE', "%{$query}%")
                    ->orWhere('emp_mname', 'LIKE', "%{$query}%")
                    ->orWhere('emp_lname', 'LIKE', "%{$query}%");
                })
                ->get(); 
                break; 
        }

        return response()->json($emp);


        
        
    }

    

}
// 