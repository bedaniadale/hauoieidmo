@php
$count = 1; 



@endphp



<x-app-layout>
    <div class="container">

       
        <div class="con-box">

            <div class="box-title">
                <a href = "{{route('admin.subjects')}}"> 
                    <img src = "{{asset('images/icons/back.png')}}"/>
                    <h3> View all Subjects</h3>
                </a> 
            </div>


    
            
            <div class='box-title'>
                <span> Subject Code</span>
                <div class="w-full flex flex-col">
                    <h1 class = "font-bold text-lg"> {{$subj->subj_code}}</h1>
                    <h1 class="hidden" id = "subj_code">{{$subj->subj_code}} </h1> 
                    <button type ="button" id = "clipboard" class="font-bold text-red-900 text-sm w-[15%] text-left"> Copy to Clipboard</button>
                    <span id = "clipboard_msg" class = "hidden"> Subject code was copied to the clipboard. </span>  
                </div>
            </div>



            <div class='box-title'>
                <span> Subject</span>
                <h1> {{$subj->subj_title}}</h1>
            </div>

           
            <div class='box-title'>
                <span> No. of Units</span>
                <h3> {{$subj->units}}.00</h3>
            </div>

            <div class="w-full flex items-center px-8 py-4 gap-2">
                <form action="" class="w-[20%]">
                    <button class="w-full flex items-center justify-center bg-red-900 hover:bg-red-700 text-white rounded-lg py-2">
                        <img src="{{asset('images/icons/delete.png')}}" class="w-[25px] h-[25px] mx-2" alt="">
                        <span class="text-lg">Delete Subject</span>
                    </button>
                </form>

                <a class="w-1/6 flex items-center justify-center bg-red-900 hover:bg-red-700 text-white rounded-lg py-2">
                    <img src="{{asset('images/icons/edit.png')}}" class="w-[25px] h-[25px] mx-2" alt="">
                    <span class="text-lg">Edit Subject</span>
                </a>

                <a href="{{route('admin.subjects.load', ['id'=> $subj->subj_id])}}" class="w-1/6 flex items-center justify-center bg-red-900 hover:bg-red-700 text-white rounded-lg py-2">
                    <img src="{{asset('images/icons/link.png')}}" class="w-[25px] h-[25px] mx-2" alt="">
                    <span class="text-lg">Add to user</span>
                </a>

            </div>


        

        
    </div>
</div> 
</x-app-layout>


<style> 

a,button { 
    cursor: pointer;
    transition :300ms;
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
     
        flex-direction: column;
    
        padding: 0rem 2rem; 

                position: relative;

      
    }

    .search-results { 
        /* box-shadow: 0px 0px 2px 0px; */
        /* border: 1px solid rgb(190,190,190);  */
        position: absolute;
        width: 50%; 
    
        
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

    .search-header  input[type=text]{
        width: 40%;

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
        grid-template-columns: 10% 20% 25% 35% 10%
    }

    .tbl-header { 
        grid-template-columns: 10% 20% 25% 35% 10%
    }

    .col-acts { 
       display: flex; 
       
    }

 
    .box-title {
        
        width: 100%; 
        line-height: 1.3rem;
        display: flex;
        flex-direction: column;
        padding: 0.5rem 2rem;
        
        
    }


    .box-title span { 
        font-size: 0.8rem; 
        color: gray; 
    }

    .box-title a { 
        padding: 0;
        width: 25%;
        display: flex; 
        padding: 0.5rem 0rem;
        color: white;
        justify-content: center;
        align-items: center;
        background-color: maroon;
        transition: 300ms;
    }

    .box-title a img { 
        width: 20px; 
        height: 20px;
        
    }

    .box-title a:hover { 
        background-color: #A52A2A;
    }

    .box-title a h3 { 
        text-transform: uppercase;
        margin-left: 0.2rem
    }

    .box-title h1 { 
        font-weight: 700;
        font-size: 1.7rem;
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

    .actions  { 
        width: 100%; 

        padding: 1rem 2rem;
        display: flex; 
    }

    .actions  a  { 
        background-color: maroon;
        display: flex; 
        justify-content: center;
        align-items: center;
        padding: 1rem 3rem;
        color: white;
        border-radius: 15px;
        transition: 300ms;
        margin-right: 0.3rem;
    }

    .actions a img { 
        width: 20px; 
        height: 20px;
        margin-right: 0.5rem;

    }

    .actions a:hover { 
        background-color: #A52A2A;
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


document.querySelector("#clipboard").addEventListener("click",()=> { 

    navigator.clipboard.writeText(document.querySelector("#subj_code").innerHTML)
    document.querySelector("#clipboard").classList.add("hidden");
    document.querySelector("#clipboard_msg").classList.remove("hidden");
    
    
    
})
      
    
   


</script> 