<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Test;
use App\Answer;
use App\Student;

class TestController extends Controller
{
    //

    public function TestAdd(Request $request)
    {
      //  dd($request->all());
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
          $test = new Test();
          $test_state = ($request->get("test_state") == "on" ? 1 : 0);
          $quest_rand = ($request->get("quest_rand") == "on" ? 1 : 0);
          $test->title_kg = $request->get("title_kg");
          $test->title_ru = $request->get("title_ru");
          $test->description_kg = $request->get("description_kg");
          $test->description_ru = $request->get("description_ru");
          $test->user_id = Auth::id();
          $test->question_rand = $quest_rand;
          $test->question_count = $request->get("quest_count");
          $test->timer = $request->get("timer");
          $test->state = $test_state;
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
      return redirect()->back()->withErrors($ret)->withInput();
    }

    public function start(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        session()->put(["start_date"=>now()]);
        return view("test", ["test_id"=>$id, "test"=>$test]);
    }

    public function showQuestion(Request $request, $id)
    {
        $lang = session()->get("lang");
        $student_id = session()->get("student_id");
        $test = Test::findOrFail($id);
        $quest = Question::where("test_id", "=", $id)->select("id","question_$lang as quest", "a_$lang as var_a", "b_$lang as var_b","c_$lang as var_c","d_$lang as var_d")->orderByRaw("RAND()")->take($test->question_count)->get();
        $f_quest = collect();
        $f_quest = $f_quest->push($quest)->shuffle();
        $f_quest = $f_quest->flatten()->shuffle();

        return response()->json(["test"=>$test, "questions"=>$f_quest, "btn_name"=>($lang == "ru" ? "Ответить" : "Жоопберуу"), "student_id" => $student_id] );

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
                if(count($results) == $index){
                    $student->result = json_encode([
                        "test_name"=> $lang == "ru" ? Test::find($test_id)->title_ru :Test::find($test_id)->title_kg ,
                        "test_start"=>$start_date,
                        "test_end"=>$end_date,
                        "duration"=>$start_date->diffInMinutes($end_date),
                        "test"=>$test_res
                    ]);
                    $student->update();
                }


            }


            session()->put(["student_id"=>$student_id]);
            //return view("finish", ["point"=>$point]);
        }
    }

    public function finishTest(Request $request){
        
        $point = session()->get("point");
        $stud_id = session()->get("student_id");
        $student = Student::find($stud_id);   

        return view("finish", ["student"=>$student]);
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
            case "d":
                return $lang == "ru" ? $q->d_ru  : $q->d_kg;
                break;
            default:
                return "None";
        }
    }
}
