<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Test;
use App\Question;

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
            if($student != null){
                return view("start", ["student"=>$student]);
            }

        }
        return redirect()->back()->withErrors($valid);
    }

    public function StudentAdd(Request $request)
    {
        $fn = $request->get("fn");
        $mn = $request->get("mn");
        $ln = $request->get("ln");
        $test_id = $request->get("test");

        $rules = [
            "fn"=> "string|required",
            "mn"=> "string|required",
            "ln"=> "string|nullable",
        ];

        if($this->validate($request, $rules, [])){
            $student = new Student();
            $student->fn=$fn;
            $student->mn=$mn;
            $student->ln=$ln;
            $student->point="0";
            $student->test_id=$test_id;
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

        return redirect()->back()->withErrors($ret)->withInput();
    }
}
