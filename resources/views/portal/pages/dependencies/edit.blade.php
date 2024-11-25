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
            <section class="reminder">
                <h1> Edit Dependent</h1> 
                <h3> Kindly double check the information before saving.</h3>
            </section>
            <section class="logo">
                <img src = "{{asset('images/hau-logo.png')}}"/> 
            </section>
        </div>
        <div class="ab-right">

            <section class="form-title">
                <h1> Dependent Details </h1> 
            </section>

            <section class="form-body">
                <form action = "{{route('portal.dependencies.update', ['id'=> $toedit->id])}}" method = "POST"> 
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <span> First Name </span>
                        <input type="text" name = "fname" value = "{{$toedit-> fname}}" /> 
                    </div>

                    <div class="form-row">
                        <span> Middle Name </span>   
                        <input type="text" name = "mname" value = "{{$toedit-> mname}}"/> 
                    </div>

                    <div class="form-row">
                        <span> Last Name </span>
                        <input type="text" name = "lname" value = "{{$toedit-> lname}}"/> 
                    </div>

                    <div class="form-row">
                        <span > Relationship </span>
                        <input type="text" name = "relationship" value = "{{$toedit-> relationship}}"/> 
                    </div>

                    <div class="form-row">
                        <span> Date of Birth </span>
                        <input type="date" name = "date_of_birth" value = "{{$toedit-> date_of_birth}}"/> 
                    </div>

                    <div class="form-row-submit">
                        <button type = "submit" class = "btn-submit"> Save </button>
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

    
    logo img { 
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
    }

    .form-row { 
        width: 100%;
        height: 100%; 
        display: flex; 
        flex-direction: column;
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