<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:livreur')->except('logout');
        $this->middleware('guest:freelancer')->except('logout');
        $this->middleware('guest:production')->except('logout');
        $this->middleware('guest:fournisseur')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.admin')
        ]);
    }

    public function showLivreurLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.livreur')
        ]);
    }

    public function showFournisseurLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.fournisseur')
        ]);
    }

    public function showProductionLoginForm()
    {
        return view('auth.login', [
            'url' => 'production'
        ]);
    }



    public function showFreelancerLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.freelancer')
        ]);
    }


    protected function validator(Request $request)
    {
        return $this->validate($request, [
            'email'   => 'required',
            'password' => 'required'
        ]);
    }

    protected function guardLogin(Request $request, $guard)
    {
        $this->validator($request);
        return Auth::guard($guard)->attempt(
            [
                'email' => $request->email,
                'password' => $request->password
            ],
            $request->get('remember')
        );
    }

    public function adminLogin(Request $request)
    {
        if ($this->guardLogin($request, Config::get('constants.guards.admin'))) {
            return redirect()->intended('/home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }


    public function productionLogin(Request $request)
    {
        if ($this->guardLogin($request, Config::get('constants.guards.production'))) {
            return redirect()->intended('/production');
        }
        return back()->withInput($request->only('email', 'remember'));
    }


    public function livreurLogin(Request $request)
    {
        if ($this->guardLogin($request,Config::get('constants.guards.livreur'))) {
            return redirect()->intended('/home');
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    public function fournisseurLogin(Request $request)
    {
        if ($this->guardLogin($request,Config::get('constants.guards.fournisseur'))) {
            return redirect()->intended('/home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function freelancerLogin(Request $request)
    {
        if ($this->guardLogin($request,Config::get('constants.guards.freelancer'))) {
            return redirect()->intended('/home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
}
