<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');
        $verifyToken = JWTToken::VerifyToken($token);
        if($verifyToken == "unauthorized"){
            return response()->json([
                'status' =>"fail",
                'message' =>"unauthorized",
            ]);
        }
        else{
            $request->headers->set('email', $verifyToken);
            return $next($request);
        }        
    }
}
