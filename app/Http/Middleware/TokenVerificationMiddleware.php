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
        $token = $request->cookie('token');
        $verifyToken = JWTToken::VerifyToken($token);
        if($verifyToken == "unauthorized"){
            return redirect('/user-login');
        }
        else{
            $request->headers->set('email', $verifyToken->userEmail);
            $request->headers->set('id', $verifyToken->userEmail);
            return $next($request);
        }        
    }
}
