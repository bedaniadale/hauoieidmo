<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\View\View; 


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str; 



//import models here
use App\Models\dependencies;
use App\Models\dependency_entries;
use App\Models\Employee;
use App\Models\requests; 

class DependencyController extends Controller
{



    protected function generateId() { 
        do { 
            $id = Auth::user()->id . 'ude' . Str::random(8); 
        } while(dependencies::where('id',$id)->exists()); 

        return $id;

    }



    //PAGE LOADERS


    //load the page
    public function loadDependencies(Request $request): View 
    { 

        $userId = Auth::user()->id; 
        $dependencies = dependencies::where('emp_id', $userId)-> get(); 
        $user = Employee::where('emp_id', Auth::user()-> id) -> first();


        return view('portal.pages.dependencies.dependencies')-> with([
            'dependencies'=> $dependencies, 
            'user'=> $user
        ]);
    }

    public function loadEdit(Request $request, $id): View { 

        $data = dependencies::where('id', $id)-> get()-> first(); 
       
        return view('portal.pages.dependencies.edit')->with('toedit', $data); 
    }


    public function loadAdd(Request $request): View 
     { 
        return view('portal.pages.dependencies.add'); 
     }




     //search and load the page
    public function searchDependency(Request $request) { 
        $search = $request->input('search');

        $userid = Auth::user()->id; 

        $dependencies_search = dependencies::query()
        ->where('emp_id', $userid)
        ->when($search, function($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('fname', 'like', "%{$search}%")
                      ->orWhere('mname', 'like', "%{$search}%")
                      ->orWhere('lname', 'like', "%{$search}%")
                      ->orWhere('relationship', 'like', "%{$search}%");
            });
        })
        ->get();
        // dd($dependencies_search);
        session(['dependencies'=>$dependencies_search]); 

        return view('portal.pages.dependencies.dependencies'); 
    }


    //add new dependent
    public function addDependent(Request $request) : RedirectResponse  
    {
        $userId = Auth::user()->id; 

    
        $generatedId = $this->generateId(); 

        $date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');

        $now = now(); 

        dependencies::create([
            'id'=> $generatedId, 
            'emp_id'=> $userId, 
            'fname' => $request -> fname, 
            'mname'=> $request -> mname,
            'lname'=> $request -> lname,
            'relationship'=>$request->relationship, 
            'date_of_birth'=> $date_of_birth,
        ]);


        

     
        session(['msg'=> 'New dependency added']); 
        
            
        return redirect()->route('portal.dependencies');
      
    }


    public function destroy($dep_id): RedirectResponse { 

      
        $dependency = dependencies::findOrFail($dep_id);
        $dependency->delete();
        session(['msg'=> 'Dependent was deleted.']); 
        return redirect()-> route('portal.dependencies');
    }

    public function clearAll() : RedirectResponse {

        $userId = Auth::user()->id; 

        DB::table('tbl_dependencies') -> where('emp_id', $userId)-> delete(); 

        session(['msg'=> "Dependencies cleared."]);
        
        return redirect()->route('portal.dependencies'); 
    }

    public function updateDependent(Request $request, $id): RedirectResponse 
    { 
        $date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');

        $request-> merge([
            'date_of_birth'=> $date_of_birth,
            'updated_at'=> now()
    ]);

        $validateData= $request-> validate([
            'fname'=> 'string', 
            'mname'=> 'string', 
            'lname'=> 'string', 
            'relationship'=> 'string', 
            
        ]);

        $data= dependencies::findOrFail($id); 
        $data-> update($validateData); 


        session(['msg'=>'Data updated successfully.']); 
        return redirect()-> route('portal.dependencies'); 
    }

    public function viewItem($id) { 
        $viewdata = dependencies::where('id', $id)->get()-> first();
        
        return view('portal.pages.dependencies.view')-> with('viewdata', $viewdata); 
    }


    
}
