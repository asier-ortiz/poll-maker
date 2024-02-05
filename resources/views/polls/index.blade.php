@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Creador')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0"><strong>Encuestas</strong></h1>
        @if(Auth::user()->role == "creator")
            <a href=" {{ route('polls.create') }}" class="btn btn-secondary"><i class="fas fa-plus"></i> Nueva</a>
        @endif
    </div>
    @include('polls.searcher')
    @include('polls.polls')
@endsection
