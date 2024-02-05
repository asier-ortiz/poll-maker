@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@if($polls->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header bg-dark"></div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-condensed table-responsive mb-0">
                <thead>
                <tr>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Pregunta</th>
                    <th>Código</th>
                    <th>Público</th>
                    <th>Publicado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($polls as $poll)
                    <tr>
                        <td class="align-middle">{{ date('d/m/Y', strtotime($poll->startDate))}}</td>
                        <td class="align-middle">{{ date('d/m/Y', strtotime($poll->endDate))}}</td>
                        <td class="align-middle">{{ $poll->question }}</td>
                        <td class="align-middle">{{ $poll->code }}</td>
                        <td class="align-middle">{{ $poll->public ? 'Sí' : 'No' }}</td>
                        <td class="align-middle">{{ $poll->published ? 'Sí' : 'No' }}</td>
                        <td>
                            <div class="d-flex flex-md-nowrap">
                                <div style="display: inline-block">
                                    <a href="{{ route('polls.show', $poll->id) }}"
                                       class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                        <div class="text-nowrap"><i class="fas fa-eye"></i> Ver</div>
                                    </a>
                                </div>
                                @if(Auth::user()->role == "creator")
                                    @if($poll->published)
                                        <div style="display: inline-block">
                                            <a href="{{ route('polls.userInvitationsList', $poll->id) }}"
                                               class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                                <div class="text-nowrap"><i class="fas fa-paper-plane"></i> Invitar
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(!$poll->published)
                                        <div style="display: inline-block">
                                            <a href=" {{ route('polls.edit', $poll->id) }}"
                                               class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                                <div class="text-nowrap"><i class="fas fa-pencil-alt"></i> Editar</div>
                                            </a>
                                        </div>
                                    @endif
                                    <div style="display: inline-block">
                                        <form name="form" method="post"
                                              action=" {{ route('polls.destroy', $poll->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ml-md-1 mt-1 mt-md-0"
                                                    onclick="return confirm('¿Seguro?');">
                                                <div class="text-nowrap"><i class="fas fa-trash-alt"></i> Borrar</div>
                                            </button>
                                        </form>
                                    </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right px-3 py-2">
            @if($polls instanceof LengthAwarePaginator)
                {{ $polls->links() }}
            @endif
        </div>
    </div>
@else
    <div class="text-center mt-5">
        <h3 class="text-secondary"><strong>Sin coincidencias</strong>
        </h3>
    </div>
@endif
