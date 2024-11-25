<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col bg-white rounded-lg p-8">
            <div class="w-full grid grid-cols-[85%,15%]">
                <div class="w-full flex flex-col">
                    <h1 class = "text-[1.5rem] font-bold"> Batch Load of Subjects </h1> 
                    <span class = "text-gray-500"> Load multiple subjects/teaching loads to users </span> 
                </div>

                <div class="w-full flex items-center justify-end relative">
                
                <div class="hamburger">
                            <h1 id="dp-ind">hidden</h1>
                            <button type = "button" class = "dp" >
                                 <img src = "{{asset('images/icons/menu.png')}}"> 
                               
                            </button>

                            <div class="dropdown-menu">
                            <a href = "{{route('admin.subjects')}}" onclick="window.open(this.href, 'newwindow', 'width='+screen.width+',height='+screen.height+',top=0,left=0'); return false;" class="dp-item">
                                  
                                    <h1> VIEW ALL SUBJECTS </h1>
                                </a>
                                
                               

                                
                            </div>
                        </div>
              

                </div>
            </div> 


                <div class="w-full flex items-center gap-4 mt-4">
                    <span class = "bg-red-900 text-white w-[40px] h-[40px] font-bold text-[1.5rem] circle flex items-center justify-center"> 1 </span> 
                    <h1 class="font-extrabold text-[2rem] text-gray-600">SELECT A SUBJECT</h1>
                </div>

                     
                <form class="w-full pl-14 mb-2" action="{{route('admin.loads.batch.subj')}}" method = "GET" >
                    @csrf
                    <input class = "w-[50%] border border-gray-400" type = "text" name = "subj_code" placeholder="Search subject code or subject ID">
                    <button class = "maroon bg-red-900 text-white h-full px-12"type = ""> LOAD </button> 
                </form>
                
                @if(isset($msg)) 
                <span class="pl-14 text-sm text-gray-400 italic"> {{$msg}} </span>
                @endif

                @if(!(isset($msg)))

                <div class="w-full pl-14 flex flex-col">
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
                            <h1 class="text-gray-500 font-semibold"> UNITS </h1> 
                        </div>
                        <div class="p-2"><h1 class="text-gray-500"> {{$subj-> units}}.00</h1></div>
                    </div>

                </div>

                <div class="w-full mt-2">
                    <form class="w-full flex justify-end" action = "{{route('admin.loads.batch.users', ['id'=> $subj-> subj_code])}}" method = "GET">
                        @csrf
                     
                        <button class="maroon bg-red-900 text-white px-12 py-2 rounded-lg"> SELECT SUBJECT </button>
                    </form> 
                </div>

                @endif
                

             
           
            
          
      

            
        </div>
    </div>
</x-app-layout>

<style >
    .circle { 
        border-radius: 50%; 
    }
    .maroon { 
        background-color: maroon;
        transition: 300ms; 
        
    }

    .maroon:hover { 
        background-color: #A84655;
    }


    .hamburger { 
        width: 50%; 
        height: 100%;
        display: flex;
        align-items: end; 
        justify-content: end;
    }

    .hamburger button { 
        margin-right: 2rem;
        height: 70%;
        display: flex;
        align-items: center;
        justify-content: center; 
        background-color: maroon;
        color: white;
        width: 100%; 
        padding: 0.2rem 0;
        transition: 300ms;
        position: relative; 
    }

    .hamburger button:hover { 
        background-color: #A84655;
    }

    .hamburger button img { 
        width: 20px; 
        height: 20px; 
    }

    .dropdown-menu { 
        position: absolute;
        top: 100%; 
        margin-right: 2rem;
       
        flex-direction: column;
        background-color: #A52A2A; 
        display: none;

    }

    .dp-item { 
        width: 220px;
        padding: 0.5rem 0;
        
        display: flex; 
        justify-content: center;
        align-items: center;
        color: white;
        transition: 300ms;

        /* border: 1px solid maroon; */
        
    }


    .dp-item:hover { 
        background-color: #8B1A1A ;
    }
    .dp-item img { 
        width: 25pX; 
        height: 25px; 
        margin-right: 0.5rem;
    }

    #dp-ind { 
        display: none;  
    }

</style>

<script> 


//drop down menu 
document.querySelector(".dp").addEventListener("click",()=> {
  let dp_menu = document.querySelector(".dropdown-menu") 
  let ind = document.querySelector("#dp-ind")
  if(ind.innerHTML == 'hidden') { 
      dp_menu.style.display = 'flex';
      ind.innerHTML = 'show' 
  } else { 
    dp_menu.style.display = 'none'
    ind.innerHTML = 'hidden' 
  }
}
)

document.body.addEventListener("click", (event) => {
    let dp_menu = document.querySelector(".dropdown-menu");
    let dp_toggle = document.querySelector(".dp");

    // Check if the clicked target is not the dropdown menu or its toggle button
    if (!dp_menu.contains(event.target) && !dp_toggle.contains(event.target)) {
        dp_menu.style.display = 'none';
        document.querySelector("#dp-ind").innerHTML = 'hidden';
    }
});



</script> 