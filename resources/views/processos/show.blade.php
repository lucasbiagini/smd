@extends('layouts.app')


@section('header')
    <b-container>
        <b-row>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Inventário de Dados Pessoais') }} - {{ $processo->name }} / {{ $processo->ref }}
                </h2>
        </b-row>
    </b-container>
@endsection

@section('content')
    <processo :processo_id="{{ $processo->id }}"></processo>
@endsection
