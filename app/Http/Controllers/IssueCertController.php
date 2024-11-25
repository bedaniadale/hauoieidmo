<?php

namespace App\Http\Controllers;

use App\Models\certifications;
use App\Models\HAUCert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IssueCertController extends Controller
{

    protected function generate_cert_id() { 
        do{  
            $id = Auth::user()->id . 'cert' . Str::random(8);
        }while(certifications::where('id', $id)->exists()); 

        return $id; 
    }

    protected function generate_id() { 
        do { 
            $id = Auth::user()->id . 'haucert' . Str::random(8); 
        } while(HAUCert::where('id', $id)->exists()); 

        return $id; 
    }
    public function create_certification(Request $request) { 

        $cert_id = $this->generate_id(); 
        


        $request->validate([
            'date_issued' => 'date',
            'duration' => 'string',
            'cert_title' => 'string',
            'cert_validity' => 'date',
            'cert_type' => 'string',
            'role' => 'string',
            'issued_by' => 'string',
        ]);
        
        $filePath = 'hau_certs/' ; 

        // if(!Storage::exists($filePath)) { 
        //     Storage::makeDirectory($filePath);
        // }

        $fileName = $cert_id . '.' . $request->file('attachment')->getClientOriginalExtension(); 
        
        //STORE THE FILE 
        $request->file('attachment')->storeAs($filePath, $fileName, 'public');


        HAUCert::insert([
            'id' => $cert_id, 
            'attachment' => $request->file('attachment')->getClientOriginalName(),
            'date_issued' => $request->date_issued,
            'duration' => $request->duration,
            'cert_title' => $request->cert_title,
            'cert_validity' => $request->cert_validity,
            'cert_type' => $request->cert_type,
            'role' => $request->role,
            'file_path' => $filePath . $fileName,
            'issued_by' => $request->issued_by,
            'created_by'=> Auth::user()->id,
            'created_at' => now(), // for timestamps
            'updated_at' => now(),
        ]);


        return redirect()->route('admin.certs.load' ,['id'=> 
        $cert_id]); 
        
        
    }



    public function load_issue($id) { 
     
        return view('admin.certs.send')-> with([ 
            'data'=> HAUCert::where('id', $id)->first()
        ]); 
    }

    
    public function issue_cert(Request $request, $id) {
        $queuedUsers = json_decode($request->input('queued_users'), true); // Decode the JSON string into an array

        $cert= HAUCert::where('id', $id)-> first(); 
        
    
        // Iterate through the user IDs
        foreach ($queuedUsers as $empId) {
            $cert_id = $this->generate_cert_id(); 
         
    
            // Set a path for the user's certification
            $path = 'certifications/' . $empId;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
    
          
            $sourcePath = 'storage/'. $cert->file_path; // Adjust if necessary
    
            // Generate a new file name for the copied file
            $newFileName = $cert_id . '.' . explode('.' ,$cert->attachment)[1] ; 

            $destinationPath = $path . '/' . $newFileName;
    
            // Check if the source file exists
            if (File::exists(public_path($sourcePath))) {
                // Copy the file to the new location
                File::copy(public_path($sourcePath), storage_path('app/public/' . $destinationPath));
            } else {
                throw new \Exception('Source file does not exist at ' . $sourcePath);
            }
    
            // Insert certification data into the database
            certifications::insert([
                'id' => $cert_id,
                'emp_id' => $empId,
                'attachment' => $newFileName, // Original file name kept here for reference
                'date_issued' => $cert->date_issued,
                'file_path' => $destinationPath, // Updated file path to the new file
                'issued_by' => $cert->issued_by, 
                'duration' => $cert->duration,
                'cert_title' => $cert->cert_title,
                'cert_validity' => $cert->cert_validity,
                'cert_type' => $cert->cert_type,
                'hau_cert' => $id, 
                'role' => $cert->role,
                'status' => 'Approved',
                'created_at' => now(),
                'updated_at' => now()
            ]);

        }
        session(['msg'=> 'Batch issue']);
        return redirect()->route('admin.certs'); 
    }
    


}
