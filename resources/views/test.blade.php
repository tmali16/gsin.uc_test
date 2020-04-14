@extends("layouts.app")

@section("nav")
  @include('layouts.nav')
@endsection

@section("content")
<div id="clocks"></div>
    <main class="full-height quest-body d-flex align-items-center">
        <show-question test_id="{{$test_id}}" timer="{{$test->timer}}"></show-question>
    </main>
@endsection

@section("script")
    <!-- jQuery 3 -->
    
    <!-- Bootstrap 3.3.7 -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    {{-- <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script> --}}
    {{-- <script type="text/javascript" src="{{asset('js/jquery.cookie.js')}}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.js" integrity="sha256-2HAs3lxuJSrA/bAbF2bgaV55gSuX8vVsj2pCcWYqmY4=" crossorigin="anonymous"></script> --}}
    {{-- <script type="text/javascript" src="{{asset('js/jquery.countdown.js')}}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script> --}}
    
    <script>
        var test_id = {{$test->id}};
        var timer = {{$test->timer}};

        // $(document).ready(function() {
        //     function e(e) {
        //         (116 == (e.which || e.keyCode) || 82 == (e.which || e.keyCode)) && e.preventDefault()
        //     }
        //     setTimeout(function() {
        //         $(".myQuestion:first-child").addClass("active")
        //     }, 2500), history.pushState(null, null, document.URL), window.addEventListener("popstate", function() {
        //         history.pushState(null, null, document.URL)
        //     }), $(document).on("keydown", e), setTimeout(function() {
        //         $(".nextbtn").click(function() {
        //             var e = $(".myQuestion.active");
        //             $(e).removeClass("active"), 0 == $(e).next().length ? (Cookies.remove("time"), Cookies.set("done", "Your Quiz is Over...!", {
        //                 expires: 1
        //             }), location.href = "{{$test->id}}/finish") : ($(e).next().addClass("active"), $(".myForm")[0].reset())
        //         })
        //     }, 700);
        //     var i, o = (new Date).getTime() + 6e4 * timer;
        //     if (Cookies.get("time") && Cookies.get("test_id") == test_id) {
        //         i = Cookies.get("time");
        //         var t = o - i,
        //             n = o - t;
        //         $("#clocks").countdown(n, {
        //             elapse: !0
        //         }).on("update.countdown", function(e) {
        //             var i = $(this);
        //             e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
        //                 expires: 1
        //             }), Cookies.remove("time"), location.href = "{{$test->id}}/finish") : i.html(e.strftime("<span>%H:%M:%S</span>"))
        //         })
        //     } else Cookies.set("time", o, {
        //         expires: 1
        //     }), Cookies.set("test_id", test_id, {
        //         expires: 1
        //     }), $(clocks).countdown(o, {
        //         elapse: !0
        //     }).on("update.countdown", function(e) {
        //         var i = $(this);
        //         e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {expires: 1}), Cookies.remove("time"), location.href = "{{$test->id}}/finish") : i.html(e.strftime("<span>%H:%M:%S</span>"))
        //     })
        // });
    </script>
@endsection