<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Auth::check()) { //if user is authenticated
            if (Auth::user()->user_type=='admin') {
                return $next($request);
            }
            else{ //Clears all session data and redirect to login page
                Session::flush();
                return redirect()->route('login');
            }
        }
        else{ //if user is not authenticated
            return redirect()->route('login');
        }
    }
}
