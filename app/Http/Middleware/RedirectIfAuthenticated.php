<?php



namespace App\Http\Middleware;



use Closure;

use Illuminate\Support\Facades\Auth;



class RedirectIfAuthenticated

{

    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard === 'admin' && Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        if ($guard === 'livreur' && Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        if ($guard === 'fournisseur' && Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        if ($guard === 'freelancer' && Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        if ($guard === 'boutique' && Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        return $next($request);

    }

}

