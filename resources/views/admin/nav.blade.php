<b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="/admin">Главная панель</b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      {{-- <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav> --}}

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        {{-- <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form> --}}
        @auth
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template v-slot:button-content>
            <span for="">{{ Auth::user()->name }}</span>
          </template>
          <b-dropdown-item href="/new/pass">Сменить пароль</b-dropdown-item>
          <b-dropdown-item href="#"  onclick="document.getElementById('logout-form').submit();">Выйти</b-dropdown-item>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </b-nav-item-dropdown>
        @endauth
      </b-navbar-nav>
    </b-collapse>
</b-navbar>