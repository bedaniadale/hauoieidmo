<x-app-layout>

<div class="container">

    <div class="add-box">
        <div class="ab-left">
            <section class="back">
                <a href="{{route('portal.dependencies')}}" class="back-btn">
                    <div class="btn-icon">
                        <img src= "{{asset('images/icons/back.png')}}"> 
                    </div>
                    <div class="btn-text"> <h1>Back to Manage </h1> </div>
                </a>
            </section>
           
            <section class="logo">
                <img src = "{{asset('images/hau-logo.png')}}"/> 
            </section>
        </div>
        <div class="ab-right">

            <section class="form-title">
                <h1> Dependent Details </h1> 
              

                    <div class="form-edit">
                    <a href = "{{route('portal.dependencies.edit', ['id'=>$viewdata->id])}}"> 
                        <img src = "{{asset('images/icons/edit.png') }}"> 
                        <span> Edit</span>
                    </a> 
                    </div>
              
            </section>
            
            <section class="form-body">
                
            
                 

                    <div class="form-row">
                        <span> First Name </span>
                        <h1> {{$viewdata -> fname}}</h1>  
                    </div>

                    <div class="form-row">
                        <span> Middle Name </span>   
                        <h1> {{$viewdata -> mname}}  </h1> 
                    </div>

                    <div class="form-row">
                        <span> Last Name </span>
                        <h1> {{$viewdata-> lname}} </h1>
                    </div>

                    <div class="form-row">
                        <span > Relationship </span>
                        <h1> {{$viewdata->relationship}}
                    </div>

                    <div class="form-row">
                        <span> Date of Birth </span>
                        <h1> {{$viewdata->date_of_birth}}
                    </div>

                  
     
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
        grid-template-rows: 15% 85%;
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
        align-items: center;
        
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


    .form-edit { 
        width: 40%; 
        height: 100%; 
        display: Flex; 
        margin-left: 0.5rem;
        
        align-items: end;
    }

    .form-edit a { 
       
        
        height:50%; 
        width: 60%; 
        display: flex; 
        justify-content: center;
        align-items: center;
        border-radius: 25px; 
        
        
        transition: 300ms; 
        background-color: maroon;
        
    }

    .form-title a:hover { 
        background-color: #A84655; ;
    }

    .form-title a span { 
        color: white; 
        font-size: 1rem;
    }

    .form-title img { 
        width: 25px; 
        height:25px;
        margin: 0 0.2rem;
    }

    .form-title h1 { 
        font-size: 1.7rem; 
        font-weight: 900;
        color: rgb(0,0,0,0.7)
    }

    .form-body { 
        display: flex; 
        justify-content: center;
        flex-direction: column;
    }

    .form-row {
        margin: 0.5rem 0;
        display: flex; 
        line-height: 1.5rem;
        flex-direction: column;
    }

    .form-row h1 { 
        font-weight: 700;
        font-size: 1.5rem; 
    }

    .form-row span { 
        font-size: 0.8rem;
        color:gray;
    }

    .ab-right input[type=text], .ab-right input[type=date] { 
        width: 90%; 
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
        padding-top: 0.7rem;
        padding-right: 3rem;
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