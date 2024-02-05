<form id="form" action=" {{ route('polls.update', $poll->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card mt-2">
        <div class="card-header bg-dark"></div>
        <div class="card-body px-3 pt-2 pb-0">
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="startDate">Fecha inicio</label>
                <div class="col-sm-10">
                    <input type="date" id="startDate" name="startDate"
                           class="form-control @error('startDate') is-invalid @enderror"
                           value= {{ $poll->startDate  }}/>
                    @error('startDate')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="endDate">Fecha fin</label>
                <div class="col-sm-10">
                    <input type="date" id="endDate" name="endDate"
                           class="form-control  @error('endDate') is-invalid @enderror"
                           value={{ $poll->endDate }}/>
                    @error('endDate')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="question">Pregunta</label>
                <div class="col-sm-10">
                    <input type="text" id="question" name="question"
                           class="form-control @error('question') is-invalid @enderror"
                           value="{{ $poll->question }}"/>
                    @error('question')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="code">Código</label>
                <div class="col-sm-10">
                    <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
                           readonly value= {{ $poll->code }}>
                    @error('code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="checkbox" id="public" name="public" checked="checked"
                               class="form-check-input" value=" {{ $poll->public ? 1 : 0 }}"/>
                        <label class="form-check-label" for="public">Pública</label>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-dark"></div>
        <div class="card-body p-0">
            <div class="d-flex flex-md-nowrap">
                <div class="col-sm-3" style="display: inline-block">
                    <button id="add_row" class="btn btn-default pull-left" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button id='delete_row' class="pull-right btn btn-default" type="button">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="col-sm-9" align="center" style="display: inline-block">
                    @if($errors->has('answer.*'))
                        <span class="error text-danger"><strong>{{ $errors->first('answer.*') }}</strong></span>
                    @endif
                </div>
            </div>
            <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0" id="tab_answers">
                @if(old('answer'))
                    @for($i=0;$i<count(old('answer'));$i++)
                        <tr id='addr{{ $i + 1 }}'>
                            <td colspan="1">Respuesta {{ $i + 1 }}</td>
                            <td class="col-sm-9">
                                <input type="text" id="answer[]" name='answer[]' class="form-control"
                                       value={{ old("answer.$i") }}/>
                                <label class="form-check-label" for="answer[]"></label>
                            </td>
                        </tr>
                    @endfor
                @else
                    @for($i=0;$i<count($poll->answers);$i++)
                        <tr id='addr{{ $i + 1 }}'>
                            <td colspan="1">Respuesta {{ $i + 1 }}</td>
                            <td class="col-sm-9" id="tdq">
                                <input type="text" id="answer[]" name='answer[]' class="form-control"
                                       value="{{ $poll->answers->get($i)->answer }}"/>
                                <label class="form-check-label" for="answer[]"></label>
                            </td>
                        </tr>
                    @endfor
                @endif
            </table>
        </div>
        <div class="card-footer text-right px-3 py-2">
            <div style="display: inline-block">
                <button type="submit" class="btn btn-danger" name="submit" value="Publish"
                        onclick="return confirm('¿Seguro?');"><i
                        class="fas fa-flag"></i> Publicar
                </button>
                <button type="submit" class="btn btn-secondary" name="submit" value="Update">
                    <i
                        class="fas fa-pencil-alt"></i> Guardar
                </button>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let i = document.getElementById('tab_answers').rows.length;

                document.getElementById('add_row').addEventListener("click", function () {
                    if (i < 5) {
                        i++;
                        let table = document.getElementById('tab_answers');
                        let newRow = table.insertRow();
                        newRow.id = 'addr' + i;
                        let firstRow = table.rows[1];
                        newRow.innerHTML = firstRow.innerHTML;
                        newRow.cells[0].innerHTML = 'Respuesta ' + i;
                        newRow.cells[1].querySelector('input').value = "";
                    }
                });

                document.getElementById('delete_row').addEventListener("click", function () {
                    if (i > 2) {
                        let rowToDelete = document.getElementById("addr" + i);
                        rowToDelete.parentNode.removeChild(rowToDelete);
                        i--;
                    }
                });
            });
        </script>
    </div>
</form>
