<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/admin">Главная панель</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            @auth
            <a class="nav-link" href="#">{{Auth::user()->name}}</a>
            @else
            <a class="nav-link" href="#">Sign out</a>
            @endauth
            
        </li>
    </ul>
</nav>