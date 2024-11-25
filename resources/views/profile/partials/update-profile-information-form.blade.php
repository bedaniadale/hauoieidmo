
@php

$changed  = session('changed'); 

session(['changed'=>false]); 
@endphp

<section>
    <header>

    <div> 
    @if($changed==true)
    <p class="msg mt-1 mb-2">
            {{ __("Profile picture successfully updated.") }}
        </p>
    </div> 
    @endif
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 mb-2 text-sm text-white-600 dark:text-gray-400">
            {{ __("Update your account's profile picture and email address.") }}
        </p>
    </header>

  

    <div class = "change_dp"> 

                            
                            @if($data->profile_picture)
                            <img id = "preview" src ="{{asset ('storage/profile_pictures/' . $data->profile_picture)}}" alt = "user_image"/> 
                            @else 
                            <img src ="{{asset ('images/blankdp.jpg')}}"/>
                            @endif

                
                @if($changedp == false) 

                    <div class="w-full flex mt-2 gap-2">



                        <a class="bg-red-900 hover:bg-red-800 px-4 py-2 text-white rounded-xl" href = "{{route('profile.changepic')}}"> 
                           <span>
                           Change Profile Picture
                           </span>
                        </a> 

                   


                    </div>
                @else 
                <form method="post" action="{{route('update-pic', ['id'=> Auth::user()->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <label for="file">Choose a file:</label>
                        <input type="file" id="file" name="profile_picture" accept="image/*">
                    </div>

                    <div class="row">
                        <a class="cancel" href="{{ route('profile.edit') }}">
                            Cancel
                        </a>
                        <button id = "save" type="submit" disabled>Save Changes</button>
                    </div>
                </form>

                @endif
        </div> 

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

      
       
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        
    </form>
</section>


<style> 
    section { 
        width: 75%;
        padding: 2rem 0;
    }
    


    .cancel { 
        font-size: 12px; 
        margin: 0 1rem;
        text-decoration: underline;
    }
    button.save { 
        background-color: green;
    }
    .nav-btn { 
        background-color: maroon;
    }
    .nav-btn {
      
        color: white; 
        width: 30%;
        text-align: center;
        padding: 0.3rem 0.5rem; 
        border-radius: 15px; 
        font-size: 13px;
        height: 100%;
        margin: 0.5rem 0;
        transition: 300ms; 
    }

    .nav-btn:hover { 
        background-color: #a52a2a
    }

    input[type=file] { 
        margin-top: 1rem;
    }

    .msg { 
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem; 
        text-align: center;
        background-color: green; 
        color: white; 
    }
</style>

<script> 
    if(@json($changedp)==true) { 

        document.getElementById('file').addEventListener('change', function(event) {
                let save_btn = document.querySelector("#save"); 
                const file = event.target.files[0];
                if (file) {
                    save_btn.disabled = false; 
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('preview');
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else { 
                    save_btn.disabled = true;
                    const preview = document.getElementById('preview');
                    preview.src = "{{asset ('uploads/profile/' . $data->profile_picture)}}"
    
                }
            });
    }


        document.addEventListener('DOMContentLoaded', function() {
            var statusChanged = @json($changed);
            if(statusChanged == true) { 
                console.log('changing'); 
                setTimeout(function() { 
                    document.querySelector('.msg').style.display = 'none'
                }, 5000)
            }
        });




    

</script> 