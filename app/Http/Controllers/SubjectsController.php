<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Loads;
use App\Models\Subjects;
use App\Models\temp_subjects;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubjectsController extends Controller
{
    
  
    public function loadSearch(Request $request, $subj) { 
        if(Loads::where("subj_id", $subj)->where('emp_id',$request->emp_id)->exists()) { 
            $existing = true; 
        } else { 
            $existing = false; 
        }
        
      
        return view('admin.subjects.load')->with([ 
            'subj'=> Subjects::where('subj_id' ,$subj) ->first(), 
            'user'=> Employee::where('emp_id', $request->emp_id)->first(),
            'loads'=> Loads::where('emp_id', $request->emp_id)->get(), 
            'status'=> $existing
        ]); 
    }


   
    public function search(Request $request) { 
    

        $query = $request->get('query');
    


        $subj = Subjects::where('subj_title', 'LIKE', "%{$query}%")
        ->orWhere('subj_code', 'LIKE', "%{$query}%") 
        ->orWhere('subj_id', 'LIKE', "%{$query}%")
        ->get();
        return response()->json($subj);
        
    }

    public function view(Request $request) { 
        $subj = Subjects::where('subj_code', $request->id)-> get()-> first(); 

        return view('admin.subjects.view')-> with(['subj'=> $subj]);
    }

    public function add() { 
        do {
            $rand = sprintf('%04d', mt_rand(0, 9999));
            $subj_id= DB::table('subjects')->where('subj_code', $rand)->exists();
        } while ($subj_id);
        
        $code = $rand; 
        return view('admin.subjects.add')-> with(['subj_id'=> $code]); 
        

        
    }

    public function load_to_user(Request $request) { 
        Loads::create([ 
            'emp_id'=> $request->user, 
            'subj_id'=> $request-> subj, 
            'added_by'=> Auth::user()->id
        ]);

        return redirect()->route('admin.loads.db')->with([ 
            'msg'=> 'Subject was loaded to user.'
        ]); 

    }


    public function store(Request $request) { 

        $request->validate([
            'subj_id'=> 'string', 
            'subj_code'=> 'string', 
            'subj_title'=> 'string', 
            'subj_description'=> 'string|nullable', 
        ]);



        
        $created= Subjects::create([
            'subj_id' => $request->subj_id,
            'subj_code'=> $request-> subj_code, 
            'subj_title'=> $request-> subj_title, 
            'subj_description'=> '',
            'units'=> $request-> units
        ]); 
        if($created) { 
            return redirect()-> route('admin.subjects')-> with(['msg'=>'New subject added.']); 
        }
        
    }


    public function destroy($id) { 
        
        //delete the subject from the table
        Subjects::where('subj_code', $id)-> get()-> first()->delete(); 
        
       
        //delete all the loads with the subj 
        Loads::where('subj_code', $id) -> delete(); 

        return redirect()-> route('admin.subjects'); 

    }

    public function delete(Request $request) { 
        $items = $request->input('items');



        foreach($items as $i) { 
            //delete from the model 

            Subjects::destroy([$i]); 

            //delete all loads
            $loads = Loads::where('subj_id', $i)-> get(); 
            foreach($loads as $load){ 
                Loads::destroy([$load->id]);
            }
        }   

        return redirect()->route('admin.subjects'); 
    }


    
    public function search_item(Request $request)
{
    $query = $request->get('query');
    $subjects = Subjects::where('subj_code', 'LIKE', "%{$query}%")
                       ->orWhere('subj_title', 'LIKE', "%{$query}%")
                       ->orWhere('subj_id', 'LIKE', " %{$query}%")
                       ->get();

    return response()->json($subjects);
}


public function import_file(Request $request) { 
    $request->validate([
        'file'=> 'required|mimes:xlsx,xls' 
    ]); 

    temp_subjects::truncate(); 

    if ($request->hasFile('file')) { 
        $file = $request->file('file'); 
        $spreadsheet = IOFactory::load($file->getRealPath()); 
        
        $sheet = $spreadsheet->getActiveSheet(); 

     
     
        foreach ($sheet->getRowIterator(8) as $row) { 
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true); 

            $rowData = [];
            foreach ($cellIterator as $cell) { 
                $column = $cell->getColumn(); 
                $cellValue = $cell->getValue(); 

               
                if (!empty($cellValue)) { 
                 
                    if ($column === 'A' || $column === 'B' || $column === 'C') {
                        $rowData[$column] = $cellValue; 

              
                    }
                }
            }


            if (isset($rowData['A']) && isset($rowData['B']) && isset($rowData['C'])) {
           
                temp_subjects::create([ 
                    'subj_code' => $rowData['A'], 
                    'subj_title' => $rowData['B'], 
                    'units' => $rowData['C']       
                ]); 
            } 
        }


        return view('admin.subjects.upload')->with([
            'imported'=> true, 
            'subjects'=>temp_subjects::all()
        ]); 
    }
}


public function load_file() { 
    $data = temp_subjects::all();
  
    foreach($data as $row) { 
        if(!Subjects::where('subj_code', $row->subj_code)->exists()) { 

            do {
                $id = sprintf('%04d', mt_rand(0, 9999));
                
            } while (Subjects::where('subj_id', $id)->exists());
    
            Subjects::create([ 
                'subj_id'=> $id, 
                'subj_code'=> $row->subj_code, 
                'subj_title'=> $row->subj_title, 
                'subj_description'=>'', 
                'units'=> $row-> units
            ]); 
        }


        
    }

    return redirect()->route('admin.subjects'); 
}


} 
