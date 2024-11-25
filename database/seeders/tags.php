<?php

namespace Database\Seeders;

use App\Models\semconfig;
use Illuminate\Database\Seeder;
use App\Models\tags as tagmodel; 

class tags extends Seeder { 

   



    public function run(): void { 

        $gender = ['Male', 'Female'];
        $license_types = [
            'Professional Regulation Commission (PRC) License',
            'Civil Service Commission (CSC) Eligibility',
            'TESDA National Certificate',
            'Teaching License',
            'Board Exam Certifications',
            'Driver’s License',
            'Medical License',
            'Engineering License',
            'Legal Bar License',
            'Real Estate Broker License'
        ];
        $training_types = [
            'Professional Development',
            'Technical Skills',
            'Leadership and Management',
            'Research and Development',
            'Soft Skills',
            'Compliance Training',
            'Community Engagement',
            'Digital Literacy'
        ];


        $emp_category = [
            'FACULTY', 
            'NTP'
        ]; 

        $emp_status = [ 
            'FULL-TIME', 
            'PART-TIME'
        ]; 

        $tenure = [ 
            'PERMANENT',
            'PROBATIONARY',
            'NON-TENURED'
        ]; 

        $non_tenured = [ 
            'Fixed Term',
            'GL',
            'Contractual',
            'Substitution'
        ];


        $semesters = [ 
            '1ST SEMESTER', 
            '2ND SEMESTER', 
            '1ST TRIMESTER', 
            '2ND TRIMESTER', 
            '3RD TRIMESTER', 

        ]; 


        //seeder for gender tags 
        foreach($gender as $item) { 
            tagmodel::create([ 
                'category'=> 'gender', 
                'item'=> $item
            ]); 
        }


        //seeder for license types
        foreach($license_types as $item) { 
            tagmodel::create([ 
                'category'=> 'license_type', 
                'item'=> $item 
            ]); 
        }

        //seeder for training types
        foreach($training_types as $item) { 
            tagmodel::create([ 
                'category'=> 'training_type', 
                'item'=> $item 
            ]); 
        }

        foreach($emp_category as $item) { 
            tagmodel::create([ 
                'category'=> 'emp_category',
                'item'=> $item
            ]); 
        }

        foreach($emp_status as $item) { 
            tagmodel::create([ 
                'category'=> 'emp_status', 
                'item'=> $item
            ]); 
        }

        foreach($tenure as $item)  { 
            tagmodel::create([ 
                'category'=> 'tenure',
                'item'=> $item
            ]); 
        }

        foreach($non_tenured as $item) { 
            tagmodel::create([ 
                'category'=> 'non_tenured', 
                'item'=> $item
            ]);
        }


        foreach($semesters as $item) { 
            tagmodel::create([ 
                 'category'=> 'semester', 
                 'item'=> $item
            ]); 
        }


        semconfig::create([ 
            'category'=> 'reg',
            'current_sy'=> '2024-2025', 
            'current_sem'=> '1ST SEMESTER' 
        ]); 

        semconfig::create([ 
            'category'=> 'tri',
            'current_sy'=> '2024-2025', 
            'current_sem'=> '1ST TRIMESTER' 
        ]); 



    }
}

?> 