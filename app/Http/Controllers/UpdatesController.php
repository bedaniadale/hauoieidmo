<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;


use App\Models\Employee;

use Illuminate\Support\Facades\Storage ;

class UpdatesController extends Controller
{
    public function updatePic(Request $request, $id): RedirectResponse 
    { 
        $emp = Employee::findOrFail(Auth::user()->id); 


      
      
        $validateData = $request->validate([ 
            'profile_picture'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
   
        //delete the old picture 
        if($emp->profile_picture) { 
            Storage::disk('public')->delete('profile_pictures/' . $emp->profile_picture);
        }


        //create the directory
        $path = 'profile_pictures'; 
        if(!Storage::exists($path)) { 
            Storage::makeDirectory($path) ; 
        }
        //setting up a new file name 
        $fn = $id . '.' .  $request->file('profile_picture')->getClientOriginalExtension(); 
        
        
        //storing the image to the storage disk
        $request->file('profile_picture')->storeAs($path, $fn, 'public');
        
        
        $emp->update([ 
            'profile_picture'=> $fn
        ]); 
        
    

        //setting up the session data user for the preview
        $userInfo = Employee::where('emp_id', $id)->first();
        session(['userInfo'=>$userInfo]);
        session(['changed'=>true]);

        return Redirect::route('profile.edit')-> with(['status'=> 'profile-updated', 'changedp'=> false]); 
    }
}
