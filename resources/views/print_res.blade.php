<div class="col-md-12 d-print-block printsBlock">
    <div class="row ">
        <div class="col-md-5 col-sm-5 col-lg-5 text-center ">            
            <h2>
            {{$settings->where("key", "gsin_name")->where('lang',"kg")->first()->values}}
            </h2>
        </div>
        <div class="col-md-2 col-sm-2 col-lg-2 text-center">
        <img src="{{asset("/img/logo.png")}}" alt="" class="" style="height: 100px;">
        </div>
        <div class="col-md-5 col-sm-5 col-lg-5 text-center title-text-right">            
            <h2>
                {{$settings->where("key", "gsin_name")->where('lang',"ru")->first()->values}}
            </h2>            
        </div>
    </div>
</div>
<div class="col-md-12 mt-4 pb-5 printsBlock">
    <h2 class="text-center">
        @if(session()->get("lang")=== "ru")
        Результаты тестирования
        @else
        Сыноонун жыйынтыгы
        @endif
    </h2>
    <div class="col-md-12 d-flex justify-content-between mt-5 mb-4">        
        <div class="d-flex ">
            @if(session()->get("lang")=== "ru")
            <h4>г.Бишкек</h4>
            @else
            <h4>Бишкек ш.</h4>
            @endif
        </div>
        <div class="d-flex">
            <h4>
            {{$settings->where("key", "test_place")->where('lang', (session()->get("lang") ?? 'kg'))->first()->values}}
            </h4>
        </div>         
    </div>
    <ul class="list-group list-group-flush ">
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>ФИО</b>
            @else
                <b>Аты жөнү</b>
            @endif
                <span class="badge-pill">{{$student->fn}} {{$student->mn}} {{$student->ln}}</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Название теста</b>
                <span class="badge-pill" style="word-wrap: break-word; width: 65%; text-align: justify;">{{$student->test->title_ru}}</span>
            @else
                <b>Сыноо аталышы</b>
                <span class="badge-pill " style="word-wrap: break-word; width: 65%; text-align: justify;">{{$student->test->title_kg}}</span>
            @endif
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Количество вопросов</b>
            @else
                <b>Суроолордун саны</b>
            @endif
            <span class=" badge-pill">{{$student->test->question_count}}</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Длительность теста</b>
            @else
                <b>Cыноо мөөнөтү</span></b>
            @endif
            <span class="badge-pill">{{$student->test->timer}} мин.</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Начало теста</b>
            @else
               <b>Cыноо башталышы</b>
            @endif
            <span class="badge-pill">{{date("d.m.Y H:i:s", strtotime(json_decode($student->result, true)["test_start"]))}}</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Конец теста</b>
            @else
                <b>Cыноонун аягы</b>
            @endif
            <span class="badge-pill">{{date("d.m.Y H:i:s", strtotime(json_decode($student->result, true)["test_end"]))}}</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
            @if(session()->get("lang")=== "ru")
                <b>Длительность теста</b>
            @else
                <b>Cыноонун мөөнөтү</b>
            @endif
            <span class="badge-pill">{{json_decode($student->result, true)['duration']}}</span>
        </li>
    </ul>
    <br>
    <div class="col-md-12 row justify-content-center text-center">
        <h4>
            @if($student->point >= $student->test->min_correct)
                <span class="text-success TestState">
                @if(session()->get("lang")=== "ru")
                    Тест сдал
                @else
                    Сынактан өттүү
                @endif
                </span>
            @else
                <span class="text-danger TestState">
                @if(session()->get("lang")=== "ru")
                    Тест не сдал</span>
                @else
                    Сынактан өткөн жок
                @endif              
                </span>          
            @endif
            <br>
            <span class="text-secondary " style="font-size: 32px; color:rgba(0, 0, 0, 0.5)">{{$student->point ." / ".$student->test->question_count}}</span>
        </h4>
    </div>
    <div class="col-md-12 row mt-4">
        <div class="col-md-12">
            @if(session()->get("lang")=== "ru") <b>Начальник</b> @else <b>Жетекчи</b> @endif
        </div>
        <div class="col-md-12 d-flex justify-content-between mt-3">
            <span class="border-bottom justify-content-start border-dark" style="width: 250px">
            {{$settings->where('key','zvan')->where('lang',session()->get("lang") ?? 'kg')->first()->values}}
            </span>
            <div class="justify-content-end " style="width: 300px">
                <label for="" style="width: 200px" class="border-bottom border-dark float-right">
                    {{$settings->where('key','boss')->where('lang', session()->get("lang") ?? 'kg')->first()->values}}
                </label>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-between mt-2">
            <div class=""></div>
            <div class="d-flex " style="width: 450px"><span class="float-left">{{  date("d.m.Y")}} {{session()->get("lang")=== "ru" ? 'г.' :'ж.'}}</span></div>
        </div>
    </div>
</div>

<style>
div{
    color: black !important;
    font-size: 28px;
}
.TestState{
    font-size: 44px;
    font-weight: bold;
}
@media print{
div{
    color: black !important;
    font-size: 28px;
}
.TestState{
    font-size: 44px;
    font-weight: bold;
}
.printsBlock{
    display: block !important;
}
.list-group-item{
    border: 1px solid rgba(0, 0, 0, 1);
}
}
</style>