@php 
$file = $data->id . '.' . explode('.', $data->attachment)[1]; 

@endphp

<x-app-layout>
   <div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col p-8 bg-white rounded-lg items-start">
        

     @if(!isset($approval))

        <a href="{{route('portal.employment')}}" class="bg-red-900 hover:bg-red-700 text-white px-8 py-1 rounded-[25px] flex gap-2 items-center justify-center">
            <img src="{{asset('images/icons/back.png')}}" class="w-[15px] h-[15px]" alt="">
            <span class=""> Employments </span>
        </a>

    @else

        <a href="{{route('admin.pendings')}}" class="bg-red-900 hover:bg-red-700 text-white px-8 py-1 rounded-[25px] flex gap-2 items-center justify-center">
            <img src="{{asset('images/icons/back.png')}}" class="w-[15px] h-[15px]" alt="">
            <span class=""> Return to Pending Requests </span>
        </a>


    @endif


    @if(isset($approval))
        <div class="w-full flex flex-col my-4">
            <h1 class="font-bold text-gray-600 text-[1rem]"> Submission Details</h1>

            <!-- first row -->
            <div class="w-full items-center flex gap-12">
                <div class="flex flex-col ">
                    <span class="text-gray-400">Employee ID</span>
                    <h1 class="font-bold text-gray-600"> {{$user->emp_id }}</h1>
                </div>

                <div class="flex flex-col leading-tight">
                    <span class="text-gray-400">Full Name</span>
                    <h1 class="font-bold text-gray-600">{{$user-> emp_lname . ', ' . $user-> emp_fname . ' ' . $user-> emp_mname}}</h1>
                </div> 



                <div class="flex flex-col">
                    <span class="text-gray-400">Department</span>
                    <h1 class="font-bold text-gray-600"> {{$user->department->dept }}</h1>
                </div>
            </div>


             <!-- second row -->
             <div class="w-full items-center flex gap-12">
                <div class="flex flex-col ">
                    <span class="text-gray-400">Request Type</span>
                    <h1 class="font-bold text-gray-600"> {{$request->type}}</h1>
                </div>

                <div class="flex flex-col leading-tight">
                    <span class="text-gray-400">Date Submitted</span>
                    <h1 class="font-bold text-gray-600">{{$request->date_submitted}}</h1>

                </div>


            </div>

        </div>

        <hr class="w-full opacity-90 my-2">

    @endif

            <div class="w-full flex items-center justify-start gap-1">

                <img src="{{asset('images/hau-logo.png')}}" class="w-[40px] h-[40px] my-4" alt="">
                <h1 class="font-bold text-gray-600 text-[1.5rem]">Employment Details</h1>

                    @if(!isset($approval))
                    <a href="{{route('portal.employment.edit', ['id'=> $data->id])}}" class="flex px-4 py-1 bg-red-900 hover:bg-red-700 text-white rounded-lg gap-1">
                        <img src="{{asset('images/icons/edit.png')}}" class="w-[20px] h-[20px] " alt="">
                        <span> Edit </span>
                    </a>


                    <form action="{{route('portal.employment.delete', ['id'=> $data->id])}}" method = "POST">
                        @csrf 
                        @method('DELETE')
                        <button type = "button" onclick="confirmDelete(this)" class="flex px-4 py-1 bg-red-900 hover:bg-red-700 text-white rounded-lg gap-1">
                            <img src="{{asset('images/icons/delete.png')}}" class="w-[20px] h-[20px] " alt="">
                            <span> Delete </span>
                        </button>

                    </form>


                    @if($data->status == 'To-review')
    <form action="{{ route('portal.employment.resubmit', ['id' => $data->id]) }}" method="POST">
        @csrf 
        @method('PATCH')
        <button type="button" onclick="confirmResubmit(this)" class="flex px-4 py-1 bg-red-900 hover:bg-red-700 text-white rounded-lg gap-1">
            <img src="{{ asset('images/icons/resubmit.png') }}" class="w-[20px] h-[20px]" alt="">
            <span>Resubmit</span>
        </button>
    </form>
    <span class="text-gray-400 text-xs pl-4 flex flex-col w-2/6">
        <strong> Important Notice </strong> 
        Please ensure that all changes are thoroughly reviewed and edited before resubmitting your request.
    </span>
