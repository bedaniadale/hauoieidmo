<x-app-layout>

<div class="container">

    <div class="add-box py-4">
        <div class="ab-left">
            <section class="back">
                <a href="{{route('portal.training.view', ['id'=> $data->id])}}" class="w-2/3 py-1 px-4  rounded-xl flex items-center justify-center bg-red-900 text-white gap-1 hover:bg-red-800">
                    
                        <img src= "{{asset('images/icons/cancel.png')}}" class="w-[20px] h-[20px]"> 
                
                        <h1>Cancel Edit </h1> 
                </a>
            </section>
            <section class="reminder">
                <h1> Edit Training</h1> 
                <h3> Kindly double check the information before saving.</h3>
            </section>
            <section class="logo">
                <img src = "{{asset('images/hau-logo.png')}}"/> 
            </section>
        </div>
        <div class="flex flex-col ab-right b-8">

            <section class="form-title">
                <h1> Training Details </h1> 
            </section>

            <section class="form-body">
                <form action = "{{route('portal.training.update',['id'=> $data->id])}}" method = "POST"  enctype="multipart/form-data"> 
                    @csrf
                    @method('PUT')

                    <div class="form-row row1">
                        <span> Training Title </span>
                        <input type="text" name = "title" value = "{{$data-> title}}"/> 
                    </div>

                    <div class="form-row row1">
                        <span> Training Type </span>
                        <select name="type" class="border-gray-400">
                            @foreach($training_types as $item)
                            <option value="{{$item->item}}" 
                                {{ $item ->item == $data->type ? 'selected' : '' }}>
                                {{$item->item}}
                        </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row row1">
                        <span> Training Provider </span>
                        <input type="text" name = "organization" value = "{{$data->organization}}"/> 
                    </div>


                    <div class="form-row row2">
                        <div class="form-col">
                            <span> Date of Start </span>   
                            <input type="date" name = "start_date" value = "{{$data->start_date}}" />
                        </div> 

                        <div class="form-col">
                            <span> Date of Completion </span>   
                            <input type="date" name = "end_date" value = "{{$data->end_date}}"/>
                        </div>

                        <div class="form-col">
                            <span> Total Hours </span>   
                            <input type="text" name = "hours" value = "{{$data->hours}}" />
                        </div>
                    </div>

                    <div class="w-full flex flex-col mb-2">
                            <span> Skills Acquired</span>   
                            <input type="text" name = "skills" value = "{{$data->skills}}"/>
                        


                    </div>

                    <div class="flex">



                    <div class="w-2/3 flex flex-col leading-tight">
                        <span class=" text-gray-400">Attachment</span>


                        <div class="flex-col">
                            <div class="w-full flex items-center my-2" id="attachment">
                                <img src="{{asset('images/icons/attachment.png')}}" alt="" class="w-[20px] h-[20px]">
                                <h1 class="truncate font-semibold text-gray-600"> {{$data->attachment}} </h1>
                                <button type='button' class="bg-gray-900 hover:bg-gray-800 text-white flex items-center px-8 py-1 ml-2 rounded-lg" id = "edit_att"> 
                                    <img src="{{asset('images/icons/upload.png')}}" alt="" class="w-[20px] h-[20px]">
                                    <span>Change File</span>
                                </button>
                            </div>

                        

                        </div>

                        <div class="w-full flex  gap-2 hide" id="attachment_edit">
                            <button type = 'button' class=" bg-gray-900 hover:bg-gray-800 text-white flex items-center justify-center px-8 py-1 ml-2 rounded-lg" id = "cancel"> 
                                    <img src="{{asset('images/icons/cancel.png')}}" alt="" class="w-[20px] h-[20px]">
                                    <span>Cancel</span>
                            </button>
                            <input type="file" id = "fileinput" name = "attachment" class="text-gray-700 truncate">

                        </div>
                    </div>


                    <div class="flex items-end justify-end w-1/3">
                        <button class="px-4 py-1 bg-red-900 text-white rounded-lg hover:bg-red-700">Save Changes</button>
                    </div>


                    </div>


                


                    

                   
                

                </form> 
            </section>




        </div>
    </div>

</div>


</x-app-layout>

<style> 

