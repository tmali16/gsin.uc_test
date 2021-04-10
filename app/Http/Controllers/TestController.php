<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use PDF;
use App\Test;
use App\Answer;
use App\Student;
use App\Setting;


class TestController extends Controller
{
    //
    public function __construct()
    {
        
    }

    public function TestAdd(Request $request)
    {
        
      $rules = [
        "title_kg"=>"required",
        "title_ru"=>"required",
        "description_kg"=>"nullable",
        "description_ru"=>"nullable",
        "test_state"=>"nullable",
        "quest_rand"=>"nullable",
        "timer"=>"integer|nullable",
        "quest_count"=>"integer|nullable",
        "min_correct"=>"required|integer"
      ];

      if($this->validate($request, $rules, [])){
          $test = new Test();          
          $test->title_kg = $request->title_kg;
          $test->title_ru = $request->title_ru;
          $test->description_kg = $request->description_kg;
          $test->description_ru = $request->description_ru;
          $test->question_rand = $request->question_rand;
          $test->question_count = $request->question_count;
          $test->timer = $request->timer;
          $test->min_correct = $request->min_correct;
          $test->state = $request->state;
          $test->user_id = Auth::id();
          if($test->save()){
            $ret = [
                "status"=>"ok",
                "msg"=>"Тестируемый добавлен",
            ];
          }else {
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
    public function TestGet()
    {        
        $test = Test::with('question')->get();
        $headers = [];
        return response()->json($test, 200, $headers);
    }
    public function TestStateChng($id, $state)
    {
        return $state;
    }
    public function TestUpdate(Request $request)
    {
        $rules = [
            "title_kg"=>"required",
            "title_ru"=>"required",
            "description_kg"=>"nullable",
            "description_ru"=>"nullable",
            "test_state"=>"nullable",
            "quest_rand"=>"nullable",
            "timer"=>"integer|nullable",
            "quest_count"=>"integer|nullable",
          ];
    
          if($this->validate($request, $rules, [])){
                $test = Test::find($request->id);
                $test->title_kg = $request->title_kg;
                $test->title_ru = $request->title_ru;
                $test->description_kg = $request->description_kg;
                $test->description_ru = $request->description_ru;
                $test->question_rand = $request->question_rand;;
                $test->question_count = $request->question_count;
                $test->min_correct = $request->min_correct;
                $test->timer = $request->timer;
                $test->state = $request->state;
                if($test->update()){
                    $ret["msg"] = "Изменение добавлены";
                    $ret["code"] = "status";
                }else{
                    $ret["msg"] = "Ошибка при изменении";
                    $ret["code"] = "status";
                }
          }
          $headers = [];
        return response()->json($ret, 200, $headers);
    }
    public function TestDelete($id)
    {
        $test = Test::find($id);
        $test->deleted_at = now();
        if($test->update()){
            $ret["msg"] = "Удалено";
            $ret["code"] = "status";
        }else{
            $ret["msg"] = "Ошибка при удалении";
            $ret["code"] = "status";
        }
        $headers = [];
        return response()->json($ret, 200, $headers);
    }
    public function start(Request $request, $id)
    {
        $candi = Student::where("code", $id)->first();
        if($candi->passed != 1){
            $test = Test::findOrFail($candi->test->id);
            session()->put(["start_date"=>now()]);
            return view("test", ["test_id"=>$test->id, "test"=>$test]);
        }else{
            session()->put(["student_id"=>$id]);
            return redirect('/test/finish');
        }
        
    }

    public function showQuestion(Request $request, $id)
    {
        $lang = session()->get("lang");
        $student_id = session()->get("student_id");
        $test = Test::where('id',$id)->select("id", "title_$lang as title", "description_$lang as description", "state", "timer","question_count", "min_correct", "question_rand")->first();
        $quest = Question::where("test_id", "=", $id)->select("id","question_$lang as quest", "a_$lang as var_a", "b_$lang as var_b","c_$lang as var_c","d_$lang as var_d")->get();
        if($test->question_rand == 1){
            $f_quest = collect();
            $f_quest = $f_quest->push($quest)->shuffle();
            $f_quest = $f_quest->flatten()->shuffle();
        }else{
            $f_quest = $quest;
        }
        return response()->json(
            [
            "test"=>$test, 
            "questions"=>$f_quest->take($test->question_count), 
            "btn_name"=>($lang == "ru" ? "Ответить" : "Жоопберүү"), "student_id" => $student_id,
            "lang"=>$lang
            ]);
    }
    
    public function finishTestStore(Request $request)
    {
        $lang = session()->get("lang");
        if($request->ajax()) {
            $results = $request->result;
            $student_id = $request->student_id;
            $point = 0;
            $start_date = session()->get("start_date");
            $end_date = now();
            $index = 0;
            $test_res = [];
            foreach ($results as $result) {
                $student_id = $result['student_id'];
                $test_id = $result['test_id'];
                $user_answer = $result['user_answer'];
                $question_id = $result['question_id'];
                $quest_answer = Question::find($question_id);
                $test = Test::find($test_id);
                $student = Student::find($student_id);
                $answer = new Answer();
                $answer->question_id = $question_id;
                $answer->student_id = $student_id;
                $answer->student_answer = $user_answer;
                $answer->test_id = $test_id;
                $answer->answer = $quest_answer->answer;
                $answer->save();
                $te = [
                  "question"=> $lang == "ru" ?$quest_answer->question_ru  : $quest_answer->question_kg,
                  "user_answer"=> $this->userAnser($user_answer, $question_id),
                  "correct"=>$user_answer == $quest_answer->answer ? 1 : 0
                ];

                if ($user_answer == $quest_answer->answer) {
                    $point++;
                    $student->point = $point;
                    $student->update();
                }
                $test_res[] = $te;
                $index++;
                $duration = ($start_date->diffInMinutes($end_date) == 0 ? $start_date->diffInSeconds($end_date) ." сек." : $start_date->diffInMinutes($end_date) ." мин.") ;
                if(count($results) == $index){
                    $student->result = json_encode([
                        "test_name"=> $lang == "ru" ? Test::find($test_id)->title_ru :Test::find($test_id)->title_kg ,
                        "test_start"=>$start_date,
                        "test_end"=>$end_date,
                        "duration"=>$duration,
                        "test"=>$test_res
                    ]);
                    $student->update();
                }
            }
            $student->passed = 1;
            $student->update();
            session()->put(["student_id"=>$student_id]);
            session()->forget("start_date");
        }
    }
    public function ChangeLang(Request $request, $lang)
    {
        $l = session()->get("lang");
        session()->forget("lang");
        switch ($lang) {
            case 'kg':
                $l = 'kg';
                break;
            
            default:
                $l = 'ru';
                break;
        }
        session()->put(["lang"=>$l]);
        return redirect()->back();
    }
    public function finishTest(Request $request){
        
        $point = session()->get("point");
        $stud_id = session()->get("student_id");
        $student = Student::find($stud_id);   
        $settings = Setting::all();
        // $request->session()->flush();
        return view("finish", ["student"=>$student, "settings"=>$settings]);
    }
    public function toPDF()
    {
        $stud_id = session()->get("student_id");
        $student = Student::find($stud_id); 
        $pdf = PDF::loadView('admin.layouts.topdf', ["student"=>$student]);
        // $pdf->save(storage_path().'_filename.pdf');
        // return $pdf->download('customers.pdf');
        return view('admin.layouts.topdf', ["student"=>$student]);
    }
    public function print()
    {
        $point = session()->get("point");
        $stud_id = session()->get("student_id");
        $student = Student::find($stud_id);  
        $settings = Setting::all();
        return view('layouts.print',["student"=>$student, "settings"=>$settings]);
    }
    public function userAnser($answer, $question_id)
    {
        $lang = session()->get("lang");
        $q = Question::find($question_id);
        switch ($answer){
            case "A":
                return $lang == "ru" ? $q->a_ru  : $q->a_kg;
                break;
            case "B":
                return $lang == "ru" ? $q->b_ru  : $q->b_kg;
                break;
            case "C":
                return $lang == "ru" ? $q->c_ru  : $q->c_kg;
                break;
            case "D":
                return $lang == "ru" ? $q->d_ru  : $q->d_kg;
                break;
            default:
                return "None";
        }
    }
    
}
