<div class="container">
    <div class="row">
        <div class="col-md-12 mb-5">
            <h1 class="display-4">Вопросы</h1>
        </div>
        <div class="quest row" >
            @foreach ($tests as $item)        
                <div class="card rounded-0 pl-2 pr-2 border-left-0 border-right-0 border-bottom-0 border-top  border-primary mr-3" style="width: 15rem;">
                    <span class="col h4 pl pt-3 pb-0">{{$item->title_ru}}</span>
                    <div class="pl-3">
                        <small class="">{{ mb_strimwidth($item->description_ru, 0, 40, "...") }}</small>
                    </div>                
                    <ul class="list-group ">
                        <li class="list-group-item rounded-0 d-flex border-0 justify-content-between align-items-center pt-2 pb-1">
                            Всего вопросов
                            <span class="badge badge-primary badge-pill">{{$item->question()->count()}}</span>
                        </li>
                        <li class="list-group-item rounded-0 d-flex border-0 justify-content-between align-items-center pt-2 pb-1">
                            Показывать вопросы
                            <span class="badge badge-primary badge-pill">{{$item->question_count}}</span>
                        </li>                    
                        <li class="list-group-item d-flex  rounded-0  border-0 justify-content-between align-items-center pt-2 pb-1">
                            Длительность теста
                            <span class="badge badge-primary badge-pill">{{$item->timer}}</span>
                        </li>
                        <li class="list-group-item d-flex rounded-0  border-0  justify-content-between align-items-center pt-2 pb-1">
                            Случайные вопросы
                            <span class="badge badge-primary badge-pill">{{ ($item->question_rand == 0 ? "нет" : "да") }}</span>
                        </li>
                    </ul>
                    <div class="display-5 pl-3 pl-3 pb-3 pt-3">
                        <a href="/new/question/add/{{$item->id}}" class="btn btn-sm btn-primary rounded-0">Подробнее...</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>