a, button { 
    transition: 300ms;
}

    .container { 
        width: 100%; 
        display: flex; 
        justify-content: center;
        padding-top: 3rem; 
    }

    .add-box { 
        width: 85%; 
    
        border-radius: 15px;  
        background-color: white;
        display: grid; 
        grid-template-columns: 40% 60%;
    }

    .ab-left, .ab-right  {
        width: 100%; 
        height: 100%;
        /* border: 1px solid red; */
    }

    .ab-left { 
        display: grid; 
        grid-template-rows: 10% 15% 75%;
    }

    .ab-left section { 
        width: 100%; 
        height: 100%; 
    }

    .back { 
        display: flex; 
        justify-content: center;
        align-items:end;
    }
    
    .back-btn { 
        display:grid; 
        grid-template-columns: 25% 75%;
        background-color: maroon;
        color: white; 
        width: 70%; 
        height: 60%;
        border-radius: 25px; 
        transition: 300ms;
    }

    .back-btn:hover { 
        background-color: #A84655;
    }


    .btn-icon, .btn-text { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        align-items: center;
    }

    .btn-text { 
        padding-left: 0.7rem;
    }
    .btn-icon { 
        justify-content: end;
    }

    .btn-icon img  { 
        width: 15px; 
        height: 15px; 
    }

   

    .reminder { 
        /* border: 1px solid red; */
        display: flex; 
        flex-direction: column;
        align-items: center;
        /* justify-content: center; */
        text-align: center;
        line-height: 1.5rem;
        padding-top: 1rem;
    }

    .reminder h1 { 
        font-size: 1.5rem;
        font-weight: bold;
    }
    .reminder h3 { 
        font-size: 0.8rem;
        /* line-height: 0.8rem; */
    }

    .logo { 
        display: flex; 
        justify-content: center; 
        
    }

    .logo img { 
        width: 300px; 
        height: 300px;
    }



    .ab-right section { 
        width: 100%; 
        height: 100%;
    }

    .form-title { 
        display: flex; 
        align-items: end;
    }

    .form-title h1 { 
        font-size: 1.7rem; 
        font-weight: 900;
        color: rgb(0,0,0,0.7)
    }

    .form-body form { 
        display: flex; 
        flex-direction: column;
        justify-content: center;
        padding: 2rem 1rem 0 0; 
        
        
    }

    .form-row { 
        width: 100%;
        height: 100%; 
        display: flex; 
        flex-direction: column;
        margin-bottom: 0.7rem ; 
        
    }
    
    .form-col { 
        width: 100%; 
        height: 100%; 
        
       
    }

    .lastrow div:first-child input[type=file]{
        width: 100%;  
    
     

    }
    .row1 input[type=text]{ 
        width: 100%;
    }

    .row2 input[type=text]{ 
        width: 100%;
    }

    .row2 input[type=date] { 
        width: 95%;
    }

    .lastrow { 
        display:grid; 
        grid-template-columns: 70% 30%;
    
    }






    .row2 { 
        display: grid; 
        grid-template-columns: 40% 40% 20% 
    }

    .row3 { 
        display: grid; 
        grid-template-columns: 50% 50%;
    }

    

    .ab-right input[type=text], .ab-right input[type=date] { 
       
        border: 1px solid rgb(0,0,0,0.2); 
        border-radius: 10px; 

    }

    .ab-right input[type=text]:active { 
        border: none;
    }
    
    .form-row-submit {
        width: 100%; 
        height: 100%; 
        display: flex; 
        align-items: center;
        justify-content: end;
       
    }

    .btn-submit {
        background-color: maroon;
        color: white; 
        padding: 0.6rem 3rem;
        border-radius: 15px; 
        transition :300ms;
    }

    .btn-submit:hover { 
        background-color: #A84655;
    }

    

</style> 

<script>
    
let attachment = document.getElementById('attachment'); 
let attachment_edit = document.getElementById('attachment_edit') 

let attachment_btn = document.getElementById('edit_att') 
let cancel_btn = document.getElementById('cancel')
 
attachment_btn.addEventListener("click",()=> { 

        attachment_edit.classList.remove('hide'); 

        attachment.classList.add('hide'); 


})

cancel_btn.addEventListener('click' ,()=> { 
    attachment_edit.classList.add('hide'); 

    //clear the file input value
    const fileinput = document.getElementById('fileinput')
    fileinput.value ='',



    attachment.classList.remove('hide'); 
})




</script>