

<x-app-layout>
<div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col p-8 bg-white rounded-lg">
        <span class="text-gray-400">Manage Users</span>
        <div class="w-full grid grid-cols-2">
            @if(Auth::user()->role == 'SuperAdmin')
            <h1 class="text-[1.8rem] text-gray-600 font-semibold">All Users</h1>
            @else 
            <h1 class="text-[1.8rem] text-gray-600 font-semibold">All Users ({{Auth::user()->user->department->dept}})</h1>

            @endif


            <div class="flex items-center justify-end gap-4 float-right ">
                <div class="w-[25%] text-right">
                    <span class="font-semibold "> {{$count}} user/s</span> 

                </div>
        
                <a href="" class="w-[25%] bg-red-900 hover:bg-red-800 flex items-center justify-center rounded-lg text-white py-1 h-[90%]">
                    <img src="{{asset('images/icons/add_plain.png')}}" class="w-[25px] h-[25px]" alt="">
                    <span> Add User</span>
                </a>

                
            </div>


        </div>

        
        <span class="text-xl text-gray-500 font-semibold mb-2">

            
                @if(isset($dept))
                Department - {{$dept}}
                @endif

                @if(isset($role))
                Role - {{$role}}
                @endif
                
            </span>



          
        <button id = "filter-btn" onclick="filter_clicked(this)" class="w-[10%] flex items-center justify-center gap-2  bg-white hover:bg-gray-200 rounded-lg inactive">
            <img src="{{asset('images/icons/filter.svg')}}" class="w-[15px] h-[15px]" alt="">
            <span class="font-semibold text-gray-400"> Filter </span> 
        </button>
  
    

        <div id = "filter-box" class="w-full flex flex-col p-2 mt-2 rounded-xl">
            <!-- main form -->

            <div class="w-full flex gap-2">

                @if(Auth::user()->role == 'SuperAdmin') 

                <button onclick = "click_filter(this)" class="w-[150px] h-[40px] flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg deptc">
                    <span class="text-sm text-gray-600">Department</span>
                </button> 

                @endif
               
                
               



                <!-- reset filter -->
                @if (request()->routeIs('admin.users.filter*')) 

                <button onclick = "resetFilter()"  class="hover:bg-gray-100 px-2"  title = "Clear Filter">
                    <img src="{{asset('images/icons/clear.svg')}}" class="w-[20px] h-[20px]" alt="">
                </button>

                @endif
             
            </div>

            <div class="w-full dept">
                <form action="{{route('admin.users.filter',['type'=>'dept'])}}" class="mt-2 flex" method = "GET">

                @csrf
                @method('GET')

                    <select name="dept" id="tags" class="border border-gray-200">
                    @foreach($depts as $item) 
                        <option value = "{{$item->code}}"> {{$item->dept}}  </option>
                    @endforeach
                </select>
                <button class="bg-red-900 hover:bg-red-700 text-white px-8"> APPLY </button>
                </form>
            </div>

            <div class="w-full role">
                <form action="{{route('admin.users.filter',['type'=>'role'])}}" class="mt-2 flex" method = "GET">

                @csrf
                @method('GET')

                    <select name="role" id="tags" class="border border-gray-200 w-[300px]">
                
                        <option value = "Employee"> Employee  </option>
                
                        <option value = "HR Admin"> HR Admin  </option>

                        <option value = "Dean"> Dean  </option>

                </select>
                <button class="bg-red-900 hover:bg-red-700 text-white px-8"> APPLY </button>
            </form>
            </div>
        </div>




        
        <hr class="opacity-90 my-4">

        <!-- Search Bar -->
        @if($count != 0)
    <input type="text" id="search" placeholder="Search user..." class="w-full border border-gray-200 p-2 rounded-sm mb-4">
    @endif



            @if($count == 0)    
            <div class="w-full text-center">
                <h1 class="text-gray-400"> No data found. </h1>
            </div>

            @endif


            
    

    <div id="user-list" class="flex flex-col gap-1">
    @foreach($users as $user) 
            <div class="w-full flex items-center">
                <div class="w-3/4 flex items-center gap-2 py-2">
                    @if($user-> profile_picture != '')
                        <img  id = "preview" src ="{{asset ('storage/profile_pictures/' . $user->profile_picture)}}" class="w-[30px] h-[30px] rounded-lg" alt = "user_image"/> 
                    @else 
                        <img  id = "preview" src ="{{asset ('images/blankdp.jpg')}}" class="w-[30px] h-[30px] rounded-lg" alt = "user_image"/> 


                    @endif
                    <h1 class="text-lg font-semibold"> {{$user-> emp_lname . ', ' . $user->emp_fname . ' ' . $user-> emp_mname}}</h1>
                    <span class="text-sm text-gray-400"> {{$user-> login-> email}}</span>
                </div>
                <div class="w-1/4 flex items-center justify-end gap-4">
                    <span class="text-sm text-gray-400"> {{$user->login->role }}, <strong class="uppercase"> {{$user->emp_dept}} </strong>  </span>

                    <a href="{{route('admin.users.view', ['id'=> $user->emp_id])}}" class="bg-gray-900 hover:bg-gray-700 p-2 rounded-xl" title="View Profile">
                        <img src="{{asset('images/icons/view.svg')}}" class="w-[25px] h-[25px]" alt="">
                    
                    </a>

                    
                </div>
            </div>

            <hr class="opacity-60 my-2">
            
            @endforeach

 
            {{$users->links()}} 
    </div>
           

    </div>
