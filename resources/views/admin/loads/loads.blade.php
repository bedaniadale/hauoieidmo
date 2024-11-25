@php
$count = 1; 



@endphp



<x-app-layout>
    <div class="container">
        <div class="con-box">

            <section class='search-header'>
                
                <form action = "{{route('admin.loads.user')}}" method = "GET" >
                    @csrf
                    @method('GET')
                    <h1 class="text-[1.6rem] font-bold"> Add New Load </h1>

                    <span> First, load the user details, then select the subject you want to add. Once both are loaded, submit the form to complete the process. </span>
                    <br> 
                    <div class="formrow">

                        <input id = "search" type = "text" name = "id" placeholder = "Enter Employee ID...">
                        
                        
                        <button type = "submit" > Load User </button> 

                        <div class="search-results"> 
                            
                        
                        </div>

                    </div>
                    
                    @if(isset($msg)) 
                             <span class="text-gray-500 text-sm">
                             {{$msg}}
                             </span>
                        @endif

                  
                </form> 

            </section>

            @if(!isset($userinfo)) 
                <div class="w-full h-[200px]"></div>
            @endif

        
            @if(isset($userinfo)) 
            <section class="userinfo">
                <h1> {{$userinfo -> emp_id}} </h1>
                <h1 class = 'name'>{{$userinfo->emp_lname . ', ' . $userinfo->emp_fname . ' ' . $userinfo -> emp_mname}} </h1>
                <span> {{$userinfo-> email_address_1}}</span> 

                <hr> 

                <h3 class = 'font-semibold text-lg'>  Number of Teaching Loads: {{$loads-> count()}}</h3> 
        

            </section>





            <div class="tbl-header" style = "text-transform: uppercase">


                    <div class="tbl-col"><h1>SUBJ_CODE </h1></div>
                    <div class="tbl-col"> <h1> SUBJ__TITLE </h1></div>
                   
                    <div class="tbl-col"> <h1> UNITS </h1></div>
              
                   
                </div>
            <section class="table-section">
                
                

                <div class="table main-dep">
                   
                    @if($loads->count()==0) 
                        <div class = "tbl-row empty"> 
                            <h1> No teaching loads.</h1>
                        </div>
                    @else
                        @foreach($loads as $item) 
                            @if($count % 2 == 0) 
                                <div class = 'tbl-row stripe'> 
                                    <div class = 'tbl-col'><h1> {{$item->subject->subj_code}} </h1>  </div> 
                                    <div class = 'tbl-col'><h1> {{$item->subject->subj_title}} </h1>  </div> 
                                    <div class = 'tbl-col'><h1> {{$item->subject-> units}}.00</h1> </div> 
                                    
        
                                </div> 
                            @else 
                                <div class = 'tbl-row'> 
                                    <div class = 'tbl-col'><h1> {{$item->subject->subj_code}} </h1>  </div> 
                                    <div class = 'tbl-col'><h1> {{$item->subject->subj_title}} </h1>  </div> 
                                    <div class = 'tbl-col'><h1> {{$item->subject-> units}}.00</h1> </div> 
                                  
                                   
                           
                                   
                                </div> 
                            @endif
                            

                            @php $count++; @endphp 
                        
                        @endforeach
                    @endif
            

                    
                 
                </div>

            </section>

            <div class="confirm">
                <form action="{{route('admin.loads.add')}}" method = "GET">
                    <input type = "text" name = "id" value = "{{$userinfo->emp_id}}" hidden/> 
                    <button type = "submit" > SELECT USER </button>

                </form>
            </div>



            
            @endif

         
            



        </div>

        
    </div>
</x-app-layout>


