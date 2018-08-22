<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JwtAuth;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $jwtAuth    =new JwtAuth();
        $hash       =$request->header('Authorization',null);
        if(!$jwtAuth->checkToken($hash)){
          $jsonresponse=[
              'status' =>'error',
              'message'=>'Autenticacion fallida'
          ];
          return response()->json($jsonresponse,200);
        }

        return $next($request);
    }
}
