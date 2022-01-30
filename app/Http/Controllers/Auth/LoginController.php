<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:livreur')->except('logout');
        $this->middleware('guest:freelancer')->except('logout');
        $this->middleware('guest:boutique')->except('logout');
        $this->middleware('guest:fournisseur')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.admin')
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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


    public function showFreelancerLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.freelancer')
        ]);
    }

    public function showBoutiqueLoginForm()
    {
        return view('auth.login', [
            'url' => Config::get('constants.guards.boutique')
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function validator(Request $request)
    {
        return $this->validate($request, [
            'email'   => 'required',
            'password' => 'required'
        ]);
    }

    /**
     * @param Request $request
     * @param $guard
     * @return bool
     */
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

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request)
    {
        if ($this->guardLogin($request, Config::get('constants.guards.admin'))) {
            return redirect()->intended('/home');
        }

        return back()->withInput($request->only('email', 'remember'));
    }



    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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


    public function boutiqueLogin(Request $request)
    {
        if ($this->guardLogin($request,Config::get('constants.guards.boutique'))) {
            return redirect()->intended('/home');
        }

        return back()->withInput($request->only('email', 'remember'));
    }
}
