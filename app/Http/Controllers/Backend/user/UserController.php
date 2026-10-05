<?php

namespace App\Http\Controllers\Backend\user;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function index()
    {
        return view('dashboard');
    }

    public function allUsers()
    {
        $alldata = User::all();
        $trachuser = User::onlyTrashed()->get();
        return view('Backend.user.index', compact('alldata', 'trachuser'));
    }

    public function addUser()
    {
        $roles = Role::all();
        return view('Backend.user.add', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@mehat\.gov\.tn$/',
            'name' => 'required|alpha|max:90',
        ]);
        $code = Str::random(13); // Générer le code aléatoire
        $data = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'code' => $code,
            'password' => bcrypt($code),
            'status' => $request->has('status') && $request->status === 'active' ? 'active' : 'inactive',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHis') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        if ($request->role) {
            $data->assignRole($request->role);
        }

        // Envoyer le mot de passe par e-mail
        // Mail::to($data->email)->send(new PasswordMail($data));

        $notification = [
            'message' => __('Successfully created'),
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user')->with($notification);
    }

    public function editUser($id)
    {
        $editData = User::find($id);
        $roles = Role::all();
        return view('Backend.user.edit', compact('editData', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $data = User::findOrFail($id);

        $data->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->has('status') && $request->status === 'active' ? 'active' : 'inactive',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHis') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);

            // Supprimer l'ancienne photo si elle existe
            if ($data->photo) {
                $oldPhotoPath = public_path('upload/user_images') . '/' . $data->photo;
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            $data->photo = $filename;
        }

        $data->save();
        $data->roles()->detach();
        if ($request->role) {
            $data->assignRole($request->role);
        }

        $notification = [
            'message' => __('Successfully updated'),
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user')->with($notification);
    }



    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $notification = [
            'message' => __('Successfully deleted'),
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user')->with($notification);
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        $notification = [
            'message' => __('Successfully restored'),
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user')->with($notification);
    }


    public function forceDeleteUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        $notification = [
            'message' => __('Successfully deleted permanently'),
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user')->with($notification);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->status = $request->status !== '' ? $request->status : 'inactive';
            $user->save();
            $notification = [
                'message' => __('Successfully changed status'),
                'alert-type' => 'success'
            ];

            return response()->json($notification);

        }
        $notification = [
            'message' => __('Error changed status'),
            'alert-type' => 'error'
        ];

        return response()->json($notification);
    }
    public function getLastActiveUser(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        if ($user) {
            $lastActive = '';

            if ($user->OnlineUser()) {
                $lastActive = '<span class="badge badge-success-lighten">' . __('Online') . '</span>';
            } elseif (is_null($user->last_active_at)) {
                $lastActive = '<span class="badge badge-secondary-lighten">' . __('You are not logged in yet') . '</span>';
            } elseif ($user->last_active_at === "2000-01-01 00:00:00") {
                $lastActive = '<span class="badge badge-danger-lighten">' . __('Offline') . '</span>';
            } else {
                $lastActive = '<span class="badge badge-info-lighten">' . __('Last activity since: ') . Carbon::parse($user->last_active_at)->diffForHumans() . '</span>';
            }

            return response()->json(['last_active' => $lastActive]);
        }

        return response()->json(['last_active' => '']);
    }


   
}
