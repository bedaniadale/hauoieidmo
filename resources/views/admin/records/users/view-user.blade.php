<x-app-layout>
    <div class="flex justify-center py-8">
        <div class="w-[95%] bg-white rounded-lg p-8 shadow-lg">
            <h1 class="text-3xl font-extrabold text-gray-800 text-center">View User Profile</h1>

            <div class="flex items-center justify-center gap-2 mt-4">
                <img src="{{ asset('images/icons/users_maroon.png') }}" class="w-6 h-6" alt="Users Icon">
                <a href="{{ route('admin.users') }}" class="text-red-900 hover:text-red-700 font-semibold">Users</a>
                <span class="text-lg"> &gt; </span>
                <span class="font-semibold">{{ $data->emp_id }}</span>
            </div>

            <hr class="opacity-90 my-4">

            <div class="w-full py-2 mb-2">

                @if(isset($msg))
                <div id="actmsg" class="bg-green-100 text-green-900 font-semibold py-2 px-4 rounded-lg flex items-center gap-2 text-[1rem]">
                    <img src="{{ asset('images/icons/success.png') }}" alt="Activate Icon" class="w-[20px] h-[20px]">
                    <p>{{$msg}}</p>
                </div>
                @endif
                
            </div>

            <div class="w-full">
                   
                        @if($data->login->terminated == 0)
                        <form class="w-full flex justify-center items-center" action="{{route('admin.users.terminate',['id'=> $data->emp_id])}}" method = "POST">
                            @csrf 
                            @method('PUT') 

                            <button type="button" onclick = "confirmTerminate(this)" class="bg-white text-red-900 flex gap-2 justify-center items-center py-2 px-8 rounded-lg border-2 border-red-900 shadow-md hover:bg-red-100 hover:shadow-lg focus:outline-none focus:ring-2">
                                <img src="{{asset('images/icons/terminate.png')}}" alt="" class="w-[25px] h-[25px]">
                                <p class="text-sm font-medium">Terminate User Account</p>
                            </button>

                        </form>
                        @else
                        <form class="w-full flex justify-center items-center" action="{{route('admin.users.activate',['id'=> $data->emp_id])}}" method = "POST">
                        @csrf 
                        @method('PUT')
                            <button type="button" onclick = "confirmActivate(this)" class="bg-white text-green-900 flex gap-2 justify-center items-center py-2 px-8 rounded-lg border-2 border-green-900 shadow-md hover:bg-green-100 hover:shadow-lg focus:outline-none focus:ring-2">
                                <img src="{{asset('images/icons/restore.png')}}" alt="" class="w-[25px] h-[25px]">
                                <p class="text-sm font-medium">Activate User Account</p>
                            </button>
                        </form>                         
                        @endif
               


                       <a href="route('admin.users.edit', $data->emp_id); "></a>

                </div>


           
