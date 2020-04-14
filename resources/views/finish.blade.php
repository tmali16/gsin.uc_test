@extends("layouts.app")

@section("nav")
    @include("layouts.nav")
@endsection
@section("content")
    <main class="full-height quest-body">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-md-10 h-100 d-flex align-items-center justify-content-center">
                    @include('admin.result')
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
    $('.print').on('click', function(){		


	            window.print();

	});
    </script>
@endsection