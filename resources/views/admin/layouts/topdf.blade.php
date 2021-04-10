<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'GSIN-TestTer') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="/font/Montserrat/Montserrat-Medium.ttf" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="row" style="font-size: 14px;">
    <div class="col-md-12" >
        <div class="row p-0 m-0">
            <div class="col-md-5 text-center ">
                Кыргыз Республикасынын Өкмөтүнө караштуу <br>Жазаларды аткаруу мамлекеттик кызматы
            </div>
            <div class="col-md-2 text-center">
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
                Өкмөтүнө караштуу ЖАМКнын ОБ
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
                    <span class="badge-pill" style="word-wrap: break-word; width: 300px">{{$student->test->title_ru}}</span>
                @else
                    Сыноо аталышы
                    <span class="badge-pill " style="word-wrap: break-word; width: 300px">{{$student->test->title_kg}}</span>
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
                        <span class="text-success">Сынактан өттү</span>
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
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>