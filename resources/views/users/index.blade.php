@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Votante')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0"><strong>Encuestas</strong></h1>
    </div>
    @if($invitations->isNotEmpty())
        @include('users.codes')
        @include('users.searcher')
        @include('users.polls')
    @else
        <div class="text-center mt-5">
            <h3 class="text-secondary"><strong>Actualmente no estás participando en ninguna encuesta</strong></h3>
        </div>
    @endif
@endsection
