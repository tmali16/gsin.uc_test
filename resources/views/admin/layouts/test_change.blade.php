@extends("layouts.app")


@section("nav")
@include("admin.nav")
@endsection
@section("content")
    <div class="container pt-4 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow rounded-0">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-10 pt-4">
                <h2 class="col p-3 shadow">{{$test->title_ru}}</h2>
            </div>
            <div class="col-md-10 mt-3">                
                <div class="card rounded-0 mt-3 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">
                        <form action="/update/test/{{$test->id}}" method="post" class="row">
                            @csrf
                            <div class="col-sm-6 form-group">
                                <label for="title_kg">Тестин аталышы *</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="title_kg" value="{{$test->title_kg}}" name="title_kg" placeholder="Тестин аталышы" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="title_ru">Название теста *</label>
                                <input type="text" class="form-control form-control-sm rounded-0" value="{{$test->title_ru}}" placeholder="Название теста" name="title_ru" id="title_ru" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="description_kg">Баяндоо</label>
                                <textarea class="form-control col" rows="2" id="description_kg" name="description_kg">{{$test->description_kg}}</textarea>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="description_ru">Описание</label>
                                <textarea class="form-control col" rows="2" id="description_ru" name="description_ru" >{{$test->description_ru}}</textarea>
                            </div>                        
                            <div class="col-sm-6  ">
                                <label for="description_ru"><b>Состояние теста</b></label>
                                <div class="form-group form-check pl-5">
                                    <input type="checkbox" class="form-check-input " id="test_state" onchange="test_state()" name="test_state" @if($test->state == 1)checked="checked" @endif/>
                                    <label for="test_state" class="form-check-label" id="test_stateform-check-label">Включить </label>
                                </div>
                                <label for=""><b>Вопросы</b></label>
                                <div class="form-group form-check pl-5">
                                    <input type="checkbox" class="form-check-input " id="quest_rand" onchange="quest_rand()" name="quest_rand" @if($test->question_rand)checked="checked" @endif/>
                                    <label for="quest_rand" class="form-check-label" id="quest_randform-check-label">по порядку</label>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="timer">Длительность теста*</label>
                                <input type="number" class="form-control form-control-sm rounded-0" placeholder="Длительность теста" name="timer" id="timer" value="{{$test->timer}}" required>
                            
                                <label for="quest_count">Количество вопросов в тесте*</label>
                                <input type="number" class="form-control form-control-sm rounded-0" placeholder="Количество вопросов в тесте" name="quest_count" value="{{$test->question_count}}" id="quest_count" required>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary rounded-0 float-right btns-shadow">Сохранить</button>
                            </div>                            
                        </form>
                    </div>
                </div>
                <br>
                <a href="/admin" class="btn btn-sm btn-success rounded-0 btns-shadow">Назад</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function test_state() {
           const inp = document.getElementById("test_state").checked;

           if(inp){
            document.getElementById("test_stateform-check-label").textContent = "Отлючить";
           }else{
            document.getElementById("test_stateform-check-label").textContent = "Включить";
           }
        }
        function quest_rand() {
           const inp = document.getElementById("quest_rand").checked;

           if(inp){
            document.getElementById("quest_randform-check-label").textContent = "по порядку";
           }else{
            document.getElementById("quest_randform-check-label").textContent = "Случайные";
           }
        }
    </script>
@endsection