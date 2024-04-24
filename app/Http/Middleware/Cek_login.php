<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @param $roles
     * @return Response
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        /**
         * if user hadn't logged in, back to login page
         */
        if (!Auth::check()) {
            return redirect('login');
        }

        /**
         * save user data
         */
        $user = Auth::user();

        /**
         * if user level is related to roles, redirect request
         */
        if ($user->level_id == $roles) {
            return $next($request);
        }

        /*if user haven't roles to access, return to log in with access denied*/
        return redirect('login')->with('error', 'Maaf anda tidak memiliki akses');
    }
}