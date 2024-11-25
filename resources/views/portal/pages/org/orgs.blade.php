    <x-app-layout>
<div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col bg-white rounded-lg p-8">
        <div class="w-full flex mb-2">
            
                
                <img src = "{{asset('images/logos/school/soc_logo.png')}}" class="w-[100px] h-[100px] mr-2"/> 
           
           
            <div class="w-full flex flex-col justify-center">
                <!-- title header  -->    
                <h1 class="text-[1.5rem] font-bold leading-tight">{{$user-> emp_lname . ', ' . $user-> emp_fname . ' ' . $user-> emp_mname}}</h1>
                <h1 class="text-[1.2rem] font-semibold text-gray-700"> {{$user-> emp_id}}</h1>
                <span class="text-gray-500 text-sm">Number of organization/s: {{$orgs-> count()}} </span>
            </div>
        </div>
        

    

            <!-- add button -->
            <div class="w-full flex gap-2">
                <a href="{{route('portal.org.add')}}" class="w-[25%] rounded-xl py-2 flex items-center justify-center gap-1 bg-red-900 my-2 hover:bg-red-800 ">
                    <img src = "{{asset('images/icons/add.png')}}" class="w-[25px] h-[25px]"/> 
                    <h1 class="text-white">Insert</h1>
    
                </a>
                <form action="{{route('portal.org.clear')}}" class="w-[25%]" method = "POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="w-full rounded-xl py-2 flex items-center justify-center gap-1 bg-red-900 my-2 hover:bg-red-800" onclick="confirmClear(this)">
                        <img src = "{{asset('images/icons/clear.png')}}" class="w-[25px] h-[25px]"/> 
                        <h1 class="text-white">Clear all data</h1>
                        
                    </button>
                </form>

                

            </div>



        <hr class="opacity-100 my-4"> 

     <!-- table -->
<div class="w-full flex flex-col border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <!-- header -->
    <div class="w-full bg-red-900 text-white grid grid-cols-[25%_20%_15%_20%_20%] p-3 font-semibold text-sm uppercase tracking-wider">
        <span>Organization</span>
        <span>Position</span>
        <span>Date Joined</span>
        <span>Last Updated</span>
        <span class="text-center">Actions</span>
    </div>

    <!-- body with empty data -->
    @if($orgs->count() == 0) 
    <div class="w-full flex items-center justify-center text-sm text-gray-400 py-8">
        <span class="italic">No user data available.</span>
    </div>
    @else
    <!-- body -->
    <div class="w-full flex flex-col overflow-y-auto h-[300px]">
        @foreach($orgs as $org)
        <div class="w-full grid grid-cols-[25%_20%_15%_20%_20%] p-4 border-t border-gray-200 bg-white hover:bg-gray-50 transition-colors">
            <span class="flex items-center text-gray-700">{{$org->org}}</span>
            <span class="flex items-center text-gray-700">{{$org->position}}</span>
            <span class="flex items-center text-gray-700">{{$org->date_joined}}</span>
            <span class="flex items-center text-gray-700">{{$org->updated_at}}</span>
            <div class="w-full flex justify-center gap-2">
                <!-- Edit Button -->
                <form action="{{route('portal.org.edit',['user'=> Auth::user()->id, 'id'=> $org->id])}}" method="GET">
                    <button type="submit" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700 transition-all" title="Edit Info">
                        <img src="{{asset('images/icons/edit.png')}}" alt="Edit" class="w-[20px] h-[20px]">
                    </button>
                </form>

                <!-- Delete Button -->
                <form action="{{route('portal.org.delete')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="text" name="id" value="{{$org->id}}" hidden>
                    <button onclick="confirmDelete(this)" type="button" class="border bg-red-900 rounded-xl p-2 hover:bg-red-700 transition-all" title="Delete Item">
                        <img src="{{asset('images/icons/delete.png')}}" alt="Delete" class="w-[20px] h-[20px]">
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

        <hr class="opacity-100 my-4"> 

        <span class="text-gray-400 text-[0.8rem]">Please ensure that all data or membership information you provide or upload is legitimate. It is essential that all submissions meet the necessary criteria and comply with our standards to maintain the integrity of our system. Thank you for your cooperation.

</span>




    
    </div>
</div> 
</x-app-layout>

<style> 
a, button { 
    transition: 300ms;
}
</style> 

<script> 
  function confirmDelete(button)  {
        const form = button.closest('form');
        if(confirm('Are you sure you want to delete this record?')) { 
           form.submit()
        }

    }
      

    function confirmClear(button) { 
        const form = button.closest('form') 
        if(confirm("Are you sure you want to clear all organization memberships?")){ 
            form.submit();
        }
    }

</script> 