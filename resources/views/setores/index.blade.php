@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Setores') }}
        <create-setor></create-setor>
    </h2>
@endsection

@section('content')
    <setores></setores>
@endsection