<style> 

    .container { 
        width: 100% ;
        display: flex; 
        justify-content: center;
        padding: 2rem 0 ;
      
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
        align-items: center;
        justify-content: center;
    
        padding: 1rem 0 ; 
    }

    .search-header form { 
        display: flex;
        flex-direction: column;
        
        padding: 0 2rem;
        width: 100%; 
        height: 100%;

    }

    .search-header form span { 
        font-size: 0.8rem; 
        color: gray; 
    }

    .search-header form input[type=text]{
        width: 40%;
    
    
    }

    .formrow button{ 
        background-color: maroon;
        color: white; 
        height: 100%; 
        padding: 0 1rem;
        transition: 300ms;
    }

    .formrow button:hover { 
        background-color: #A84655;
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
        height: 250px;
       
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
        margin-top: 1rem;

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
        padding: 0 0.5rem;
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
        height: 250px; 
        overflow-y: auto;
        
    }


    .actions { 
        width: 95%; 
        height: 250px; 
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
   

    #msg  { 
        
    color: green;
        font-weight: 500
    }


    .formrow { 
        position: relative;
        display: flex; 
        
        align-items: center;
        width: 100%;
    }


   
    
    .search-results { 
        /* box-shadow: 0px 0px 2px 0px; */
        /* border: 1px solid rgb(190,190,190);  */
        position: absolute;
        width: 40%; 

        overflow-y: auto;
    
        
        background-color: beige;
        top: 100%;
        left: 0%;
        display: flex;

        flex-direction: column;
        max-height: 220px; /* Set a maximum height */
        
      
    
    }

    .search-results button { 
        display: flex;
        text-align: left;
        width: 100%; 
        
        
        padding:0.5rem 1rem;
        line-height: 1rem;
        transition: 300ms; 
        border: 1px solid lightgray;
        

    }

    .search-results button:hover { 
        background-color: maroon;
    }


    .search-results h1 {
        font-size: 1rem; 
        font-weight: 700; 
        font-style:italic;
    }

    .search-results h3  { 
        font-size: 0.8rem;
        font-weight: 500;

        
    }


    .userinfo { 
        width: 100%; 
        padding: 0 2rem;

        display: flex; 
        flex-direction: column;
        line-height: 1.2rem;
    }

    .userinfo hr { 
        margin: 1rem 0;
    }

    .userinfo h1:first-child { 
        font-size: 1rem;
        font-weight: 700;
    }

    .userinfo .name {

        font-size: 1.3rem; 
        font-weight: 900;
    }  


    .userinfo span { 
        color: gray; 
    }
    
    .confirm { 
        width: 100%; 
        display: flex; 
        justify-content: end;
        padding: 1rem 2rem;
    }

    .confirm form { 
        width: 20%; 
       
    }

    .confirm form button { 
        border-radius: 15px; 
        padding: 0.5rem 0;
        background-color: maroon;
        color: white;
        width: 100%;
        transition: 300ms; 
    }

    .confirm form button:hover { 
        background-color: #A84655;
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

    function debounce(func, delay) {
        return function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(func, delay);
        };
    }

    function performSearch() {
        const query = searchInput.value;

        if (query === '') {
            searchResults.innerHTML = ''; // Clear results if the input is empty
            return;
        }

        fetch(`{{ route('admin.pendings.search2') }}?query=${encodeURIComponent(query)}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            searchResults.innerHTML = ''; // Clear previous results

            if (data.length > 0) {
                data.forEach(post => {
                    const resultItem = document.createElement('div');

                    resultItem.innerHTML = `
                        <button type="button" class="sr-item" style="background-color: beige; color: black;">
                            <div class="details">
                                <h1>${post.emp_lname}, ${post.emp_fname} ${post.emp_mname}</h1>
                                <h3>${post.emp_id}</h3>
                                <span>${post.email_address_1}</span>
                            </div>
                        </button>
                    `;
                    searchResults.appendChild(resultItem);

                    // Add the event listener to the dynamically created button
                    const button = resultItem.querySelector('.sr-item');
                    button.addEventListener('click', () => {
                        const h3Element = button.querySelector('.details h3');
                        const h3Content = h3Element.innerHTML;
                        searchInput.value = h3Content; // Set the input value to the h3 content
                        searchResults.innerHTML = '';
                    });
                });
            } else {
                searchResults.innerHTML = '<div style="padding: 0.5rem 1rem"><span>No results found</span></div>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

    searchInput.addEventListener('keyup', debounce(performSearch, 300)); // Adjust the delay as needed
});





</script> 