</div>

</x-app-layout>


<style>
    a,button { 
        transition: 300ms;
    }

    #filter-box { 
        display: none ; 
    }

    .dept { 
        display: none 
    }

    .role { 
        display: none; 
    }

    .act { 
        background-color: rgb(229 231 235);
    }
</style>

<script>  



function filter_clicked(button){ 
    let box = document.getElementById('filter-box')
    if(button.classList.contains('inactive')) { 
        box.style.display =  'flex'; 
        button.classList.remove('inactive') 
        button.style.backgroundColor = 'rgb(229, 231, 235)';
    } else  { 
        box.style.display = 'none' 
        button.classList.add('inactive'); 
        button.style.backgroundColor = 'white';
       
    }

}

function click_filter(btn) { 
    if(btn.classList.contains('deptc')) { 
        btn.classList.add('act'); 
        document.querySelector('.dept').style.display = 'flex'; 
        document.querySelector('.role').style.display = 'none';
    } else if (btn.classList.contains('rolec')) { 
        btn.classList.add('act'); 
        document.querySelector('.role').style.display = 'flex'
        document.querySelector('.dept').style.display = 'none';

    }
}

function resetFilter(){ 
    if(confirm('Are you sure to clear the filter?')) { 
        window.location='{{ route("admin.users") }}'
    }
}


//search
document.getElementById('search').addEventListener('input', function() {
        let searchQuery = this.value;
        fetchSubjects(searchQuery);
    });

    function fetchSubjects(query) {
    fetch(`{{ route('admin.users.search') }}?query=${encodeURIComponent(query)}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => { 
        let tbody = document.getElementById('user-list');
        tbody.innerHTML = ''; // Clear the current list
        
        data.forEach(user => {
          
            let profilePicture = user.profile_picture 
                ? `{{ asset('storage/profile_pictures/') }}/${user.profile_picture}` 
                : `{{ asset('images/blankdp.jpg') }}`;


            let viewProfileUrl = `{{ url('admin/records/users/') }}/${user.emp_id}`;




            let row = `
                <div class="w-full flex items-center">
                    <div class="w-3/4 flex items-center gap-2 py-2">
                        <img id="preview" src="${profilePicture}" class="w-[30px] h-[30px] rounded-lg" alt="user_image" />
                        <h1 class="text-lg font-semibold">${user.emp_lname}, ${user.emp_fname} ${user.emp_mname}</h1>
                    </div>
                    <div class="w-1/4 flex items-center justify-end gap-4">
                        
                        <a href="${viewProfileUrl}" class="bg-gray-900 hover:bg-gray-700 p-2 rounded-xl" title="View Profile">
                            <img src="{{ asset('images/icons/view.svg') }}" class="w-[25px] h-[25px]" alt="">
                        </a>
                    </div>
                </div>
                <hr class="opacity-60 my-2">
            `;

            tbody.innerHTML += row;
        });
    })
    .catch(error => console.error('Error fetching user data:', error));
}


</script> 