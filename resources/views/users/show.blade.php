@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Votante')
@section('content')
    <div class="d-flex align-items-center">
        <h1 class="d-inline-block mr-3 mb-0">
            <strong>Encuesta # {{ $poll->id }}</strong>
        </h1>
        <div>
            <a href=" {{ route('users.index') }} " class="btn btn-outline-secondary"><i
                    class="fas fa-list"></i> Listado</a>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header bg-dark"></div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
                <tbody>
                <tr>
                    <th>Inicio</th>
                    <td>{{ date('d/m/Y', strtotime($poll->startDate))}}</td>
                </tr>
                <tr>
                    <th>Fin</th>
                    <td>{{ date('d/m/Y', strtotime($poll->endDate))}}</td>
                </tr>
                <tr>
                    <th>Pregunta</th>
                    <td>{{ $poll->question }}</td>
                </tr>
                <tr>
                    <th>Código</th>
                    <td>{{ $poll->code }}</td>
                </tr>
                <tr>
                    <th>Público</th>
                    <td>{{ $poll->public ? 'Sí' : 'No' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex align-items-center mt-4">
        <h1 class="d-inline-block mr-3 mb-0">
            Respuestas
        </h1>
    </div>
    <div class="card mt-2">
        <div class="card-header bg-dark"></div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
                <thead>
                <tr>
                    <th>Respuestas</th>
                    <th>Tu respuesta</th>
                    <th>Votos</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($answers);$i++)
                    <tr>
                        <td>{{ $answers[$i]->answer }}</td>
                        @if($answers[$i]->id == $answerId)
                            <td><i class="fas fa-check"></i></td>
                        @else
                            <td><i></i></td>
                        @endif
                        @if(isset($noAnswerCount))
                            @foreach($noAnswerCount as $answerCount)
                                @if($answerCount->answer_id == $answers[$i]->id)
                                    <td style="width: 1px">
                                        {{ $answerCount->total }}
                                    </td>
                                @endif
                            @endforeach
                        @else
                            <td style="width: 1px"></td>
                        @endif
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
