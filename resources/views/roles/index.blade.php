@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Perfis') }}
        <roles-create></roles-create>
    </h2>
@endsection

@section('content')
    <roles></roles>
@endsection
