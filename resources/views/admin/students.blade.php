<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 bg-dark p-2 ">
            <button class="ml-auto btn btn-sm btn-primary rounded-0" data-toggle="collapse" data-target="#collapseNewStudent" role="button" aria-expanded="false" aria-controls="collapseNewStudent">
                Новый студент
            </button>
        </div>
        <div class="col-md-7 collapse p-4" id="collapseNewStudent">
            <div class="card rounded-0">
                <div class="card-header p-1 text-center">
                    <h4>
                        Новый Тестируемый
                    </h4>
                </div>
                <div class="card-body">
                    <form action="/new/test/user" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="fn">Фамилия *</label>
                            <input type="text" class="form-control form-control-sm rounded-0" id="fn" name="fn" placeholder="Фамилия" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="mn">Имя *</label>
                            <input type="text" class="form-control form-control-sm rounded-0" placeholder="Имя" name="mn" id="mn" required>
                        </div>
                        <div class="form-group">
                            <label for="ln">Отчество</label>
                            <input type="text" class="form-control form-control-sm rounded-0" placeholder="Отчество" name="ln" id="ln">
                        </div>
                        <div class="form-group">
                            <label for="testForStudent">Выберите тест для тестируемого</label>
                            <select class="form-control form-control-sm rounded-0" id="testForStudent" name="test">
                                @foreach ($tests as $item)
                                    <option value="{{$item->id}}">{{$item->title_ru}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-0 float-right">Добавить</button>
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
                        <th scope="col">Фамилия</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Отчество</th>
                        <th scope="col">Код пользователя</th>
                        <th scope="col">Состояние</th>
                        <th scope="col">Тест</th>
                        <th scope="col">Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($students ?? '' as $item)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{ $item->fn}}</td>
                                <td>{{ $item->mn}}</td>
                                <td>{{ $item->ln}}</td>
                                <td>{{ $item->code}}</td>
                                <td>@mdo</td>
                                <td>{{ $item->test_id}}</td>
                                <td>{{ $item->created_at}}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{$students->links()}}
            </div>
        </div>
    </div>
</div>