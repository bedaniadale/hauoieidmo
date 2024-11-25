<x-app-layout>
<div class = 'w-full flex items-center justify-center py-8'>
    <div class="w-[95%] bg-white px-8 py-8">
        <div class="w-full flex flex-col leading-tight">
            <h1 class = "text-xl font-bold">{{$userinfo->emp_lname . ', ' . $userinfo->emp_fname . ' ' . $userinfo -> emp_mname}} </h1>
                <span class = "text-gray-500" > {{$userinfo-> email_address_1}}</span> 

        

                <hr class = "my-4 opacity-90">  
            

                <div class="w-full">
                    
                    <div class="w-full flex flex-col leading-normal">
                        <div class="w-full flex items-center">
                            <h1 class = "text-xl mb-2 font-bold"> ADD SUBJECT </h1>
                            <a class = "maroon ml-4 text-white px-8 rounded-lg"href="{{route('admin.subjects')}}" onclick="window.open(this.href, 'newwindow', 'width='+screen.width+',height='+screen.height+',top=0,left=0'); return false;">View All Subjects</a>
                        </div>
    
                        <div class = 'w-full'>
                            <form action= "{{route('admin.loads.subj')}}" method ="GET" class = 'w-full flex'> 
                                @csrf
                            <input class = "w-[70%] border-gray-300" type = "text" name = "id"placeholder="Enter Subject Code"> </input> 
                            <input class = "w-[70%] border-gray-300" type = "text" name = "emp_id" value="{{$userinfo->emp_id}}" hidden> </input> 
                            <button class = "w-[30%] maroon text-white"type = "submit"> LOAD SUBJECT</button>
                            </form> 
                        </div>


                        @if(isset($msg)) 
                            <span class="text-sm tesxt-gray-300 italic" style = "color:gray;"> {{$msg}} </span>
                        @endif


                        @if(isset($subj))
                       
                        <div class="mt-4 w-full flex flex-col" >
                        <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                            <div class="p-2 border-r border-gray flex items-center justify-center">
                                <h1 class="text-gray-500 font-semibold"> SUBJECT CODE </h1> 
                            </div>
                            <div class="p-2"><h1 class="text-gray-500"> {{$subj->subj_code}} </h1></div>
                        </div>

                        <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                            <div class="p-2  border-r border-gray  flex items-center justify-center">
                                <h1 class="text-gray-500 font-semibold"> SUBJECT </h1> 
                            </div>
                            <div class="p-2"><h1 class="text-gray-500"> {{$subj-> subj_title}}</h1></div>
                        </div>


                        <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                            <div class="p-2  border-r border-gray flex items-center justify-center">
                                <h1 class="text-gray-500 font-semibold"> DESCRIPTION </h1> 
                            </div>
                            <div class="p-2"><h1 class="text-gray-500"> {{$subj-> subj_description}}</h1></div>
                        </div>

                    <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                        <div class="p-2  border-r border-gray flex items-center justify-center">
                            <h1 class="text-gray-500 font-semibold"> UNITS </h1> 
                        </div>
                        <div class="p-2"><h1 class="text-gray-500"> {{$subj-> units}}.00</h1></div>
                    </div>

                </div>
                        <div class="w-full mt-4">
                                <form class="w-full flex justify-end" action="{{route('admin.loads.store')}}" method = "POST">
                                    @csrf 
                                    @method('POST' )
                                    <input type = "text" value = "{{$subj-> subj_id}}" name = "subj" hidden>
                                    <input type = "text" value = "{{$userinfo->emp_id}}" name = "id" hidden>
                                    <button type ="submit" class = "maroon text-white px-12 py-2 rounded-lg flex items-center justify-center" > 
                                        <img class = 'w-[20px] h-[20px] mr-4' src = "{{asset('images/icons/add.png')}}">
                                        <h1> ADD TO USER </h1> 
                                     </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

        </div>
    </div>
</div>
</x-app-layout>

<style> 
    .maroon { 
        background-color: maroon;
        transition: 300ms;
    }

    input[type=text]::placeholder { 
        color: gray; 
        font-style: italic;
    }

    .maroon:hover { 
        background-color: #A84655;
    }

   
</style> 


<script> 
setTimeout(()=> { 
    document.getElementById('popup').style.display = 'none' 
}, 5000)
</script> 