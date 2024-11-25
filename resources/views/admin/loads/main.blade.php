<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col bg-white rounded-lg">


            <div class="w-full px-8 py-4 flex flex-col"> 
            
                <h1 class= "text-[1.5rem] font-bold text-gray-600">Tools </h1>

                @if(isset($msg))
                    <span class="msg w-[100%] bg-green-600 text-white rounded-lg px-4 py-2 my-4"> {{$msg}}</span>
                @endif
                <section class="w-full flex py-4 gap-4">

                    <a href="{{route('admin.loads.search')}}" class="w-[20%] maroon flex flex-col justify-center items-center py-8 rounded-lg">
                        <img class = "w-[80px] h-[80px]"src = "{{asset('images/icons/search_user.png')}}"/> 
                        <h1 class="text-white"> Search User Loads</h1> 
                    </a>

                    <a href="{{route('admin.loads')}}" class="w-[20%] maroon flex flex-col justify-center items-center py-8 rounded-lg">
                        <img class = "w-[80px] h-[80px]"src = "{{asset('images/icons/add_to_user.png')}}"/> 
                        <h1 class="text-white"> Add Load to User</h1> 
                    </a>

                    <a href="{{route('admin.loads.batch')}}" class="w-[20%] maroon flex flex-col justify-center items-center py-8 rounded-lg">
                        <img class = "w-[80px] h-[80px]"src = "{{asset('images/icons/group_add.png')}}"/> 
                        <h1 class="text-white"> Batch Upload</h1> 
                    </a>


                    <a href="{{route('admin.lbs')}}" class="w-[30%] maroon flex flex-col justify-center items-center py-8 rounded-lg">
                        <img class = "w-[80px] h-[80px]"src = "{{asset('images/icons/search_record.png')}}"/> 
                        <h1 class="text-white"> Show Loads by Subject</h1> 
                    </a>

                    <a href="{{route('admin.loads.upload')}}" class="w-[20%] maroon flex flex-col justify-center items-center py-8 rounded-lg">
                        <img class = "w-[80px] h-[80px]"src = "{{asset('images/icons/upload.png')}}"/> 
                        <h1 class="text-white"> File Upload</h1> 
                    </a>


                   


                </section>

             


            </div>

    
            
        </div>
    </div>
</x-app-layout>

<style> 
    .maroon { 
        background-color: maroon;
        transition: 300ms; 
        
    }

    .maroon:hover { 
        background-color: #A84655;
    }
</style> 

<script> 
    setTimeout(()=> { 
        document.querySelector(".msg").style.display = 'none'
    }, 5000)
</script> 