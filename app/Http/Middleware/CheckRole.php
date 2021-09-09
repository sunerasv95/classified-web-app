<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use App\Util\Messages;
use Closure;

class CheckRole
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        //dd($roles);
        $hasRole = $request->user()->hasAnyRole($roles);
        //dd($hasRole);
        if(!$hasRole) return $this->respondUnAuthorized(Messages::UNAUTHORIZED_MESSAGE);
        return $next($request);
    }
}
