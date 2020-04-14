<div class="card rounded-0 test-result" style="width: 100%; min-height: 40%; margin-top: 50px;">
    <div class="card-body " style="padding-top: 40px">
        <div class="col-md-12 d-print-block">
            <div class="row ">
                <div class="col-md-5 text-center ">
                    Кыргыз Республикасынын Өкмөтүнө караштуу <br>Жазаларды аткаруу мамлекеттик кызматы
                </div>
                <div class="col-md-2">
                <img src="{{asset("/img/logo.png")}}" alt="" class="" style="height: 100px;">
                </div>
                <div class="col-md-5 text-center title-text-right">
                    Государственная служба исполнения наказаний при <br>Правительстве Кыргызской Республики
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4 pb-5">
            <h2 class="text-center">
                @if(session()->get("lang")=== "ru")
                Результаты тестирования
                @else
                Сыноонун жыйынтыгы
                @endif
            </h2>
            <div class="col-md-12 d-flex justify-content-between mt-5 mb-4">
                @if(session()->get("lang")=== "ru")
                <div class="d-flex ">
                    <h4>г.Бишкек</h4>
                </div>
                <div class="d-flex">
                    <h4>
                    УЦ ГСИН при ПКР
                    </h4>
                </div>
                @else
                <div class="d-flex ">
                    <h4>Бишкек ш.</h4>
                </div>
                <div class="d-flex">
                    <h4>
                    Окмотко караштуу ЖАМКнын ОБ
                    </h4>
                </div>
                @endif
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        ФИО
                    @else
                        Аты жону
                    @endif
                        <span class="badge-pill">{{$student->fn}} {{$student->mn}} {{$student->ln}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        Название теста
                        <span class="badge-pill">{{$student->test->title_ru}}</span>
                    @else
                        Сыноо аталышы
                        <span class="badge-pill">{{$student->test->title_kg}}</span>
                    @endif
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        <span>Количество вопросов</span>
                    @else
                        <span>Суроолордун саны</span>
                    @endif
                    <span class=" badge-pill">{{$student->test->question_count}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        <span>Длительность теста</span>
                    @else
                        <span>Cыноо мөөнөтү</span>
                    @endif
                    <span class="badge-pill">{{$student->test->timer}} мин.</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        <span>Начало теста</span>
                    @else
                        <span>Cыноо башталышы</span>
                    @endif
                    <span class="badge-pill">{{date("d.m.Y H:i:s", strtotime(json_decode($student->result, true)["test_start"]))}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        <span>Конец теста</span>
                    @else
                        <span>Cыноонун аягы</span>
                    @endif
                    <span class="badge-pill">{{date("d.m.Y H:i:s", strtotime(json_decode($student->result, true)["test_end"]))}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        <span>Длительность теста</span>
                    @else
                        <span>Cыноонун мөөнөтү</span>
                    @endif
                    <span class="badge-pill">{{json_decode($student->result, true)['duration']}}</span>
                </li>
            </ul>
            <br>            
            <div class="col-md-12 row justify-content-center">
            @foreach(json_decode($student->result, true)['test'] as $key=>$test)
                <div class="col-md-10 d-flex align-items-center mb-3 border-bottom" style="height: 50px;">  
                    <div class="d-flex align-items-center justify-content-center text-white border  text-center" style="height: 40px; width: 40px;">
                        @if($test['correct'] == 1)
                        <img src="{{asset('img/check.png')}}" alt="" class="h-100 w-100 p-1" >
                        @else
                        <img src="{{asset('img/close.png')}}" alt="" class="h-100 w-100 p-1">
                        @endif                        
                    </div>                 
                    <div class="media-body ml-3">
                        <h5 class="m-0">
                            @if(session()->get("lang")=== "ru")<i class="text-secondary">Вопрос:</i>@else<i>Суроо:</i> @endif<b> &nbsp;{{$test['question']}}</b></h5>
                            @if(session()->get("lang")=== "ru")<i class="text-secondary ml-2">ответ:</i>@else<i class="text-secondary ml-2">жооп:</i> @endif &nbsp; <i>{{$test['user_answer']}}</i> 
                    </div>
                </div>
            @endforeach
            </div>            
        </div>
    </div>
</div>
