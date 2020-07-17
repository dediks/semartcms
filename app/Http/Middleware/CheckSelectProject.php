<?php

namespace App\Http\Middleware;

use App\Project;
use Closure;

class CheckSelectProject
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
        if ($request->session()->has('project') == null) {
            return redirect(route('project.index'));
        }

        return $next($request);
    }
}
