<?php

namespace App\Http\Controllers\Backend\permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function AllPermission()
    {

        $permissions = Permission::select('group_name')->groupBy('group_name')->get();
        return view('Backend.role_permission.permission.index', compact('permissions'));

    } // End Method


    public function AddPermission()
    {

        return view('Backend.role_permission.permission.add');

    } // End Method


    public function StorePermission(Request $request)
    {

        $validateddata = $request->validate([
            'name' => 'required|unique:permissions',
            'group_name' => 'required|unique:permissions',
         ]);

        $countpermission = count($request->name);
        if ($countpermission !=null) {
            for ($i=0; $i <$countpermission ; $i++) {
                $data = new Permission();
                $data->name = $request->name[$i];
                $data->group_name = $request->group_name[$i];
                $data->save();
            }
        }



        $notification = array(
           'message' => __('Successfully created'),
           'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }// End Method


    public function EditPermission($group_name)
    {

        $permission = Permission::where('group_name', $group_name)->orderBy('group_name', 'asc')->get();
        return view('Backend.role_permission.permission.edit', compact('permission'));

    }// End Method


    public function UpdatePermission(Request $request, $group_name)
    {


        if ($request->name == null) {
            $notification = array(
            'message' => __('Sorry, the field must not be empty'),
            'alert-type' => 'error'
            );

            return redirect()->route('edit.permission', $group_name)->with($notification);
        } else {

            $countpermission = count($request->name);
            Permission::where('group_name', $group_name)->delete();
            for ($i=0; $i <$countpermission ; $i++) {
                $data = new Permission();
                $data->name = $request->name[$i];
                $data->group_name = $request->group_name[$i];
                $data->save();
            }
        }

        $notification = array(
           'message' => __('Successfully updated'),
           'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }// End Method


    public function DeletePermission($group_name)
    {


        Permission::where('group_name', $group_name)->delete();

        $notification = array(
            'message' => __('Successfully deleted'),
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method
}
