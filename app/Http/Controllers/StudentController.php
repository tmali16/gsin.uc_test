<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Test;
use App\Question;
use App\Setting;

class StudentController extends Controller
{
    //

    public function index(Request $request)
    {
        $rules = [
            "code"=>'exists:App\Student,code',
            "lang"=>'string',
        ];
        session(["lang"=> $request->get("lang")]);

        $msg = [
          "exists"=>'Неверно введен код',
          "lang"=>'Выберите язык',
        ];
        $valid = $this->validate($request, $rules, $msg);
        if($this->validate($request, $rules, $msg)) {
            $student = Student::where("code", $request->get("code"))->with(["test"])->first();
            session(["student_id"=>$student->id]);
            if ($student != null && $student->passed != 0) {
                return redirect('/test/finish'); 
            }else{
                if($student != null && $student->passed != 1){
                    return view("start", ["student"=>$student]);
                }else{
                    return redirect()->back();
                }
            }
        }
        return redirect()->back()->withErrors($valid);
    }
    public function CandidateGet()
    {
        $user = Student::with('test')->get();
        $settings = Setting::all();
        $data = [
            'user'=>$user,
            'settings'=>$settings,
        ];
        $headers = [];
        return response()->json($data, 200, $headers);
    }
    public function CandidateAdd(Request $request)
    {
        $rules = ["fn"=> "string|required","mn"=> "string|required","ln"=> "string|nullable",];
        if($this->validate($request, $rules, [])){
            $student = new Student();
            $student->fn=$request->fn;
            $student->ln=$request->ln;
            $student->mn=$request->mn;
            $student->code = random_int(00000, 99999);
            $student->point="0";
            $student->test_id=$request->test_id;
            $student->user_id=Auth::id();
            if($student->save()){         
                $ret = [
                    "status"=>"ok",
                    "msg"=>"Тестируемый добавлен",
                ];
            }else{
                $ret = [
                    "status"=>"error",
                    "msg"=>"Тестируемый добавлен",
                ];
            }
        }else {
            $ret = [
                "status"=>"error",
                "msg"=>"Ошибка заполнения",
            ];
        }
        $headers = [];
        return response()->json($ret, 200, $headers);
    }
    public function CandiUpdate(Request $request)
    {
        $student = Student::find($request->id);
        $headers = [];
        $rules = ["fn"=> "string|required","mn"=> "string|required","ln"=> "string|nullable",];
        if($this->validate($request, $rules, [])){
            $student->fn = $request->fn;
            $student->mn = $request->mn;
            $student->ln = $request->ln;
            $student->test_id = $request->test_id;
            $student->user_id = Auth::id();
            if($student->update()){
                $ret["msg"] = "Изменение добавлены";
                $ret["code"] = "status";
            }else{
                $ret["msg"] = "Ошибка при изменении";
                $ret["code"] = "status";
            }
        }
        return response()->json($ret, 200, $headers);
    }
    public function CandidateTrash($id)
    {
        $student = Student::find($id);
        $headers = [];
        if($student != null){
            if($student->answer()->count() > 0){
                if($student->answer()->delete()){
                    $ret["msg"] = "Данные удалены";
                    $ret["code"] = "200";                
                }else{
                    $ret["msg"] = "Ошибка при удалении";
                    $ret["code"] = "500";
                }
            }else{
                try{
                    //;
                    if($student->delete()){
                        $ret["msg"] = "Данные удалены";
                        $ret["code"] = "200";                
                    }else{
                        $ret["msg"] = "Ошибка при удалении";
                        $ret["code"] = "500";
                    }
                }catch (\Illuminate\Database\QueryException $e){
                    $ret["msg"] = $e;
                    $ret["code"] = "500";
                }
            }
        }else{
            $ret["msg"] = "Данные не найдены";
            $ret["code"] = "500";
        }
        return response()->json($ret, 200, $headers);        
    }
}
