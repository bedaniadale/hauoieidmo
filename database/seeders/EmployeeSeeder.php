<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employee_Login;
use App\Models\provincial_contact;
use App\Models\tags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        

        Employee::insert([
            'emp_id' => 20421990,
            'emp_fname' => 'Dale',
            'emp_mname' => 'Salo',
            'emp_lname' => 'Bedania',
            'emp_dept' => 'soc', 
            'emp_gender' => 'M',
            'emp_maiden_name' => '',
            'emp_dob' => now()->subYears(25)->toDateString(),
            'emp_pob' => 'Balibago, Angeles City',
            'emp_cStatus' => 'Single',
            'emp_religion' => 'Iglesia Ni Cristo',
            'emp_blood_type' => 'O+',
            'emp_houseno' => '1256',
            'street' => 'Roxas Street',
            'brgy' => 'Dau',
            'city' => 'Mabalacat City',
            'province' => 'Pampanga',
            'postal_code' => '2010',
            'profile_picture' => '',
           
            'info_status' => 'Active',
            'home_phone' => '2521321',
            'mobile_phone' => '3213321',
            'email_address_1' => 'dsbedania@student.hau.edu.ph',
            'email_address_2' => 'dale.bedania10@gmail.com',
            

            'created_at' => now(),
            'updated_at' => now(),

        ]);

        Employee_Login::insert([
            'id' => 20421990,
            'email' => 'dsbedania@student.hau.edu.ph',
            'password' => Hash::make('20421990'),
            'role' => 'SuperAdmin',
            'terminated'=>1, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        provincial_contact::insert([ 
        'id'=> 20421990, 
        'pc_emp_houseno' => '1195', 
        'pc_street' => 'Roxas Street', 
        'pc_brgy' => 'Dau',  
        'pc_city' => 'Mabalacat City', 
        'pc_province' => 'Pampanga',  
        'pc_postal_code'=>'2010',
        'pc_phone'=> '09210828947',
        
        'created_at'=> now(), 
        'updated_at'=> now(), 
        ]); 


        DB::table('tbl_emergency')->insert([ 
            'emp_id'=> 20421990, 
            'cp_fname'=> 'Juvy', 
            'cp_mname'=> 'Salo', 
            'cp_lname'=> 'Bedania', 
            'cp_relationship'=> 'Mother',
            'cp_house_no' => '1256',
            'cp_street'=> 'Roxas Street', 
            'cp_city'=> 'Mabalacat City', 
            'cp_province'=>'Pampanga', 
            'cp_postal_code'=> '2010',
            'cp_home_phone'=> '09210828947', 
            'cp_mobile_no'=> '09210828947',
            'created_at'=> now(), 
            'updated_at' => now()
        ]); 


        DB::table('tbl_accounting_details')->insert([ 
            'emp_id' => 20421990, 
            'sss_no' => '1234-5678-9021',
            'tax_no' => '1234-5678-9021', 
            'pagibig_no' => '1234-5678-9021',  
            'philhealth_no' => '1234-5678-9021', 
            'updated_at' => now(),
            'created_at'=> now()
        ]); 



            /// for user 2 

            DB::table('tbl_info')-> insert([
                'emp_id' => 20321832,
                'emp_fname' => 'Chelsea Zyra',
                'emp_mname' => 'Bolus',
                'emp_lname' => 'Cuevas',
                'emp_dept' => 'nam', 
                'emp_gender' => 'F',
                'emp_maiden_name' => '',
                'emp_dob' => now()->subYears(25)->toDateString(),
                'emp_pob' => 'Balibago, Angeles City',
                'emp_cStatus' => 'Single',
                'emp_religion' => 'Iglesia Ni Cristo',
                'emp_blood_type' => 'O+',
                'emp_houseno' => '1256',
                'street' => 'Roxas Street',
                'brgy' => 'Dau',
                'city' => 'Mabalacat City',
                'province' => 'Pampanga',
                'postal_code' => '2010',
                'profile_picture' => '20321832.jpg',
               
                'info_status' => 'Active',
                'home_phone' => '2521321',
                'mobile_phone' => '3213321',
                'email_address_1' => 'czcuevas@hau.edu.ph',
                'email_address_2' => 'dale.bedania10@gmail.com',
                

                
                'created_at' => now(),
                'updated_at' => now(),
    
            ]);
    
            DB::table('tbl_login')->insert([
                'id' => 20321832,
                'email' => 'czcuevas@hau.edu.ph',
                'password' => Hash::make('20421990'),
                'role' => 'Employee',
             
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
    
            DB::table('tbl_provincial_contact')->insert([ 
                'id'=> 20321832, 
            'pc_emp_houseno' => '1195', 
            'pc_street' => 'Roxas Street', 
            'pc_brgy' => 'Dau',  
            'pc_city' => 'Mabalacat City', 
            'pc_province' => 'Pampanga',  
            'pc_postal_code'=>'2010',
            'pc_phone'=> '09210828947',
            
            'created_at'=> now(), 
            'updated_at'=> now(), 
            ]); 
    
    
            DB::table('tbl_emergency')->insert([ 
                'emp_id'=> 20321832, 
                'cp_fname'=> 'Juvy', 
                'cp_mname'=> 'Salo', 
                'cp_lname'=> 'Bedania', 
                'cp_relationship'=> 'Mother',
                'cp_house_no' => '1256',
                'cp_street'=> 'Roxas Street', 
                'cp_city'=> 'Mabalacat City', 
                'cp_province'=>'Pampanga', 
                'cp_postal_code'=> '2010',
                'cp_home_phone'=> '09210828947', 
                'cp_mobile_no'=> '09210828947',
                'created_at'=> now(), 
                'updated_at' => now()
            ]); 
    
    
            DB::table('tbl_accounting_details')->insert([ 
                'emp_id' => 20321832, 
                'sss_no' => '1234-5678-9021',
                'tax_no' => '1234-5678-9021', 
                'pagibig_no' => '1234-5678-9021',  
                'philhealth_no' => '1234-5678-9021', 
                'updated_at' => now(),
                'created_at'=> now()
            ]); 




        for ($i = 1; $i <= 10; $i++) {
            $id = 20502020 + $i;

            

            // Insert into tbl_info
            DB::table('tbl_info')->insert([
                'emp_id' => $id,
                'emp_fname' => 'FirstName' . $i,
                'emp_mname' => 'MiddleName' . $i,
                'emp_lname' => 'LastName' . $i,
                'emp_dept'=> 'sas',  
                'emp_gender' => 'Male',
                'emp_maiden_name' => 'MaidenName' . $i,
                'emp_dob' => now()->subYears(25)->toDateString(),
                'emp_pob' => 'City' . $i,
                'emp_cStatus' => 'Single',
                'emp_religion' => 'Religion' . $i,
                'emp_blood_type' => 'O+',
                'emp_houseno' => '123',
                'street' => 'Street' . $i,
                'brgy' => 'Brgy' . $i,
                'city' => 'City' . $i,
                'province' => 'Province' . $i,
                'postal_code' => '12345',
                // 'profile_picture' => 'path/to/profile' . $i . '.jpg',
                // 'role' => 'Employee',
                'info_status' => 'Active',
                'home_phone' => '1234567',
                'mobile_phone' => '1234567890',
                'email_address_1' => 'email1_' . $i . '@example.com',
                'email_address_2' => 'email2_' . $i . '@example.com',
                

                
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into tbl_login
            DB::table('tbl_login')->insert([
                'id' => $id,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password' . $i),
                'role' => 'Employee',
                // 'profile_picture' => 'path/to/profile' . $i . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
