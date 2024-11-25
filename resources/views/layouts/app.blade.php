@php
    use App\Helpers\pagetitle;

    $curr_page = pagetitle::getCurrentPageTitle();
@endphp


    <!--------------- the code above is for the header title text. -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if($curr_page!='') 
            <title>{{$curr_page}} | {{ config('app.name')}}</title>
        @else 
            <title> {{config('app.name') }}</title> 
        @endif

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
    
        <!-- Scripts -->

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style> 
/* 
            body { 
                overflow: hidden;
            } */


            @media (max-width: 820px) {
        body {
            font-size: 0.7rem; /* Font size for medium viewports */
        }

      

      
}


            body { 
                background-color: #edf2f7;
                
            }

            

        
            .sidebar { 
                position: fixed;
                left: 0; 
                height: 100%; 
                width: 20%;
            }

            .content { 
                background-color:#edf2f7;
                position: absolute;
                top: 10% ;
                overflow-x: auto;
                left: 20%;
                width: 80%;
            }


                
            .header { 
                
            
                width: 80%;
                height: 10%;
                left: 20%;
                position: fixed;
                background-color: white;
                box-shadow: 4px 3px 5px rgba(0, 0, 0, 0.1);
            }




          
        

            .header { 
                background-color: #fdfdfd;
                display: flex; 

            }

            .page-title {
        
                height: 100%; 
                display: flex; 
                align-items: center;
                float: left; 
                /* justify-content: center; */
            }
        

            .user-image img { 
                width:40px; 
                height: 40px; 
             
                border-radius: 50%;
            }


            .logged-user { 
               
                height: 100%;
                display: flex; 
                flex-direction: column;


            }

            .user-image,.details { 
                width: 100%; 
                height: 100%; 
            }

            .dropdown { 
                
                height: 10%;
               
                right: 0;
                
                display: flex; 
                position: fixed;
                align-items: center;
            }

            .logged-user { 
                
                margin: 0 1rem;
                display: flex; 
                justify-content: center;
                align-items: end;
                justify-content: center;
            }

            .logout{ 
                display: flex; 
                
                align-items: center;
                padding: 0 2rem 0 0;
            }

    
      
            .logged-user h3 { 
                line-height: 20px;
                font-size: 15px;
                color: #100F0D;
                font-weight: 700; 
            }

            .logged-user h4 { 
                opacity: 50%;
                color: #100F0D;
                font-size: 13px;
                line-height: 10px;
            }
           

            .content { 
                z-index: 4;
            }

            .dropdown { 
                z-index: 7;
            }

            .header { 
                z-index: 5;
            }

            .dropdown button:hover { 
                color: #70121D; 
            }

            .dropdown-toggle { 
                
                width: 140px; 
           
                height: 100px;
         
               
                position: absolute; 
                top: 2.8rem; 
                right: 1rem;
                background-color: #fdfdfd;
                flex-direction: column;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                display: grid; 
                grid-template-rows: 50% 50%;
                z-index: 5;
               
            }

            
            
            .dt-row { 
                width: 100%; 
                height: 100%; 
                

               
                
            }

           

            .hide > * {
                display: none;
             }

             .hide { 
                height: 0px;

             }

            .dt-row:hover { 
                background-color: #FFF0ED;
            }


            .dt-row form { 
                width: 100%; 
                height: 100%;
                display: flex; 
                justify-content: center;
                align-items: center; 

            }

            .dt-row button {
                width: 100%; 
                height: 100%;
                display: flex; 
                justify-content: center;
                align-items: center; 
            }
         

            .dt-row form img { 
                width: 20px; 
                height: 20px;
                margin: 0 0.5rem; 
            }


            .dt-row span { 
                font-size: 1rem; 
            }

            
            .all-clickable * {
    pointer-events: auto !important;
}

        </style> 
    </head>
    <body class="font-sans antialiased">
            
        <div class="content">

            <div class="main-content">
                {{ $slot }}
            </div>
        
        </div>

        <div class="sidebar">

            @php
                $currentPath = request()->path(); 
            @endphp 

            @if (Str::contains($currentPath, 'hau_ep'))
            <!-- Display content for routes containing 'emp' -->
                @include('layouts.portal_navigation')
            @elseif (Str::contains($currentPath, 'admin'))
                @include('layouts.admin_nav') 
            @else 
                @include('layouts.navigation')
            @endif
        </div>

        <div class="header">
                <div class="page-title">
                    <h1 class="text-xl text-red-900 font-bold pl-4">  {{ $curr_page}} </h1> 
                </div>

                
        </div>
    
                    

        <div class="dropdown">

            
                <div class="logged-user">
                        
                        
                    
                    
                </div>
                <div class = "logout"> 
                    <button class = "dropdown-btn"> ⮟ </button>
                    <div class="dropdown-toggle hide">
                        

                        <!-- 1 row -->
                    <div class="dt-row"> 
                                
                                
                                <form method="GET" action="{{ route('profile.edit') }}">
                                    @csrf

                                    <button :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                             <img src = "{{asset( 'images/icons/icon-settings.png')}}"/>
                                             <span> Settings </span> 
                                        
                                    </button>
                                </form>
                           
                        </div>
                            
                        <!-- 1 row -->
                        <div class="dt-row"> 
                                
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                             <img src = "{{asset( 'images/icons/icon-logout.png')}}"/>
                                             <span> Logout </span> 
                                        
                                    </button>
                                </form>
                           
                        </div>
                    </div> 
            </div>
                        


     
                
       



        
        


        <script>
            
            
            let doc_btn = document.querySelector('.dropdown-btn')
            let dropdown_box = document.querySelector(".dropdown-toggle"); 

            let header = document.querySelector(".header")  
            let content = document.querySelector(".content") 


            header.addEventListener("click",()=> { 
                dropdown_box.classList.add('hide')  
            })

            content.addEventListener("click",()=> { 
                 dropdown_box.classList.add('hide')
            })
            doc_btn.addEventListener("click",()=> { 
                if(dropdown_box.classList.contains('hide')) { 
                    dropdown_box.classList.remove('hide')
                } else { 
                    dropdown_box.classList.add('hide'); 
                }
            })

            document.body.addEventListener("click", (event)=> { 
                if(!dropdown_box.contains(event.target) && !doc_btn.contains(event.target)) { 
                    dropdown_box.classList.add('hide')
                }
            }) 

            
        </script>                                               
    </body>
</html>


<!-- 
THIS IS THE LOGOUT BUTTON CODE
<form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        ⮟
                    </x-responsive-nav-link>
                </form> -->

             