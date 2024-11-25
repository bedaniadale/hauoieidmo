@php
$author = $user-> emp_fname . ' ' . $user-> emp_mname . ' ' . $user-> emp_lname; 
@endphp

<x-app-layout>
    <div class="container">

    <div class="box-card">
        <div class="box-title">
            <div class="left">
                <div class="cancel">
                    <a href = "{{route('portal.respub.view',['id'=> $data-> id])}}"> 
                        
                             <img src = "{{asset('images/icons/back.png')}}"> 

                             <h1> Cancel  </h1>
                      
                    </a> 
                </div>
                <div class="rtitle">
                    <h1> Research and Publications - Re-submit form</h1> 
                </div>
            </div>

            <div class="right">
                <div class="logo"><img src = "{{asset('images/hau-logo.png')}}"/> </div>
            </div>
        </div>

        <div class="box-body">
            <form action = "{{route('portal.respub.resub',['id'=> $data->id])}}" method = "POST" enctype="multipart/form-data">
                @csrf 
                @method('POST') 
                <input type = "text" name = "type" value = "Research" hidden/> 
                <div class="form-row">
                    <div class="form-col">
                        <span> Title </span>
                        <input type = "text" name = "title" value = "{{$data-> title}}">  
                    </div>
                </div>

                <div class="form-row desc">
                    <div class="form-col">
                    <span> Description </span>     
                    <textarea class="form-control" id="description" name="description"  rows="4">{{$data-> description}}</textarea>

                    </div>
                </div>

                <div class="form-row grid">
                <div class="form-col">
                        <span> Author </span>     
                        <input type = "text" name = "author" value = "{{$author}}" disabled> 
                    </div>
                    <div class="form-col">
                        <span> Date Published </span>     
                        <input type = "date" name = "date_published" value = "{{$data-> date_published}}"> 
                    </div>
                    <div class="form-col">
                    <span> Attachment </span>     
                    <input type = "file" name = "attachment" required> 
                    </div>
                </div>


                <div class="form-row submit" style = "height: 80px">
                    <div class="submit-box">
                        <button type = "submit" >Resubmit</button>
                    </div>
                </div>
            </form> 
            
            
        </div>
</div> 

</div> 
</div> 
</x-app-layout>

<style> 
    .container { 
        width: 100%;
        display: flex ;
        justify-content: center;
    }

    .box-card { 
         width: 90%; 
         margin: 2rem 0;
         border-radius: 10px;
         background-color: white; 
         display: flex; 
         flex-direction: column;
    }

    .box-title { 
        width: 100%; 
        height: 120px; 
        
        display: grid; 
        grid-template-columns: 80% 20%;
    }

    .left, .right { 
        width: 100%; 
        height: 100%; 
    }


    .left { 
        display: grid; 
        grid-template-rows: 50% 50%;
    }

    .left div { 
        width: 100%; 
        height: 100%; 
    }


    .cancel { 
        display: flex; 
        padding-left: 2rem;
        align-items: center;
    }

    .cancel a { 
        background-color: maroon;
        color: white; 
        display: flex; 
        justify-content: center;
        align-items: center;
        padding: 0.3rem 2rem;
        border-radius: 25px; 
        transition:300ms; 

    }

    .cancel a:hover {
        background-color: #A84655;
    }

    .cancel a img { 
        width: 15px; 
        height: 15px;
        margin: 0 0.5rem;
    }

    .cancel a h1 { 
        padding-right: 1rem;
    }

    .rtitle { 
        display: flex; 
       
        padding-left: 2rem;
    }

    .rtitle h1 { 
        font-size:2rem;
        font-weight: 900;
        color: rgb(90,90,90)
    }
    .right {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .right img {
        width: 90px; 
        height: 90px; 
    }

    .box-body { 
        width: 100%; 
        height: 380px;

        display: flex; 
        justify-content: center;
    
    }


    .box-body form { 
        width: 95%; 
        height: 100%;
        display: flex; 
        flex-direction: column;
    }

    .form-row { 
       
        width: 100%; 
    }

    .form-col { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        flex-direction: column;
    }

    .form-col input[type=text] { 
        width: 100%;
        border-radius: 5px; 
        border: 1px solid rgb(0,0,0,0.2) 
    }

    .form-col span { 
        font-weight: 500;
         
    }

    .desc textarea { 
        height: 90%;
      
        border: 1px solid rgb(0,0,0,0.2) 
    }

    .grid { 
        display: grid; 
        grid-template-columns: 40%  35% 25%;
    }

    .grid input[type=text] { 
        width: 95%;
    }

    

    .grid input[type=date] { 
        width: 90%;
    }

  
    .form-col { 
        padding: 0.5rem 0;
    }
    .grid div { 
      
        width: 100%; 
        height: 100%; 
    }


    .submit-box { 
        float: right; 
        width: 30%;
        height: 100%;
        
        display: flex; 
        justify-content: end;
       
    }

    .submit-box button { 
        width: 70%;
        height: 60%;
        padding: 0.3rem 3rem; 
        background-color: maroon;
        color: white; 
        border-radius: 10px;
        transition: 300ms;
    }

    .submit-box button:hover { 
        background-color: #A84655;
    }

    





    
</style> 