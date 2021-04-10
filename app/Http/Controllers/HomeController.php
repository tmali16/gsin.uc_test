<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Test;
use App\Student;
use App\Question;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->updated_at == null){
            return redirect('/new/pass');
        }
        $students = Student::all();
        $tests = Test::with(["question"])->get();

        return view('admin.index', ["students"=>$students, "tests"=>$tests]);
    }
    public function Dashboard()
    {
        $headers = [];
        $data = [
            "TestCount"=>Test::all()->count(),
            "CandiCount"=>Student::all()->count(),
            "QuestCount"=>Question::all()->count(),
        ];
        return response()->json($data, 200, $headers);
    }
    public function ChangePass()
    {
        return view("auth.repass");
    }
    public function NewPassword(Request $request)
    {
        $this->validate($request,[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $pass = $request->input("password");
        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($pass);
        if($user->update()){
            $ret = [
                "msg"=>"Измененения внесены"
            ];
        }else{
            $ret = [
                "msg"=>"Ошибка при изменении"
            ];
        }
         return redirect('/admin');
    }
    public function UserGet()
    {
        $headers = [];
        $ret = [];
        if(auth()->user()->can("users.*")){
            $ret = [
                "Users"=> User::with(['roles.permissions'])->get(),
                "Auth"=> Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray(),
                "Roles" => Role::all(),
                "Permissions"=>Permission::all()
            ];
        }

        return response()->json($ret, 200, $headers);
    }
    public function CheckUsername($name)
    {
        if(User::where("username",$name)->count() == 0){
            $ret = true;
        }else{
            $ret = false;
        }
        $headers = [];
        return response()->json($ret, 200, $headers);
    }
    public function UserCreate(Request $request)
    {
        $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'username'=>['required', 'string', 'max:255', 'unique:users']
            ]);
        $headers = [];
        $defPass = 'qwerty123';
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($defPass);
        if($res = $user->save()){
            $role = Role::find($request->role);
            $user->assignRole($role);
            $ret = [
                "msg"=>"Новый пользователь добавлен успешно",
                "pass"=>$defPass
            ];
        }else{
            $ret = [
                "msg"=> "Плохо",
                "pass"=>''
            ];
        }
        return response()->json($ret, 200, $headers);
    }
    public function UserUpdate(Request $request)
    {
        $headers = [];
        $user = User::find($request->id);
        if($user->name != $request->name){
            $user->name = $request->name; 
        }
        if($user->email != $request->email){
            $user->email = $request->email;
        }
        if($user->roles()->first()->id != $request->roles[0]["id"]){
            $role = Role::find($request->roles[0]["id"]);
            $user->roles()->detach();
            $user->assignRole($role);
        }
        if($res = $user->update()){
            $ret = [
                "msg"=>"Изменение внесены ".$res
            ];
        }else{
            $ret = [
                "msg"=> "Плохо"
            ];
        }
        return response()->json($ret, 200, $headers);
    }
    public function role()
    {
        // return Auth::user()->roles()->permissions()->pluck('roles');
        return auth()->user()->getPermissionsViaRoles()->pluck('name');
    }
    public function IsAdmin()
    {
        if(auth()->user()->can("read user") || auth()->user()->can("create user") || auth()->user()->can("delete user") ||auth()->user()->can("update user") ){
            return true;
        }else{
            return false;
        }
    }
}
