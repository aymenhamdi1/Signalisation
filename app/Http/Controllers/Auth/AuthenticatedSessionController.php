<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($lang = App::getLocale()=== 'ar') {
            $notification = array(
                'message' => 'تم تسجيل دخول المستخدم بنجاح',
                'alert-type' => 'success'
             );
        } elseif ($lang = App::getLocale()=== 'fr') {
            $notification = array(
                'message' => "L'utilisateur s'est connecté avec succès",
                'alert-type' => 'success'
            );
        } elseif ($lang = App::getLocale()=== 'en') {
            $notification = array(
                'message' => "User Login Successfully",
                'alert-type' => 'success'
            );
        }

        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
