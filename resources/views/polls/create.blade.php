@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Creador')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0">
            <strong>Encuesta</strong>
            <small class="text-muted">Nueva</small>
        </h1>
        <div>
            <a href=" {{ route('polls.index') }} " class="btn btn-outline-secondary"><i
                    class="fas fa-list"></i> Listado</a>
        </div>
    </div>
    @include('polls.form_new')
@endsection


