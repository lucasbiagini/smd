@extends('layouts.app')


@section('header')
    <b-container>
        <b-row>
            <b-col cols="10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Processos') }}
                </h2>
            </b-col>
            <b-col>
                @if(auth()->user()->hasPermissionTo('processos.store'))
                    <create-processo></create-processo>
                @endif
            </b-col>
        </b-row>
    </b-container>
@endsection

@section('content')
    <processos></processos>
@endsection
