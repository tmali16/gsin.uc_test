<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Test;
use App\Student;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $test = Test::where('id', $id)->with(["question"])->first();
        
        return view("admin.layouts.add_question", ["test"=>$test]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {

        $rules = [
            "question_ru"=>"required",
            "question_kg"=>"required",
            "a_kg"=>"required",
            "a_ru"=>"required",
            "b_ru"=>"required",
            "b_kg"=>"required",
            "c_ru"=>"nullable",
            "c_kg"=>"nullable",
            "d_ru"=>"nullable",
            "d_kg"=>"nullable",
            "answer"=>"required",

        ];
        if($this->validate($request, $rules, [])){
            $question = new Question();
            $question->question_ru = $request->question_ru;
            $question->question_kg = $request->question_kg;
            $question->a_ru = $request->a_ru;
            $question->a_kg = $request->a_kg;
            $question->b_ru = $request->b_ru;
            $question->b_kg = $request->b_kg;
            $question->c_kg = $request->c_kg;
            $question->c_ru = $request->c_ru;
            $question->d_kg = $request->d_kg;
            $question->d_ru = $request->d_ru;
            $question->answer = $request->answer;
            $question->test_id = $id;
            if($question->save()){
                $ret = [
                    "status"=>"ok",
                    "msg"=>"Вопросы и варианты добавлены успешно",
                ];
            }else{
                $ret = [
                    "status"=>"error",
                    "msg"=>"Ошибка вопросы и варианты не добавлены",
                ];
            }
        }else{
            $ret = [
                "status"=>"error",
                "msg"=>"Ошибка вопросы и варианты не добавлены",
            ];
        }
        return redirect()->back()->with("msg",$ret);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
