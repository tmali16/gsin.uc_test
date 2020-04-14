<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use App\Student;


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
        $students = Student::where("point", ">=", 0)->paginate(1);
        $tests = Test::with(["question"])->paginate(1);

        return view('admin.index', ["students"=>$students, "tests"=>$tests]);
    }
}
