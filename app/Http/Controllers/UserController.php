<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showProfile(User $user)
    {
        return view('user.profile', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'email' => 'string|email|max:255|nullable',
            'password' => 'nullable|string|min:6'
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->city = $request->city;
        $user->email = $request->email;
        if(!is_null($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('home');
    }
}

