<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use App\Http\Controllers\AdminAuthController;
use App\Models\certifications;
use App\Models\Employee;
use App\Models\Employee_Login;
use App\Models\Employment;
use App\Models\Licenses;
use App\Models\requests;
use App\Models\respub;
use App\Models\Trainings;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str; 

class AdminPendingController  
{

        
    protected function fetchGroup($role) { 

 
        switch($role) { 
            case 'SuperAdmin': 
            case 'HR Admin': 
                $all= requests::
                    where(function ($query) {
                            $query->whereHas('certifications', function ($subQuery) {
                                $subQuery->where('status', 'Pending');
                            })
                            ->orWhereHas('modelrespub', function ($subQuery) {
                                $subQuery->where('status', 'Pending');
                            })
                            ->orWhereHas('employment', function($subQuery) { 
                                $subQuery -> where('status' , 'Pending');
                            })
                            ->orWhereHas('training', function($subQuery) { 
                                 $subQuery-> where('status', 'Pending'); 
                            })
                            ->orWhereHas('license', function($subQuery) { 
                                $subQuery->where('status','Pending'); 
                            }); 
                        })
                        ->orderBy('type', 'asc')
                        ->get();

                $certifications = requests::where('type', 'Certification')
                ->where(function($query){ 
                    $query-> whereHas('certifications', function($sq) { 
                        $sq->where('status','Pending');
                    }); 
                })->orderBy('date_submitted', 'asc')-> get(); 

                $employments = requests::where('type','Employment')
                ->where(function($query){ 
                    $query-> whereHas('employment', function($sq) { 
                        $sq->where('status','Pending');
                    }); 
                })->orderBy('date_submitted', 'asc')-> get(); 
                
                $respubs = requests::where('type','Research and Publication') 
                ->where(function($query) { 
                    $query -> whereHas('modelrespub', function($sq) {
                        $sq ->where('status', 'Pending') ; 
                    }); 
                })->orderBy('date_submitted', 'asc')->get(); 


                $trainings = requests::where('type', 'Training') 
                ->where(function($q) { 
                    $q-> whereHas('training', function($sq){ 
                        $sq->where('status','Pending'); 
                    }); 
                })->orderBy('date_submitted')->get();

                $licenses = requests::where('type', 'License') 
                ->where(function($q) { 
                    $q-> whereHas('license', function ($sq) { 
                        $sq->where('status', 'Pending'); 
                    }); 
                })->orderBy('date_submitted')->get();

               
                
                break;
            default:
                $all= requests::
                whereHas('user', function ($query) {
                    
                    
                    $query->where('emp_dept', Auth::user()->user-> emp_dept);  
                })
                ->where(function ($query) {
                    $query->whereHas('certifications', function ($subQuery) {
                        $subQuery->where('status', 'Pending');
                    })
                    ->orWhereHas('modelrespub', function ($subQuery) {
                        $subQuery->where('status', 'Pending');
                    })
                    ->orWhereHas('employment', function($subQuery) { 
                        $subQuery -> where('status' , 'Pending');
                    })
                    ->orWhereHas('training', function($subQuery) { 
                        $subQuery-> where('status', 'Pending'); 
                   })
                   ->orWhereHas('license', function($subQuery) { 
                       $subQuery->where('status','Pending'); 
                   }); 

                })
                ->orderBy('date_submitted', 'desc')
                ->get(); 


                $certifications = requests::whereHas('user', function($q) { 
                    $q->where('emp_dept', Auth::user()->user->emp_dept);
                })
                ->whereHas('certifications',function($query) { 
                    $query->where ('status', 'Pending'); 
                })->orderBy('date_submitted' , 'asc')->get(); 

                $employments = requests::whereHas('user', function($user) { 
                    $user-> where("emp_dept", Auth::user()->user-> emp_dept); 
                })
                ->whereHas('employment', function($q) { 
                    $q->where('status','Pending');  
                })->orderBy('date_submitted', 'asc')->get(); 

                $respubs = requests::whereHas('user', function($user) { 
                    $user->where('emp_dept', Auth::user()->user->emp_dept); 
                })
                ->whereHas('modelrespub', function($q) { 
                    $q-> where('status','Pending'); 
                })->orderBy('date_submitted' , 'asc') ->get()   ; 


                $trainings =  requests::whereHas('user', function($user) { 
                    $user->where('emp_dept', Auth::user()-> user-> emp_dept);
                })
                ->whereHas('training', function($q) { 
                    $q->where('status', 'Pending'); 
                })-> orderBy('date_submitted', 'asc')->get(); 

                $licenses = requests::whereHas('user', function($user) { 
                    $user->where('emp_dept', Auth::user()-> user-> emp_dept); 
                })
                -> whereHas('license', function ($q) { 
                    $q->where('status', 'Pending'); 
                })-> orderBy('date_submitted' ,'asc')-> get(); 
                

            } 

        return [$all, $certifications, $employments, $respubs, $trainings, $licenses ]; 
    }




