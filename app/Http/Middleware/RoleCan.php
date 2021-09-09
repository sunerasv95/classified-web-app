<?php

namespace App\Http\Middleware;

use App\Enums\ErrorCodes;
use App\Traits\ApiResponser;
use App\Util\Messages;
use Closure;

class RoleCan
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        //dd($roles);
        $userRole = $request->user()->with(['role'])->first()->role;
        $hasPermission = $userRole->hasPermissions($permissions);

        if(!$hasPermission) return $this->respondUnAuthorized(
            Messages::UNAUTHORIZED_ACTION,
            ErrorCodes::UNAUTHORIZED_ACTION
        );
        return $next($request);
    }
}
