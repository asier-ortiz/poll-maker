@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Usuario')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0"><strong>Votar</strong></h1>
        <div>
            <a href=" {{ route('users.index') }} " class="btn btn-outline-secondary"><i
                    class="fas fa-list"></i> Listado</a>
        </div>
    </div>
    <form id="form_vote" action=" {{ route('users.vote', $poll->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mt-2">
            <div class="card-header bg-dark text-white px-3 py-2 position-relative">
                {{ $poll->question }}
            </div>
            <div class="mt-3" align="center" style="display: inline-block">
                @if($errors->has('answer'))
                    <span class="error text-danger"><strong>{{ $errors->first('answer') }}</strong></span>
                @endif
            </div>
            <div class="card-body align-items-center d-flex justify-content-center">
                <ul style="list-style-type:none">
                    @forelse ($poll->answers as $answer)
                        <li class="mt-3" style="text-align:left;">
                            <input type="radio" class="form-check-input" id="answer[]" name="answer[]"
                                   value="{{ $answer->id }}">
                            <label class="form-check-label" for="answer[]">
                                {{ $answer->answer }}
                            </label>
                        </li>
                    @empty
                        <p><strong>¡Error! Esta encuesta no tiene respuestas. Por favor, comuníqueselo a un
                                administrador</strong></p>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-right px-3 py-2">
                <div style="display: inline-block">
                    <input name="poll" type="hidden" value="{{ $poll->id }}">
                    <button type="submit" class="btn btn-secondary" name="vote" value="Vote">
                        <i class="fas fa-person-booth"></i> Votar
                    </button>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('input[type="checkbox"]').on('change', function () {
                    $('input[type="checkbox"]').not(this).prop('checked', false);
                });
            });
        </script>
    </form>
@endsection
