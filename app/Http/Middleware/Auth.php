<?php

namespace App\Http\Middleware;

use App\Helper\Helper;
use Closure;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if(empty($token)){
            return response()->json(['message' => 'Token não informado!'], 418);
        }

        $request->attributes->add(['user' => Helper::verifyJwt($token)]);

        return $next($request);
    }
}
