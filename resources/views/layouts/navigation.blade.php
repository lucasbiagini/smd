<b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="{{ route('home') }}">
{{--        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />--}}
        CALAF
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item {{ request()->route()->getName() == 'home' ? 'active' : '' }} href="{{ route('home') }}">{{ __('Processos') }}</b-nav-item>
            <b-nav-item v-if="$can('users.index')" {{ request()->route()->getName() == 'users.index' ? 'active' : '' }} href="{{ route('users.index') }}">{{ __('Usuários') }}</b-nav-item>
            <b-nav-item v-if="$can('setores.index')" {{ request()->route()->getName() == 'setores.index' ? 'active' : '' }} href="{{ route('setores.index') }}">{{ __('Setores') }}</b-nav-item>
            <b-nav-item v-if="$can('roles.index')" {{ request()->route()->getName() == 'roles.index' ? 'active' : '' }} href="{{ route('roles.index') }}">{{ __('Perfis') }}</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown
                id="my-nav-dropdown"
                text="Setor{{session()->has('setor_name') ? ": " . session('setor_name') : ""}}"
                toggle-class="nav-link-custom"
                right
            >
                @foreach(auth()->user()->setores()->where('status', 1)->get() as $setor)
                    <form method="POST" action="/setores/{{ $setor->id }}/select">
                        @csrf
                        <b-dropdown-item onclick="event.preventDefault();
                                                    this.closest('form').submit();">{{ $setor->name }}
                        </b-dropdown-item>
                    </form>
                @endforeach
                @if(auth()->user()->hasRole('admin'))
                    <b-dropdown-divider></b-dropdown-divider>
                    <form method="POST" action="/setores/-1/select">
                        @csrf
                        <b-dropdown-item onclick="event.preventDefault();
                                                    this.closest('form').submit();">Todos
                        </b-dropdown-item>
                    </form>
                @endif
            </b-nav-item-dropdown>
            <b-nav-item-dropdown right>
                <!-- Using 'button-content' slot -->
                <template #button-content>
                    <em>{{ Auth::user()->name }}</em>
                </template>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <b-dropdown-item href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                        {{ __('Sair') }}
                    </b-dropdown-item>
                </form>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </b-collapse>
</b-navbar>
