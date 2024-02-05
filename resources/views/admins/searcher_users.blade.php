<form action=" {{ route('admins.searchUsers') }}" method="POST">
    @csrf
    <div class="card mt-2">
        <div class="card-header bg-dark text-white px-3 py-2 position-relative">
            Buscador
        </div>
        <div class="card-body px-3 pt-2 pb-0">
            <div class="form-group row"><label class="col-form-label col-sm-2"
                                               for="user_name">Nombre</label>
                <div class="col-sm-10"><input type="text" id="user_name" name="user_name"
                                              class="form-control"/>
                </div>
            </div>
            <div class="form-group row"><label class="col-form-label col-sm-2"
                                               for="user_email">Email</label>
                <div class="col-sm-10"><input type="text" id="user_email" name="user_email"
                                              class="form-control"/></div>
            </div>
            <div class="form-group row"><label class="col-form-label col-sm-2 required"
                                               for="user_role">Rol</label>
                <div class="col-sm-10"><select id="user_role" name="user_role" class="form-control">
                        <option value="all">Todos</option>
                        <option value="admin">Administrador</option>
                        <option value="creator">Creador</option>
                        <option value="user">Usuario</option>
                    </select></div>
            </div>
        </div>
        <div class="card-footer text-right px-3 py-2">
            <button type="submit" name="search" value="Search" class="btn btn-sm btn-secondary"><i
                    class="fas fa-search"></i>
                Buscar
            </button>
            <a href="{{ route('admins.index') }}" class="btn btn-sm btn-outline-secondary"><i
                    class="fas fa-trash-alt"></i> Limpiar
            </a>
        </div>
    </div>
</form>
