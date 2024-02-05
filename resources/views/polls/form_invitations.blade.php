@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Poll Maker - Creador')
@section('content')
    <div class="d-flex align-items-center mb-1">
        <h1 class="d-inline-block mr-3 mb-0"><strong>Invitaciones</strong></h1>
        <div>
            <a href=" {{ route('polls.index') }} " class="btn btn-outline-secondary"><i
                    class="fas fa-list"></i> Listado</a>
        </div>
    </div>
    @if($users->isNotEmpty())
        <form action=" {{ route('polls.sendInvitations', $poll->id) }}" method="POST">
            @csrf
            <div class="card mt-2">
                <div class="card-header bg-dark text-white px-3 py-2 position-relative">
                    {{ $poll->question }}
                </div>
                <div class="card-body px-0 pt-0 pb-0">
                    <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th style="text-align:center;">Todos
                                <input type="checkbox" id="selectAll"/>
                                <label class="form-check-label" for="selectAll"></label>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="align-middle">{{ $user->name }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle" style="text-align:center;">
                                    <input type="checkbox" id="invite[]" name="invite[]" class="form-control"
                                           value="{{ $user->id }}"/>
                                    <label class="form-check-label" for="invite[]"></label>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var selectAllCheckbox = document.getElementById('selectAll');
                            selectAllCheckbox.addEventListener('click', function () {
                                var table = selectAllCheckbox.closest('table');
                                var checkboxes = table.querySelectorAll('td input[type="checkbox"]');
                                checkboxes.forEach(function (checkbox) {
                                    checkbox.checked = selectAllCheckbox.checked;
                                });
                            });
                        });
                    </script>
                </div>
                <div class="card-footer text-right px-3 py-2">
                    <div style="display: inline-block">
                        <input name="poll" type="hidden" value="{{ $poll->id }}">
                        <button type="submit" class="btn btn-secondary" name="submit" value="Update">
                            <i class="fas fa-paper-plane"></i> Enviar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="text-center mt-5">
            <h3 class="text-secondary"><strong>No quedan usuarios a los que invitar</strong></h3>
        </div>
    @endif
@endsection
