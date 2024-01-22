<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;

use App\Mail\OTPMail;
use Nette\Utils\Random;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function LoginPage(){
        return view('pages.auth.login-page');
    }
    public function RegistrationPage(){
        return view('pages.auth.registration-page');
    }
    public function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }
    public function VerifyOtpPage(){
        return view('pages.auth.verify-otp-page');
    }
    public function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }
    public function Dashboard(){
        return view('pages.dashboard.dashboard-page');
    }









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
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "Faild",
                "massage" => $e->getMessage()
            ], 200);
        }
    }

    public function UserLogin(Request $request)
    {
        try {

            $email = $request->input('email');
            $password = $request->input('password');

            $count = User::where('email', '=', $email)->where('password', '=', $password)->count();
            if ($count == 1) {

                $token = JWTToken::CreateToken($email);

                return response()->json([
                    'status' => 'success',
                    'message' => "User Login successfully",
                ], 200)->cookie("LoginToken", $token, 60*60);
            }
            else{
                return response()->json([
                    "status" => "Faild",
                    "message" => "unauthorise"
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Faild",
                "message" => $e->getMessage()
            ], 200);
        }
    }

    public function SendOtp(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|string|email'
            ]);

            $email = $request->input('email');
            $otp = rand(1000000, 9999999);
            $count = User::where('email', '=', $email)->count();

            if ($count == 1) {
                Mail::to($email)->send(new OTPMail($otp));

                User::where('email', '=', $email)->update(['otp' => $otp]);

                return response()->json([
                    'status' => 'success',
                    'message' => "OTP send successfully"
                ], 200);
            }
            else{
                return response()->json([
                    "status" => "Faild",
                    "message" => "unauthorized"
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Faild",
                "message" => $e->getMessage()
            ], 200);
        }
    }

    public function VerifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|string|max:50',
                'otp' => 'required|max:7|min:7'
            ]);

            $email = $request->input('email');
            $otp = $request->input('otp');

            $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

            if ($count == 1) {
                User::where('email', '=', $email)->where('otp', '=', $otp)->update(['otp' => '0']);

                $token = JWTToken::CreateTokenForVerify($email);

                return response()->json([
                    'status' => 'success',
                    'message' => "OTP Veryfy successfully",
                    'token' => $token
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "Faild",
                "message" => $e->getMessage()
            ], 200);
        }
    }

    public function ResetPassword(Request $request){
        try{
            $password = $request->input('password');
            $email = $request->header('email');
            User::where('email','=',$email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'massage' => "Reset password successfully",
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "status" => "Faild",
                "massage" => $e->getMessage()
            ], 200);
        }
      
    }
}
