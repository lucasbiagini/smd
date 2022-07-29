<b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand href="{{ route('home') }}">
{{--        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />--}}
        CALAF
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item href="{{ route('home') }}">{{ __('Início') }}</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
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
