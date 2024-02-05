@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Administrador')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0"><strong>Usuarios</strong></h1>
    </div>
    @include('admins.searcher_users')
    @include('admins.users')
@endsection
