<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] bg-white flex flex-col px-8 pt-8 pb-12 rounded-lg">
            <a href="{{route('portal.org')}}" class="w-[25%] rounded-lg flex items-center justify-center py-2 bg-red-900 text-white font-bold gap-1 hover:bg-red-700">
                <img src="{{asset('images/icons/back.png')}}" class="w-[20px] h-[20px]" alt="">
                <h1>Back </h1>
            </a>

            <div class="w-full flex flex-col items-center">

                <img src = "{{asset('images/hau-logo.png')}}" class="w-[120px] h-[120px] mt-4"/> 
                <h1 class="text-[2rem] text-gray-700 font-extrabold mt-4 leading-tight">ORGANIZATION MEMBERSHIP</h1>
                <span class="text-gray-500 text-[0.8rem] text-center px-[8rem]">Please update the form below to modify the existing organization membership details. Ensure that all required fields are correctly filled out before submitting your changes. </span>
            </div>

            <hr class="opacity-90 my-4"> 

            <form action="{{route('portal.org.update', ['id'=> $org->id])}}" method ="POST" class="w-full flex flex-col items-center gap-2 ">

            @csrf 
            @method('PUT')
                <div class="w-[50%] flex flex-col gap-1">
                    <span class="text-gray-500 font-semibold"> Organization Name </span> 
                    <input type = "text" name = "org" class="border border-gray-300" value="{{$org->org}}"required/> 
                </div>

                <div class="w-[50%] flex flex-col gap-1">
                    <span class="text-gray-500 font-semibold"> Position </span> 
                    <input type = "text" name = "position" class="border border-gray-300 " value="{{$org->position}}" required/> 
                </div>

                <div class="w-[50%] flex flex-col gap-1">
                    <span class="text-gray-500 font-semibold"> Date Joined </span> 
                    <input type = "date" name = "date_joined" class="border border-gray-300 text-center" value="{{$org->date_joined}}" required/> 
                </div>


                @if(isset($msg)) 
                    <span> {{$msg}} </span> 
                @endif
                <button type = submit class="w-[50%] bg-red-900 hover:bg-red-700 text-white py-2 mt-2">UPDATE</button>
            </form>



            
        </div>
    </div>
     
</x-app-layout>

<style> 

a,button{  
    transition: 300ms;
}
</style>  