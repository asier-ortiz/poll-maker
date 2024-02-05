<div class="card mt-2">
    <div class="card-header bg-dark"></div>
    <div class="card-body p-0">
        <table class="table table-striped table-bordered table-condensed table-responsive-md mb-0">
            <thead>
            <tr>
                <th>Pregunta</th>
                <th>Código</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invitations as $poll)
                <tr>
                    <td class="align-middle">{{ $poll->question }}</td>
                    <td class="align-middle">{{ $poll->code }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <form class="mb-0" action=" {{ route('users.addPoll') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body mt-2">
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="code">Introducir código</label>
                <div class="col-sm-10">
                    <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror">
                    @error('code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-right px-3 py-2">
            <button type="submit" name="takePart" value="TakePart" class="btn btn-sm btn-secondary"><i
                    class="fas fa-plus"></i>
                Participar
            </button>
        </div>
    </form>
</div>
