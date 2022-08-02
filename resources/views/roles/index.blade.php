@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Perfis') }}
        @if(auth()->user()->hasPermissionTo('roles.store'))
            <create-role></create-role>
        @endif
    </h2>
@endsection

@section('content')
    <roles></roles>
@endsection
