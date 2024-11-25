@php
$count = 1; 

session()->forget('msg');




@endphp



<x-app-layout>
<div class="w-full flex justify-center py-8">

    
        <div class="w-[95%] flex flex-col p-8 rounded-lg bg-white items-start">

  
    


         
            <div class="w-full flex flex-col justify-start mb-4">

            <form action="{{route('admin.pendings.loadsearch')}} " class="w-full flex flex-col" method ="GET">


            @csrf
                    @method('GET')
                    <span class="font-semibold text-gray-400"> Search for specific user </span>
                    <div class="formrow w-full flex">

                        <input id = "search" type = "text" name = "emp_id" placeholder = "Enter Employee ID..." class="w-[50%]">
                        
                        <button type = "submit"> Load Requests </button>

                        <div class="search-results"></div> 


                    </div>
                  
                    @if(isset($user_not_found))
                         <span> {{$user_not_found}} </span>
                    @endif

                    @if(isset($userfound))
                        @if($userfound == false)
                            <span> User not in your unrestricted access. </span>
                        @endif
                    @endif

                </form> 
            </div>


            @if(isset($msg))
            <div id="msg" class="w-full bg-green-600 text-white rounded-md py-1 px-4">
                <h1 class="text-white">{{$msg}}</h1>
            </div>
            @endif
                

            




        @if(isset($user_search)) 

        <div class="w-full flex flex-col gap-0 items-start leading-tight  my-2">
            <h1 class="font-extrabold text-gray-800 text-[1.5rem]">{{$user_search->emp_id}}</h1>
            <h1 class="font-bold text-gray-500 text-[1.3rem]">{{$user_search->emp_lname . ', ' . $user_search-> emp_fname . ' ' . $user_search->emp_mname}}</h1>
            <h1 class="font-semibold text-gray-500 text-sm">{{$user_search->department->dept}}</h1>

            
            
                            <a href="{{route('admin.pendings')}}" class="bg-red-900 px-6 border-left-2 border-white py-1 mt-2 flex items-center justify-center text-white gap-2">
                                <img src="{{asset('images/icons/reset.png')}}" alt="" class="w-[25px] h-[25px]">
                                <span class="font-semibold">Clear Search</span>
                            </a>

        </div>

        <hr class="w-full opacity-90">
        @endif

        <div class="w-full flex">

            <button id = "all_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2 active_link"> All </button>

            <button id = "certifications_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2"> Certification </button>

            <button id = "trainings_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2"> Training</button>

            
            <button id = "licenses_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2"> License</button>

            
            <button id = "employments_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2"> Employment</button>

            
            <button id = "respubs_btn" class="hover:bg-gray-100 text-gray-400 font-semibold px-8 py-2"> Research and Publication</button>



            
        </div>
        <hr class="mb-2 opacity-90 w-full">

        <!-- table for all -->
        <div id = "all" class="w-full flex flex-col border border-gray-200 gap-0">
        

             

             <!-- body with empty data -->

             @if($pendings->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else


             <div class="w-full flex flex-col overflow-y-auto h-[500px]">

           
                @foreach($pendings as $item)
                <div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
                        <div class="flex flex-col leading-tight">
                            
                            <!-- submitted by details -->

                            <div class="flex items-center gap-4 ">
                            @if($item->user->profile_picture)
                            <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">
                            
                            @else
                            <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                            @endif
                                            
                                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
                            </div>
                             

                             <hr class="w-full opacity-2 my-2">
                            <h1 class="font-semibold text-gray-700"> <strong> {{$item->type}} </strong>  - {{$item->title}}</h1>
                            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
                            
                        </div>

                        <div class="flex items-center justify-end gap-1">
                            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
                            </a>

                        </div>
                    </div>
                    @endforeach

                </div>


             @endif
             

        </div>



           <!-- table for pending -->
           <div id = "certifications"  class="w-full flex flex-col border border-gray-200 gap-0 inactive_link">
            <!-- header -->
           


             <!-- body with empty data -->

             @if($certifications->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else

             <div class="w-full flex flex-col overflow-y-auto h-[500px]">

           
                @foreach($certifications as $item)
             <div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
                        <div class="flex flex-col leading-tight">
                            
                            <!-- submitted by details -->

                            <div class="flex items-center gap-4 ">
                            @if($item->user->profile_picture)
                                <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                                
                            @else
                                 <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">  
                            @endif
                                            
                                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
                            </div>
                             

                             <hr class="w-full opacity-2 my-2">
                            <h1 class="font-semibold text-gray-700"> <strdeong> {{$item->type}} </strdeong>  - {{$item->title}}</h1>
                            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
                            
                        </div>

                        <div class="flex items-center justify-end gap-1">
                            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
                            </a>

                        </div>
                    </div>
                    @endforeach

                </div>

             @endif
             

        </div>


        
           <!-- table for trainings -->
           <div  id = "trainings"  class="w-full flex flex-col border border-gray-200 gap-0 inactive_link">
            <!-- header -->
            


             <!-- body with empty data -->

             @if($trainings->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else

             <div class="w-full flex flex-col overflow-y-auto h-[500px]">
                 
            @foreach($trainings as $item)
<div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
        <div class="flex flex-col leading-tight">
            
            <!-- submitted by details -->

            <div class="flex items-center gap-4 ">
            @if($item->user->profile_picture)
                <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                
            @else
                 <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">  
            @endif
                            
                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
            </div>
             

             <hr class="w-full opacity-2 my-2">
            <h1 class="font-semibold text-gray-700"> <strong> {{$item->type}} </strong>  - {{$item->title}}</h1>
            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
            
        </div>

        <div class="flex items-center justify-end gap-1">
            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
            </a>

        </div>
    </div>
    @endforeach
    </div> 





             @endif
             

        </div>


         <!-- table for licenses -->
         <div  id = "licenses"  class="w-full flex flex-col border border-gray-200 gap-0 inactive_link">
            <!-- header -->
            


             <!-- body with empty data -->

             @if($licenses->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else
             <div class="w-full flex flex-col overflow-y-auto h-[500px]">

           
@foreach($licenses as $item)
<div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
        <div class="flex flex-col leading-tight">
            
            <!-- submitted by details -->

            <div class="flex items-center gap-4 ">
            @if($item->user->profile_picture)
                <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                
            @else
                 <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">  
            @endif
                            
                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
            </div>
             

             <hr class="w-full opacity-2 my-2">
            <h1 class="font-semibold text-gray-700"> <strong> {{$item->type}} </strong>  - {{$item->title}}</h1>
            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
            
        </div>

        <div class="flex items-center justify-end gap-1">
            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
            </a>

        </div>
    </div>
    @endforeach

</div>


             @endif
             

        </div>



         <!-- table for employments -->
         <div  id = "employments"  class="w-full flex flex-col border border-gray-200 gap-0 inactive_link">
            <!-- header -->
            


             <!-- body with empty data -->

             @if($employments->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else


             <div class="w-full flex flex-col overflow-y-auto h-[500px]">

           
@foreach($employments as $item)
<div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
        <div class="flex flex-col leading-tight">
            
            <!-- submitted by details -->

            <div class="flex items-center gap-4 ">
            @if($item->user->profile_picture)
                <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                
            @else
                 <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">  
            @endif
                            
                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
            </div>
             

             <hr class="w-full opacity-2 my-2">
            <h1 class="font-semibold text-gray-700"> <strong> {{$item->type}} </strong>  - {{$item->title}}</h1>
            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
            
        </div>

        <div class="flex items-center justify-end gap-1">
            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
            </a>

        </div>
    </div>
    @endforeach

</div>


             @endif
             

        </div>


         <!-- table for trainings -->
         <div  id = "respubs"  class="w-full flex flex-col border border-gray-200 gap-0 inactive_link">
            <!-- header -->
            


             <!-- body with empty data -->

             @if($respubs->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No user data. </span> 
             </div>
             @else
             <div class="w-full flex flex-col overflow-y-auto h-[500px]">

           
@foreach($respubs as $item)
<div class="w-full grid grid-cols-[85%_15%] hover:bg-gray-100 px-4 py-4  border-l-8 border-red-900 border-b-2 border-t-2">
        <div class="flex flex-col leading-tight">
            
            <!-- submitted by details -->

            <div class="flex items-center gap-4 ">
            @if($item->user->profile_picture)
                <img src = "{{asset('images/blankdp.jpg')}}" class="w-[25px] h-[25px] ">
                
            @else
                 <img src = "{{asset('storage/profile_pictures/' . $item->user->profile_picture)}}" class="w-[25px] h-[25px] rounded-md ">  
            @endif
                            
                <h1 class="text-gray-700 font-bold text-lg ">{{$item->user->emp_lname . ', ' . $item->user->emp_fname . ' ' . $item->user->emp_mname}}</h1>

                <span class="text-sm text-gray-400">{{$item->user->login-> email}}</span>
            </div>
             

             <hr class="w-full opacity-2 my-2">
            <h1 class="font-semibold text-gray-700"> <strong> {{$item->type}} </strong>  - {{$item->title}}</h1>
            <span class="italic text-sm text-gray-500"> Date Submitted: {{$item->date_submitted}} </span>
            
        </div>

        <div class="flex items-center justify-end gap-1">
            <a href="{{route('admin.pendings.view',['id'=> $item->id])}}" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700" title="View Info">
                <img src="{{asset('images/icons/eye.svg')}}" alt="" class="w-[20px] h-[20px]" >
            </a>

        </div>
    </div>
    @endforeach

</div>


             @endif
             

        </div>


      




            


        </div>
        
    </div>
</x-app-layout>


<style> 

    .container { 
        width: 100% ;
        display: flex; 
        justify-content: center;
        padding: 2rem 0 ;
        
    }
    
    .con-box { 
        /* for windowed layout */
        border-radius: 10px; 
        width: 95%;   

        /* for full screen */
        /* width: 100%;   */

        background-color: white;
        display: flex; 
        flex-direction: column;
        align-items: center;
        padding: 1rem 0; 
       
        /* border-radius: 15px;  */
    }

    .box-header { 
        
        margin-bottom: 1rem;
        width: 95%; 
        display: flex;


        
   
    }

    .usersearch { 
        display: flex; 
        flex-direction: column;
        width: 100%; 
        padding: 0.2rem 2rem;
        line-height: 1.3rem; 
    }

    .usersearch h1 { 
        font-size: 1.5rem;
        font-weight:900; 
    }

    .usersearch h3 { 
        font-size: 1rem; 
        font-weight: 700; 
        color: gray; 

    }

    .search-header { 
        width: 100%; 
        display: flex; 
        align-items: center;
    
        padding: 1rem 0 ; 
    }

    .search-header form { 
        display: flex;
        flex-direction: column;
        padding: 0 2rem;
        width: 100%; 
        height: 100%;

    }

    .search-header form span { 
        font-size: 0.8rem; 
        color: gray; 
    }

    .search-header form input[type=text]{
        width: 40%;
    
    }

    .formrow button{ 
        background-color: maroon;
        color: white; 
        height: 100%; 
        padding: 0 1rem;
        transition: 300ms;
    }

    .formrow button:hover { 
        background-color: #A84655;
    }
  

    .categories { 
        width: 100%; 
        display: flex; 
        
    }


    
    .cat-slot form { 
       
        display: flex; 
        justify-content: center;
        align-items: center;
        margin: 0 0.2rem;
    }
    
    .cat-slot form button { 
        color: white; 
   
        height: 80%; 
        border-radius: 10px; 
        background-color: #555556;
        transition: 300ms; 
        padding: 0.5rem 2rem;
    }

    .cat-slot form .active  { 
        background-color: #9d9898;
    }

    .cat-slot form button:hover { 
        background-color: #6c6c6c ;
    }

    .cat-slot form .active:hover{ 
        background-color:#b3aead  ;
    }


    input::placeholder {
            color: rgb(200, 200,200); /* Placeholder text color */
            font-size: 14px; /* Placeholder text size */
            font-style: italic; /* Placeholder text style */
        }


    input[type="text"]:focus {
    outline: none; /* Removes the outline */
    box-shadow: none; /* Optionally removes any shadow */
    }



    .table-section { 
       
        width: 95% ;
        height: 350px;
   
        overflow-y: auto;
    
    }
    
        /* table template codes */
    .table { 
        width: 100%; 
        border: 1px solid rgb(0,0,0,0.1);
    }

    .tbl-header { 
       
        width: 95%; 
        height: 40px; 
        background-color: maroon;

        display: grid; 
    }

    .tbl-row { 
        width: 100%; 
        padding: 1rem 0;
        display: grid; 
        transition: 300ms; 

        
    }

    hr{ 
        opacity: 0.8;
        width: 100%; 
        color: black;
    }

    .tbl-row:hover{ 
        background-color: beige;
    }

    .tbl-row h1 { 
        color: #696969; 
        font-weight:400;
        font-size: 14px; 
    }

    .empty { 
        display: flex; 
        justify-content: center;
        align-items: center;
        color: lightgray; 
    }

    .empty span { 
        color: rgb(40, 40,40);
    }
    .table button {
        background-color: maroon;
        color: white;
        padding: 0 0.5rem;
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
       background-color: #f7f7f7;
    }


    .tbl-header .tbl-col h1 { 
        color: white;
        font-size: 13px; 
        font-weight: 500;
        
    }
    /* should be changed based on the sizing of the table */
    .tbl-header, .main-dep .tbl-header, .main-dep .tbl-row { 
        grid-template-columns: 20% 25% 20% 20% 10%
    }

    .tbl-header { 
        grid-template-columns: 20% 25% 20% 20% 10%
    }

    .col-acts { 
       display: flex; 
       
    }

 

   
    #edit {
        background-color: green; 
    }
    #edit:hover { 
        background-color: #32CD32;
    }

    #delete { 
        
        background-color: red;
    }
    
    #delete:hover { 
        background-color:#FF6347;
    }


    /*** set height of your table here | call the unique class name so that it won't affect other table*/
    .main-dep { 
        height: 350px; 
        overflow-y: auto;
        
    }


    .actions { 
        width: 95%; 
        height: 50px; 
        display: flex; 
    

    }


    .act-slot { 
        width: 35%; 
        height: 100%; 
        display: flex; 
        align-items: center;
        padding-right: 0.5rem;
        
    }

    .act-slot form { 
        width: 100%; 
        height: 100%; 
        display: flex ;
        align-items: center;

    }
   

    #msg  { 
        
    color: green;
        font-weight: 500
    }


    .formrow { 
        position: relative;
    }
    
    .search-results { 
        /* box-shadow: 0px 0px 2px 0px; */
        /* border: 1px solid rgb(190,190,190);  */
        position: absolute;
        width: 50%; 
    
        
        background-color: beige;
        top: 100%;
        display: flex;

        flex-direction: column;
        max-height: 300px; /* Set a maximum height */
        overflow-x: auto;
    
    }

    .search-results button { 
        display: flex;
        text-align: left;
        width: 100%; 
        
        
        padding:0.5rem 1rem;
        line-height: 1rem;
        transition: 300ms; 
        border: 1px solid lightgray;
        

    }

    .search-results button:hover { 
        background-color: maroon;
    }


    .search-results h1 {
        font-size: 1rem; 
        font-weight: 700; 
        font-style:italic;
    }

    .search-results h3  { 
        font-size: 0.8rem;
        font-weight: 500;

        
    }


    

    
    .active_link{ 
        border-bottom: 4px solid #FFD700   ;
        font-weight: 700;
        transition: 300ms;
    }

    

    .active_link:hover { 
        background-color: rgb(230,230,230);

    }

    .inactive_link { 
        display: none;
    }


</style>


<script>

const all_btn = document.getElementById('all_btn'); 
const certifications_btn = document.getElementById('certifications_btn')
const trainings_btn =document.getElementById('trainings_btn')
const licenses_btn = document.getElementById('licenses_btn')
const employments_btn = document.getElementById('employments_btn')

const respubs_btn = document.getElementById('respubs_btn')



const all_tbl = document.getElementById('all') 
const certifications_tbl = document.getElementById('certifications') 
const trainings_tbl = document.getElementById('trainings') 
const licenses_tbl = document.getElementById('licenses')
const employments_tbl = document.getElementById('employments')
const respubs_tbl = document.getElementById('respubs'); 


//class for hiding the table is: 'hide'

all_btn.addEventListener("click",()=> { 
    all_btn.classList.add("active_link"); 
    certifications_btn.classList.remove('active_link'); 
    trainings_btn.classList.remove('active_link'); 
    licenses_btn.classList.remove('active_link');
    employments_btn.classList.remove('active_link'); 
    respubs_btn.classList.remove('active_link')

    all_tbl.classList.remove('inactive_link'); 
    certifications_tbl.classList.add('inactive_link')  
    trainings_tbl.classList.add('inactive_link')
    licenses_tbl.classList.add('inactive_link')
    employments_tbl.classList.add('inactive_link')
    respubs_tbl.classList.add('inactive_link')


})


certifications_btn.addEventListener("click",()=> { 
    all_btn.classList.remove("active_link"); 
    certifications_btn.classList.add('active_link'); 
    trainings_btn.classList.remove('active_link'); 
    licenses_btn.classList.remove('active_link'); 
    employments_btn.classList.remove('active_link'); 
    respubs_btn.classList.remove('active_link')

    
    

    all_tbl.classList.add('inactive_link'); 
    certifications_tbl.classList.remove('inactive_link')  
    trainings_tbl.classList.add('inactive_link')
    licenses_tbl.classList.add('inactive_link')
    employments_tbl.classList.add('inactive_link')
    respubs_tbl.classList.add('inactive_link')

})

trainings_btn.addEventListener("click",()=> { 
    all_btn.classList.remove("active_link"); 
    certifications_btn.classList.remove('active_link'); 
    trainings_btn.classList.add('active_link'); 
    licenses_btn.classList.remove('active_link'); 
    employments_btn.classList.remove('active_link'); 
    respubs_btn.classList.remove('active_link')
    

    all_tbl.classList.add('inactive_link'); 
    certifications_tbl.classList.add('inactive_link')  
    trainings_tbl.classList.remove('inactive_link')
    licenses_tbl.classList.add('inactive_link')
    employments_tbl.classList.add('inactive_link')
    respubs_tbl.classList.add('inactive_link')

})


licenses_btn.addEventListener("click",()=> { 
    all_btn.classList.remove("active_link"); 
    certifications_btn.classList.remove('active_link'); 
    trainings_btn.classList.remove('active_link'); 
    licenses_btn.classList.add('active_link'); 
    employments_btn.classList.remove('active_link'); 
    respubs_btn.classList.remove('active_link')

    all_tbl.classList.add('inactive_link'); 
    certifications_tbl.classList.add('inactive_link')  
    trainings_tbl.classList.add('inactive_link')
    licenses_tbl.classList.remove('inactive_link')
    employments_tbl.classList.add('inactive_link')
    respubs_tbl.classList.add('inactive_link')
})

employments_btn.addEventListener("click",()=> { 
    all_btn.classList.remove("active_link"); 
    certifications_btn.classList.remove('active_link'); 
    trainings_btn.classList.remove('active_link'); 
    licenses_btn.classList.remove('active_link'); 
    employments_btn.classList.add('active_link'); 
    respubs_btn.classList.remove('active_link')

    all_tbl.classList.add('inactive_link'); 
    certifications_tbl.classList.add('inactive_link')  
    trainings_tbl.classList.add('inactive_link')
    licenses_tbl.classList.add('inactive_link')
    employments_tbl.classList.remove('inactive_link')
    respubs_tbl.classList.add('inactive_link')
})



respubs_btn.addEventListener("click",()=> {

    all_btn.classList.remove("active_link"); 
    certifications_btn.classList.remove('active_link'); 
    trainings_btn.classList.remove('active_link'); 
    licenses_btn.classList.remove('active_link'); 
    employments_btn.classList.remove('active_link'); 
    respubs_btn.classList.add('active_link')

    all_tbl.classList.add('inactive_link'); 
    certifications_tbl.classList.add('inactive_link')  
    trainings_tbl.classList.add('inactive_link')
    licenses_tbl.classList.add('inactive_link')
    employments_tbl.classList.add('inactive_link')
    respubs_tbl.classList.remove('inactive_link')
})





/************** END OF TABS ANIMATION */



setTimeout(function() { 
    document.getElementById ('msg').style.display= 'none'
}, 5000 )


setTimeout(function() {
            
            document.querySelector('.dep-msg').innerHTML = '';
        }, 5000); // Hide after 5 seconds


    // for confirmation 
    function confirmClearDependencies() {
        if (confirm('Are you sure you want to clear the dependencies?')) {
            document.getElementById('clear-dependencies-form').submit();
        }
    }


    function deleteDependency(button)  {
        const form = button.closest('form');
        if(confirm('Are you sure you want to cancel this request?')) { 
           form.submit()
        }

    }



    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchResults = document.querySelector('.search-results');
    let debounceTimer;

    searchInput.addEventListener('keyup', function() {
        clearTimeout(debounceTimer);

        const query = searchInput.value;

        if (query === '') {
            searchResults.innerHTML = ''; // Clear results if the input is empty
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.pendings.search2') }}?query=${encodeURIComponent(query)}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = ''; // Clear previous results

                if (data.length > 0) {
                    data.forEach(post => {
                        const resultItem = document.createElement('div');

                        resultItem.innerHTML = `
                            <button type="button" class="sr-item" style="background-color: beige; color: black;">
                                <div class="details">
                                    <h1>${post.emp_lname}, ${post.emp_fname} ${post.emp_mname}</h1>
                                    <h3>${post.emp_id}</h3>
                                    <span>${post.email_address_1}</span>
                                </div>
                            </button>
                        `;
                        searchResults.appendChild(resultItem);

                        // Add the event listener to the dynamically created button
                        const button = resultItem.querySelector('.sr-item');
                        button.addEventListener('click', () => {
                            const h3Element = button.querySelector('.details h3');
                            const h3Content = h3Element.innerHTML;
                            searchInput.value = h3Content; // Set the input value to the h3 content
                            searchResults.innerHTML = '';
                        });
                    });
                } else {
                    searchResults.innerHTML = '<div style="padding: 0.5rem 1rem"><span>No results found</span></div>';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        }, 300); // Adjust the delay (in milliseconds) as needed
    });
});





</script> 