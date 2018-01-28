<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
use App\User;

class AuthLogin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('member.isLogin')) { 
            $user = User::where('username', Session::get('member.username'))->first();
            if ($user['type'] == 2) {
                $request->user = $user;
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
