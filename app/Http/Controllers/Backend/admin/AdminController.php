<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
   


    public function Index()
    {
        return view('template.index');

    }
      

          

    public function ChangeLanguage($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }

    public function AdminLogout(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        if ($user) {
            // Update the last_active_at field
            $user->last_active_at = Carbon::parse('2000-01-01 00:00:00');
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($lang = App::getLocale()=== 'ar') {
            $notification = array(
                'message' => 'تم تسجيل خروج المستخدم بنجاح',
                'alert-type' => 'success'
             );
        } elseif ($lang = App::getLocale()=== 'fr') {
            $notification = array(
                'message' => "L'utilisateur s'est déconnecté avec succès",
                'alert-type' => 'success'
            );
        } elseif ($lang = App::getLocale()=== 'en') {
            $notification = array(
                'message' => "User Logout Successfully",
                'alert-type' => 'success'
            );
        }

        return redirect('/login')->with($notification);
    }

    public function IndexProfile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('Backend.admin.profil.index', compact('adminData'));

    }// End Method


    public function EditProfile()
    {

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('Backend.admin.profil.edit', compact('editData'));
    }// End Method

    public function storeProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->adresse = $request->adresse;
        $data->gender = $request->gender;

        if ($request->file('photo')) {
            $file = $request->file('photo');

            $filename = date('YmdHis') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);

            // Supprimer l'ancienne photo si elle existe
            if ($data->photo) {
                $oldPhotoPath = public_path('upload/admin_images') . '/' . $data->photo;
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $data->photo = $filename;
        }
        $data->save();

        if (App::getLocale() === 'ar') {
            $notification = [
                'message' => 'تم تحديث الملف الشخصي بنجاح',
                'alert-type' => 'info'
            ];
        } elseif (App::getLocale() === 'fr') {
            $notification = [
                'message' => "Mise à jour du profil réussie",
                'alert-type' => 'info'
            ];
        } elseif (App::getLocale() === 'en') {
            $notification = [
                'message' => "Profile Updated Successfully",
                'alert-type' => 'info'
            ];
        }

        return redirect()->route('admin.profile')->with($notification);
    }


    public function ChangePassword()
    {

        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('Backend.admin.password.index', compact('adminData'));

    }// End Method


    public function UpdatePassword(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'new_password_confirmation' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            if ($lang = App::getLocale()=== 'ar') {
                $notification = array(
                    'message' => 'تم تغيير كلمة المرور بنجاح',
                    'alert-type' => 'success'
                 );
            } elseif ($lang = App::getLocale()=== 'fr') {
                $notification = array(
                    'message' => "Le mot de passe a été changé avec succès",
                    'alert-type' => 'success'
                );
            } elseif ($lang = App::getLocale()=== 'en') {
                $notification = array(
                    'message' => "Password changed successfully",
                    'alert-type' => 'success'
                );
            }


            return redirect()->back()->with($notification);
        } else {

            if ($lang = App::getLocale()=== 'ar') {
                $notification = array(
                    'message' => "كلمة المرور القديمة غير متطابقة",
                    'alert-type' => 'error'
                 );
            } elseif ($lang = App::getLocale()=== 'fr') {
                $notification = array(
                    'message' => "L'ancien mot de passe ne correspond pas",
                    'alert-type' => 'error'
                );
            } elseif ($lang = App::getLocale()=== 'en') {
                $notification = array(
                    'message' => "Old password doesn't match",
                    'alert-type' => 'error'
                );
            }
            return redirect()->back()->with($notification);
        }

    }// End Method
}
