<x-app-layout>
<div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col bg-white rounded-lg p-8">
        <!-- title header  -->    

        <div class="w-full flex flex-col items-center leading-tight">
            
                
            <img src = "{{asset('images/hau-logo.png')}}" class="w-[100px] h-[100px] mr-2"/> 
       

            <h1 class="text-red-900 text-lg font-extrabold"> Holy Angel University </h1>
            <span class="text-gray-600 text-[1rem] "> List of Departments</span>
            <span class="text-gray-400 text-[0.8rem] "> Last Updated: {{$u_at}}</span>
    
            <div class="w-full flex justify-center my-4 gap-2">
                <a href = "{{route('admin.registry.dept.edit.all')}}" class="relative flex justify-center items-center  bg-gray-500 hover:bg-gray-600 text-white px-12 py-2 gap-4" id = "btn">
                    <img src="{{asset('images/icons/upload_csv.png')}}" class="w-[25x] h-[25px]" alt="">
                    <span>
                       Update Records 
                    </span>

   
                </a>

             
                 <a href="{{asset('documents/department_templates/HAU-IDMO_Deparments_MasterList_Template.xlsx')}}" class="flex justify-center items-center bg-gray-500 hover:bg-gray-600 text-white px-12 py-2 gap-4">
               
                <img src="{{asset('images/icons/download.svg')}}" class="w-[20x] h-[20px]" alt="">
                    <span>
                       Download Template
                    </span>
                </a>

            </div>
        </div>

        @if(isset($msg) && $msg != '')
        <span class="w-full rounded-xl bg-green-600 text-white  py-1 px-4" id = "msg"> 
            {{$msg}}
        </span>
    
        {{session()->forget('msg');}}
        @endif


        <hr class="opacity-100 mb-4"> 

            <!-- Search Bar -->
    <input type="text" id="search" placeholder="Search Department..." class="w-full border border-gray-300 p-2 rounded-md mb-4">


        <!-- table -->
        <div class="w-full flex flex-col border border-gray-200 gap-0">
            <!-- header -->
             <div class="w-full bg-red-900 text-white grid grid-cols-[10%_10%_55%] p-2 ">
                    <h1></h1>
                    <h1>ID</h1>
                    <H1>Department</H1>
             </div>

         

             <!-- body with empty data -->

                  
            
             @if($dept->count()==0) 
             <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                  <span class="italic"> No records. </span> 
             </div>
             @else
             <!-- body -->

            <div class="flex flex-col items-start" id="dept-list">

            

             @foreach($dept as $item) 
                <div class="w-full bg-gray text-gray-500 grid grid-cols-[10%_10%_55%_25%] p-2 border bt-gray-100">
                     
                        @if($item->logo != '') 
                        <img src=  "{{asset('storage/dept/logo/' . $item->logo)}}" class="w-[50px] h-[50px]"/> 
                        @else
                        <img src=  "{{asset('images/logo-circle.png')}}" class="w-[50px] h-[50px]"/> 
                        @endif
                        <div class="flex items-center">

                            <h1>{{$item->code}}</h1>
                        </div>
                        <div class="flex items-center">

                            <h1>{{$item->dept}}</h1>
                        </div>


                        <div class="flex items-center justify-end">
                            <form class="flex items-center" action="{{route('admin.dept.view', ['id'=> $item->id])}}">
                                <button class=" w-[95%] bg-green-700 hover:bg-green-800 px-4 py-1 text-white rounded-lg" title = "Edit"> 
                                    <img src="{{asset('images/icons/edit.png')}}" alt="" class="w-[20px] h-[20px]">
                                </button>
                            </form>

                            <form class="flex items-center" action="{{route('admin.dept.delete', ['id'=> $item->id])}}" method = "POST">
                                @csrf 
                                @method('DELETE')
                                <button onclick = "confirmDelete(this)" type = "button" class="w-[95%] bg-red-700 px-4 py-1 text-white rounded-lg" title="Delete"> 
                                <img src="{{asset('images/icons/delete.png')}}" alt="" class="w-[20px] h-[20px]">
                             </button>
                            </form>

                        </div>
                </div>
             @endforeach

             </div>



             <div class="w-full p-4">

                 {{ $dept->links() }}
             </div>

        


             @endif


             
                     

             

        </div>

        

        

     

    </div>
