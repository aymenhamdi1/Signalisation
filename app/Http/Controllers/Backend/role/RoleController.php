<?php

namespace App\Http\Controllers\Backend\role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function AllRoles()
    {

        $roles = Role::all();
        return view('Backend.role_permission.role.index', compact('roles'));

    }// End Method


   public function AddRoles()
   {

       return view('Backend.role_permission.role.add');

   }// End Method


    public function StoreRoles(Request $request)
    {

        $role = Role::create([
            'name' => $request->name,

        ]);

        $notification = array(
            'message' => __('Successfully created'),
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);

    }// End Method


   public function EditRoles($id)
   {

       $roles = Role::findOrFail($id);
       return view('Backend.role_permission.role.edit', compact('roles'));

   }// End Method

    public function UpdateRoles(Request $request)
    {

        $role_id = $request->id;

        Role::findOrFail($role_id)->update([
            'name' => $request->name,

        ]);

        $notification = array(
            'message' => __('Successfully updated'),
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);

    }// End Method


    public function DeleteRoles($id)
    {

        Role::findOrFail($id)->delete();

        $notification = array(
            'message' => __('Successfully deleted'),
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method
}
