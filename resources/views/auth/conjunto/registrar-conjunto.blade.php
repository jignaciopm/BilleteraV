@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
        	@if(session()->has("success-registrar-conjunto"))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Listo!</strong> Se ha registrado el conjunto. <a href="{{ route('home') }}">VER</a>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif
            <div class="card">
                <div class="card-header">Registrar Conjunto</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registrar-conjunto-post') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="conjunto">Usuarios</label>
                            <select id="conjunto" class="custom-select {{$errors->has('conjunto') ? 'is-invalid' : ''}}">
							  	<option selected>* Seleccionar usuario conjunto</option>
							</select>
                            <div class="invalid-feedback">
                                {!! $errors->first('conjunto', ':message') !!}
                            </div>                            
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
