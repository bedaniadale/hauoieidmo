<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Loads;
use App\Models\LoadsImport;
use App\Models\Subjects;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LoadsImportController extends Controller
{


    protected function check_existence($uid, $sid, $cid) { 
        if(!(
            LoadsImport::where('emp_id', $uid)->where('subj_id',$sid)->where('class_code', $cid) ->exists()  
            )) { 
                return true; //if true then it means the test case passed
            }
            
        return false; 
        
    }
    public function import_file(Request $request) { 
        $request->validate([ 
            'file'=> 'required|mimes:xlsx,xls'
        ]); 

        LoadsImport::truncate (); 


        if($request->hasFile('file'))  { 
            $file= $request->file('file'); 
            $spreadsheet = IOFactory::load($file-> getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet() ; 

            //get the school year and semester 
            $sy = $sheet->getCell('F2')->getValue() . '-' . $sheet->getCell('F3')->getValue(); 
            $sem = $sheet->getCell('E6')->getValue(); 
 
            foreach($sheet->getRowIterator(8) as $row) { 
                $cellIterator = $row->getCellIterator(); 
                $cellIterator-> setIterateOnlyExistingCells(true);
                $rowData = []; 
                foreach($cellIterator as $cell) {
                    $column = $cell->getColumn(); 
                    $cellValue =  $cell->getValue(); 

                    if (!empty($cellValue)) { 
                 
                        if ($column === 'A' || $column === 'B' || $column === 'C' 
                        || $column === 'D') {
                            $rowData[$column] = $cellValue; 
                        }
                    }
                } //end of cell iterator

                if (isset($rowData['A']) && isset($rowData['B']) && isset($rowData['C']) && isset($rowData['D'])) {
                    $scode =$rowData['C'];
                    $sj = Subjects::where('subj_code', $scode)->first(); 
                    $uid = $rowData['A'];
                    $ccode = $rowData['D']; 
                    if($this->check_existence($uid, $scode, $ccode) && Employee::where('emp_id', $uid)->exists()  && Subjects::where('subj_code', $scode)->exists()) { 

                        $subj= Subjects::where ('subj_code', $scode)->first(); 
                        LoadsImport::create([ 
                            'emp_id'=> $uid, 
                            'subj_id'=> $subj->subj_id,  
                            'class_code'=> $rowData['D'], 
                            'added_by'=> FacadesAuth::user()->id,
                            'sy'=> $sy, 
                            'semester'=> $sem    
                        ]);
                        

                    } 
                } 

            } //end of row iterator


            return view('admin.loads.import.upload')->with([ 
                'loads'=> LoadsImport::all(),
                'imported'=> true
            ]); 
        }
    }


    public function upload_file() { 
        $loads = LoadsImport::all(); 

        foreach($loads as $load) { 
            if(!(Loads::where('emp_id', $load->emp_id)
                ->where('subj_id', $load->subj_id)
                ->where('subj_code' ,$load->class_code)
                ->where('semester', $load->semester) 
                ->where('sy', $load->sy)
                ->exists()))  { 
                    Loads::create([ 
                        'emp_id'=> $load->emp_id,
                        'subj_id'=> $load->subj_id, 
                        'class_code'=> $load->class_code, 
                        'sy'=> $load->sy, 
                        'semester'=> $load->semester, 
                        'added_by'=> $load->added_by

                    ]); 
            }
        }

     
        //return here 

    }
}