</div> 
</x-app-layout>

<style> 
a, button { 
    transition: 300ms;
}

.show { 
    display: flex; 
    flex-direction: column;
}

.hide {
    display: none;
}
</style> 

<script> 


function showToggle(){ 
    let dp=document.getElementById('dp'); 

    if(dp.classList.contains('hide')) { 
        dp.classList.remove('hide'); 
        dp.classList.add('show')
    } else { 
        dp.classList.add('hide'); 
        dp.classList.remove('show')
    }
}

let dp=document.getElementById('dp'); 
let btn = document.getElementById('btn')
document.body.addEventListener("click", (event)=> { 
                if(!dp.contains(event.target) && !btn.contains(event.target)) { 
                    dp.classList.add('hide')
                    dp.classList.remove('show')
                }
            }) 



            let debounceTimer;

        document.getElementById('search').addEventListener('input', function() {
            let searchQuery = this.value;

            // Clear the previous timer whenever the user types
            clearTimeout(debounceTimer);

            // Set a new timer to call fetchSubjects after 2 seconds of no typing
            debounceTimer = setTimeout(function() {
                fetchSubjects(searchQuery);
            }, 2000); // 2000 milliseconds = 2 seconds
        });



    function fetchSubjects(query) {
        fetch(`{{ route('admin.dept.search') }}?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('dept-list');
                tbody.innerHTML = ''; // Clear the current list
                data.forEach(dept => {

            
                    

                    let route = `{{ url('admin/registry/departments/') }}/${dept.id}`;
                    let deleteRoute = `{{url('admin/registry/departments/delete/')}}/${dept.id}`; 
                    let logo; 
                    if (dept.logo && dept.logo.trim() !== "") {
                         logo = `storage/dept/logo/${dept.logo}`;
                    } else {
                         logo = 'images/logo-circle.png';
                    }

                 
                    let row = `
                       <div class="w-full bg-gray text-gray-500 grid grid-cols-[10%_10%_55%_25%] p-2 border bt-gray-100">
                     
                       
                        <img src=  "{{asset('${logo}')}}" class="w-[50px] h-[50px]"/> 
                        
                        
                       
                       
                        <div class="flex items-center">

                            <h1>${dept.code}</h1>
                        </div>
                        <div class="flex items-center">

                            <h1>${dept.dept}</h1>
                        </div>


                        <div class="flex items-center justify-end">
                            <form class="flex items-center"  action = "${route}">
                                <button onclick = "edit_dept(this)" class="w-[95%] bg-green-700 hover:bg-green-800 px-4 py-1 text-white rounded-lg" title = "Edit"> 
                                    <img src="{{asset('images/icons/edit.png')}}" alt="" class="w-[20px] h-[20px]">
                                </button>
                            </form>

                            <form class="flex items-center"  action = "${deleteRoute}" method = "POST">
                                @csrf 
                             @method('DELETE')
                                <button type = "button" class="w-[95%] bg-red-700 px-4 py-1 text-white rounded-lg" title="Delete" onclick = "confirmDelete(this)"> 
                                <img src="{{asset('images/icons/delete.png')}}" alt="" class="w-[20px] h-[20px]">
                             </button>
                            </form>

                        </div>
                </div>
                    `;
                    tbody.innerHTML += row;
                });
            });
    }


    let msgElement = document.getElementById('msg');

if (msgElement) {
    setTimeout(() => { 
        msgElement.style.display = 'none'; 
    }, 5000); // 5000 milliseconds = 5 seconds
}



function confirmDelete(button) { 
    const form = button.closest('form'); 
    if(confirm('Are you sure you want to delete this department?')){  
        form.submit(); 
    }
}


function edit_dept(button) { 
    button.closest('form').submit();
}

</script> 