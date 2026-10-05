<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }
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

        $request->session()->put('auth.password_confirmed_at', time());
        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
    }
}
