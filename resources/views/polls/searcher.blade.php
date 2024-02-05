<form action="{{ route('polls.search') }}" method="POST">
    @csrf
    <div class="card mt-2">
        <div class="card-header bg-dark text-white px-3 py-2 position-relative">
            Buscador
        </div>
        <div class="card-body px-3 pt-2 pb-0">
            <div class="form-group row"><label class="col-form-label col-sm-2"
                                               for="poll_code">Código</label>
                <div class="col-sm-10"><input type="text" id="poll_code" name="poll_code"
                                              class="form-control"/>
                </div>
            </div>
            <div class="form-group row"><label class="col-form-label col-sm-2"
                                               for="poll_question">Pregunta</label>
                <div class="col-sm-10"><input type="text" id="poll_question" name="poll_question"
                                              class="form-control"/></div>
            </div>
            <div class="form-group row"><label class="col-form-label col-sm-2 required"
                                               for="poll_public">Público</label>
                <div class="col-sm-10"><select id="poll_public" name="poll_public" class="form-control">
                        <option value="all">Todas</option>
                        <option value="active">Sí</option>
                        <option value="inactive">No</option>
                    </select></div>
            </div>
            <div class="form-group row"><label class="col-form-label col-sm-2 required"
                                               for="poll_published">Publicado</label>
                <div class="col-sm-10"><select id="poll_published" name="poll_published"
                                               class="form-control">
                        <option value="all">Todas</option>
                        <option value="active">Sí</option>
                        <option value="inactive">No</option>
                    </select></div>
            </div>
        </div>
        <div class="card-footer text-right px-3 py-2">
            <button type="submit" name="search" value="Search" class="btn btn-sm btn-secondary"><i
                    class="fas fa-search"></i>
                Buscar
            </button>
            <a href="{{ route('polls.index') }}" class="btn btn-sm btn-outline-secondary"><i
                    class="fas fa-trash-alt"></i> Limpiar
            </a>
        </div>
    </div>
</form>
