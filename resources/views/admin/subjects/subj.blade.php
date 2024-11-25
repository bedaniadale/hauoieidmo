@php
$count = 1; 



@endphp



<x-app-layout>
    <div class="container">

       
        <div class="con-box">

            <section class='search-header'>
                
                        <div class="search-btn">
                            <span>Search for Subject</span>
                            <input id = "search" type = "text" name = "search" placeholder = "Enter a keyword...">
                            <div class="search-results"></div>                            
                        </div>

                        <div class="hamburger">
                            <h1 id="dp-ind">hidden</h1>
                            <button type = "button" class = "dp" >
                                 <img src = "{{asset('images/icons/menu.png')}}"> 
                               
                            </button>

                            <div class="dropdown-menu">
                            <a href = "{{route('admin.subjects.add')}}"class="dp-item">
                                  
                                    <h1> ADD NEW SUBJECT </h1>
                                </a>
                                
                                <a href = "{{route('admin.subjects.delete')}}" class="dp-item">
                                 
                                    <h1> DELETE SUBJECT </h1>
                                </a>

                                <a href= "{{route('admin.subjects.upload')}}" class="dp-item">
                                  
                                    <h1> UPLOAD SUBJECTS </h1>
                                </a>

                                
                            </div>
                        </div>
                        
            </section>

           
            <section class="box-header">
               
            </section>

           
            <div class="tbl-header">
                    <!-- <div class="tbl-col"><h1>SUBJ_ID </h1></div> -->
                    <div class="tbl-col"><h1>SUBJ_CODE </h1></div>
                    <div class="tbl-col"> <h1> SUBJ_TITLE </h1></div>
               
                    <div class="tbl-col"> <h1>  </h1></div>
              
                    <div class="tbl-col"> <h1> </h1></div>
                </div>
            <section class="table-section">
                
              

                <div class="table main-dep">
                   
                    @if($data->count()==0) 
                        <div class = "tbl-row empty"> 
                            <h1> No data.</h1>
                        </div>
                    @else
                        @foreach($data as $item) 
                            @if($count % 2 == 0) 
                                <div class = 'tbl-row stripe'> 

                                <!-- <div class = 'tbl-col'><h1 class = "subj_id">{{$item->subj_id}}</h1>  </div>     -->
                                <div class = 'tbl-col'><h1 class = "subj_code">{{$item->subj_code}}</h1>  </div> 
                                    <div class = 'tbl-col'><h1>{{$item->subj_title}}</h1>  </div> 
                                    <!-- <div class = 'tbl-col'><h1>{{$item->subj_description}}</h1> </div>  -->
                                  
                                    
                                    
                                <div class="tbl-col col-acts"> 
                                <form action = "{{route('admin.subjects.view')}}" method = "GET"> 
                                            @csrf
                                            @method('GET') 
                                            <input type = "text" name = "id" value = "{{$item->subj_code}}" hidden/> 
                                            <button id =  "edit" type = "submit"> READ </button>  
                                        </form> 

                    

                                      
                                        
                                    </div>
                                </div> 
                            @else 
                                <div class = 'tbl-row'> 
                                <!-- <div class = 'tbl-col'><h1 class = "subj_id"> {{$item->subj_id}} </h1>  </div>     -->
                                <div class = 'tbl-col'><h1 class = "subj_code"> {{$item->subj_code}} </h1>  </div> 
                                    <div class = 'tbl-col'><h1> {{$item->subj_title}} </h1>  </div> 
                                    <!-- <div class = 'tbl-col'><h1> {{$item->subj_description}}</h1> </div>  -->
                                  
                                    
                           
                                    <div class="tbl-col col-acts"> 
                                    <form action = "{{route('admin.subjects.view')}}" method = "GET"> 
                                            @csrf
                                            @method('GET') 
                                            <input type = "text" name = "id" value = "{{$item->subj_code}}" hidden/> 
                                            <button id =  "edit" type = "submit"> READ </button>  
                                        </form> 


                                     

                                      
                                    </div>
                                </div> 
                            @endif
                            

                            @php $count++; @endphp 
                        
                        @endforeach
                    @endif
            

                    
                 
                </div>

            </section>
            

            <section class="actions">
                <!-- for blank slots -->
                <div class="act-slot">
                    <span id = "cb_msg" class="text-gray-500"></span>
                            
                        <h1 class = "dep-msg" id = "msg"> {{ session('msg') }} </h1>
                  
                    {{session(['msg'=> ''])}}
                 
                   
                </div> 
                <div class="act-slot"></div> 
                <div class="act-slot"></div> 
                <!-- end of blank slots  -->
                

              


                
            </section>
        </div>

        
    </div>
</x-app-layout>


<style> 