@endif

                    
    
                    @endif
                </div>
           



              
         

            
            


       

        <div class="w-full flex flex-col gap-2">
                <div class="w-full flex flex-col leading-tight">
                    <span class=" text-gray-400">Training</span>
                    <h1 class="text-lg font-bold text-gray-700">{{$data->company}}</h1>
                </div>

                <div class="w-full grid grid-cols-3 gap-2">
                    <div class="flex flex-col leading-tight">
                        <span class=" text-gray-400">Date Hired</span>
                        <h1 class="text-lg font-bold text-gray-700">{{$data->date_hired}}</h1>
                    </div>

                    <div class="flex flex-col leading-tight">
                        <span class=" text-gray-400">Date Resigned</span>
                        <h1 class="text-lg font-bold text-gray-700">{{$data->date_resigned}}</h1>
                    </div>

                    <div class="w-full flex flex-col leading-tight">
                        <span class=" text-gray-400">Position</span>
                        <h1 class="text-lg font-bold text-gray-700">{{$data->position}}</h1>
                    </div>

                </div>

                <div class="w-full grid grid-cols-3 gap-2">
                    <div class="w-full flex flex-col leading-tight">
                        <span class=" text-gray-400">Reason for Exit</span>
                        <h1 class="text-lg font-bold text-gray-700">{{$data->reason}}</h1>
                    </div>


                    <div class="flex flex-col leading-tight">
                        <span class=" text-gray-400">Attachment</span>
                        <h1 class="text-lg font-bold text-gray-700 truncate">{{$data->attachment}}</h1>
                    </div>

                    <div class="flex flex-col leading-tight">
                        <span class=" text-gray-400">Status </span>
                        <h1 class="text-lg font-bold text-gray-700">{{$data->status}}</h1>
                    </div>
                    

                </div>


                    <span class="mt-4 text-gray-400">
                        Proof of Employment
                    </span>

               
                
                    
                    @if(isset($approval)) 
                    <iframe id="pdfIframe" src="{{ asset('storage/employment/' .$user->emp_id . '/'. $file) }}" width="100%" height= "500px" ></iframe>

                    @else
                    <iframe id="pdfIframe" src="{{ asset('storage/employment/' . Auth::user()->id. '/'. $file) }}" width="100%" height= "500px" ></iframe>
                    @endif




             

                

        </div>


        @if(isset($approval))
        <hr class="w-full opacity-100 my-4 text-gray-400">
        <div class="w-full justify-end flex gap-2">
            <form action="{{route('admin.pendings.toreview', ['id'=> $data->id])}}" method = "POST">
                @csrf 
                @method('PATCH')
            <button class="bg-red-500 hover:bg-red-600 text-white px-8 py-1 rounded-xl">Send to Review</button>
            </form>


            <form action="{{route('admin.pendings.approved', ['id'=>$data->id])}}" method = "POST">
                @csrf 
                @method('PATCH')
                <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-1 rounded-xl">Approve</button>
            </form>




        </div>
        @endif
</div> 

        



   </div>
</x-app-layout>

<style>
    a, button { 
        transition: 300ms;
    }
</style>


<script>

function confirmDelete(button) { 
    const form = button.closest('form'); 
    if(confirm('Are you sure you want to delete this record?')){ 
        form.submit(); 
    }
}

function confirmResubmit(button) { 
    const form = button.closest('form'); // Find the closest form element
    
    if(confirm('Are you sure you want to resubmit the data?')) { 
        form.submit(); // Submit the form if the user confirms
    }
}


</script>