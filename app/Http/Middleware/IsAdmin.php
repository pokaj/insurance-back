<?php

namespace App\Http\Middleware;

use App\Role;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user['role'] == Role::Admin->value){
            return $next($request);
        }
        return $this->error( Response::HTTP_UNAUTHORIZED, 'You are not authorized to perform this action');
    }
}
