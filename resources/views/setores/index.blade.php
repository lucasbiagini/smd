@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Setores') }}
        <setores-create></setores-create>
    </h2>
@endsection

@section('content')
    <setores></setores>
@endsection
