@extends("layouts.app")
@section("content")
<div class="flex-center position-ref full-height">
    <div class="row title_top">
        <div class="col-md-5 text-center title-text-left">            
            {{$settings->where('lang',"kg")->first()->values}}
        </div>
        <div class="col-md-2">
        <img src="{{asset("/img/logo.png")}}" alt="" class="shadow" style="height: 120px;">
        </div>
        <div class="col-md-5 text-center title-text-right">            
            {{$settings->where('lang',"ru")->first()->values}}
        </div>
    </div>
    <div class="content text-center">
        @if ($errors->any())
            <div class="col-md-12 alert alert-danger rounded-0 border-0 shadow-sm" style="opacity: 0.6">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card rounded-0 shadow-lg border-0">
            <div class="card-body ">
                <form action="/start" method="post" class="row justify-content-center">
                    @csrf
                    <div class="col-sm-12 text-center">
                        <i><span class="col-md-12">Тил тандаңыз / Выберите язык</span> </i> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lang" id="lang_kg" onchange="startTestBrnLang()" value="kg" checked required>
                            <label class="form-check-label" for="lang_kg">Кыргызча</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lang" id="lang_ru" value="ru" onchange="startTestBrnLang()">
                            <label class="form-check-label" for="lang_ru">Русский</label>
                        </div>
                    </div>
                    <div class="border-success w-75 mt-3 mb-3 border"></div>

                    <div class="col-md-8 form-group text-center">
                        <span id="enter_code_label">Кодуңузду жазыңыз</span>
                        <input type="text" class="form-control form-control-sm rounded-0 d-inline-block" name="code" required autocomplete="off"/>
                        <button class="btn  mt-4 btn-success btn-sm rounded-0 " id="enter_code_btn">Кирүү</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section("script")
    <script>
        function startTestBrnLang() {
            const radio = document.getElementsByName("lang");
            const btn = document.getElementById("enter_code_btn");

            if(radio[0].checked){
                btn.textContent = "Кирүү";
                document.getElementById("enter_code_label").innerHTML = "Кодуңузду жазыңыз";
            }else{
                btn.textContent="Войти";
                document.getElementById("enter_code_label").innerHTML = "Введите ваш код";
            }
        }

    </script>
@endsection