<div class = "profile-card"> 
    <!-- each section will be placed here  -->

    <div class = "account-info"> 
        <div class = "account-info-box">  
            <div class = "account-info-box-left"> 
                <div class = "account-image" >   @if($data->profile_picture)
                            <img class = "acc-img" src ="{{asset ('storage/profile_pictures/' . $data->profile_picture)}}" alt = "user_image"/> 
                            @else 
                            <img class = "acc-img" src ="{{asset ('images/blankdp.jpg')}}" alt = "user_image"/> 
                            @endif       
            
            </div>
                <div class = "account-details"> 
                    <h1 id = "empid">  {{$data->emp_id}} </h1>
                    <h1  class="text-2xl text-gray-600 font-bold">  {{$data->emp_lname}}, {{$data->emp_fname}} {{$data->emp_mname}} </h1>
                    <h3 class="text-sm text-gray-400 font-bold" > {{$data->department->dept}}</h3> 
                </div> 
            </div>

            @if($dep==true)
                    @if($data->department->logo!= '')
                        <div class="account-info-box-right">

                            <img class="hau-banner" src = "{{asset('storage/dept/logo/'. $data->department->logo)}}"/> 
                        </div>
                    @else
                        <img class="hau-banner" src="{{asset('images/logo-circle.png')}}" alt="">
                    @endif
                @else 
                    <img class="hau-banner" src="{{asset('images/logo-circle.png')}}" alt="">
            @endif
           
          
        </div> 
    </div> 


    
    <div class = "section personal-data"> <!--- section indicator ---> 
    <!-- start of personal data box  -->
         <div class = "section-box"> 
             <div class  = "box-title"> <h1> Personal Data </h1> 
           
             <span> Last Updated: {{explode(' ', $data->updated_at)[0]  . ' | ' .  explode(' ', $data->updated_at)[1]}}  </span>

         
            </div>  

            <div class = "personal-information"> 
                <!-- title of the section  -->
                
                
            <!-- this is a row  -->
             <!-- for each item, add a box-row div then adjust width  -->
            <div class = 'box-row'> 
                <div class = "box-row-item" style = "width: 300px;"> 
                     <h3> First Name  </h3> 
                     <h1> {{$data -> emp_fname?? 'n/a'}} </h1> 
                </div> 

                <div class = "box-row-item" style = "width: 300px;"> 
                     <h3> Middle Name  </h3> 
                     <h1> {{$data -> emp_mname?? 'n/a'}} </h1> 
                </div>

                <div class = "box-row-item" style = "width: 300px;"> 
                     <h3> Last Name  </h3> 
                     <h1> {{$data -> emp_lname?? 'n/a'}} </h1> 
                </div>

                <div class = "box-row-item" style = "width: 100px;"> 
                     <h3> Gender  </h3> 
                     @if($data->emp_gender == 'Female') 
                        <h1> F </h1>
                    @else 
                         <h1> M </h1>
                    @endif
                </div>
            </div>  
            <!--- -END OF A ROW --> 


            
            <div class = "line-break"> <hr> </div> 

            
            
            <!-- this is a row  -->
            <div class = 'box-row'> 
                <div class = "box-row-item" style = "width: 170px;"> 
                    <h3> Date of Birth  </h3> 
                    <h1>{{explode(' ', $data->emp_dob)[0]?? 'n/a' }}</h1>
                </div> 
                
                <div class = "box-row-item" style = "width: 250px;"> 
                    <h3> Place of Birth  </h3> 
                    <h1> {{$data -> emp_pob ?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 150px;"> 
                    <h3> Civil Status  </h3> 
                    <h1> {{$data -> emp_cStatus?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 200px;"> 
                    <h3> Religion  </h3> 
                    <h1> {{$data -> emp_religion?? 'n/a'}} </h1> 
                </div>

                <div class = "box-row-item" style = "width: 100px;"> 
                     <h3> Blood Type  </h3> 
                     <h1> {{$data -> emp_blood_type?? 'n/a'}} </h1> 
                </div>

            </div>  
            <!--- -END OF A ROW --> 

               
            <div class = "line-break"> <hr> </div> 
            
            
            <!-- this is a row  -->
            <div class = 'box-row'> 
                <div class = "box-row-item" style = "width: 350px;"> 
                     <h3> Email Address  </h3> 
                     <h1> {{$data-> login->email?? 'n/a'}} </h1> 
                </div> 

                <div class = "box-row-item" style = "width: 150px;"> 
                     <h3> Role  </h3> 
                     <h1> {{$data->login->role?? 'n/a'}} </h1> 
                </div>

             

                
            </div>  
            <!--- -END OF A ROW --> 
            

        </div> 

<br> 
            <div class = "contact-information"> 
                 <!-- title of the section  -->
                 
                 <div class  = "box-title"> <h1> Contact Information </h1> </div>
                 <h1 class = 'subtitle' > Present Address </h1> 

                   <!-- this is a row  -->
            <div class = 'box-row'> 
                <div class = "box-row-item" style = "width: 70px;"> 
                    <h3> House No.  </h3> 
                    <h1>{{$data-> emp_houseno ?? 'n/a' }}</h1>
                </div> 
                
                <div class = "box-row-item" style = "width: 170px;"> 
                    <h3> Street  </h3> 
                    <h1> {{$data -> street ?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 150px;"> 
                    <h3> Barangay  </h3> 
                    <h1> {{$data -> brgy ?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 200px;"> 
                    <h3> City  </h3> 
                    <h1> {{$data -> city ?? 'n/a'}} </h1> 
                </div>

                <div class = "box-row-item" style = "width: 200px;"> 
                     <h3> Province  </h3> 
                     <h1> {{$data -> province?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 100px;"> 
                     <h3> Postal Code  </h3> 
                     <h1> {{$data -> postal_code?? 'n/a'}} </h1> 
                </div>

            </div>  

            <!--- -END OF A ROW --> 
            
            <div class = "line-break"> <hr> </div>

                     <!-- this is a row  -->
                     <div class = 'box-row'> 
                <div class = "box-row-item" style = "width: 170px;"> 
                    <h3> Home Phone No.  </h3> 
                    <h1>{{$data-> home_phone ?? 'n/a' }}</h1>
                </div> 
                
                <div class = "box-row-item" style = "width: 170px;"> 
                    <h3> Mobile Phone No.  </h3> 
                    <h1> {{$data -> mobile_phone ?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 300px;"> 
                    <h3> Primary Email Address  </h3> 
                    <h1> {{$data -> email_address_1 ?? 'n/a'}} </h1> 
                </div>
                
                <div class = "box-row-item" style = "width: 300px;"> 
                    <h3> Secondary Email Address  </h3> 
                    <h1> {{$data -> email_address_2 ?? 'n/a'}} </h1> 
                </div>


            </div>  
            <!-- end of row --> 
            
            

            </div> 
         </div> 
    </div> 
    <!---- end of a section --->

    <div class="section provincial-contact"> <!--- section indicator ---> 
    <!-- start of personal data box  -->
    <div class="section-box"> 
        <div class="box-title"> 
            <h1> Provincial Contact </h1> 
            @if($data->provincial_contact != null)
                <span> Last Updated:  {{ $data->provincial_contact->updated_at->format('Y-m-d H:i:s') }}   </span> 
            @endif 
         
        </div> 

        <h1 class='subtitle' style="margin-top: 1rem"> Provincial Address </h1> 

        <!-- this is a row  -->
        <div class='box-row'> 
            @if($data->provincial_contact)
                <div class="box-row-item" style="width: 70px;"> 
                    <h3> House No.  </h3> 
                    <h1>{{ $data->provincial_contact->pc_emp_houseno }}</h1>
                </div> 

                <div class="box-row-item" style="width: 170px;"> 
                    <h3> Street  </h3> 
                    <h1>{{ $data->provincial_contact->pc_street }}</h1> 
                </div>

                <div class="box-row-item" style="width: 150px;"> 
                    <h3> Barangay  </h3> 
                    <h1>{{ $data->provincial_contact->pc_brgy }}</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> City  </h3> 
                    <h1>{{ $data->provincial_contact->pc_city }}</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> Province  </h3> 
                    <h1>{{ $data->provincial_contact->pc_province }}</h1> 
                </div>

                <div class="box-row-item" style="width: 100px;"> 
                    <h3> Postal Code  </h3> 
                    <h1>{{ $data->provincial_contact->pc_postal_code }}</h1> 
                </div>
            @else
                <div class="box-row-item" style="width: 70px;"> 
                    <h3> House No.  </h3> 
                    <h1>n/a</h1>
                </div> 

                <div class="box-row-item" style="width: 170px;"> 
                    <h3> Street  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 150px;"> 
                    <h3> Barangay  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> City  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> Province  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 100px;"> 
                    <h3> Postal Code  </h3> 
                    <h1>n/a</h1> 
                </div>
            @endif
        </div>  

        <div class='line-break'> <hr> </div> 

        <div class="box-row"> 
            <div class="box-row-item" style="width: 200px"> 
                <h3> Provincial Phone Number  </h3> 
                <h1>{{ $data->provincial_contact ? $data->provincial_contact->pc_phone : 'n/a' }}</h1> 
            </div> 
        </div>  
    </div>
</div>



                                     
<div class="section emergency-box"> 
    <div class="section-box"> 
        <div class="box-title"> 
            <h1> In-case of Emergency </h1> 
            
            <span> Last Updated: 
                @if($data->emergency_contact && $data->emergency_contact->updated_at)
                    {{ $data->emergency_contact->updated_at->format('Y-m-d H:i:s') }} 
                @else 
                    'n/a' 
                @endif
            </span>  
           
        </div>

        <h1 class='subtitle' style="margin-top: 1rem"> Contact Person </h1> 

        <div class="box-row"> 
            @if($data->emergency_contact)
                <div class="box-row-item" style="width: 300px"> 
                    <h3> First Name </h3>
                    <h1>{{ $data->emergency_contact->cp_fname }}</h1>  
                </div> 

                <div class="box-row-item" style="width: 300px"> 
                    <h3> Middle Name </h3>
                    <h1>{{ $data->emergency_contact->cp_mname }}</h1>  
                </div>

                <div class="box-row-item" style="width: 300px"> 
                    <h3> Last Name </h3>
                    <h1>{{ $data->emergency_contact->cp_lname }}</h1>  
                </div>

                <div class="box-row-item" style="width: 200px"> 
                    <h3> Relationship </h3>
                    <h1>{{ $data->emergency_contact->cp_relationship }}</h1>  
                </div>
            @else
                <div class="box-row-item" style="width: 300px"> 
                    <h3> First Name </h3>
                    <h1>n/a</h1>  
                </div> 

                <div class="box-row-item" style="width: 300px"> 
                    <h3> Middle Name </h3>
                    <h1>n/a</h1>  
                </div>

                <div class="box-row-item" style="width: 300px"> 
                    <h3> Last Name </h3>
                    <h1>n/a</h1>  
                </div>

                <div class="box-row-item" style="width: 200px"> 
                    <h3> Relationship </h3>
                    <h1>n/a</h1>  
                </div>
            @endif
        </div> 

        <div class="line-break"> <hr> </div> 

        <div class="box-row"> 
            @if($data->emergency_contact)
                <div class="box-row-item" style="width: 70px;"> 
                    <h3> House No.  </h3> 
                    <h1>{{ $data->emergency_contact->cp_house_no }}</h1>
                </div> 

                <div class="box-row-item" style="width: 170px;"> 
                    <h3> Street  </h3> 
                    <h1>{{ $data->emergency_contact->cp_street }}</h1> 
                </div>

                <div class="box-row-item" style="width: 150px;"> 
                    <h3> Barangay  </h3> 
                    <h1>{{ $data->emergency_contact->cp_brgy }}</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> City  </h3> 
                    <h1>{{ $data->emergency_contact->cp_city }}</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> Province  </h3> 
                    <h1>{{ $data->emergency_contact->cp_province }}</h1> 
                </div>

                <div class="box-row-item" style="width: 100px;"> 
                    <h3> Postal Code  </h3> 
                    <h1>{{ $data->emergency_contact->cp_postal_code }}</h1> 
                </div>
            @else
                <div class="box-row-item" style="width: 70px;"> 
                    <h3> House No.  </h3> 
                    <h1>n/a</h1>
                </div> 

                <div class="box-row-item" style="width: 170px;"> 
                    <h3> Street  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 150px;"> 
                    <h3> Barangay  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> City  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 200px;"> 
                    <h3> Province  </h3> 
                    <h1>n/a</h1> 
                </div>

                <div class="box-row-item" style="width: 100px;"> 
                    <h3> Postal Code  </h3> 
                    <h1>n/a</h1> 
                </div>
            @endif
        </div> 

        <div class="box-row"> 
            <div class="box-row-item" style="width: 250px"> 
                <h3> Home Phone No.</h3> 
                <h1>{{ $data->emergency_contact ? $data->emergency_contact->cp_home_phone : 'n/a' }}</h1> 
            </div> 
            <div class="box-row-item" style="width: 250px"> 
                <h3> Mobile Phone No.</h3> 
                <h1>{{ $data->emergency_contact ? $data->emergency_contact->cp_mobile_no : 'n/a' }}</h1> 
            </div> 
        </div> 
    </div>
</div>


<div class="section accounting-data"> 
    <div class="section-box"> 
        <div class="box-title"> 
            <h1> Accounting Data </h1> 
            <span> Last Updated: 
                @if($data->accounting_details && $data->accounting_details->updated_at)
                    {{ $data->accounting_details->updated_at->format('Y-m-d H:i:s') }} 
                @else 
                    'n/a' 
                @endif
            </span>  
             
        </div>

        <div class="box-row"> 
            <div class="box-row-item" style="width: 300px"> 
                <h3> SSS No.</h3> 
                <h1> {{$data->accounting_details->sss_no ?? 'n/a'}} </h1> 
            </div>
            <div class="box-row-item" style="width: 300px"> 
                <h3> Tax Identification No. </h3> 
                <h1> {{$data->accounting_details->tax_no ?? 'n/a'}} </h1> 
            </div>
            <div class="box-row-item" style="width: 300px"> 
                <h3> Pag-Ibig No.</h3> 
                <h1> {{$data->accounting_details->pagibig_no ?? 'n/a'}} </h1> 
            </div>
            <div class="box-row-item" style="width: 300px"> 
                <h3> PhilHealth No.</h3> 
                <h1> {{$data->accounting_details->philhealth_no ?? 'n/a'}} </h1> 
            </div> 
        </div>  
    </div>
</div>

<div class = "section hiring-history mt-2"> 

        <div class = "section-box"> 
            <div class  = "box-title"> 
                <h1> Hiring Information </h1>

                <a href="{{route('admin.hiring', $data->emp_id)}}" class="bg-red-900 text-white px-8 rounded-xl mx-2 hover:bg-red-800" >EDIT </a>
                
            </div>

            <div class="box-row"> 
            <div class="box-row-item" style="width: 150px"> 
                <h3> Position</h3> 
                <h1> {{$data->hiring->emp_position ?? 'n/a'}} </h1> 
            </div>
            <div class="box-row-item" style="width: 150px"> 
                <h3> Nature </h3> 
                <h1> {{$data->hiring->emp_nature ?? 'n/a'}} </h1> 
            </div>
            <div class="box-row-item" style="width: 300px" class="mr-2"> 
                <h3> Tenure</h3> 
                <h1> {{$data->hiring->emp_tenure ?? 'n/a'}} @if($data->hiring->emp_tenure === 'NON-TENURED') - {{$data->hiring->non_tenured}} @endif </h1> 
                

            </div>
            <div class="box-row-item" style="width: 300px"> 
                <h3> Division</h3> 
                <h1> {{$data->hiring->division ?? 'n/a'}} </h1> 
            </div> 
        </div>  


        </div>

    </div>



    
    









   
</div> 

        </div>
    </div>
</x-app-layout>




<style> 
    .container {
        width: 100%; 
        display: flex; 
        justify-content: center;
        align-items: center;
        padding: 2rem 0;
    } 

    .profile-card { 
        width:100%;
      
        border-radius: 15px; 
        /* border: 1px solid red; */
        background-color: white;
        padding-bottom: 2rem;
    }

    .account-info { 
        width: 100%; 
        height:180px;
        /* border: 1px solid red; */
    }

    .account-info-box { 
        width: 100%; 
        height: 100%;
        display: grid; 
        grid-template-columns: 80% 20%;
    }

    .account-info-box-left, .account-info-box-right{ 
        width: 100%; 
        height: 100%; 
    }

    .account-info-box-left { 
        display: grid; 
        grid-template-columns: 30% 70%;
    }

    .account-image, .account-details { 
        width: 100%; 
        height: 100%; 
    }

    .account-image { 
        display: flex; 
        justify-content: center;
        align-items: center;
    }

    .acc-img { 
        width: 125px; 
        height: 125px;
        border-radius: 50%;  
    }

    .account-info-box-right { 
        display: flex; 
        justify-items: flex-end;
        align-items: center; 
    } 

    .hau-banner {
        width: 130px; 
        height: 130px; 
    }


    .account-details { 
        display: flex; 
        /* align-items: center; */
        justify-content: center;
        flex-direction: column;
    }
    
    #empid { 
        font-size: 40px; 
        font-weight: 900;
        line-height: 1.5rem;
        color: #333333; 
    }

    #role { 
        font-size: 20px;
        font-weight:700;
        color: #666666; 

    }

    .section { 
        width: 100%;
        height: 80px;
        display: flex; 
        justify-content: center;
        overflow: hidden;
        transition: 300ms ease-in-out;
        /* cursor: pointer; */
        /* align-items: center; */
        /* border: 1px solid blue;  */
    }

    .pd-clicked {
        cursor: default; 
        height: 650px;
     }
    
     .pc-clicked {
        cursor: default; 
        height: 300px;
     }

     .emergency-clicked {
        cursor: default; 
        height: 370px;
     }

     .ad-clicked { 
        cursor: default; 
        height: 180px;

     }

     .dep-clicked{ 
        cursor: default; 
        height: 350px;
     }
    

    


    .section-box { 
        width: 95%; 
        height: 95%; 
        border: 1px solid rgb(0,0,0,0.3); 
        padding: 1rem 2rem;
        border-radius: 15px;
    }


    .box-title { 
        width: 100%; 
        height: 50px; 
        /* border: 1px solid red; */
        display: flex;
        align-items: center; 
        position: relative; 
        margin-bottom: 1rem;
    }


    .box-title h1 { 

        font-size: 1.2rem; 
        font-weight: 700;
        color: #333333;
    }

    .subtitle { 
        color: rgb(180,180,180); 
        font-size: 1rem;
        font-style: italic;
    }

    .box-title a { 
        padding: 0 2rem;
     
        background-color: #70121D;
        color: white; 
        border-radius: 10px;
        font-size: 12px; 
        transition: 300ms;
     
        z-index: 3;
    }   

    .box-title a:hover { 
        background-color: #8A2B36;
    }

    span { 
        font-size: 0.8rem; 
        opacity: 0.5; 
        margin: 0 1rem;
    }

.section-box-button { 
    height: 80px; 
    width: 10%; 
    /* border: 1px solid red;  */
    float: right;
    right: 0;
    position: absolute; 
    display: flex ;
    justify-content: center;
    align-items: center;
    z-index: 5;
    
}

.edit-btn { 
    position: absolute;
    float: right;
    /* border: 1px solid blue; */
    right: 8%

    
}

.dp_button { 
    color:#70121D;
    transition: 300ms;
    font-size: 1.2rem;
    cursor: pointer;
   
}

.dp_button:hover { 
    color: #A84655;
    transform: scale(1.1)
}




    .line-break hr  { 
        opacity: 0.8
    }

    .box-row {
        width: 100%; 
        padding: 1rem 0 ;
        display: flex; 
    }

    .box-row-item { 
        height: 100%; 
        display: flex; 
        flex-direction: column;
        justify-content: center;
        /* border: 1px solid red; */
    }

    .box-row-item h1 { 
        font-size: 1rem;
        font-weight: bold; 
        color: #333333;
    }

    .box-row-item h3 { 
        font-size: 11px; 
        opacity: 0.6
    }

    .status::before { 
        content: "●";
        font-size: 1.5rem; 
        /* border-radius: 50%;  */
      
        
    }


    .status { 
        font-weight: 900; 
    }
    .approved{  
        
        color: green; 
        /* background-color: green; */
    }

    .pending { 
        color:orange; 
    }



        .msg-box { 
    width: 100%; 
    height: 50px; 
    /* border: 1px solid red; */
    display: flex; 
    justify-content: center;
    align-items: center;
}

.msg-box { 
    width: 100%; 
    height: 50px; 
    /* border: 1px solid red; */
    display: flex; 
    justify-content: center;
    align-items: center;
}

#msg { 
    width: 95%; 

    text-align: center;
    padding: 5px 0;
    background-color: green;
    color: white; 
    border-radius: 15px;
}

 

#successMessage {

            display: none;
            text-align: center;
            color: green;
            width: 95%; 
           
            background: #e0ffe0;
            padding: 10px;
            border: 1px solid #b0ffb0;
            border-radius: 25px;
            margin: 0 auto;
            margin-bottom: 10px;
            transition: 300ms;
            
            
            
        }
    

        /* table template codes */
    .table { 
        width: 100%; 
        /* border: 1px solid rgb(0,0,0,0.1); */
    }

    .tbl-header { 
        width: 100%; 
        height: 40px; 
        background-color: maroon;
        display: grid; 
    }

    .tbl-row { 
        width: 100%; 
        height: 40px; 
        display: grid; 
    }

    .tbl-row h1 { 
        font-weight: 500;
        font-size: 14px; 
    }

    .empty { 
        display: flex; 
        justify-content: center;
        align-items: center;
        color: lightgray; 
    }

    .empty h1 { 
        color: rgb(40, 40,40, 0.7);
    }
    .table button {
        background-color: maroon;
        color: white;
        padding: 0 2.3rem;
        border-radius: 25px; 
        transition: 300ms; 
        font-size: 15px;

    }

    .table button:hover { 
        background-color: #A84655;
    }

    .tbl-col { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        align-items: center;
        padding-left: 1rem;
    }

    .stripe { 
       background-color: beige;
    }

    .tbl-header .tbl-col h1 { 
        color: white;
        font-size: 13px; 
        font-weight: 500;
        
    }
    /* should be changed based on the sizing of the table */
    .dep .tbl-header, .dep .tbl-row { 
        grid-template-columns: 50% 20% 30% ;
    }


    .personal-data { 
        height :650px; 
    }


    .provincial-contact {  
        height: 300px; 
    }

    .emergency-box { 
        height: 370px; 
    }


    .accounting-data, .hiring-history{ 
        height: 180px; 
    }
    
    
</style> 



<script>

setTimeout(()=> { 
    document.getElementById('actmsg').style.display= 'none' 
}, 5000)

function confirmTerminate(button) { 
    if(confirm("Are you sure you want to terminate this account?")) { 
        button.closest('form').submit() ;
    }
}    

function confirmActivate(button) { 
    if(confirm("Are you sure you want to activate this account?")) { 
        button.closest('form').submit() ;
    }
} 

</script> 