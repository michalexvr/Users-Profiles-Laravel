<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\User_credentialsController;

class has_access
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
    	//echo User_credentialsController::has_permision($request->path())?"has permision":"has not permision"; die; //DEBUG
    	if(!User_credentialsController::has_permision($request->path())) return abort(404);
    	
    	return $next($request);
    }
}
