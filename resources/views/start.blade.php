@extends("layouts.app")
@section("content")
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="card rounded-0 shadow-lg border-0">
                <div class="card-body text-center">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-12 border-bottom-1">
                           <h3>{{$student->fn}} {{$student->mn}} {{$student->ln}}</h3>
                           <br>
                           @if(session()->get("lang")=== "ru")
                           <h5>Электронное тестирование</h5>
                           @else
                           <h5>Электрондук сыноо</h5>
                           @endif
                        </div>
                        <div class="col-md-12 mt-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if(session()->get("lang")=== "ru")
                                    Название теста
                                    <span class="badge-pill" style="word-wrap: break-word; width: 300px">{{$student->test->title_ru}}</span>
                                    @else
                                        Сыноонун аталышы
                                        <span class="badge-pill" style="word-wrap: break-word; width: 300px">{{$student->test->title_kg}}</span>
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
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <a href="/start/{{$student->code}}/{{session()->get("lang")}}" class="btn btn-success btn-sm rounded-0 w-25"  id="start_test-btn" >
                                @if(session()->get("lang")=== "ru")
                                    Начать
                                @else
                                    Баштоо
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

