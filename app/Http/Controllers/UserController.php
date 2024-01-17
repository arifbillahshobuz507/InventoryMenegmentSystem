<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;

use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {

        try {

            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|email|string|unique:users,email|max:50',
                'phone' => 'required|string|max:50',
                'password' => 'required|string|min:3'
            ]);

            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => $request->input('password')
            ]);

            return response()->json([
                "status" => "Success",
                "massage" => "User Create Successfully!",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "Faild",
                "massage" => $e->getMessage()
            ]);
        }
    }
   
}