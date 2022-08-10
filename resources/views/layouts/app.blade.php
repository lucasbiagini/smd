<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <div id="app">
            <div class="min-h-screen bg-gray-100" v-cloak>
                @if (!auth()->user()->hasActiveRoles())
                    <index-unauthorized message="Perfil inativo."></index-unauthorized>
                @elseif(auth()->user()->status && session()->has('setor_id') && ( session('setor_id') === -1 || \App\Models\Setor::find(session('setor_id'))->status === 1))
                    @include('layouts.navigation')

                    <!-- Page Heading -->
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('header')
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                @elseif (!auth()->user()->status)
                    <index-unauthorized message="Usuário inativo."></index-unauthorized>
                @elseif (auth()->user()->setores()->where('status', 1)->count() > 0)
                    <select-setor :user_id="{{ auth()->user()->id }}"></select-setor>
                @else
                    <index-unauthorized message="Nenhum setor cadastrado ou ativo no momento."></index-unauthorized>
                @endif
            </div>
        </div>
    </body>

    <script>
        @auth
            window.Permissions = {!! json_encode(auth()->user()->allPermissions, true) !!};
        @else
            window.Permissions = [];
        @endauth
    </script>
</html>
