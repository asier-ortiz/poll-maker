@if($pollsInWhichUserTakingPart->isNotEmpty())
<div class="card mt-4">
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
                @if(Auth::user()->role == "user")
                    <th>Acciones</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($pollsInWhichUserTakingPart as $poll)
                <tr>
                    <td class="align-middle">{{ date('d/m/Y', strtotime($poll->startDate))}}</td>
                    <td class="align-middle">{{ date('d/m/Y', strtotime($poll->endDate))}}</td>
                    <td class="align-middle">{{ $poll->question }}</td>
                    <td class="align-middle">{{ $poll->code }}</td>
                    <td class="align-middle">{{ $poll->public ? 'Sí' : 'No' }}</td>
                    <td class="align-middle">{{ $poll->published ? 'Sí' : 'No' }}</td>
                    @if(Auth::user()->role == "user")
                        <td>
                            <div class="d-flex flex-md-nowrap">
                                @if($poll->public)
                                    <div style="display: inline-block">
                                        <a href="{{ route('users.show', $poll->id) }}"
                                           class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                            <div class="text-nowrap"><i class="fas fa-eye"></i> Ver</div>
                                        </a>
                                    </div>
                                @endif
                                @if(!in_array($poll->id, $alreadyAnsweredPollsIds))
                                    <div style="display: inline-block">
                                        <a href="{{ route('users.pollAnswersList', $poll->id) }}"
                                           class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                            <div class="text-nowrap"><i class="fas fa-person-booth"></i> Votar</div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="text-center mt-5">
        <h3 class="text-secondary"><strong>Sin coincidencias</strong>
        </h3>
    </div>
@endif
