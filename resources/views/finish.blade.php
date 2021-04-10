@extends("layouts.app")

@section("nav")
    @include("layouts.nav")
@endsection
@section("content")
    <main class="full-height quest-body">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-md-12 mt-4 d-print-none">
                    <div class="card border-0 shadow">
                        <div class="card-body p-2">
                        <a href="/lang/kg" class="btn btn-link">Кыр</a>
                        /
                        <a href="/lang/ru" class="btn btn-link">Рус</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 w-100 print-parrent h-100 d-flex align-items-center justify-content-center">                    
                    @include('admin.result')                    
                </div>
            </div>
        </div>
    </main>
@endsection