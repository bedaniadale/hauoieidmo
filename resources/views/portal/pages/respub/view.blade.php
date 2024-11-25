@php

$author = $user-> emp_fname . ' ' . $user-> emp_mname . ' ' . $user-> emp_lname; 


@endphp

<x-app-layout>
    <div class="container">

    <div class="box-card">
        
            
            <div class="cancel">
                <a href = "{{route('portal.respub')}}"> 
                    
                            <img src = "{{asset('images/icons/back.png')}}"> 

                            <h1> Return  </h1>
                    
                </a> 

                <a href = "{{route('portal.respub.edit',['id'=> $data->id])}}"> 
                    
                    <img src = "{{asset('images/icons/edit.png')}}"> 

                    <h1> Edit Details </h1> 
                
                </a> 

                @if($data->status == 'To-review')
                <a href = "{{route('portal.respub.resubmit',['id'=> $data->id])}}"> 
                    
                    <img src = "{{asset('images/icons/resubmit.png')}}"> 

                    <h1> Resubmit </h1>
                
                </a> 
                @endif



               
                <span>To update your file attachments, please submit a new request. Changes to attachments are not supported for existing requests. </span>
            </div>

           
      

        <div class="box-title">
            <h1> {{$data->title }} </h1> 
        </div>

        <div class="box-body">
                <div class="box-row">
                    <span>Type</span>
                    <h1>{{$data->type}}</h1>
                </div>
                <div class="box-row">
                    <span>Description</span>
                    <h1>{{$data->description}}</h1>
                </div>

                


                <div class="form-row grid">
                <div class="form-col">
                        <span> Author </span>     
                        <!-- <input type = "text" name = "author" value = "{{$author}}"disabled>  -->
                         <h1> {{$author}}</h1> 
                    </div>
                    <div class="form-col">
                        <span> Date Published </span>     
                        <!-- <input type = "text" name = "date_published" value = "{{$data->date_published}}" disabled>  -->
                        <h1> {{$data->date_published }} </h1> 
                    </div>
                    <div class="form-col">
                    <span> Attachment </span>     
                    <div class="file-attachment">
                        <img src = "{{asset('images/icons/attachment.png')}}"/> 
                        <a href = "{{asset('storage/' . $data->file_path )}}"> {{$data -> attachment}}</a>
                    </div>
                    </div>
                </div>

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
        
        padding: 2rem 0 2rem 0;
         width: 90%; 
         margin: 2rem 0;
         
         border-radius: 10px;
         background-color: white; 
         display: flex; 
         flex-direction: column;
    }

    .box-title {
        
        width: 100%; 
        line-height: 1.7rem;
        display: flex;
        padding: 1rem 2rem; 
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
        padding-left: 1.5rem;
        align-items: center;
    }

    .cancel a { 
        background-color: maroon;
        color: white; 
        display: flex; 
        justify-content: center;
        align-items: center;
        margin: 0 0.5rem;
        padding: 0.3rem 2rem;
        border-radius: 25px; 
        transition:300ms; 

    }

    .cancel span { 
        font-size: 0.7rem; 
        color: gray; 
        margin-left: 1rem; 
    
        width: 30%; 
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


    
    .box-title h1 { 
        font-size:1.7rem;
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

    

    
    .box-body hr { 
        opacity: 0.8
    }
    
    .box-body { 
        width: 100%; 
        display: flex; 
        flex-direction: column;
        padding: 0 2rem;
    }

    .box-row { 
        display: flex; 
        width: 100%; 
        flex-direction: column;
        line-height: 1.5rem;
        margin-bottom: 1rem;
    }

    .box-row span { 
        color: rgb(150,150,150); 
        font-size: 0.7rem;
    }

    .box-row h1,.form-col h1 { 
        font-size: 1rem ; 
        font-weight: 700;
        color:rgb(40,40,40)
    }


    


  
    .grid { 
        display: grid; 
        
        grid-template-columns: 20%  20% 50%;
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

    .file-attachment { 
        display: flex; 
        
        align-items: center;
        margin-top: -0.7rem;

    }

    .file-attachment { 
        overflow: hidden;
    }
    .file-attachment img { 
        width: 20px; 
        height: 20px; 
        margin-right: 0.3rem;
    }


    .file-attachment a { 
        color: darkblue;
        text-decoration: underline;
    }

    .file-attachment a:hover { 
        color: blue; 

    }


    





    
</style> 