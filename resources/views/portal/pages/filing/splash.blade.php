<x-app-layout>
  <div class="container">

    <div class="con-card">
        <div class="title-card">
            <div class="image-logo"> <img src = "{{asset('images/hau-logo.png')}}"> </div>
            <div class="card-text"> <h1> Submit Application </h1> </div>
        </div>

        <div class="card-buttons">
            <div class="card-slot"></div>
             <!-- card buttons   -->
            <div class="card-slot">
                <a href = "{{route('portal.filing.certification')}}"> 
                    <div class="card-btn">
                        <div class="card-icon"> <img src ="{{asset('images/icons/cert_maroon.png')}}"></div>
                        <div class="card-text"><h1>Certification </h1> </div>
                    </div>
                </a> 
            </div>

            <div class="card-slot">
                    <a href = "{{route('portal.filing.training')}}"> 
                        <div class="card-btn">
                            <div class="card-icon"> <img src ="{{asset('images/icons/training_maroon.png')}}"></div>
                            <div class="card-text"><h1>Training </h1> </div>
                        </div>
                    </a> 
            </div>

            <div class="card-slot">
                <a href = "{{route('portal.filing.license')}}"> 
                        <div class="card-btn">
                            <div class="card-icon"> <img src ="{{asset('images/icons/license_maroon.png')}}"></div>
                            <div class="card-text"><h1>License  </h1> </div>
                        </div>
                    </a> 
            </div>

            <div class="card-slot">
            <a href = "{{route('portal.filing.employment')}}" > 
                        <div class="card-btn">
                            <div class="card-icon"> <img src ="{{asset('images/icons/employment_maroon.png')}}"></div>
                            <div class="card-text"><h1>Employment   </h1> </div>
                        </div>
                    </a> 
            </div>
            <!-- end of card buttons -->
            
            <div class="card-slot"></div>

        </div>
    </div>
  </div>
</x-app-layout>


<style> 

    .container { 
       
        width: 100%; 
        
    }

    .con-card {
        width: 100%;
        height: 560px; 
        display: grid; 
        grid-template-rows: 50% 50%;
    }

    .con-card div { 
        width: 100%; 
        height: 100%; 
    }


    .title-card { 
        display: grid; 
        grid-template-rows: 85% 15%;

    }

    .title-card div { 
        width: 100%; 
        height: 100%; 

     
    }
    .image-logo { 
        display: flex; 
        justify-content: center;
        align-items:end;
    }

    .image-logo img { 
        width: 180px; 
        height: 180px;
    
    }

    .card-text{ 
        display: flex; 
        justify-content: center;
        align-items: center;
    }
    
    .card-text h1 { 
    
        font-weight: 900; 
        font-size: 2rem;
        color: maroon; 
    }

    .card-buttons { 
        display: grid; 
        grid-template-columns: 4% 23% 23% 23% 23% 4%; 
    }

    .card-buttons div { 
        width: 100%; 
        height: 100%; 
        
    }

    .card-slot { 
      
        
        display: flex; 
        justify-content: center;
        align-items: center;
    }

    .card-slot a { 
        width: 90%;
        height: 80%;
    }

    .card-btn {
        width: 100%; 
        height: 100%; 
        border-radius: 25px;
        background-color: white;
        display: grid; 
        grid-template-rows: 60% 40%;
        transition: 300ms; 
    }

    .card-btn div { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        justify-content: center;
    }

    .card-icon img { 
        width: 90px; 
        height: 90px;
    }

    .card-icon { 
        align-items: end;
    }

    .card-text { 
        align-items: start;
    }

    .card-btn .card-text h1 { 
        font-size: 1.5rem;
        font-weight: 700;
    }

    .card-btn:hover { 
        transform: scale(1.07)
    }

    
    
</style> 