.subj_id, .subj_code { 
    cursor:pointer;
}

    .container { 
        width: 100% ;
        display: flex; 
        justify-content: center;
        padding: 2rem 0 ;
        position: relative; 
    }

    

    
    .con-box { 
        /* for windowed layout */
        border-radius: 10px; 
        width: 95%;   

        /* for full screen */
        /* width: 100%;   */

        background-color: white;
        display: flex; 
        flex-direction: column;
        align-items: center;
        padding: 1rem 0; 
       
        /* border-radius: 15px;  */
    }

    .box-header { 
        
        margin-bottom: 1rem;
        width: 95%; 
        display: flex;


        
   
    }


   

    
    .usersearch { 
        display: flex; 
        flex-direction: column;
        width: 100%; 
        padding: 0.2rem 2rem;
        line-height: 1.3rem; 
    }

    .usersearch h1 { 
        font-size: 1.5rem;
        font-weight:900; 
    }

    .usersearch h3 { 
        font-size: 1rem; 
        font-weight: 700; 
        color: gray; 

    }

    .search-header { 
        width: 100%; 
        display: flex; 
     
    
        

        position: relative;

      
    }

    .search-btn{ 
        width: 50%;
        padding-left: 2rem; 

        display: flex; 
        flex-direction: column;
        position: relative ;

    }

    .search-btn input[type=text] { 
        width: 100%;
    }
    .search-results { 
        /* box-shadow: 0px 0px 2px 0px; */
        /* border: 1px solid rgb(190,190,190);  */
        position: absolute;
        width: 93.5%; 
    
        
        background-color: beige;
        top: 100%;
        display: flex;

        flex-direction: column;
        max-height: 300px; /* Set a maximum height */
        overflow-x: auto;
    
    }

    .res-item { 
        border: 1px solid red;
        width: 100%;
        display: flex; 
        flex-direction: column;
        
        border: 1px solid rgb(190,190,190);
        padding: 1rem;
        line-height: 1.2rem;
        
     }

     .res-item button { 
        text-align: left;
     }
    

     .res-item:hover { 
        background-color: #e0e0d1;
     }
     .search-results h1 { 
        font-style: italic;
        font-size: 1rem;
        width: 100%;
        font-weight: 700;
     }

     .search-results h3 { 
        font-size: 0.8rem;
     }

    

 

    .search-header span { 
        font-size: 0.8rem; 
        color: gray; 
    }

   

    

  

    .categories { 
        width: 100%; 
        display: flex; 
        
    }


    
    .cat-slot form { 
       
        display: flex; 
        justify-content: center;
        align-items: center;
        margin: 0 0.2rem;
    }
    
    .cat-slot form button { 
        color: white; 
   
        height: 80%; 
        border-radius: 10px; 
        background-color: #555556;
        transition: 300ms; 
        padding: 0.5rem 2rem;
    }

    .cat-slot form .active  { 
        background-color: #9d9898;
    }

    .cat-slot form button:hover { 
        background-color: #6c6c6c ;
    }

    .cat-slot form .active:hover{ 
        background-color:#b3aead  ;
    }


    input::placeholder {
            color: rgb(200, 200,200); /* Placeholder text color */
            font-size: 14px; /* Placeholder text size */
            font-style: italic; /* Placeholder text style */
        }


    input[type="text"]:focus {
    outline: none; /* Removes the outline */
    box-shadow: none; /* Optionally removes any shadow */
    }



    .table-section { 
       
        width: 95% ;
        height: 350px;
   
        overflow-y: auto;
    
    }
    
        /* table template codes */
    .table { 
        width: 100%; 
        border: 1px solid rgb(0,0,0,0.1);
    }

    .tbl-header { 
       
        width: 95%; 
        height: 40px; 
        background-color: maroon;

        display: grid; 
    }

    .tbl-row { 
        width: 100%; 
        padding: 1rem 0;
        display: grid; 
        transition: 300ms; 

        
    }

    hr{ 
        opacity: 0.8;
        width: 100%; 
        color: black;
    }

    .tbl-row:hover{ 
        background-color: beige;
    }

    .tbl-row h1 { 
        color: #696969; 
        font-weight:400;
        font-size: 14px; 
    }

    .empty { 
        display: flex; 
        justify-content: center;
        align-items: center;
        color: lightgray; 
    }

    .empty span { 
        color: rgb(40, 40,40);
    }
    .table button {
        background-color: maroon;
        color: white;
        padding: 0 2.3rem;
        border-radius: 25px; 
        transition: 300ms; 
        font-size: 15px;

    }

    .table button:hover { 
        background-color: #A84655;
    }

    .tbl-col { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        align-items: center;
        padding-left: 1rem;
    }
    .stripe { 
       background-color: #f7f7f7;
    }


    .tbl-header .tbl-col h1 { 
        color: white;
        font-size: 13px; 
        font-weight: 500;
        
    }
    /* should be changed based on the sizing of the table */
    .tbl-header, .main-dep .tbl-header, .main-dep .tbl-row { 
        grid-template-columns: 25% 60% 15%
    }

    .tbl-header { 
        grid-template-columns: 25% 60% 15%
    }

    .col-acts { 
       display: flex; 
       
    }

 

    .col-acts button { 
        color: white; 
        padding: 0.1rem 1rem; 
        border-radius: 10px;
        text-align: center;
        margin: 0 0.3rem;
        transition: 300ms; 
    }


    #edit {
        background-color: green; 
    }
    #edit:hover { 
        background-color: #32CD32;
    }

    #delete { 
        
        background-color: red;
    }
    
    #delete:hover { 
        background-color:#FF6347;
    }


    /*** set height of your table here | call the unique class name so that it won't affect other table*/
    .main-dep { 
        height: 350px; 
        overflow-y: auto;
        
    }


    .actions { 
        width: 95%; 
        height: 50px; 
        display: flex; 
    

    }

    
    .act-slot { 
        width: 35%; 
        height: 100%; 
        display: flex; 
        align-items: center;
        padding-right: 0.5rem;
        
    }

    .act-slot form { 
        width: 100%; 
        height: 100%; 
        display: flex ;
        align-items: center;

    }
    /* .act-slot button { 
        width: 100%; 
        height: 70%; 
        background-color: maroon;
        display: grid; 
        grid-template-columns: 20% 80%;
        border-radius: 10px; 
        transition: 300ms; 
    } */

    .act-btn { 
        width: 100%; 
        height: 70%; 
        background-color: maroon;
        display: grid; 
        grid-template-columns: 20% 80%;
        border-radius: 10px; 
        transition: 300ms; 
    }

    .act-btn:hover { 
        background-color: #A52A2A;
    }


   
    .act-btn-icon, .act-btn-text { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        
        align-items: center;
    }


    .act-btn-icon img { 
        width: 30px ; 
        height: 30px; 
    }
    .act-btn-icon{ 
        justify-content: end;
    }

    .act-btn-text {
        padding-left:0.5rem; 
        color: white;
    }

    #msg  { 
        
    color: green;
        font-weight: 500
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
        width: 10%; 
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
        padding: 0.5rem 1rem 0.5rem 2rem;
        display: flex; 
        justify-content: end;
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




