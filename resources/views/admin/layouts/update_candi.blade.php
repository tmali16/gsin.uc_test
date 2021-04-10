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
                <h2 class="col p-3 shadow">{{$student->fn . " " . $student->mn . " " . $student->ln}}</h2>
            </div>
            <div class="col-md-10 mt-3">
                
                <div class="card rounded-0 mt-3 border-0 shadow">
                    <div class="card-body d-flex justify-content-center">
                        <form action="/user/update/{{$student->id}}" method="post" class="col-md-7">
                            @csrf
                            <div class="form-group">
                                <label for="fn">Фамилия *</label>
                                <input type="text" class="form-control form-control-sm rounded-0" value="{{$student->fn}}" id="fn" name="fn" placeholder="Фамилия" required>
                            </div>
                            <div class="form-group">
                                <label for="mn">Имя *</label>
                                <input type="text" class="form-control form-control-sm rounded-0" value="{{$student->mn}}" placeholder="Имя" name="mn" id="mn" required>
                            </div>
                            <div class="form-group">
                                <label for="ln">Отчество</label>
                                <input type="text" class="form-control form-control-sm rounded-0" value="{{$student->ln}}" placeholder="Отчество" name="ln" id="ln">
                            </div>
                            <div class="form-group">
                                <label for="testForStudent">Выберите тест для тестируемого</label>
                                <select class="form-control form-control-sm rounded-0" id="testForStudent" name="test">
                                    @foreach ($tests as $item)
                                        <option value="{{$item->id}}" @if($item->id == $student->test_id) selected @endif>{{$item->title_ru}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-0 float-right btns-shadow">Сохранить</button>
                        </form>
                    </div>
                </div>
                <br>
                <a href="/admin" class="btn btn-sm btn-success rounded-0 btns-shadow">Назад</a>
            </div>
        </div>
    </div>
@endsection