    protected function fetchDataByUser ($id) { 
        

        $data = requests::where('emp_id', $id)
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
                ->orwhereHas('training', function($sq) { 
                    $sq-> where('Status', 'Pending'); 
                })
                ->orWhereHas('license', function($sq) { 
                    $sq-> where('Status', 'Pending'); 
                });
            })
            ->orderBy('date_submitted', 'desc')
            ->get();

        $certifications= requests::where('emp_id',$id)
        ->whereHas('certifications', function($q) { 
            $q->where('status','Pending');  
        })->orderBy('date_submitted', 'asc')->get(); 

        $employments= requests::where('emp_id',$id)
        ->whereHas('employment', function($q) { 
            $q->where('status','Pending');  
        })->orderBy('date_submitted', 'asc')->get(); 

        $respubs= requests::where('emp_id',$id)
        ->whereHas('modelrespub', function($q) { 
            $q->where('status','Pending');  
        })->orderBy('date_submitted', 'asc')->get(); 

        $trainings = requests::where('emp_id', $id) 
        -> whereHas('training' , function($q) { 
            $q-> where('status', 'Pending'); 
        })-> orderBy('date_submitted' ,'asc')-> get(); 


        $licenses = requests::where('emp_id' ,$id) 
        -> whereHas('license', function($q) { 
            $q-> where('status','Pending'); 
        })->orderBy('date_submitted', 'asc')->get(); 


        return [$data, $certifications, $employments, $respubs, $trainings, $licenses];

    }
    
  

    

    /// helper methods 


    protected function deleteRequest($id) { 
        $req = requests::findOrFail($id); 
        if($req-> delete()){ 
            return true;
        } 
    }
  


    

    /**************
     * 
     * 
     * 
     * 
     * 

     */

    //start of  APPROVE METHODS


    protected function approve($id, $type) { 
        $selection_type = [
              certifications::class, 
              Trainings::class, 
              Licenses::class,
              Employment::class, 
              respub::class, 
        ]; 

        switch($type) { 
            case 'Certification': 
                $index = 0; 
                break; 
            case 'Training';
                $index = 1; 
                break; 
            case 'License': 
                $index = 2; 
                break; 
            case 'Employment': 
                $index = 3; 
                break; 
            case 'Research and Publication':  
                $index = 4; 
                break; 
        }

        $item = $selection_type[$index]::findOrFail($id); 
        $item->update([ 
            'status'=> 'Approved'
        ]); 

        requests::destroy([$id]); //delete or destroy the request
    }


    /**************
     * 
     * 
     * 
     * 
     * 

     */

    /// START OF TO-REVIEW METHODS
    protected function review($id, $type) { 
        $selection_type = [
            certifications::class, 
            Trainings::class, 
            Licenses::class,
            Employment::class, 
            respub::class, 
      ]; 


      switch($type) { 
        case 'Certification': 
            $index = 0; 
            break;
        case 'Training': 
            $index = 1; 
            break; 
        case 'License': 
            $index =  2; 
            break; 
        case 'Employment': 
            $index = 3; 
            break; 
        case 'Research and Publication': 
            $index = 4; 
            break; 
      }

      $item = $selection_type[$index]::findOrFail($id); 

      $item->update([ 
        'status'=> 'To-review'
      ]); 

      $item->save(); 



    }



   


    //end of helper methods

    function loadPending() { 

        $fetch = $this-> fetchGroup(Auth::user()-> role);
       



        
        return view('admin.pendings.main')-> with([
            'msg' => Str::length(session('msg')) > 0 ? session('msg') : null,
            'pendings'=> $fetch[0], 
            'certifications'=>$fetch[1], 
            'employments'=> $fetch[2], 
            'respubs'=>$fetch[3] ,  
            'trainings'=> $fetch[4], 
            'licenses'=> $fetch[5]
        ]);
     
    }


    public function reviewItem($id) { 
        
        $data = requests::where('id', $id) -> get() -> first(); 



        switch($data-> type){ 
            case 'Certification': 
                $cert = certifications::where('id', $id)->get()-> first(); 
                $user= Employee::where('emp_id', $cert->emp_id)-> get()-> first(); 
                $requests = requests::where('id', $id)->get()->first(); 
                return view('admin.pendings.review.certification')->with(['data'=> $cert , 'user'=> $user, 'requests'=> $requests]); 
            case 'Research and Publication': 
                $respub = respub::where('id', $id)-> get()-> first(); 
                $user = Employee::where('emp_id', $respub-> emp_id)-> get()-> first(); 
                $requests = requests::where('id' ,$id)-> get()-> first(); 
                return view('admin.pendings.review.respub')-> with(['data'=> $respub , 'user'=> $user, 'requests'=> $requests]) ;
            case 'Employment': 
                $employment= Employment::where('id', $id)->first(); 
                $user = Employee::where('emp_id', $employment->emp_id)->first();
                $request = requests::where('id', $id)->first();
                return view('portal.pages.employments.view')->with([
                    'approval'=>true, 
                    'data'=> $employment,
                    'user'=> $user, 
                    'request'=> $request
                ]);
            case 'Training': 
                $training = Trainings::where('id',$id)-> first();
                $user = Employee::where('emp_id', $training-> emp_id)-> first(); 
                $request= requests::where('id',$id)->first(); 
                return view('portal.pages.trainings.view')-> with([ 
                    'approval'=>true, 
                    'data'=> $training, 
                    'user'=> $user, 
                    'request'=> $request
                ]);
            case 'License': 
                $license = Licenses::where('id', $id)-> first();
                $user = Employee::where('emp_id', $license-> emp_id)-> first();
                $request= requests::where('id',$id)-> first() ; 
                return view ('portal.pages.license.view')->with([ 
                    'approval'=>true, 
                    'data'=>$license,
                    'user'=> $user, 
                    'request'=> $request 

                ]);

            
                
        }

    }



    public function search(Request $request) { 
      

        $uid = $request-> emp_id; 

        //check the user if existing
        $user = Employee::where('emp_id', $uid)->get(); 
        if($user-> count()== 0) { 
            $pendings = $this-> fetchGroup(Auth::user()->role);
    
            return view('admin.pendings.main')-> with(['pendings'=>$pendings, 'user_not_found'=>'User not found...']);
        }

        //if it exist, redirect to the route
        return redirect()-> route('admin.pendings.loadsearch',['id'=>$uid]);
        
    }

    public function loadSearch(Request $request) {
    
        $user= Employee::where('emp_id', $request->emp_id)-> first(); 
        if(Auth::user()->role == 'Dean') { 
           if(!($user->department->dept  == Auth::user()->user->department->dept)) { 
                $fetch = [[],[],[],[],[],[]]; 
              
                $userfound = false; 
           } 
        } else { 

            
            $fetch = $this-> fetchDataByUser($user->emp_id);
            $userfound = true;
        }
         
        return view('admin.pendings.main')-> with([
            'user_search'=> $user,
            'pendings'=> $fetch[0], 
            'certifications'=>$fetch[1], 
            'employments'=> $fetch[2], 
            'respubs'=>$fetch[3] ,  
            'trainings'=> $fetch[4], 
            'licenses'=> $fetch[5], 
            'userfound' => $userfound
        ]) ;
    }



    

    public function approveItem($id){ 

        $data = requests::where('id', $id)-> get()-> first();   
   
        $this-> approve($id, $data->type) ;

        
        session(['msg'=> 'The request was approved']);
        return redirect()->route('admin.pendings');

    }

    public function toreviewItem($id) { 
        $data = requests::where('id', $id)-> get()-> first(); 

        $this -> review($id, $data->type); 


        session(['msg'=> 'The request was sent to be reviewed']);
        return redirect()->route('admin.pendings');

    }
 }
