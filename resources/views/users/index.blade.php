@extends('layouts.app')


@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Usuários') }}
    </h2>
@endsection

@section('content')
    <users></users>
@endsection
