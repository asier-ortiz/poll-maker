@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Administrador')
@section('content')
    <div class="container">
        <div class="d-flex align-items-center mb-1">
            <h1 class="d-inline-block mr-3 mb-0"><strong>Detalle Usuario # {{ $user->id }}</strong></h1>
            <div>
                <a href=" {{ route('admins.index') }} " class="btn btn-outline-secondary"><i class="fas fa-list"></i>
                    Listado</a>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header bg-dark"></div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
                    <tbody>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $user->name  }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Rol</th>
                        <td>
                            @if($user->role == 'creator')
                                Creador
                            @else
                                Usuario
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha registro</th>
                        <td>{{ date('d/m/Y', strtotime($user->created_at))}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
        @if($user->role == 'creator')
            @if(count($pollsCreatedByTheUser) > 0)
                <div class="d-flex align-items-center mt-4">
                    <h1 class="d-inline-block mr-3 mb-0">
                        Encuestas que ha creado
                    </h1>
                </div>
                <div class="card mt-2">
                    <div class="card-header bg-dark"></div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
                            <thead>
                            <tr>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Pregunta</th>
                                <th>Código</th>
                                <th>Público</th>
                                <th>Publicado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pollsCreatedByTheUser as $poll)
                                <tr>
                                    <td class="align-middle">{{ date('d/m/Y', strtotime($poll->startDate))}}</td>
                                    <td class="align-middle">{{ date('d/m/Y', strtotime($poll->endDate))}}</td>
                                    <td class="align-middle">{{ $poll->question }}</td>
                                    <td class="align-middle">{{ $poll->code }}</td>
                                    <td class="align-middle">{{ $poll->public ? 'Sí' : 'No' }}</td>
                                    <td class="align-middle">{{ $poll->published ? 'Sí' : 'No' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center mt-5">
                    <h3 class="text-secondary"><strong>El usuario todavía no ha creado ninguna encuesta</strong>
                    </h3>
                </div>
            @endif
        @else
            @if(count($pollsInWhichUserTakingPart) > 0)
                <div class="d-flex align-items-center mt-4">
                    <h1 class="d-inline-block mr-3 mb-0">
                        Encuestas en las que ha participado
                    </h1>
                </div>
                @include('users.polls')
            @else
                <div class="text-center mt-5">
                    <h3 class="text-secondary"><strong>El usuario todavía no ha participado en ninguna encuesta</strong>
                    </h3>
                </div>
            @endif
        @endif
    </div>
@endsection
