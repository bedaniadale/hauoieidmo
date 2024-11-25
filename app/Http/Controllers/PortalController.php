<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Employee; 
use App\Models\provincial_contact;
use App\Models\acc_details;
use App\Models\emergency; 
use App\Models\dependencies; 

class PortalController extends Controller
{

    // Updating personal data 
    public function updatePersonal(Request $request, $id ) { 
        $date_of_birth = Carbon::parse($request->emp_dob)->format('Y-m-d');
        $request->merge([ 
            'emp_dob' => $date_of_birth, 
            'updated_at'=> now()
        ]); 


     
        $validatedData = $request->validate([
            'emp_fname' => 'string', 
            'emp_mname'=> 'string', 
            'emp_lname'=> 'string', 
            'emp_gender' => 'string', 
            'emp_dob'=> 'nullable|date', 
            'emp_pob' => 'string', 
            'emp_cStatus'=> 'string', 
            'emp_religion'  => 'string' , 
            'emp_blood_type' => 'string' 
        ]); 


        $data = Employee::findOrFail($id); 
        $data->update($validatedData); 


        

        return redirect()->route('portal.profile')->with('success', 'Personal data updated successfully.'); 

    }

    //Updating Contact Information
    public function updateContact(Request $request, $id) { 

        $request -> merge([
            'updated_at'=>now() 
        ]); 

        $validateData = $request->validate([
            'emp_houseno'=>  'string', 
            'street'=>'string',
            'brgy'=> 'string', 
            'city'=> 'string', 
            'province' => 'string', 
            'postal_code' =>  'integer', 
            'home_phone'=> 'string', 
            'mobile_phone'=> 'string', 
            'email_address_1' => 'string',
            'email_address_2' => 'string'
        ]); 

        $data = Employee::findOrFail($id); 
        $data -> update($validateData); 

       

        return redirect()-> route('portal.profile')-> with('success','Contact Information data updated successfully.'); 

    }
    
    

    //Updating Accounting
    public function updateAccounting(Request $request,$id) { 
 

        $request-> validate([
            'sss_no'=> 'string', 
            'tax_no' => 'string', 
            'pagibig_no'=> 'string' , 
            'philhealth_no' => 'string', 
           
        ]); 


    
        if(acc_details::where('emp_id', Auth::user()->id)){ 
            acc_details::create([ 
                'emp_id'=> Auth::user()->id,
                'sss_no'=> $request->sss_no, 
                'tax_no'=> $request->tax_no, 
                'pagibig_no'=>$request->pagibig_no, 
                'philhealth_no'=> $request->philhealth_no
            ]);
        } else { 

            $data = acc_details::findOrFail($id); 
            
            $data -> update([ 
                'sss_no'=> $request->sss_no, 
                'tax_no'=> $request->tax_no, 
                'pagibig_no'=>$request->pagibig_no, 
                'philhealth_no'=> $request->philhealth_no
            ]);   
        }

        return redirect()-> route('portal.profile')-> with('success', 'Accounting Details Information successfully updated.'); 
    }



   // Updating Provincial Contact
public function updateProvincial(Request $request, $id) { 
    $request->validate([
        'pc_emp_houseno'=> 'string', 
        'pc_street' => 'string', 
        'pc_brgy' => 'string', 
        'pc_city'=> 'string' , 
        'pc_province' => 'string', 
        'pc_postal_code'=> 'string', 
        'pc_phone'=> 'string' 
    ]); 

    // Check if the provincial_contact already exists for the user
    if (!provincial_contact::where('id', Auth::user()->id)->exists()) { 
        // Create new provincial contact if it does not exist
        provincial_contact::create([ 
            'id'=> Auth::user()->id,
            'pc_emp_houseno'=> $request->pc_emp_houseno, 
            'pc_street'=> $request->pc_street, 
            'pc_brgy'=> $request->pc_brgy, 
            'pc_city'=> $request->pc_city, 
            'pc_province'=> $request->pc_province, 
            'pc_postal_code'=> $request->pc_postal_code, 
            'pc_phone'=> $request->pc_phone,
        ]);
    } else { 
        // If it exists, find and update the existing provincial contact
        $data = provincial_contact::findOrFail($id); 
        $data->update([ 
            'pc_emp_houseno'=> $request->pc_emp_houseno, 
            'pc_street'=> $request->pc_street, 
            'pc_brgy'=> $request->pc_brgy, 
            'pc_city'=> $request->pc_city, 
            'pc_province'=> $request->pc_province, 
            'pc_postal_code'=> $request->pc_postal_code, 
            'pc_phone'=> $request->pc_phone,
        ]);   
    }

    return redirect()->route('portal.profile')->with('success', 'Provincial Contact Information successfully updated.'); 
}



    // Updating Emergency Contact
public function updateEmergency(Request $request, $id){ 
    $request->validate([
        'cp_fname'=> 'string', 
        'cp_mname' => 'string', 
        'cp_lname' => 'string', 
        'cp_relationship'=> 'string', 
        'cp_house_no'=> 'string', 
        'cp_street'=> 'string', 
        'cp_brgy'=> 'string', 
        'cp_city'=> 'string', 
        'cp_province'=> 'string', 
        'cp_postal_code'=> 'integer', 
        'cp_home_phone'=> 'string', 
        'cp_mobile_no' => 'string'
    ]);

    // Check if emergency contact exists for the user
    if (!emergency::where('emp_id', Auth::user()->id)->exists()) { 
        // Create a new emergency contact if it does not exist
        emergency::create([ 
            'emp_id'=> Auth::user()->id,
            'cp_fname'=> $request->cp_fname, 
            'cp_mname'=> $request->cp_mname, 
            'cp_lname'=> $request->cp_lname, 
            'cp_relationship'=> $request->cp_relationship, 
            'cp_house_no'=> $request->cp_house_no, 
            'cp_street'=> $request->cp_street, 
            'cp_brgy'=> $request->cp_brgy, 
            'cp_city'=> $request->cp_city, 
            'cp_province'=> $request->cp_province, 
            'cp_postal_code'=> $request->cp_postal_code, 
            'cp_home_phone'=> $request->cp_home_phone, 
            'cp_mobile_no'=> $request->cp_mobile_no,
        ]);
    } else { 
        // If it exists, find and update the existing emergency contact
        $data = emergency::findOrFail($id); 
        $data->update([ 
            'cp_fname'=> $request->cp_fname, 
            'cp_mname'=> $request->cp_mname, 
            'cp_lname'=> $request->cp_lname, 
            'cp_relationship'=> $request->cp_relationship, 
            'cp_house_no'=> $request->cp_house_no, 
            'cp_street'=> $request->cp_street, 
            'cp_brgy'=> $request->cp_brgy, 
            'cp_city'=> $request->cp_city, 
            'cp_province'=> $request->cp_province, 
            'cp_postal_code'=> $request->cp_postal_code, 
            'cp_home_phone'=> $request->cp_home_phone, 
            'cp_mobile_no'=> $request->cp_mobile_no,
        ]);   
    }

    return redirect()->route('portal.profile')->with('success','Emergency Information successfully updated.'); 
}




    public function searchDependency(Request $request) { 
        $search = $request->input('search');

        $dependencies_search = dependencies::query()
            ->when($search, function($query, $search) {
                return $query->where('fname', 'like', "%{$search}%")
                             ->orWhere('mname', 'like', "%{$search}%")
                             ->orWhere('lname', 'like', "%{$search}%")
                             ->orWhere('relationship','like',"%{$search}%"); 
            })
            ->get();

        session(['dependencies'=>$dependencies_search]); 

        return view('portal.pages.dependencies'); 
    }
}


