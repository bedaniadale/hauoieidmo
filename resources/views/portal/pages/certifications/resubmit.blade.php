<x-app-layout>

<div class="container">

    <div class="add-box">
        <div class="ab-left">
            <section class="back">
                <a href="{{route('portal.certifications.view',['id'=>$data->id])}}" class="back-btn">
                   
                        <img src= "{{asset('images/icons/back.png')}}"> 
                   
                     <h1>Cancel  </h1> 
                </a>
            </section>
            <section class="reminder">
                <h1> Resubmit Application</h1> 
                <h3> Kindly double check the information before submitting.</h3>
            </section>
            <section class="logo">
                <img src = "{{asset('images/hau-logo.png')}}"/> 
            </section>
        </div>
        <div class="ab-right">

            <section class="form-title">
                <h1> Certification Details </h1> 
            </section>

            <section class="form-body">
                <form action = "{{route('portal.certifications.resub',['id'=> $data-> id])}}" method = "POST"  enctype="multipart/form-data"> 
                    @csrf
                    @method('POST')

                    <div class="form-row row1">
                        <span> Certification Title </span>
                        <input type="text" name = "cert_title" value = "{{$data->cert_title}}" /> 
                    </div>

                    <div class="form-row row2">
                        <div class="form-col">
                            <span> Date Issued </span>   
                            <input type="date" name = "date_issued" value = "{{$data ->date_issued}}"/>
                        </div> 

                        <div class="form-col">
                            <span> Validity </span>   
                            <input type="date" name = "cert_validity" value =  "{{$data-> cert_validity}}"/>
                        </div>

                        <div class="form-col">
                            <span> Duration </span>   
                            <input type="text" name = "duration" value = "{{$data->duration}}"/>
                        </div>
                    </div>

                    <div class="form-row row3">
                        <div class="form-col">
                            <span> Certification Type </span>   
                            <input type="text" name = "cert_type" value = "{{$data-> cert_type}}" style = "width: 95%"/>
                        </div>

                        <div class="form-col">
                            <span> Role </span>   
                            <input type="text" name = "role" value = "{{$data-> role}}"  style = "width: 100%"/>
                        </div>

                    </div>

                    <div class="form-row lastrow">
                        <div class="form-col">
                            <span > Certificate </span>
                            <input type="file" name = "attachment" required/> 
                        </div>

                        <div class = "form-col form-row-submit">
                        <button type = "submit" class = "btn-submit"> Submit </button>
                        </div>
                    </div>

                   
                

                </form> 
            </section>




        </div>
    </div>

</div>


</x-app-layout>

<style> 

    .container { 
        width: 100%; 
        display: flex; 
        justify-content: center;
        padding-top: 3rem; 
    }

    .add-box { 
        width: 85%; 
        height: 470px;
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
        display: flex; 
        justify-content: center;
        align-items: center;
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


    .back-btn img  { 
        width: 13px; 
        height: 13px; 
        margin-left: -2rem;
        margin-right: 1rem; 
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

    .lastrow div:first-child input[type=file]{
        width: 100%;  
    
     

    }
    

    .logo img { 
        width: 300px; 
        height: 300px;
    }


    .ab-right { 
        display:grid; 
        grid-template-rows: 15% 75%;
        padding-left: 2rem;
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