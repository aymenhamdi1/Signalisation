<?php

namespace App\Http\Controllers\Backend\permission_par_role;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionByRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('Backend.role_permission.permission_by_role.add', compact('roles', 'permissions', 'permission_groups'));
    }// End Method


    public function StoreRolesPermission(Request $request)
    {
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' => __('Successfully created'),
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);
    }// End Method


    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('Backend.role_permission.permission_by_role.index', compact('roles'));
    } // End Method


    public function AdminEditRoles($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('Backend.role_permission.permission_by_role.edit', compact('role', 'permissions', 'permission_groups'));
    } // End Method


    public function RolePermissionUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);


            $notification = array(
               'message' => __('Successfully updated'),
               'alert-type' => 'success'
            );

            return redirect()->route('all.roles.permission')->with($notification);

        } elseif (empty($permissions)) {
            $role->syncPermissions($permissions);


            $notification = array(
               'message' => __('No roles have been updated'),
               'alert-type' => 'info'
            );

            return redirect()->route('all.roles.permission')->with($notification);
        }
    }// End Method


    public function AdminDeleteRoles($id)
    {
        $role = Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = array(
            'message' => __('Successfully deleted'),
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }// End Method
}
