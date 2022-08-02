@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Setores') }}
        @if(auth()->user()->hasPermissionTo('setores.store'))
            <create-setor></create-setor>
        @endif
    </h2>
@endsection

@section('content')
    <setores></setores>
@endsection
