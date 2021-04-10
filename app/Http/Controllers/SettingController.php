<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Test;
use App\Student;
use App\User;
use App\Setting;

class SettingController extends Controller
{
    //
    public function GetRole()
    {
        $headers = [];
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $auth = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
        $data = [
            "Roles"=>$roles,
            "Permissions"=>$permissions,
            "Auth"=>$auth
        ];
        return response()->json($data, 200, $headers);
    }
    public function RoleGivPermiss(Request $request)
    {
        $headers = [];
        $role = Role::find($request->role);
        if($role !=null){
            $role->revokePermissionTo($role->getAllPermissions());
            $permission = Permission::find($request->permissions);
            $role->givePermissionTo($permission);
            $ret = [
                'msg'=>'Изменения внесены',
            ];
        }else{
            $ret = [
                'msg'=>'Ошибка при поиске роли',
            ];
        }
        return response()->json($ret, 200, $headers);
    }
    public function CreateRole(Request $request)
    {
        $headers = [];
        $role = new Role();
        $role->name = $request->name;
        if($role->save()){
            $permi = Permission::find($request->permissions);
            $role->givePermissionTo($permi);
            $ret = [
                'msg'=>'Новая роль создана',
            ];
        }else{
            $ret = [
                'msg'=>'Ошибка при создании роли пользователя',
            ];
        }
        return response()->json($ret, 200, $headers);
    }
    public function getPermission()
    {
        $headers = [];
        
        $permissions = Permission::all();
        $auth = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
        $data = [
            "Permissions"=>$permissions,
            "Auth"=>$auth
        ];
        return response()->json($data, 200, $headers);
    }
    public function storePermission(Request $request)
    {
        $headers = [];
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = 'web';
        if($permission->save()){
            $ret = [
                'msg'=>'Новые полномочия созданы',
            ];
        }else{
            $ret = [
                'msg'=>'Ошибка при создания полномочий',
            ];
        }
        return response()->json($ret, 200, $headers);
    }
    public function GetPermissionForUser()
    {
        $auth = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
        $headers = [];
        return response()->json($auth, 200, $headers);
    }

    public function GetSettings()
    {
        $da = Setting::all();
        $headers = [];
        return response()->json($da, 200, $headers);
    }
    public function EditSettings(Request $request) 
    {
        $settings = Setting::find($request->id);
        $settings->values = $request->values;
        $settings->lang = $request->lang;
        $headers = [];
        if($settings->update()){
            $ret = [
                'msg'=>'Настройки изменены',
            ];
        }else{
            $ret = [
                'msg'=>'Ошибка при изменении настроек',
            ];
        }
        return response()->json($ret, 200, $headers);
    }

}