setTimeout(function() {
            
            document.querySelector('.dep-msg').innerHTML = '';
        }, 5000); // Hide after 5 seconds


    // for confirmation 
    function confirmClearDependencies() {
        if (confirm('Are you sure you want to clear the dependencies?')) {
            document.getElementById('clear-dependencies-form').submit();
        }
    }


    function deleteDependency(button)  {
        const form = button.closest('form');
        if(confirm('Are you sure you want to cancel this request?')) { 
           form.submit()
        }

    }
      
   
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchResults = document.querySelector('.search-results');
    let debounceTimeout;

    function fetchSearchResults(query) {
        if (query === '') {
            searchResults.innerHTML = ''; // Clear results if the input is empty
            return;
        }

        fetch(`{{ route('admin.subjects.search2') }}?query=${encodeURIComponent(query)}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            searchResults.innerHTML = ''; // Clear previous results

            if (data.length > 0) {
                data.forEach(post => {
                    const resultItem = document.createElement('div');

                    // Construct URL with dynamic ID
                    const viewUrl = `{{ route('admin.subjects.view', ['id' => '']) }}/${post.subj_code}`;

                    resultItem.innerHTML = `
                        <form class='res-item' action="{{route('admin.subjects.view')}}" method="GET">
                            <input type="hidden" name="id" value="${post.subj_code}" />
                            <button class="details" type="submit">
                                <h1>${post.subj_code} - ${post.subj_title}</h1>
                                <h3>${post.subj_description}</h3>
                                <span>Units: ${post.units}.00</span>
                            </button>
                        </form>
                    `;
                    searchResults.appendChild(resultItem);
                });
            } else {
                searchResults.innerHTML = '<div style="padding: 0.5rem 1rem"><span>No results found</span></div>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

    function debounce(func, delay) {
        return function(...args) {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    searchInput.addEventListener('keyup', debounce(function() {
        const query = searchInput.value;
        fetchSearchResults(query);
    }, 500)); // 
});



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

document.addEventListener("click", function(event) { 
    if(event.target.classList.contains('subj_id')){ 
        navigator.clipboard.writeText(event.target.innerHTML);
        document.getElementById("cb_msg").innerHTML = "Subject ID successfully copied to clipboard!";  
    }

    if(event.target.classList.contains('subj_code')) { 
        console.log(event.target.innerHTML);
        navigator.clipboard.writeText(event.target.innerHTML) ;
        document.getElementById("cb_msg").innerHTML = "Subject Code successfully copied to clipboard!"
    }
})
</script> 