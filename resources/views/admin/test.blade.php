<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 bg-dark p-2 ">
            <button class="ml-auto btn btn-sm btn-primary rounded-0" data-toggle="collapse" data-target="#collapseNewStudent" role="button" aria-expanded="false" aria-controls="collapseNewStudent">
                Добавить тест
            </button>
        </div>
        <div class="col-md-8 collapse p-4" id="collapseNewStudent">
            <div class="card rounded-0">
                <div class="card-header p-1 text-center">
                    <h4>
                        Новый тест
                    </h4>
                </div>
                <div class="card-body">
                    <form class="row" action="/new/test/add" method="post">
                        @csrf
                        <div class="col-sm-6 form-group">
                            <label for="title_kg">Тестин аталышы *</label>
                            <input type="text" class="form-control form-control-sm rounded-0" id="title_kg" value="{{old("title_kg")}}" name="title_kg" placeholder="Тестин аталышы" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="title_ru">Название теста *</label>
                            <input type="text" class="form-control form-control-sm rounded-0" value="{{old("title_ru")}}" placeholder="Название теста" name="title_ru" id="title_ru" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="description_kg">Баяндоо</label>
                            <textarea class="form-control col" rows="2" id="description_kg" name="description_kg" value="{{old("description_kg")}}"> </textarea>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="description_ru">Описание</label>
                            <textarea class="form-control col" rows="2" id="description_ru" name="description_ru" value="{{old("description_ru")}}"> </textarea>
                        </div>                        
                        <div class="col-sm-6  ">
                            <label for="description_ru"><b>Состояние теста</b></label>
                            <div class="form-group form-check pl-5">
                                <input type="checkbox" class="form-check-input " id="test_state" onchange="test_state()" name="test_state" @if(old("test_state"))checked="checked" @endif/>
                                <label for="test_state" class="form-check-label" id="test_stateform-check-label">Включить</label>
                            </div>
                            <label for=""><b>Вопросы</b></label>
                            <div class="form-group form-check pl-5">
                                <input type="checkbox" class="form-check-input " id="quest_rand" onchange="quest_rand()" name="quest_rand" @if(old("quest_rand"))checked="checked" @endif/>
                                <label for="quest_rand" class="form-check-label" id="quest_randform-check-label">по порядку</label>
                            </div>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="timer">Длительность теста*</label>
                            <input type="number" class="form-control form-control-sm rounded-0" placeholder="Длительность теста" name="timer" id="timer" value="{{old("timer")}}" required>
                        
                            <label for="quest_count">Количество вопросов в тесте*</label>
                            <input type="number" class="form-control form-control-sm rounded-0" placeholder="Количество вопросов в тесте" name="quest_count" value="{{old("quest_count")}}" id="quest_count" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary rounded-0 float-right">Добавить</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mt-3 ">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Состояние</th>
                        <th scope="col">Длительность</th>
                        <th scope="col">Количество вопросов</th>
                        <th scope="col">Вопросы</th>
                        <th scope="col">Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($tests as $item)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>>{{ $item->title_kg }}<br>>{{$item->title_ru}}</td>
                                <td>>{{ $item->description_kg}}<br>>{{ $item->description_ru}} </td>
                                <td>{{ ($item->state == 1 ? "Включена" : "Отключена")}}</td>
                                <td>{{ $item->timer}}</td>
                                <td>{{ $item->question_count}}</td>
                                <td>{{ $item->question_rand}}</td>
                                <td>{{ $item->created_at}}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

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