<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // import User model

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Update profile info
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user(); // explicitly type for Intelephense

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        if($request->hasFile('profile_image')){
            $imageName = time().'_'.$request->profile_image->getClientOriginalName();
            $request->profile_image->storeAs('public/profiles', $imageName);
            $user->profile_image = $imageName;
        }

        $user->save(); // now Intelephense recognizes save()

        return back()->with('success', 'Profile updated successfully!');
    }
}
