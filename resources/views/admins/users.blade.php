@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
<div class="card mt-4">
    <div class="card-header bg-dark"></div>
    <div class="card-body p-0">
        <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="align-middle">{{ $user->name  }}</td>
                    <td class="align-middle">{{ $user->email  }}</td>
                    <td class="align-middle">
                        @switch($user->role)
                            @case('admin')
                                Administrador
                                @break
                            @case('creator')
                                Creador
                                @break
                            @case('user')
                                Usuario
                                @break
                        @endswitch
                    </td>
                    <td>
                        <div class="d-flex flex-md-nowrap">
                            @switch($user->role)
                                @case('creator')
                                    <div style="display: inline-block">
                                        <form action=" {{ route('admins.promote') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="btn-group">
                                                <button type="button"
                                                        class="btn btn-primary dropdown-toggle ml-md-1 mt-1 mt-md-0"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Promocionar
                                                </button>
                                                <div class="dropdown-menu">
                                                    <input name="user" type="hidden" value="{{ $user->id }}">
                                                    <input id="role-type{{ $user->id }}" name="role" type="hidden"
                                                           value="">
                                                    <button type="submit" class="dropdown-item" name="submit"
                                                            value="Admin"
                                                            onclick="document.getElementById('role-type' + '{{$user->id}}').value='admin'">
                                                        a administrador
                                                    </button>
                                                    <button type="submit" class="dropdown-item" name="submit"
                                                            value="User"
                                                            onclick="document.getElementById('role-type' + '{{$user->id}}').value='user'">
                                                        a usuario
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div style="display: inline-block">
                                        <a href="{{ route('admins.showUser', $user->id) }}"
                                           class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                            <div class="text-nowrap"><i class="fas fa-eye"></i> Ver</div>
                                        </a>
                                    </div>
                                    @break
                                @case('user')
                                    <div style="display: inline-block">
                                        <form action=" {{ route('admins.promote') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="btn-group">
                                                <button type="button"
                                                        class="btn btn-primary dropdown-toggle ml-md-1 mt-1 mt-md-0"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Promocionar
                                                </button>
                                                <div class="dropdown-menu">
                                                    <input name="user" type="hidden" value="{{ $user->id }}">
                                                    <input id="role-type{{ $user->id }}" name="role" type="hidden"
                                                           value="">
                                                    <button type="submit" class="dropdown-item" name="submit"
                                                            value="Admin"
                                                            onclick="document.getElementById('role-type' + '{{$user->id}}').value='admin'">
                                                        a administrador
                                                    </button>
                                                    <button type="submit" class="dropdown-item" name="submit"
                                                            value="Creator"
                                                            onclick="document.getElementById('role-type' + '{{$user->id}}').value='creator'">
                                                        a creador
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div style="display: inline-block">
                                        <a href=" {{ route('admins.showUser', $user->id) }} "
                                           class="btn btn-outline-secondary ml-md-1 mt-1 mt-md-0">
                                            <div class="text-nowrap"><i class="fas fa-eye"></i> Ver</div>
                                        </a>
                                    </div>
                                    @break
                            @endswitch
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer text-right px-3 py-2">
        @if($users instanceof LengthAwarePaginator)
            {{ $users->links() }}
        @endif
    </div>
</div>
