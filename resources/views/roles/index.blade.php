@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Perfis') }}
        <create-role></create-role>
    </h2>
@endsection

@section('content')
    <roles></roles>
@endsection
