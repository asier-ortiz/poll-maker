<form action=" {{ route('polls.store') }}" method="POST">
    @csrf
    <div class="card mt-2">
        <div class="card-header bg-dark"></div>
        <div class="card-body px-3 pt-2 pb-0">
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="startDate">Fecha inicio</label>
                <div class="col-sm-10">
                    <input type="date" id="startDate" name="startDate"
                           class="form-control @error('startDate') is-invalid @enderror"
                           value= {{ $startDate }}/>
                    @error('startDate')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="endDate">Fecha fin</label>
                <div class="col-sm-10">
                    <input type="date" id="endDate" name="endDate"
                           class="form-control @error('endDate') is-invalid @enderror" value={{$endDate}}/>
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
                           value="{{ old('question')}}"/>
                    @error('question')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="code">Código</label>
                <div class="col-sm-10">
                    <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror"
                           readonly
                           value= {{ $code }}>
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
                               class="form-check-input" value="1"/>
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
                <button id="add_row" class="btn btn-default pull-left" type="button" >
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
            <tbody>
            @if(old('answer'))
                @for($i=0;$i<count(old('answer'));$i++)
                    <tr id='addr{{ $i + 1 }}'>
                        <td colspan="1">Respuesta {{ $i + 1 }}</td>
                        <td class="col-sm-10">
                            <input type="text" id="answer[]" name='answer[]' class="form-control"
                                   value={{ old("answer.$i") }}/>
                            <label class="form-check-label" for="answer[]"></label>
                        </td>
                    </tr>
                @endfor
            @else
                <tr id='addr0'>
                    <td colspan="1">Respuesta 1</td>
                    <td class="col-sm-10">
                        <input type="text" id="answer[]" name='answer[]' class="form-control"/>
                        <label class="form-check-label" for="answer[]"></label>
                    </td>
                </tr>
                <tr id='addr1'>
                    <td colspan="1">Respuesta 2</td>
                    <td class="col-sm-10">
                        <input type="text" id="answer[]" name='answer[]' class="form-control"/>
                        <label class="form-check-label" for="answer[]"></label>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let i = document.getElementById('tab_answers').rows.length;

                    document.getElementById('add_row').addEventListener('click', function () {
                        if (i < 5) {
                            i++;
                            const newRow = document.createElement('tr');
                            newRow.setAttribute('id', 'addr' + i);
                            newRow.innerHTML = document.getElementById('addr1').innerHTML;
                            newRow.querySelector('td:first-child').innerHTML = 'Respuesta ' + i;
                            newRow.querySelector('td:last-child').querySelector(':first-child').value = "";
                            document.getElementById('tab_answers').appendChild(newRow);
                        }
                    });

                    document.getElementById('delete_row').addEventListener('click', function () {
                        if (i > 2) {
                            const rowToDelete = document.getElementById('addr' + i);
                            rowToDelete.parentNode.removeChild(rowToDelete);
                            i--;
                        }
                    });
                });
            </script>
        </div>
        <div class="card-footer text-right px-3 py-2">
            <button type="submit" class="btn btn-secondary" name="save" value="Save"><i
                    class="fas fa-pencil-alt"></i> Guardar
            </button>
        </div>
    </div>
</form>
