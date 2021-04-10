<div class="card border-0 test-result" style="width: 100%; min-height: 40%; margin-top: 50px;">
    {{-- <div class="card-header">
        <a href="/test/finish/download" class="btn btn-sm btn-link bg-success">Скачать</a>
    </div> --}}
    <div class="card-body " style="padding-top: 40px">
        <div class="col-md-12 d-print-block">
            <div class="row ">
                <div class="col-md-5 col-sm-5 col-lg-5 text-center ">
                    {{-- Кыргыз Республикасынын Өкмөтүнө караштуу <br>Жазаларды аткаруу мамлекеттик кызматы --}}
                    <h3>
                        {{$settings->where("key", "gsin_name")->where('lang',"kg")->first()->mark}}
                    </h3>
                </div>
                <div class="col-md-2 col-sm-2 col-lg-2 text-center">
                <img src="{{asset("/img/logo.png")}}" alt="" class="" style="height: 100px;">
                </div>
                <div class="col-md-5 col-sm-5 col-lg-5 text-center title-text-right">
                    {{-- Государственная служба исполнения наказаний при <br>Правительстве Кыргызской Республики --}}
                    <h3>
                        {{$settings->where("key", "gsin_name")->where('lang',"ru")->first()->mark}}
                    </h3>
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
                    КР Өкмөтүнө караштуу ЖАМКнын ОБ
                    </h4>
                </div>
                @endif
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        ФИО
                    @else
                        Аты жөнү
                    @endif
                        <span class="badge-pill">{{$student->fn}} {{$student->mn}} {{$student->ln}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if(session()->get("lang")=== "ru")
                        Название теста
                        <span class="badge-pill" style="word-wrap: break-word; width: 65%; text-align: justify;">{{$student->test->title_ru}}</span>
                    @else
                        Сыноо аталышы
                        <span class="badge-pill " style="word-wrap: break-word; width: 65%; text-align: justify;">{{$student->test->title_kg}}</span>
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
            <div class="col-md-12 row justify-content-center text-center">
                <h4>
                    @if($student->point >= $student->test->min_correct)
                        @if(session()->get("lang")=== "ru")
                            <span class="text-success">Тест сдал</span>
                        @else
                            <span class="text-success">Сынактан өттүү</span>
                        @endif
                    @else
                        @if(session()->get("lang")=== "ru")
                            <span class="text-danger">Тест не сдал</span>
                        @else
                            <span class="text-danger">Сынактан өткөн жок</span>
                        @endif                        
                    @endif
                    <br>
                    <span class="text-secondary ">{{$student->point ." / ".$student->test->question_count}}</span>
                </h4>
            </div>
            <div class="col-md-12 row mt-4">
                <div class="col-md-12">
                    @if(session()->get("lang")=== "ru") <b>Начальник</b> @else <b>Жетекчи</b> @endif
                </div>
                <div class="col-md-12 d-flex justify-content-between @if($settings->where('key','zvan')->where('lang',session()->get("lang"))->first()->values) mt-3 @endif">
                    <span class="border-bottom justify-content-start border-dark" style="width: 250px">
                    {{$settings->where('key','zvan')->where('lang',session()->get("lang"))->first()->values}}
                    </span>
                    <div class="justify-content-end " style="width: 300px">
                        <label for="" style="width: 200px" class="border-bottom border-dark float-right">
                            {{$settings->where('key','boss')->where('lang', session()->get("lang"))->first()->values}}
                        </label>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-between mt-2">
                    <div class=""></div>
                    <div class="d-flex " style="width: 300px"><span class="float-left">{{  date("d.m.Y")}} {{session()->get("lang")=== "ru" ? 'г.' :'ж.'}}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
