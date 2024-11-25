<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col bg-white rounded-lg px-8 py-8">
            <h1 class = " text-[1.8rem] font-semibold"> Welcome back, <strong class= "text-red-900"> {{$fname}} </strong> </h1> 
            <hr class = "opacity-100 my-4"> 
            <span class= "text-gray-400">Admin Tools </span>
            
            <div class="w-full flex gap-12">
                        <!-- management tools -->   
                        <section class=" flex flex-col mt-2">
                            <h1 class = "text-gray-500 text-[1.7rem] font-bold"> Management</h1> 

                            <div class="w-full flex py-1 gap-2">

                                <a class= "maroon bg-red-900 text-white rounded-[25px] px-12 py-8 font-semibold flex flex-col items-center justify-center" href="{{route('admin.records')}}">
                                    <img src = "{{asset('images/icons/users.png')}}"> 

                                    <h1> Manage Users</h1>
                                </a>


                                
                                <a class= "maroon bg-red-900 text-white rounded-[25px] px-12 py-8 font-semibold flex flex-col items-center justify-center" href="{{route('admin.pendings')}}">
                                    <img src = "{{asset('images/icons/portal_nav/pending.png')}}"> 

                                    <h1> Pending Requests</h1>
                                </a>


                            

                            </div>
                        </section>


                        <!-- EDUCATION TOOLS  -->
                        <section class=" flex flex-col mt-2">
                            <h1 class = "text-gray-500 text-[1.7rem] font-bold"> Education</h1> 

                            <div class="w-full flex py-1 gap-2">
                            
                                <a class= "maroon bg-red-900 text-white rounded-[25px] px-12 py-8 font-semibold flex flex-col items-center justify-center" href="{{route('admin.loads.db')}}">
                                    <img src = "{{asset('images/icons/portal_nav/loads.png')}}"> 

                                    <h1> Teaching Loads</h1> 
                                </a>

                                <a class= "maroon bg-red-900 text-white rounded-[25px] px-12 py-8 font-semibold flex flex-col items-center justify-center" href="{{route('admin.subjects')}}">
                                    <img src = "{{asset('images/icons/portal_nav/subjects.png')}}"> 

                                    <h1> Subjects </h1>
                                </a>


                            </div>
                        </section>

                        
                        
                    </div>



                    <div class="w-full flex gap-12">
                        <!-- management tools -->   
                        <section class=" flex flex-col mt-2">
                            <h1 class = "text-gray-500 text-[1.7rem] font-bold"> Issuance </h1> 

                            <div class="w-full flex py-1 gap-2">

                                <a class= "maroon bg-red-900 text-white rounded-[25px] px-12 py-8 font-semibold flex flex-col items-center justify-center" href="{{route('admin.certs')}}">
                                    <img src = "{{asset('images/icons/portal_nav/cert.svg')}}"> 

                                    <h1> Certifications</h1>
                                </a>


                                
                              
                            

                            </div>
                        </section>


                        
                        
                    </div>


                    


                   




            
        </div>
    </div> 
</x-app-layout>

<style> 

.maroon { 
    transition: 300ms;
}
.maroon:hover { 
        background-color: #A84655;
    }
</style> 