@extends("layouts.app")


@section("nav")
@include("admin.nav")
@endsection
@section("content")
    <div class="container pt-4 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 pt-4">
                <h2 class="col">{{$test->title_ru}}</h2>
                <p class="col">
                    {{$test->description_ru}}
                </p>
            </div>
            <div class="col-md-10 mt-3">
                <button class="btn btn-success rounded-0 btn-sm" data-toggle="modal" data-target="#QuestionModalAdd">Добавить вопрос</button>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="alert alert-success">
                {!! Session::has('msg') ? Session::get("msg")['msg'] : '' !!}
                </div>
                <div class="card rounded-0 mt-3 border-0">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Вопрос</th>
                                    <th>Варианты</th>
                                    <th>Жооптор</th>
                                    <th>Правельный ответ</th>
                                    <th>Дата создания</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($test->question as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->question_ru}}<br>{{$item->question_kg}}</td>
                                        <td>А) {{$item->a_ru}}<br>Б) {{$item->b_ru}}<br>В) {{$item->c_ru}}<br>Г) {{$item->d_ru}}</td>
                                        <td>А) {{$item->a_kg}}<br>Б) {{$item->b_kg}}<br>В) {{$item->c_kg}}<br>Г) {{$item->d_kg}}</td>
                                        <td>{{$item->answer}}</td>
                                        <td>{{$item->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <br>
                <a href="/admin" class="btn btn-sm btn-success rounded-0">Назад</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade " id="QuestionModalAdd" tabindex="-1" role="dialog" aria-labelledby="QuestionModalAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content rounded-0 border-0">
                <div class="modal-body">
                    <form action="/new/question/add/{{$test->id}}/store" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="question_kg"><b>Суроо: *</b></label>
                                    <textarea class="form-control form-control-sm rounded-0" id="question_kg" aria-describedby="question_kg" name="question_kg" required value="{{old("question_kg")}}" >
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="question_ru"><b>Вопрос: *</b></label>
                                    <textarea class="form-control form-control-sm rounded-0" id="question_ru" aria-describedby="question_ru" name="question_ru" required value=" {{old("question_ru")}}">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row ml-2">
                                    <label for="a_kg"><b>A) *</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="a_kg" aria-describedby="a_kg" name="a_kg" required value="{{old("a_kg")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="b_kg"><b>Б) *</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="b_kg" aria-describedby="b_kg" name="b_kg" required value="{{old("b_kg")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="c_kg"><b>В) &nbsp;</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="c_kg" aria-describedby="c_kg" name="c_kg" value="{{old("c_kg")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="d_kg"><b>Г) &nbsp;</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="d_kg" aria-describedby="d_kg" name="d_kg" value="{{old("d_kg")}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row ml-2">
                                    <label for="a_ru"><b>A) *</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="a_ru" aria-describedby="a_ru" name="a_ru" required value="{{old("a_ru")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="b_ru"><b>Б) *</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="b_ru" aria-describedby="b_ru" name="b_ru" required value="{{old("b_ru")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="c_ru"><b>В) &nbsp;</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="c_ru" aria-describedby="c_ru" name="c_ru" value="{{old("c_ru")}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <label for="d_ru"><b>Г) &nbsp;</b></label>
                                    <div class="col-sm-11 mr-0 pr-0">
                                        <input type="text" class="form-control form-control-sm rounded-0 pt-0 pb-0" id="d_ru" aria-describedby="d_ru" name="d_ru" value="{{old("d_ru")}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 border-top">
                                <div class="form-group">
                                    <b><label for="answer ">Правельный ответ: *</label></b>
                                    <select class="form-control form-control-sm rounded-0" id="answer" name="answer">
                                        <option value="A" @if(old("answer") === "A") selected @endif>A</option>
                                        <option value="B" @if(old("answer") === "B") selected @endif>Б</option>
                                        <option value="C" @if(old("answer") === "C") selected @endif>В</option>
                                        <option value="D" @if(old("answer") === "D") selected @endif>Г</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <button class="btn btn-sm btn-success float-right rounded-0 ml-2 shadow-sm">Сохранить</button>
                                <input type="reset" class="btn btn-sm ml-auto btn-light float-right rounded-0 shadow-sm">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection