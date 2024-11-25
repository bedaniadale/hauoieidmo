<x-app-layout>
    <div class="flex justify-center items-center w-full  py-8">
        <div class="flex-col w-[95%] bg-white rounded-lg py-8">
            <div class = 'w-full flex flex-col items-center justify-center px-8 py-4 leading-tight'> 
                <img class= 'w-[120px] h-[120px] my-0'src = "{{asset('images/logo-circle.png')}}"/> 
                <h1 class = "text-[3rem] font-bold text-gray-700"> NEW SUBJECT FORM </h1>
                <span class  ="text-[0.7rem] text-gray-400">Please be aware that all new subjects submitted through this form must be approved by the Commission on Higher Education (CHED) or the relevant accrediting body.</span>
            </div>

            <div>
                <form class = "flex-col w-full px-8" action="{{route('admin.subjects.create')}}" method = "POST" >
                    @csrf 
                    @method('POST') 

                    <div class = 'w-full flex'>

                        <div class="flex flex-col mr-4 w-[15%] hidden" >
                            <h1 class = "text-gray-500"> SUBJECT ID </h1>
                            <input type="hidden" name="subj_id" value="{{$subj_id}}"/>
                   </div>

                        <div class="flex flex-col mr-4 w-[25%]">
                            <h1 class = "text-gray-500"> SUBJECT CODE </h1>
                            <input class = "rounded-lg w-full" name = "subj_code" type = "text"/> 
                        </div>



                        <div class="flex flex-col mr-4 w-[65%]">
                            <h1 class = "text-gray-500"> SUBJECT TITLE </h1>
                            <input class = "rounded-lg w-full" name = "subj_title" type = "text"/> 
                        </div>

                        <div class="flex flex-col w-[10%]">
                            <h1 class = "text-gray-500"> UNITS </h1>
                            <input class = "rounded-lg w-full" name = "units" type = "text"/> 
                        </div>

                    </div>
            

                    <div class="w-full flex justify-end py-4">
                        <button class = "maroon text-white px-12 py-2 rounded-md" type = "submit"> SUBMIT </button>
                    </div>


                    
                </form>
            </div>
        </div>
        
    </div>
</x-app-layout>

<style> 
.maroon { 
    background-color: maroon;
}
</style> 
